@extends('layouts.admin')



@section('content')


<div class="row">



        <div class="col-md-6 h4">@if (app()->getLocale() === 'bn')
        আসন্ন কর্মকর্তা/কর্মচারীর অবসর তালিকা
            @else
                Upcoming Employee Retirement List
            @endif</div>

        <div class="col-md-6 h4 text-end">

            @if (app()->getLocale() === 'bn')
                মোট কর্মকর্তা/কর্মচারী: {{englishToBanglaNumber($data)}}
            @else
                Total Employee: {{$data}}
            @endif

        </div>


	<br>
		<br>

		<div class="col-md-8 mb-3">
    <form action="{{ route('admin.search_retirement') }}" method="POST">
        @csrf

        <!-- Start Date Field with datepicker style -->
        <div class="col-md-8 mb-3">
            <label for="start_date" class="control-label-b">
			@if(app()->getLocale() === 'bn')
				তারিখ হইতে *
			@else
				From Date *
			@endif
			</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input name="start_date" placeholder="YYYY-MM-DD" type="text" class="form-control pull-right datepicker" id="datepicker_start" autocomplete="off" required>
            </div>
        </div>

        <!-- End Date Field with datepicker style -->
        <div class="col-md-8 mb-3">
            <label for="end_date" class="control-label-b">
			@if(app()->getLocale() === 'bn')
				তারিখ পর্যন্ত *
			@else
				End Date *
			@endif
			</label>
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input name="end_date" placeholder="YYYY-MM-DD" type="text" class="form-control pull-right datepicker" id="datepicker_end" autocomplete="off" required>
            </div>
        </div>

        <div class="col-md-8 mb-3">
        <label for="designation_id" class="form-label">
			@if (app()->getLocale() === 'bn')
                পদবি
            @else
                Designation
            @endif
			</label>
            <div class="input-group">
                <select id="designation_id" name="designation_id[]" class="form-control select2 px-5" multiple>

                    @foreach($designations as $designation)
                        <option value="{{ $designation->id }}">{{ $designation->name_bn }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-8 mb-3">
        <label for="circle_id" class="form-label">
			@if (app()->getLocale() === 'bn')
                বন অঞ্চল
            @else
                Forest Circle
            @endif
			</label>
            <div class="input-group">
                <select id="circle_id" name="circle_id" class="form-control select2 px-5">
                    <option value="" disabled selected>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($forest_circles as $circle)
                        <option value="{{ $circle->id }}">{{ $circle->name_bn }}</option>
                    @endforeach
                </select>

            </div>
        </div>

        <div class="col-md-8 mb-3">
        <label for="designation_id" class="form-label">
			@if (app()->getLocale() === 'bn')
                বন বিভাগ
            @else
                Forest Division
            @endif
			</label>
            <div class="input-group">
                <select id="division_id" name="division_id" class="form-control select2 px-5">
                    <option value="" disabled selected>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($forest_divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->name_bn }}</option>
                    @endforeach
                </select>

            </div>
        </div>



        <!-- Search Button -->
        <div class="col-md-8">
            <button type="submit" class="btn btn-success">
                <i class="fa fa-search" aria-hidden="true"></i>
                {{ trans('global.search') }}
            </button>
        </div>

    </form>
</div>


    </div>

	<br>
		<br>





@foreach ($employeeList as $result)


<div class="card mb-1 p-2">



            <div class="row justify-content-center align-items-center g-3">


                <div class="col">
                    <div class="d-flex align-items-center">
                        <div class="customer-pic p-2">
                        @if ($result->employee_photo)
                                <a href="{{ $result->employee_photo->getUrl() }}" target="_blank"
                                    style="display: inline-block">

                                    <img src="{{ $result->employee_photo->getUrl('thumb') }}" class="rounded-circle"
                                        width="50" height="50" alt="">
                                </a>
                            @else
                                <img src="{{ asset('assets/images/logo1.png') }}" class="rounded-circle" width="50"
                                    height="50" alt="">
                            @endif

                        </div>
                        <div>
                            <p class="customer-name fw-bold mb-0">

                                @if (app()->getLocale() === 'bn')
                                    {{ $result['fullname_bn'] }}
                                @else
                                    {{ $result['fullname_en'] }}
                                @endif


                            </p>
                            <p class="mb-0">{{ englishToBanglaNumber($result['employeeid'] ?? 'N/A') }}</p>

                        </div>
                    </div>
                </div>





                <div class="col">

                        <span class="badge bg-warning"style="
                        background-color: #5d1f1f17 !important;
                        color: #5d1f1f !important;
                        padding: 6px !IMPORTANT;
                        border-radius: 25px;
                    "> @if(app()->getLocale() === 'bn')
							   {{ $result->designation->name_bn ?? 'N/A' }}
						   @else
							   {{ $result->designation->name_en ?? 'N/A' }}
						   @endif</span>





                </div>
                <div class="col mb-0"> <b>


                    @if (app()->getLocale() === 'bn')
                        অবসরের তারিখ
                    @else
                        Retirement Date:
                    @endif </b><br>
                    <p class="mb-0" >{{ englishToBanglaNumber($result['prl_date'] ?? 'N/A') }}</p>

                </div>
                <div class="col text-end">
                    <div class="btn-group">
                        <a href="{{ route('admin.employeedata', ['id' => $result['id']]) }}"
                            class="btn btn-sm btn-outline-success">
                            {{ trans('global.view') }}
                        </a>
                        <a href="{{ route('admin.commonemployeeshow', ['id' => $result['id']]) }}"
                            class="btn btn-sm btn-outline-success">
                            {{ trans('global.edit') }}
                        </a>
                        <a href="{{ route('admin.employeedata.pdf', ['id' => $result['id']]) }}"
                            class="btn btn-sm btn-outline-success">

                            @if (app()->getLocale() === 'bn')
                                পিডিএফ
                            @else
                                PDF
                            @endif

                        </a>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
		<div class="pagination">
        {{ $employeeList->links('pagination::bootstrap-4') }}
    </div>
    @php
    session()->forget(['from_date', 'to_date','designation_id','division_id','circle_id']);
@endphp

@endsection



