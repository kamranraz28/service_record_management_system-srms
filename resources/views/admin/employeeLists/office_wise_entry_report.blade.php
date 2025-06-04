@extends('layouts.admin')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali&display=swap');

    .report-wrapper {
        font-family: 'Noto Sans Bengali', sans-serif;
        background: #f9f9f9;
        color: #333;
        padding: 24px;
    }

    .report-wrapper h2 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #006625;
        margin-bottom: 12px;
    }

    .download-link {
        display: inline-block;
        margin-bottom: 20px;
        padding: 8px 16px;
        background: #006625;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        font-weight: 600;
    }

    .download-link:hover {
        background: #004d1a;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    thead {
        background-color: #006625;
        color: #fff;
    }

    th, td {
        padding: 12px 16px;
        border: 1px solid #ddd;
        text-align: center;
    }

    th:nth-child(2),
    td:nth-child(2) {
        text-align: left;
    }

    .forest-row {
        background-color: #dff0d8;
        font-weight: 700;
        color: #2d572c;
    }

    .division-row td:nth-child(2) {
        padding-left: 32px;
        color: #004d1a;
    }

    .total-row {
        background-color: #e6f2e6;
        font-weight: 700;
        color: #2d572c;
    }
</style>

<div class="report-wrapper">
    <h2>অফিসভিত্তিক এন্ট্রি রিপোর্ট</h2>

    <a href="{{ route('admin.office_entry_report_pdf') }}" target="_blank" class="download-link">
        রিপোর্ট পিডিএফ হিসেবে ডাউনলোড করুন
    </a>

    <table>
        <thead>
            <tr>
                <th>ক্রমিক নং</th>
                <th>অফিসের নাম</th>
                <th>এন্ট্রির সংখ্যা</th>
            </tr>
        </thead>
        <tbody>
            @php $totalEntries = 0; @endphp
            @foreach($reportList as $index => $report)
                @php $totalEntries += $report->count; @endphp
                @if ($report->type === 'forest_state')
                    <tr class="forest-row">
                        <td>{{ englishToBanglaNumber($index + 1) }}</td>
                        <td>{{ $report->office }}</td>
                        <td>{{ englishToBanglaNumber($report->count) }}</td>
                    </tr>
                @else
                    <tr class="division-row">
                        <td>{{ englishToBanglaNumber($index + 1) }}</td>
                        <td>{{ $report->office }}</td>
                        <td>{{ englishToBanglaNumber($report->count) }}</td>
                    </tr>
                @endif
            @endforeach
            <tr class="total-row">
                <td colspan="2">সর্বমোট</td>
                <td>{{ englishToBanglaNumber($totalEntries) }}</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
