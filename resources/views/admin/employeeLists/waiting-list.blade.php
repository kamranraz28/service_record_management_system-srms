@extends('layouts.admin')



@section('content')
    <div>

    <div class="row">





        <div class="col-md-6 h4">@if (app()->getLocale() === 'bn')
                অপেক্ষমান তালিকা
            @else
                Waiting List
            @endif </div>
        <div class="col-md-6 h4 text-end">

            @if (app()->getLocale() === 'bn')
                মোট অপেক্ষমান কর্মকর্তা/কর্মচারী
            @else
                Total Waiting Employee
            @endif
            : {{ englishToBanglaNumber ($total) }}

        </div>

    </div>

    <div class="card mb-1">
        <div class="table-responsive p-3">

            <div class="row justify-content-center align-items-center g-1">
                <div class="col">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="position-relative">
                            <span
                                class="material-icons-outlined position-absolute translate-middle-y top-50 fs-5 start-0 ms-3">search</span>
                            <input type="text" wire:model.debounce.200ms="searchQuery" class="form-control px-5"
                                placeholder="Search...">
                        </div>
                    </form>
                </div>
                {{--<div class="col text-end">

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
                </div>--}}
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
                            <p class="mb-0">{{ $result['employeeid'] }}</p>

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
                                'trainings',
                                'travelRecords',
                                'foreigntravelpersonals',
                                'extracurriculams',
                                'otherservicejobs',
                                'languages',
                                'acrmonitorings',
                                'awards',
                                'acrmonitorings',
                                'publications',
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
                        <a href="{{ route('user.send', ['id' => $empID]) }}" class="btn btn-sm btn-success">
							@if (app()->getLocale() === 'bn')
								অনুমোদনের জন্য পাঠান
							@else
								Send to Approval
							@endif
						</a>
                        </a>
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
