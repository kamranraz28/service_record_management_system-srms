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
            border: 1px solid black;
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
						ত্রৈমাসিক প্রতিবেদন
					</h3>
                    <p>
                    বন অঞ্চলঃ {{$desig['name_bn']}}
                    </p>

                        
                    @else
                    <h3 style=" margin:0"> Service Record Management System <br>
						Three Months Report
                        
					</h3>
                    <p>
                    Forest Circle: {{$desig['name_en']}}
                    </p>
                        
                    
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
					<th rowspan="2">@if (app()->getLocale() === 'bn') ক্রমিক নং @else SN @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') কর্মকর্তা/কর্মচারীর নাম @else Employee Name @endif</th>
                    <th rowspan="2">@if (app()->getLocale() === 'bn') লিঙ্গ @else Gender @endif</th>

					<th rowspan="2">@if (app()->getLocale() === 'bn') পদবী @else Designation @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') গ্রেড @else Grade @endif</th>
					
					<th rowspan="2">@if (app()->getLocale() === 'bn') জন্ম তারিখ @else Date of Birth @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') নিজ জেলা @else Home District @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') স্থায়ী ঠিকানা @else Permanent Address @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') বর্তমান ঠিকানা @else Present Address @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') চাকরিতে যোগদানের তারিখ @else First Joining Date @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') বর্তমান পদে পদোন্নতির তারিখ @else Promotion Date @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') বর্তমান কর্মরত অফিসের নাম @else Current Office Name @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') কর্মরত সার্কেল/ অফিসে যোগদানের তারিখ @else Office Joining Date @endif</th>

					<th rowspan="2">@if (app()->getLocale() === 'bn') রাজস্ব যোগদানের তারিখ @else Revenue Joining Date @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') প্রকল্প যোগদানের তারিখ ও নাম @else Project Date & Name @endif</th>

					
					<th colspan="3">@if (app()->getLocale() === 'bn') যে দপ্তর বা বিভাগে চাকরি করেছেন নাম ও চাকরি কাল @else Work Office History @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') মোট চাকরির সময়কাল@else Total Job Duration @endif</th>
                    <th rowspan="2">@if (app()->getLocale() === 'bn') কোন বিশেষ কোটায় নিয়োগ হলে কোটার নাম@else Quota @endif</th>

					<th rowspan="2">@if (app()->getLocale() === 'bn') শিক্ষাগত যোগ্যতা@else  Educational Qualification @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') বিভাগীয় মামলা রুজু করা হয়ে থাকলে রুজুর অফিস আদেশ নং, নিষ্পত্তির আদেশ নং ও বিবরণ@else If any Departmental Procecution? Ruju Number, Closing Number & Description @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') অবসর গ্রহণের তারিখ @else PRL Date @endif</th>
					

				</tr>
				<tr>
					
					<th>@if (app()->getLocale() === 'bn') দপ্তরের নাম @else Work Place Name @endif</th>
					<th>@if (app()->getLocale() === 'bn') আরম্ভ @else Start @endif</th>
					<th>@if (app()->getLocale() === 'bn') শেষ @else End @endif</th>
				</tr>
				
					

				
				
			</thead>
			<tbody>
    @foreach($chunkReport as $report)
        @php $rowspan = count($report['job_histories']) ?: 1; @endphp
        
        <tr>
            <td rowspan="{{ $rowspan }}">
                @if (app()->getLocale() === 'bn')
                    {{ englishToBanglaNumber($loop->iteration) }}
                @else
                    {{ $loop->iteration }}
                @endif
            </td>
            <td rowspan="{{ $rowspan }}">
                @if (app()->getLocale() === 'bn')
                    {{$report['employee_name_bn']}}
                @else
                    {{$report['employee_name_en']}}
                @endif
            </td>
            <td rowspan="{{ $rowspan }}">
                @if (app()->getLocale() === 'bn')
                    {{$report['gender_bn']}}
                @else
                    {{$report['gender_en']}}
                @endif
            </td>
            <td rowspan="{{ $rowspan }}">
                @if (app()->getLocale() === 'bn')
                    {{$report['designation_bn']}}
                @else
                    {{$report['designation_en']}}
                @endif
            </td>
            <td rowspan="{{ $rowspan }}">
                @if ($report['promotion_grade_bn'])
                    @if (app()->getLocale() === 'bn')
                        {{ $report['promotion_grade_bn'] }}
                    @else
                        {{ $report['promotion_grade_en'] }}
                    @endif
                @else
                    @if (app()->getLocale() === 'bn')
                        {{ $report['grade_bn'] }}
                    @else
                        {{ $report['grade_en'] }}
                    @endif
                @endif
            </td>
            
        
            <td rowspan="{{ $rowspan }}">
                @if (app()->getLocale() === 'bn')
                    {{ englishToBanglaNumber($report['dob']) }}
                @else
                    {{$report['dob']}}
                @endif
            </td>
            <td rowspan="{{ $rowspan }}">
                @if (app()->getLocale() === 'bn')
                    {{$report['home_district_bn']}}
                @else
                    {{$report['home_district_en']}}
                @endif
            </td>
            <td rowspan="{{ $rowspan }}">
                @if (app()->getLocale() === 'bn')
                ফ্ল্যাট/বাড়ি/গ্রাম/রাস্তাঃ {{$report['permanent_village']}} <br>
                ডাকঘরঃ {{$report['permanent_post']}} <br>
                উপজেলাঃ {{$report['permanent_address_bn']}} <br>
                জেলাঃ {{$report['permanent_district_bn']}}
                @else
                Flat/House/Village/Road {{$report['permanent_village']}} <br>
                Post Office: {{$report['permanent_post']}} <br>
                Upazilla: {{$report['permanent_address_en']}} <br>
                District: {{$report['permanent_district_en']}}
                @endif
            </td>
            <td rowspan="{{ $rowspan }}">
                @if (app()->getLocale() === 'bn')
                ফ্ল্যাট/বাড়ি/গ্রাম/রাস্তাঃ {{$report['present_village']}} <br>
                ডাকঘরঃ {{$report['present_post']}} <br>
                উপজেলাঃ {{$report['present_address_bn']}} <br>
                জেলাঃ {{$report['present_district_bn']}}
                @else
                Flat/House/Village/Road {{$report['present_village']}} <br>
                Post Office: {{$report['present_post']}} <br>
                Upazilla: {{$report['present_address_en']}} <br>
                District: {{$report['present_district_en']}}
                @endif
            </td>
            <td rowspan="{{ $rowspan }}">
                @if (app()->getLocale() === 'bn')
                    {{ englishToBanglaNumber($report['fjoining_date']) }}
                @else
                    {{$report['fjoining_date']}}
                @endif
            </td>
            <td rowspan="{{ $rowspan }}">
                @if (app()->getLocale() === 'bn')
                    {{ englishToBanglaNumber($report['promotion_date']) }}
                @else
                    {{$report['promotion_date']}}
                @endif
            </td>
            <td rowspan="{{ $rowspan }}">
				
                @if (app()->getLocale() === 'bn')
					অঞ্চলঃ
                    {{$report['circle_name_bn']}}{{$report['office_name']}} <br>
					বিভাগঃ 
					{{$report['division_name_bn']}} <br>
					রেঞ্জঃ
					{{$report['range_name_bn']}} <br>
					বিটঃ
					{{$report['beat_name_bn']}} <br>
                @else
					Circle:
                    {{$report['circle_name_en']}}{{$report['office_name']}} <br>
					Division:
					{{$report['division_name_en']}} <br>
					Range:
					{{$report['range_name_en']}} <br>
					Beat: 
					{{$report['beat_name_en']}} <br>
                @endif
				
				
            </td>
			<td rowspan="{{ $rowspan }}">
                @if (app()->getLocale() === 'bn')
                    {{ englishToBanglaNumber($report['joining_date']) }}
                @else
                    {{$report['joining_date']}}
                @endif
            </td>
            <td rowspan="{{ $rowspan }}">
                @if ($report['revenue_id'] == 2)
                    @if (app()->getLocale() === 'bn')
                        {{ englishToBanglaNumber($report['fjoining_date']) }}
                    @else
                        {{$report['fjoining_date'] }}
                    @endif
                @endif
            </td>
            <td rowspan="{{ $rowspan }}">
                @if ($report['project_id'])
                    @if (app()->getLocale() === 'bn')
                        {{ englishToBanglaNumber($report['fjoining_date']) }} - {{$report['project_name_bn'] }}
                    @else
                        {{$report['fjoining_date'] }} - {{$report['project_name_en'] }}
                    @endif
                @endif
            </td>
            
            <td>
                @if (app()->getLocale() === 'bn')
                    @if (!empty($report['job_histories'][0]['work_place_bn']))
                        {{ englishToBanglaNumber($report['job_histories'][0]['work_place_bn']) }}
                    @else
                        -
                    @endif
                @else
                    {{ $report['job_histories'][0]['work_place_en'] ?? '-' }}
                @endif
            </td>
            <td>
                @if (app()->getLocale() === 'bn')
                    @if (!empty($report['job_histories'][0]['start_date']))
                        {{ englishToBanglaNumber($report['job_histories'][0]['start_date']) }}
                    @else
                        -
                    @endif
                @else
                    {{ $report['job_histories'][0]['start_date'] ?? '-' }}
                @endif
            </td>

            <td>
                @if (app()->getLocale() === 'bn')
                    @if (!empty($report['job_histories'][0]['end_date']))
                        {{ englishToBanglaNumber($report['job_histories'][0]['end_date']) }}
                    @else
                        -
                    @endif
                @else
                    {{ $report['job_histories'][0]['end_date'] ?? '-' }}
                @endif
            </td>
            
            <td rowspan="{{ $rowspan }}">
                @if (app()->getLocale() === 'bn')
                    {{ englishToBanglaNumber($report['total_job_bn']) }}
                @else
                    {{ $report['total_job_en'] }}
                @endif
            </td>

            <td rowspan="{{ $rowspan }}">
                @if (app()->getLocale() === 'bn')
                    {{ $report['quota_bn'] }}
                @else
                    {{ $report['quota_en'] }}
                @endif
            </td>
        
			
			<td rowspan="{{ $rowspan }}">
				@if (app()->getLocale() === 'bn')
					@foreach($report['education_histories'] as $education)
						{{ englishToBanglaNumber ($loop->iteration) }}. {{ $education['education_name_bn'] }} - 
						{{ $education['board_name_bn'] }}<br> <br>
					@endforeach
				@else
					@foreach($report['education_histories'] as $education)
						{{ $loop->iteration }}. {{ $education['education_name_en'] }} - 
						{{ $education['board_name_en'] }}<br> <br>
					@endforeach
				@endif
			</td>
			
			<td rowspan="{{ $rowspan }}">
				@if (app()->getLocale() === 'bn')
					@foreach($report['mamla_histories'] as $mamla)
						{{ englishToBanglaNumber ($loop->iteration) }}. {{ $mamla['mamla_name_bn'] }} - 
						{{ $mamla['mamla_start'] }} - {{ $mamla['mamla_end'] }}  - 
						{{ $mamla['comment'] }}<br> <br>
					@endforeach
				@else
					@foreach($report['mamla_histories'] as $mamla)
						{{ $loop->iteration }}. {{ $mamla['mamla_name_en'] }} - 
						{{ $mamla['mamla_start'] }} - {{ $mamla['mamla_end'] }} - 
						{{ $mamla['comment'] }}<br> <br>
					@endforeach
				@endif
			</td>
			
			<td rowspan="{{ $rowspan }}">
                @if (app()->getLocale() === 'bn')
                    {{ englishToBanglaNumber($report['prl_date']) }}
                @else
                    {{$report['prl_date']}}
                @endif
            </td>



        </tr>

        @foreach(array_slice($report['job_histories'], 1) as $job)
            <tr>
                <td>
                    @if (app()->getLocale() === 'bn')
                        {{ $job['work_place_bn'] }}
                    @else
                        {{ $job['work_place_en'] }}
                    @endif
                </td>
                <td>
                    @if (app()->getLocale() === 'bn')
                        {{ englishToBanglaNumber($job['start_date']) }}
                    @else
                        {{ $job['start_date'] }}
                    @endif
                </td>
                <td>
                    @if (app()->getLocale() === 'bn')
                        {{ englishToBanglaNumber($job['end_date']) }}
                    @else
                        {{ $job['end_date'] }}
                    @endif
                </td>
            </tr>
        @endforeach
        
        
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