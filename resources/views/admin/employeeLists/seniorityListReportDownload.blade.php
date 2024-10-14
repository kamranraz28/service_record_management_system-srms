<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three Months Report</title>
    <!-- Include any CSS styles if needed -->
    <style>
        body {
            font-family: 'nsikosh', sans-serif;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {

            font-weight: normal;
            border: 0.1px solid black;
            padding: 8px;
            text-align: left;
            padding: 4;
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

<body style="padding: 20px">
    {{-- <htmlpageheader name="page-header">
        Your Header Content
    </htmlpageheader> --}}
	<table class="header w-100" cellspacing="0" cellpadding="0">
        <tr>
            
            <td style="text-align: center;" style="border: 0;">
                <center>
                    <h2 style="color: #006625; margin:0">বন অধিদপ্তর-গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</h2>
                    @if (app()->getLocale() === 'bn')
                    <h3 style=" margin:0"> সার্ভিস রেকর্ড ম্যানেজমেন্ট সিস্টেম<br>
						জ্যেষ্ঠতা তালিকা প্রণয়ন সংক্রান্ত চাকরির তথ্যের ছক
					</h3>
                        
                    @else
                    <h3 style=" margin:0"> Service Record Management System <br>
						Table of Job Information regarding preparation of seniority list
					</h3>
                        
                    
                    @endif
                    <br>
                </center>
            </td>

        </tr>
    </table>
		<br>

    <table >
    <thead>
        <tr>
            <th>@if (app()->getLocale() === 'bn') ক্রমিক নং @else SN @endif</th>
            <th>@if (app()->getLocale() === 'bn') কর্মকর্তা/কর্মচারীর নাম @else Employee Name @endif</th>
            <th>@if (app()->getLocale() === 'bn') পদের নাম @else Designation @endif</th>
            <th>@if (app()->getLocale() === 'bn') নিজ জেলা @else Home District @endif</th>
            <th>@if (app()->getLocale() === 'bn') জন্ম তারিখ @else Date of Birth @endif</th>
            <th>@if (app()->getLocale() === 'bn') নিয়োগ আদেশের তারিখ (এডহক/প্রকল্প) @else First joining G.O. Date (Adhok/Project) @endif</th>
            <th>@if (app()->getLocale() === 'bn') চাকুরিতে প্রথম যোগদানের তারিখ @else Date of First Joining @endif</th>
            <th>@if (app()->getLocale() === 'bn') বর্তমান পদে যোগদানের তারিখ @else Promotion Date @endif</th>
            <th>@if (app()->getLocale() === 'bn') প্রকল্পে নিয়োগের ক্ষেত্রে রাজস্বখাতে যোগদানের তারিখ @else Date of Regularization from Project @endif</th>
            <th>@if (app()->getLocale() === 'bn') চাকুরিতে স্থায়ী কিনা @else Permanent or Not? @endif</th>
            <th>@if (app()->getLocale() === 'bn') প্রশিক্ষণের তথ্য @else Training Details @endif</th>
			

        </tr>
        
    </thead>
    <tbody>
        @foreach($seniorityListReport as $report)
            <tr>
                <td>
                    @if (app()->getLocale() === 'bn')
                        {{ englishToBanglaNumber($loop->iteration) }}
                    @else
                        {{ $loop->iteration }}
                    @endif
                </td>
                <td>
                    @if (app()->getLocale() === 'bn')
                        {{$report['employee_name_bn']}}
                    @else
                        {{$report['employee_name_en']}}
                    @endif
                </td>
                <td>
                    @if (app()->getLocale() === 'bn')
                        {{$report['designation_bn']}}
                    @else
                        {{$report['designation_en']}}
                    @endif
                </td>
                <td>
                    @if (app()->getLocale() === 'bn')
                        {{$report['home_district_bn']}}
                    @else
                        {{$report['home_district_en']}}
                    @endif
                </td>
                <td>
                    @if (app()->getLocale() === 'bn')
                        {{ englishToBanglaNumber($report['dob']) }}
                    @else
                        {{$report['dob']}}
                    @endif
                </td>
                <td>
                    @if ($report['project_id'])
                        @if (app()->getLocale() === 'bn')
                            {{ englishToBanglaNumber($report['fjoining_date']) }}
                        @else
                            {{$report['fjoining_date'] }}
                        @endif
                    @endif
                </td>
                <td>
                    @if (app()->getLocale() === 'bn')
                        {{ englishToBanglaNumber($report['fjoining_date']) }}
                    @else
                        {{$report['fjoining_date'] }}
                    @endif
                </td>
                <td>
                    @if (app()->getLocale() === 'bn')
                        {{ englishToBanglaNumber($report['promotion_date']) }}
                    @else
                        {{$report['promotion_date']}}
                    @endif
                </td>
                <td>
                    @if ($report['project_id'])
                        @if (app()->getLocale() === 'bn')
                            {{ englishToBanglaNumber($report['regularization_date']) }}
                        @else
                            {{$report['regularization_date'] }}
                        @endif
                    @endif
                </td>
                <td>
                    @if ($report['project_id'])
                        @if($report['regularization_date'])
                            @if (app()->getLocale() === 'bn')
                                স্থায়ী
                            @else
                                Permanent
                            @endif
                        @else
                            @if (app()->getLocale() === 'bn')
                                অস্থায়ী
                            @else
                                Not Permanent
                            @endif
                        @endif
                    @else
                        @if (app()->getLocale() === 'bn')
                            স্থায়ী
                        @else
                            Permanent
                        @endif
                    @endif
                </td>
                <td>
                    <table style="width: 100%;">
						
                        <tbody>
                            @if (is_array($report['training_info']) && count($report['training_info']) > 0)
                                @foreach($report['training_info'] as $training)
                                    <tr>
                                        <td>{{ $training['training_name'] }}</td>
                                        <td>{{ $training['institute'] }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2">
                                        @if (app()->getLocale() === 'bn')
                                            প্রশিক্ষণের তথ্য নেই
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
            </div>
        </div>
    </div>
    <htmlpagefooter name="page-footer">

        @if (app()->getLocale() === 'bn')
        পৃষ্ঠা নং: {PAGENO}
        @else
        Page No {PAGENO}
        @endif

        <br><br>
    </htmlpagefooter>
</body>

</html>