<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three Months Report</title>
    <style>
        body {
            font-family: 'nsikosh', sans-serif;
            font-size: 14px;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            font-weight: normal;
            border: 0.1px solid black;
            padding: 4px;
            text-align: left;
            vertical-align: top;
        }

        h2, h3 {
            margin: 0;
        }

        strong {
            font-size: 18px;
            line-height: 20px;
            margin-top: 20px;
        }

        @page {
            header: page-header;
            footer: page-footer;
        }
    </style>
</head>

<body>

    {{-- <htmlpageheader name="page-header">Your Header Content</htmlpageheader> --}}

    <table class="header">
        <tr>
            <td style="text-align: center;">
                <h2 style="color: #006625;">বন অধিদপ্তর-গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</h2>
                @if (app()->getLocale() === 'bn')
                    <h3>সার্ভিস রেকর্ড ম্যানেজমেন্ট সিস্টেম<br>জ্যেষ্ঠতা তালিকা প্রণয়ন সংক্রান্ত চাকরির তথ্যের ছক</h3>
                @else
                    <h3>Service Record Management System<br>Table of Job Information regarding preparation of seniority list</h3>
                @endif
                <br>
            </td>
        </tr>
    </table>

    <br>

    <table>
        <thead>
            <tr>
                <th>@lang('SN')</th>
                <th>@lang('Employee Name')</th>
                <th>@lang('Designation')</th>
                <th>@lang('Home District')</th>
                <th>@lang('Date of Birth')</th>
                <th>@lang('First joining G.O. Date (Adhoc/Project)')</th>
                <th>@lang('Date of First Joining')</th>
                <th>@lang('Promotion Date')</th>
                <th>@lang('Project/Revenue/Adhoc')</th>
                <th>@lang('Project Name')</th>
                <th>@lang('Date of Regularization from Project')</th>
                <th>@lang('Date of Regularization')</th>
                <th>@lang('Permanent or Not?')</th>
                <th>@lang('Training Details')</th>
                <th>@lang('Current Office')</th>
            </tr>
        </thead>

        <tbody>
            @php $counter = 1; @endphp
            @foreach($seniorityListReport->chunk(100) as $chunk)
                @foreach($chunk as $report)
                    <tr>
                        <td>
                            {{ app()->getLocale() === 'bn' ? englishToBanglaNumber($counter++) : $counter++ }}
                        </td>
                        <td>{{ app()->getLocale() === 'bn' ? ($report['employee_name_bn'] ?? '') : ($report['employee_name_en'] ?? '') }}</td>
                        <td>{{ app()->getLocale() === 'bn' ? ($report['designation_bn'] ?? '') : ($report['designation_en'] ?? '') }}</td>
                        <td>{{ app()->getLocale() === 'bn' ? ($report['home_district_bn'] ?? '') : ($report['home_district_en'] ?? '') }}</td>
                        <td>{{ app()->getLocale() === 'bn' ? englishToBanglaNumber($report['dob'] ?? '') : ($report['dob'] ?? '') }}</td>
                        <td>
                            @if (!empty($report['project_id']))
                                {{ app()->getLocale() === 'bn' ? englishToBanglaNumber($report['fjoining_date'] ?? '') : ($report['fjoining_date'] ?? '') }}
                            @endif
                        </td>
                        <td>{{ app()->getLocale() === 'bn' ? englishToBanglaNumber($report['fjoining_date'] ?? '') : ($report['fjoining_date'] ?? '') }}</td>
                        <td>{{ app()->getLocale() === 'bn' ? englishToBanglaNumber($report['promotion_date'] ?? '') : ($report['promotion_date'] ?? '') }}</td>
                        <td>{{ app()->getLocale() === 'bn' ? ($report['joining_type_bn'] ?? '') : ($report['joining_type_en'] ?? '') }}</td>
                        <td>{{ app()->getLocale() === 'bn' ? ($report['project_name_bn'] ?? '') : ($report['project_name_en'] ?? '') }}</td>
                        <td>
                            @if (!empty($report['project_id']) && !empty($report['regularization_date']))
                                {{ app()->getLocale() === 'bn' ? englishToBanglaNumber($report['regularization_date']) : $report['regularization_date'] }}
                            @endif
                        </td>
                        <td>
                            @if (!empty($report['project_id']))
                                {{ !empty($report['regularization_date']) ? (app()->getLocale() === 'bn' ? 'স্থায়ী' : 'Permanent') : (app()->getLocale() === 'bn' ? 'অস্থায়ী' : 'Not Permanent') }}
                            @else
                                {{ app()->getLocale() === 'bn' ? 'স্থায়ী' : 'Permanent' }}
                            @endif
                        </td>
                        <td>
                            @if (!empty($report['training_info']) && is_array($report['training_info']))
                                @foreach($report['training_info'] as $tIndex => $training)
                                    <span>
                                        {{ app()->getLocale() === 'bn' ? englishToBanglaNumber($tIndex + 1) : $tIndex + 1 }}.
                                        {{ $training['training_name'] ?? '' }}
                                    </span>
                                    <br><br>
                                @endforeach
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if (app()->getLocale() === 'bn')
                                অঞ্চলঃ {{ $report['circle_name_bn'] ?? '' }} {{ $report['office_name'] ?? '' }}<br>
                                বিভাগঃ {{ $report['division_name_bn'] ?? '' }}<br>
                                রেঞ্জঃ {{ $report['range_name_bn'] ?? '' }}<br>
                                বিটঃ {{ $report['beat_name_bn'] ?? '' }}<br>
                            @else
                                Circle: {{ $report['circle_name_en'] ?? '' }} {{ $report['office_name'] ?? '' }}<br>
                                Division: {{ $report['division_name_en'] ?? '' }}<br>
                                Range: {{ $report['range_name_en'] ?? '' }}<br>
                                Beat: {{ $report['beat_name_en'] ?? '' }}<br>
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr style="page-break-after: always;"></tr>
            @endforeach
        </tbody>
    </table>

    <htmlpagefooter name="page-footer">
        {{ app()->getLocale() === 'bn' ? 'পৃষ্ঠা নং:' : 'Page No' }} {PAGENO}
        <br><br>
    </htmlpagefooter>

</body>
</html>
