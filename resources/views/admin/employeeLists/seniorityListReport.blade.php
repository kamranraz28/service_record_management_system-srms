@extends('layouts.admin')

@section('content')
<div>
    <div class="row">
    <div class="col-md-12 d-flex justify-content-between align-items-center h4">
        <div>
            @if (app()->getLocale() === 'bn')
                জ্যেষ্ঠতা তালিকা প্রণয়ন সংক্রান্ত চাকরির তথ্যের ছক
            @else
                Table of Job Information regarding preparation of seniority list
            @endif 
        </div>
       <div>
            <a href="{{route('admin.seniority_list_report_download')}}" class="btn btn-primary">
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
			<th>@if (app()->getLocale() === 'bn') বর্তমান কর্মস্থল @else Current Office @endif</th>


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
				<td>
					@if($report['division_bn'])
						@if(app()->getLocale() === 'bn')
						{{ $report['division_bn'] }}
						@else
						{{ $report['division_en'] }}
						@endif
					@elseif($report['circle_bn'])
						@if(app()->getLocale() === 'bn')
						{{ $report['circle_bn'] }}
						@else
						{{ $report['circle_en'] }}
						@endif
					@else
						Admin
					@endif
				</td>
            </tr>
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
