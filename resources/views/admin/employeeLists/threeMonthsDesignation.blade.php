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
		<br>
		<br>




    </div>
</div>

<div class="col">
<a href="{{route('admin.downloadThreeMonthsReport')}}" class="btn btn-success ms-1">
<i class="fa fa-search" aria-hidden="true"></i>
				@if (app()->getLocale() === 'bn')
					পূর্ণ প্রতিবেদন ডাউনলোড করুন
				@else
					Download Full Report
				@endif
			</a>
</div>
<br>
<br>



<div class="col">
    <form action="{{ route('admin.downloadThreeMonthsDesignation') }}" method="POST" class="p-3 border border-dark rounded">
        @csrf
        <div class="mb-3">
            <!-- Label added above the select -->
            <label for="designation_id" class="form-label">
			@if (app()->getLocale() === 'bn')
                পদবি দিয়ে অনুসন্ধান
            @else
                Search by Designation
            @endif
			</label>
            <div class="input-group">
                <select id="designation_id" name="designation_id[]" class="form-control select2 px-5" multiple>

                    @foreach($designations as $designation)
                        <option value="{{ $designation->id }}">{{ $designation->name_bn }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-success ms-1">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    @if (app()->getLocale() === 'bn')
					ডাউনলোড করুন
				@else
					Download Report
				@endif
                </button>
            </div>
        </div>
    </form>
</div>
<br>

<div class="col">
    <form action="{{ route('admin.downloadThreeMonthsDistrict') }}" method="POST" class="p-3 border border-dark rounded">
        @csrf
        <div class="mb-3">
            <!-- Label added above the select -->
            <label for="district_id" class="form-label">
			@if (app()->getLocale() === 'bn')
                নিজ জেলা দিয়ে অনুসন্ধান
            @else
                Search by Home District
            @endif
			</label>
            <div class="input-group">
                <select id="district_id" name="district_id" class="form-control select2 px-5" required>
                    <option value="" disabled selected>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name_bn }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-success ms-1">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    @if (app()->getLocale() === 'bn')
					ডাউনলোড করুন
				@else
					Download Report
				@endif
                </button>
            </div>
        </div>
    </form>
</div>

<br>
<div class="col">
    <form action="{{ route('admin.downloadThreeMonthsQuota') }}" method="POST" class="p-3 border border-dark rounded">
        @csrf
        <div class="mb-3">
            <!-- Label added above the select -->
            <label for="quota_id" class="form-label">
			@if (app()->getLocale() === 'bn')
                কোটা দিয়ে অনুসন্ধান
            @else
                Search by Quota
            @endif
			</label>
            <div class="input-group">
                <select id="quota_id" name="quota_id" class="form-control select2 px-5" required>
                    <option value="" disabled selected>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($quotas as $quota)
                        <option value="{{ $quota->id }}">{{ $quota->name_bn }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-success ms-1">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    @if (app()->getLocale() === 'bn')
					ডাউনলোড করুন
				@else
					Download Report
				@endif
                </button>
            </div>
        </div>
    </form>
</div>

<br>

<div class="col">
    <form action="{{ route('admin.downloadThreeMonthsCircle') }}" method="POST" class="p-3 border border-dark rounded">
        @csrf
        <div class="mb-3">
            <!-- Label added above the select -->
            <label for="circle_id" class="form-label">
			@if (app()->getLocale() === 'bn')
                বন অঞ্চল দিয়ে অনুসন্ধান
            @else
                Search by Forest Circle
            @endif
			</label>
            <div class="input-group">
                <select id="circle_id" name="circle_id" class="form-control select2 px-5" required>
                    <option value="" disabled selected>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($circles as $circle)
                        <option value="{{ $circle->id }}">{{ $circle->name_bn }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-success ms-1">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    @if (app()->getLocale() === 'bn')
					ডাউনলোড করুন
				@else
					Download Report
				@endif
                </button>
            </div>
        </div>
    </form>
</div>

<br>


<div class="col">
    <form action="{{ route('admin.downloadThreeMonthsCircleOffice') }}" method="POST" class="p-3 border border-dark rounded">
        @csrf
        <div class="mb-3">
            <!-- Label added above the select -->
            <label for="circle_id" class="form-label">
			@if (app()->getLocale() === 'bn')
                বন অঞ্চল দিয়ে অনুসন্ধান
            @else
                Search by Forest Circle
            @endif
			</label>
            <div class="input-group">
                <select id="circle_id" name="circle_id" class="form-control select2 px-5" required>
                    <option value="" disabled selected>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($circles as $circle)
                        <option value="{{ $circle->id }}">{{ $circle->name_bn }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-success ms-1">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    @if (app()->getLocale() === 'bn')
					ডাউনলোড করুন
				@else
					Download Report
				@endif
                </button>
            </div>
        </div>
    </form>
</div>

<br>


<div class="col">
    <form action="{{ route('admin.downloadThreeMonthsDivision') }}" method="POST" class="p-3 border border-dark rounded">
        @csrf
        <div class="mb-3">
            <!-- Label added above the select -->
            <label for="division_id" class="form-label">
			@if (app()->getLocale() === 'bn')
                বন বিভাগ দিয়ে অনুসন্ধান
            @else
                Search by Forest Division
            @endif
			</label>
            <div class="input-group">
                <select id="division_id" name="division_id" class="form-control select2 px-5" required>
                    <option value="" disabled selected>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->name_bn }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-success ms-1">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    @if (app()->getLocale() === 'bn')
					ডাউনলোড করুন
				@else
					Download Report
				@endif
                </button>
            </div>


        </div>


    </form>
</div>

<br>


<div class="col">
    <form action="{{ route('admin.downloadThreeMonthsMultiple') }}" method="POST" class="p-3 border border-dark rounded">
        @csrf

        <!-- First Select Field -->
        <div class="mb-3">
            <label for="division_id" class="form-label">
                @if (app()->getLocale() === 'bn')
                    বন বিভাগ
                @else
                    Forest Division
                @endif
            </label>
            <div class="input-group">
                <select id="division_id" name="division_id" class="form-control select2 px-5">
                    <option value="" disabled selected>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->name_bn }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Second Select Field -->
        <div class="mb-3">
            <!-- Label added above the select -->
            <label for="district_id" class="form-label">
			@if (app()->getLocale() === 'bn')
                জেলা
            @else
                District
            @endif
			</label>
            <div class="input-group">
                <select id="district_id" name="district_id" class="form-control select2 px-5">
                    <option value="" disabled selected>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name_bn }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Third Select Field -->
        <div class="mb-3">
            <!-- Label added above the select -->
            <label for="designation_id" class="form-label">
			@if (app()->getLocale() === 'bn')
                পদবি
            @else
                Designation
            @endif
			</label>
            <div class="input-group">
                <select id="designation_id" name="designation_id" class="form-control select2 px-5">
                    <option value="" disabled selected>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($designations as $designation)
                        <option value="{{ $designation->id }}">{{ $designation->name_bn }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success ms-1">
            <i class="fa fa-search" aria-hidden="true"></i>
            @if (app()->getLocale() === 'bn')
                ডাউনলোড করুন
            @else
                Download Report
            @endif
        </button>
    </form>
</div>

<br>
<br>



@endsection
