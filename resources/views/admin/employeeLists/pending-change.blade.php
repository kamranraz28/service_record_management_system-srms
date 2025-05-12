@extends('layouts.admin')

@section('content')
<style>
    body {
        background: linear-gradient(145deg, #f3fdf6, #ffffff);
        font-family: 'Segoe UI', sans-serif;
    }

    .custom-card {
        background-color: #ffffff;
        border: 1px solid rgba(8, 100, 36, 0.15);
        border-radius: 1rem;
        box-shadow: 0 10px 25px rgba(8, 100, 36, 0.08);
        overflow: hidden;
    }

    .custom-header {
        background-color: #086424;
        color: #fff;
        padding: 1rem 1.5rem;
        font-size: 1.25rem;
        font-weight: 600;
        border-bottom: 1px solid #06521c;
    }

    .custom-table th, .custom-table td {
        padding: 0.85rem 1rem;
        vertical-align: middle;
        border-color: rgba(8, 100, 36, 0.1);
    }

    .custom-table thead {
        background-color: rgba(8, 100, 36, 0.06);
        color: #086424;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
    }

    .custom-table tbody tr:hover {
        background-color: rgba(8, 100, 36, 0.035);
    }

    .btn-success {
        background-color: #086424;
        border-color: #086424;
        font-weight: 600;
    }

    .btn-success:hover {
        background-color: #0a7232;
        border-color: #0a7232;
    }

    .badge-custom {
        background-color: #086424;
        color: #fff;
        font-size: 0.75rem;
        padding: 0.35em 0.6em;
        border-radius: 0.4rem;
    }

    .section-title {
        color: #086424;
        font-size: 2rem;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination .page-link {
        color: #086424;
    }

    .pagination .page-item.active .page-link {
        background-color: #086424;
        border-color: #086424;
    }

    input[type="checkbox"] {
        width: 1.15rem;
        height: 1.15rem;
        accent-color: #086424;
    }

    .table-responsive {
        border-top: 1px solid rgba(8, 100, 36, 0.15);
    }
</style>

<div class="container py-4">

    @if($pendingChange->isEmpty())
        <div class="alert alert-warning shadow-sm rounded">
            <strong>কোনো পরিবর্তন নেই</strong>
        </div>
    @else
        <div class="custom-card">
            <div class="custom-header d-flex justify-content-between">
                <span>📋 পরিবর্তনসমূহের তালিকা</span>
            </div>

            <div class="card-body p-0">
                <form action="{{ route('changeApproval') }}" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table class="table custom-table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="select-all"></th>
                                    <th>#</th>
                                    <th>ফর্মের নাম</th>
                                    <th>কর্মচারী</th>
                                    <th>ফিল্ডের নাম</th>
                                    <th>পূর্বের তথ্য</th>
                                    <th>পরিবর্তিত তথ্য</th>
                                    <th>পরিবর্তনকারী</th>
                                    <th>তারিখ</th>
                                    <th>অবস্থা</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendingChange as $change)
                                    <tr>
                                        <td><input type="checkbox" name="changes[]" value="{{ $change->id }}"></td>
                                        <td>{{ englishToBanglaNumber($loop->iteration) }}</td>
                                        <td>
                                            @switch($change->form)
                                                @case(2) শিক্ষাগত তথ্য @break
                                                @case(3) পেশাগত তথ্য @break
                                                @case(4)
                                                    @php $addressType = $change->relatedData->address_type; @endphp
                                                    {{ $addressType === 'permanent' ? 'স্থায়ী ঠিকানা' : 'বর্তমান ঠিকানা' }}
                                                    @break
                                                @case(5) জরুরী যোগাযোগ @break
                                                @case(6) স্বামী/স্ত্রীর তথ্য @break
                                                @case(7) সন্তানদের তথ্য @break
                                                @case(8) চাকরির বিবরণ @break
                                                @case(9) পদোন্নতির তথ্য @break
                                                @case(10) ছুটির তালিকা @break
                                                @case(11) স্থানীয় প্রশিক্ষণ @break
                                                @case(12) বিদেশ ভ্রমণ (দাপ্তরিক) @break
                                                @case(13) সহ-পাঠ্যক্রমিক কার্যক্রম @break
                                                @case(14) প্রকাশনা @break
                                                @case(15) পুরস্কার @break
                                                @case(16) পরিষেবা/চাকরি/লিয়েন @break
                                                @case(17) মামলা @break
                                                @case(18) এসিআর পর্যবেক্ষণ @break
                                                @case(19) টাইম স্কেল/উচ্চতর গ্রেড/বেতন সংরক্ষণ @break
                                                @case(20) পুলিশ ভেরিফিকেশন @break
                                                @case(21) অন্যান্য @break
                                            @endswitch
                                        </td>
                                        <td>
                                            <strong>{{ $change->employee->fullname_bn ?? 'N/A' }}</strong><br>
                                            <span class="badge-custom">{{ englishToBanglaNumber($change->employee->employeeid) ?? 'N/A' }}</span>
                                        </td>
                                        <td>{{ $change->level ?? 'N/A' }}</td>
                                        <td>{!! $change->previous_data ?? 'N/A' !!}</td>
                                        <td>{!! $change->formatted_content !!}</td>
                                        <td>
                                            <strong>{{ $change->user->name ?? 'N/A' }}</strong><br>
                                            <span class="badge-custom">{{ $change->user->designations->name_bn ?? 'এডমিন' }}</span>
                                        </td>
                                        <td>{{ englishToBanglaNumber($change->created_at->format('d/m/Y')) }}</td>
                                        <td>
                                            <span class="badge {{ $change->status == 0 ? 'bg-warning text-dark' : 'bg-success' }}">
                                                {{ $change->status == 0 ? 'অপেক্ষায়' : 'অনুমোদিত' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap">
                        <div class="pagination mb-2">
                            {{ $pendingChange->links('pagination::bootstrap-4') }}
                        </div>
                        <button type="submit" class="btn btn-success shadow-sm"
                        onclick="return confirm('অনুমোদন হয়ে গেলে আপনি আর পুর্বের তথ্যে ফেরত যেতে পারবেন না। আপনি কি নিশ্চিতভাবে নির্বাচিতগুলো অনুমোদন করতে চান?');">
                            ✅ নির্বাচিতগুলো অনুমোদন করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

<script>
    document.getElementById('select-all').addEventListener('change', function () {
        document.querySelectorAll('input[name="changes[]"]').forEach(cb => cb.checked = this.checked);
    });
</script>
@endsection
