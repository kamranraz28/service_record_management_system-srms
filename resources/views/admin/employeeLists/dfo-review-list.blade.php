@extends('layouts.admin')

@section('content')
    <h4> 
	@if (app()->getLocale() === 'bn')
		অনুমোদনের অপেক্ষাধীন
	@else
		Waiting for Approval
	@endif
	</h4>
    
	<div>

    <div>
	@if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <!-- Your component content here -->
    </div>

    <div class="table-responsive card p-3">

        <div class="row">
            <div class="col">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search..."
                        wire:model.debounce.300ms="search">

                </div>
            </div>
            <div class="col text-end">

                {{-- @can('employee_list_create')
                    <a class="btn btn-success" href="{{ route('admin.employee-lists.create') }}"> <i class="fa fa-plus"
                            aria-hidden="true"></i>
                        {{ trans('global.add') }} {{ trans('cruds.employeeList.title_singular') }}
                    </a> 
                @endcan --}}
                {{-- <button type="button" class="btn btn- btn-success">
                    <i class="fa fa-filter" aria-hidden="true"></i>

                    @if (app()->getLocale() === 'bn')
                        ফিল্টার
                    @else
                        Filter
                    @endif

                </button> --}}


            </div>
        </div>
    </div>

    @if ($data)
        @foreach ($data as $result)
            @php
                $empID = $result['id'];
                $designationName = 'NA';
                if ($result->jobhistories) {
                    $lastJobHistory = $result->jobhistories->last();
                    if ($lastJobHistory && $lastJobHistory->relationLoaded('designation')) {
                        $designation = $lastJobHistory->designation;
                        $designationName = $designation->name_bn ?? '';
                    }
                }
            @endphp
            <div class="card mb-1">
                <div class="table-responsive p-3">
                    <div class="row justify-content-center align-items-center g-1">
                        <div class="col">
                            <div class="d-flex align-items-center gap-3">
                                {{-- <div class="customer-pic">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="empoleyid"
                                            value="{{ $empID }}" />
                                    </div>
                                </div> --}}
                                <div class="customer-pic">
                                    <img src="{{ asset('assets/images/logo1.png') }}" class="rounded-circle"
                                        width="80" height="80" alt="">
                                </div>
                                <div>
                                    <p class="customer-name fw-bold mb-0">
                                        @if (app()->getLocale() === 'bn')
                                            {{ $result['fullname_bn'] }}
                                        @else
                                            {{ $result['fullname_en'] }}
                                        @endif
                                    </p>
									<p>
									   @if(app()->getLocale() === 'bn')
										   {{ $result->designation->name_bn ?? 'N/A' }}
									   @else
										   {{ $result->designation->name_en ?? 'N/A' }}
									   @endif
									</p>
                                    <p class="mb-0">{{ $result['employeeid'] }}</p>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            @if (app()->getLocale() === 'bn')
                                প্রোফাইলের অগ্রগতি
                            @else
                                Profile progress
                            @endif

                            <div class="progress">
                                @php
                                    $total = 0;
                                    $totalvalue = 17;

                                    $relationships = [
                                        'batch',
                                        'educations',
                                        'professionales',
                                        'addressdetailes',
                                        'emergencecontactes',
                                        'spouseinformationes',
                                        'childinformationes',
                                        'jobhistories',
                                        'employeepromotions',
                                        'trainings',
                                        'travelRecords',
                                        'foreigntravelpersonals',
                                        'socialassprattachments',
                                        'extracurriculams',
                                        'otherservicejobs',
                                        'languages',
                                        'acrmonitorings',
                                    ];

                                    foreach ($relationships as $relationship) {
                                        $countable = $result->{$relationship} ?? collect();
                                        if ($countable->count()) {
                                            $total++;
                                        }
                                    }

                                    $progress = ($total / $totalvalue) * 100;
                                @endphp

                                <div class="progress-bar" role="progressbar" style="width:{{ round($progress) }}%;"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{ round($progress) }}%
                                </div>
                            </div>
                        </div>
                        <div class="col text-end">
                            <div class="btn-group">
                                <a href="{{ route('user.approve', ['id' => $empID]) }}" class="btn btn-sm btn-success">
    @if (app()->getLocale() === 'bn')
        অনুমোদন করুন
    @else
        Approve
    @endif
</a>


{{--<a href="{{ route('admin.commonemployeeshow', ['id' => $empID]) }}"
                                    class="btn btn-sm btn-outline-dark">
                                    {{ trans('global.edit') }}
                                </a> --}}

                                <a href="{{ route('admin.employeedata', ['id' => $empID]) }}" target="_blank"
                                    class="btn btn-sm btn-outline-success">
                                    {{ trans('global.view') }}
                                </a>
                                {{-- <a href="{{ route('admin.commonemployeeshow', ['id' => $empID]) }}"
                                    class="btn btn-sm btn-outline-dark">
                                    {{ trans('global.edit') }}
                                </a>
                                <a href="{{ route('admin.employeedata', ['id' => $empID]) }}"
                                    class="btn btn-sm btn-outline-dark">

                                    @if (app()->getLocale() === 'bn')
                                        পিডিএফ
                                    @else
                                        PDF
                                    @endif --}}

                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{ $data->links('pagination::bootstrap-4') }}
    @else
        <p>No results found.</p>
    @endif
</div>

@endsection
