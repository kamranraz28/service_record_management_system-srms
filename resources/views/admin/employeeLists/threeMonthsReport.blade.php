@extends('layouts.admin')

@section('content')
<div>
    <div class="row">
    <div class="col-md-12 d-flex justify-content-between align-items-center h4">
        <div>
            @if (app()->getLocale() === 'bn')
                ত্রৈমাসিক প্রতিবেদন
            @else
                Three Months Report
            @endif 
        </div>
        <div>
            <a href="{{route('admin.downloadThreeMonthsReport')}}" class="btn btn-primary">
				@if (app()->getLocale() === 'bn')
					ডাউনলোড করুন
				@else
					Download Report
				@endif 
			</a>
        </div>
    </div>
</div>


    
<div class="card mb-1 p-2">
    <div class="table-responsive">
				<table class="table table-striped">
			<thead>
				<tr>
					<th rowspan="2">@if (app()->getLocale() === 'bn') ক্রমিক নং @else SN @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') কর্মকর্তা/কর্মচারীর নাম @else Employee Name @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') পদবী @else Designation @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') গ্রেড @else Grade @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') জন্ম তারিখ @else Date of Birth @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') নিজ জেলা @else Home District @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') স্থায়ী ঠিকানা @else Permanent Address @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') বর্তমান ঠিকানা @else Present Address @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') চাকরিতে যোগদানের তারিখ @else First Joining Date @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') বর্তমান পদে পদোন্নতির তারিখ @else Promotion Date @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') কর্মরত সার্কেল/ অফিসের নাম @else Circle/Office Name @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') কর্মরত সার্কেল/ অফিসে যোগদানের তারিখ @else Office Joining Date @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') বিভাগ @else Division @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') রেঞ্জ @else Range @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') নার্সারি/বিট @else Nursery/Beat @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') রাজস্ব যোগদানের তারিখ @else Revenue Joining Date @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') প্রকল্প যোগদানের তারিখ ও নাম @else Project Date & Name @endif</th>

					
					<th colspan="3">@if (app()->getLocale() === 'bn') যে দপ্তর বা বিভাগে চাকরি করেছেন নাম ও চাকরি কাল @else Work Office History @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') মোট চাকরির সময়কাল@else Total Job Duration @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') কোন বিশেষ কোটায় নিয়োগ হলে কোটার নাম@else Quota @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') মুক্তিযোদ্ধা কোটায় নিয়োগপ্রাপ্ত হলে মুক্তিযোদ্ধার সাথে সম্পর্ক@else Relation with Freedom @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') মুক্তিযোদ্ধার নাম, ঠিকানা ও সনদ নম্বর ও গেজেট নম্বর@else Relation with Freedom @endif</th>
					<th rowspan="2">@if (app()->getLocale() === 'bn') প্রশিক্ষণ সংক্রান্ত তথ্য (প্রশিক্ষণের নাম)@else Training Name @endif</th>
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
    @foreach($threeMonthsReport as $report)
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
                    {{$report['permanent_address_bn']}}
                @else
                    {{$report['permanent_address_en']}}
                @endif
            </td>
            <td rowspan="{{ $rowspan }}">
                @if (app()->getLocale() === 'bn')
                    {{$report['present_address_bn']}}
                @else
                    {{$report['present_address_en']}}
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
                    {{$report['circle_name_bn']}}{{$report['office_name']}}
                @else
                    {{$report['circle_name_en']}}{{$report['office_name']}}
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
                @if (app()->getLocale() === 'bn')
                    {{$report['division_name_bn']}}
                @else
                    {{$report['division_name_en']}}
                @endif
            </td>
            <td rowspan="{{ $rowspan }}">
                @if (app()->getLocale() === 'bn')
                    {{$report['range_name_bn']}}
                @else
                    {{$report['range_name_en']}}
                @endif
            </td>
            <td rowspan="{{ $rowspan }}">
                @if (app()->getLocale() === 'bn')
                    {{$report['beat_name_bn']}}
                @else
                    {{$report['beat_name_en']}}
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
                    {{ $report['relation_bn'] }}
                @else
                    {{ $report['relation_en'] }}
                @endif
            </td>
            
            <td rowspan="{{ $rowspan }}">
                {{ $report['fighter_name'] }} - {{ $report['fighter_address'] }} - {{ $report['fighter_address'] }}
            </td>
            
            <td rowspan="{{ $rowspan }}">
				@if ($report['training_histories'])
					@foreach($report['training_histories'] as $training)
						<span>{{ englishToBanglaNumber ($loop->iteration) }}. {{ $training['training_name'] }}</span> <br><br>
					@endforeach
				@else
					-
				@endif
			</td>
			
			<td rowspan="{{ $rowspan }}">
				@if (app()->getLocale() === 'bn')
					@foreach($report['education_histories'] as $education)
						{{ englishToBanglaNumber ($loop->iteration) }}. {{ $education['education_name_bn'] }}<br> <br>
					@endforeach
				@else
					@foreach($report['education_histories'] as $education)
						{{ $loop->iteration }}. {{ $education['education_name_en'] }}<br> <br>
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


    <!-- Pagination -->
    <div class="pagination">
        
    </div>
</div>
@endsection
