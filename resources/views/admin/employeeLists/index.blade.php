@extends('layouts.admin')



@section('content')
    <div>

    <div class="row">





        <div class="col-md-6 h4">@if (app()->getLocale() === 'bn')
                সাধারণ তথ্যসমূহের তালিকা
            @else
                General Information List
            @endif </div>
        <div class="col-md-6 h4 text-end">

            @if (app()->getLocale() === 'bn')
                মোট কর্মকর্তা/কর্মচারী
            @else
                Total Employee
            @endif
            : {{ englishToBanglaNumber ($total) }}

        </div>

    </div>

    <div class="card mb-1">
        <div class="table-responsive p-3">

            <div class="row justify-content-center align-items-center g-3">

			<div class="col">
    <form action="{{ route('admin.search_employee') }}" method="POST">
        @csrf
        <div class="mb-3">
            <!-- Label added above the input -->
            <label for="employee_id" class="form-label">
			@if (app()->getLocale() === 'bn')
                কর্মকর্তা/কর্মচারী আইডি দিয়ে অনুসন্ধান
            @else
                Search by Employee ID
            @endif
			</label>
            <div class="input-group">
                <input id="employee_id" name="id" type="text" class="form-control px-5" placeholder="{{ trans('global.search') }}...">
                <button type="submit" class="btn btn-success ms-1">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    {{ trans('global.search') }}
                </button>
            </div>
        </div>

    </form>
</div>

<div class="col">
<form action="{{ route('admin.search_employee_by_name') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="employee_name" class="form-label">
            @if (app()->getLocale() === 'bn')
                কর্মকর্তা/কর্মচারীর নাম দিয়ে অনুসন্ধান
            @else
                Search by Employee Name
            @endif
        </label>
        <div class="input-group">
            <input id="employee_name" name="name" type="text" class="form-control px-5" placeholder="{{ trans('global.search') }}...">
            <button type="submit" class="btn btn-success ms-1">
                <i class="fa fa-search" aria-hidden="true"></i> {{ trans('global.search') }}
            </button>
        </div>
    </div>
</form>
</div>

                <div class="col">
    <form action="{{ route('admin.search_designation') }}" method="POST">
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
                <select id="designation_id" name="designation_id[]" class="form-control select2 px-5">
                                        <option value="" disabled selected>{{ trans('global.pleaseSelect') }}</option>

                    @foreach($designations as $designation)
                        <option value="{{ $designation->id }}">{{ $designation->name_bn }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-success ms-1">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    {{ trans('global.search') }}
                </button>
            </div>
        </div>
    </form>
</div>





                <div class="col text-end">

                    @can('employee_list_create')

                        <a class="btn btn-success" href="{{ route('admin.employee-lists.create') }}">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            {{ trans('cruds.employeeList.title_singular') }} {{ trans('global.add') }}
                        </a>

						<a class="btn btn-success" href="{{ route('admin.employee-lists.waitingList') }}">

                            @if (app()->getLocale() === 'bn')
											অপেক্ষমান তালিকা
                                    @else
                                        Waiting List
                                    @endif
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    @foreach ($data as $result)
        @php
            $empID = $result['id'];
        @endphp
        <!-- Loader HTML -->



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
                            <p class="mb-0">
							@if (app()->getLocale() === 'bn')
                                    {{ englishToBanglaNumber($result['employeeid']) }}
                                @else
                                    {{ $result['employeeid'] }}
                                @endif</p>

                        </div>
                    </div>
                </div>





                <div class="col">

                        <p class="badge bg-warning"
						   style="background-color: #5d1f1f17 !important; color: #5d1f1f !important; padding: 6px !important; border-radius: 25px; width: 300px; overflow: hidden;">
						   @if(app()->getLocale() === 'bn')
							   {{ $result->designation->name_bn ?? 'N/A' }}
						   @else
							   {{ $result->designation->name_en ?? 'N/A' }}
						   @endif
						</p>








                    <div class="progress"
                        title=" @if (app()->getLocale() === 'bn') প্রোফাইলের অগ্রগতি
                    @else
                        Profile progress @endif">
                        @php
                            $total = 1;

                            $relationships = [
                                'educations',
                                'professionales',
                                'addressdetailes',
                                'emergencecontactes',
                                'spouseinformationes',
                                'childinformationes',
                                'jobhistories',
                                'employeepromotions',
                                'leaverecords',
                                'trainings',
                                'travelRecords',
                                'publications',
                                'awards',
                                'otherservicejobs',
                                'criminalprosecutiones',
                                'policeVerifications',
                                'timeScales',
                                'others',
                            ];

                            $totalvalue = count($relationships) + 1;

                            foreach ($relationships as $relationship) {
                                $countable = $result->{$relationship} ?? collect();
                                if ($countable->count()) {
                                    $total++;
                                }
                            }

                            $progress = ($total / $totalvalue) * 100;
                        @endphp

                        {{-- @dd($totalvalue) --}}
                        <div class="progress-bar" role="progressbar" style="width:{{ round($progress) }}%;"
                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{ round($progress) }}%
                        </div>
                    </div>


                </div>
                <div class="col text-end">
                    <div class="btn-group">
                        <a href="{{ route('admin.employeedata', ['id' => $empID]) }}"
                            class="btn btn-sm btn-outline-success">
                            {{ trans('global.view') }}
                        </a>
                        <a href="{{ route('admin.commonemployeeshow', ['id' => $empID]) }}"
                            class="btn btn-sm btn-outline-success">
                            {{ trans('global.edit') }}
                        </a>
                        <a href="{{ route('admin.employeedata.pdf', ['id' => $empID]) }}"
                            class="btn btn-sm btn-outline-success">

                            @if (app()->getLocale() === 'bn')
                                পিডিএফ
                            @else
                                PDF
                            @endif

                        </a>
						@can('employee_list_delete')
                        <a href="{{ route('admin.employeedata.delete', ['id' => $empID]) }}"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('{{ app()->getLocale() === 'bn' ? 'আপনি কি নিশ্চিতভাবে ডিলিট করতে চান?' : 'Are you sure you want to delete?' }}')">

                                @if (app()->getLocale() === 'bn')
                                    ডিলিট
                                @else
                                    Delete
                                @endif

                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="pagination">
        {{ $data->links('pagination::bootstrap-4') }}
    </div>
</div>

@endsection
