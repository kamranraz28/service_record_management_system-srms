@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="row mb-3">
        <div class="col-12">
            <h2 class="text-center">
                @if (app()->getLocale() === 'bn')
                    অফিস ভিত্তিক এন্ট্রির তালিকা
                @else
                    Office Wise Entry List
                @endif
            </h2>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>
                        @if (app()->getLocale() === 'bn')
                            ক্রমিক নং
                        @else
                            SL No
                        @endif
                    </th>
                    <th>
                        @if (app()->getLocale() === 'bn')
                            অফিসের নাম
                        @else
                            Office Name
                        @endif
                    </th>
                    <th>
                        @if (app()->getLocale() === 'bn')
                            অনুমোদিত এন্ট্রি সংখ্যা
                        @else
                            Approve Entry
                        @endif
                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach($employeeQuery as $key => $entry)
    <tr>
        <td>{{ englishToBanglaNumber($key + 1) }}</td>
        <td>
            @if ($entry->approve_user)
                @if ($entry->approve_user->circle)
                    {{ $entry->approve_user->circle->name_bn ?? '' }}
                @elseif($entry->approve_user->division)
                    {{ $entry->approve_user->division->name_bn ?? '' }}
                @else
                    Admin
                @endif
            @else
                No User Found
            @endif
        </td>
        <td>{{ englishToBanglaNumber($entry->count) }}</td>
    </tr>
@endforeach

            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" class="text-center">
                        @if (app()->getLocale() === 'bn')
                            মোট অনুমোদিত এন্ট্রি সংখ্যা
                        @else
                            Total Approved Entries
                        @endif
                    </th>
                    <th>
                        {{ englishToBanglaNumber($totalCount) }}
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
