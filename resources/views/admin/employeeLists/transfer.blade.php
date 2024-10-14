@extends('layouts.admin')



@section('content')
<div>

    <div class="row">





        <div class="col-md-6 h4">@if (app()->getLocale() === 'bn')
            কর্মকর্তা/কর্মচারীর অফিস স্থানান্তর করুন
            @else
            Employee Office Transfer
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

            </div>
        </div>
    </div>

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif




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
                        <a href="{{ $result->employee_photo->getUrl() }}" target="_blank" style="display: inline-block">

                            <img src="{{ $result->employee_photo->getUrl('thumb') }}" class="rounded-circle" width="50"
                                height="50" alt="">
                        </a>
                        @else
                        <img src="{{ asset('assets/images/logo1.png') }}" class="rounded-circle" width="50" height="50"
                            alt="">
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











            </div>
            <div class="col text-end">
                <div class="btn-group">
                    {{--<a href="{{ route('admin.employeedata', ['id' => $empID]) }}"
                        class="btn btn-sm btn-outline-success">
                        {{ trans('global.view') }}
                    </a>--}}

                    {{--<a href="{{ route('admin.employeedata.pdf', ['id' => $empID]) }}"
                        class="btn btn-sm btn-outline-success">

                        @if (app()->getLocale() === 'bn')
                        স্থানান্তর করুন
                        @else
                        Transfer Now
                        @endif

                    </a>--}}
                    <!-- Transfer Button -->
                    <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal"
                        data-target="#myModal_{{ $empID }}">
                        @if (app()->getLocale() === 'bn')
                        স্থানান্তর করুন
                        @else
                        Transfer Now
                        @endif
                    </button>

                    <!-- Modal -->
                    <div id="myModal_{{ $empID }}" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg"> <!-- modal-lg for a larger modal -->
                            <!-- Modal content-->
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header" style="background-color: #006625; text-align: center;">
                                    <h6 class="modal-title mb-2" style="color: white; width: 100%;">
                                        <!-- Employee's Full Name centered -->
                                        @if (app()->getLocale() === 'bn')
                                        {{ $result['fullname_bn'] }}
                                        @else
                                        {{ $result['fullname_en'] }}
                                        @endif
                                        <br>
                                        @if (app()->getLocale() === 'bn')
                                        কর্মকর্তা/কর্মচারী আইডি: {{ englishToBanglaNumber ($result['employeeid']) }}
                                        @else
                                        Employee ID: {{ $result['employeeid'] }}
                                        @endif

                                    </h6>

                                </div>

                                <!-- Modal Body -->
                                <div class="modal-body text-left">
                                    <!-- Transfer Office Selection Heading -->
                                    <h4 class="font-weight-bold">
                                        @if (app()->getLocale() === 'bn')
                                        যে অফিসে স্থানান্তর করতে চান সেই অফিস নির্বাচন করুন
                                        @else
                                        Select the Office to Transfer
                                        @endif
                                    </h4>

                                    <hr>

                                    <form action="{{route('admin.transferConfirm',['id' => $empID])}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <h6>
                                                @if (app()->getLocale() === 'bn')
                                                যদি ডিভিশনাল অফিসে স্থানান্তর হয়
                                                @else
                                                If transfer office is a Division
                                                @endif
                                            </h6>

                                            <label for="division-select">
                                                @if (app()->getLocale() === 'bn')
                                                নতুন ডিভিশন নির্বাচন করুন
                                                @else
                                                Please select new division
                                                @endif
                                            </label>
                                            <select id="division-select" class="form-select select2" name="division_id">
                                                <!-- Dynamically populate options from $divisionList -->
                                                @foreach($divisionList as $id => $division)
                                                <option value="{{ $id }}">{{ $division }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Circle Transfer Section -->
                                        <div class="form-group">
                                            <h6>
                                                @if (app()->getLocale() === 'bn')
                                                যদি সার্কেল অফিসে স্থানান্তর হয়
                                                @else
                                                If transfer office is a Circle
                                                @endif
                                            </h6>
                                            <label for="circle-select">
                                                @if (app()->getLocale() === 'bn')
                                                নতুন সার্কেল নির্বাচন করুন
                                                @else
                                                Please select new circle
                                                @endif
                                            </label>
                                            <select id="circle-select" class="form-select select2" name="circle_id">
                                                <!-- Dynamically populate options from $circleList -->
                                                @foreach($circleList as $id => $circle)
                                                <option value="{{ $id }}">{{ $circle }}</option>
                                                @endforeach
                                            </select>
                                            <br>

                                            <label for="circle-select">
                                                @if (app()->getLocale() === 'bn')
                                                মন্তব্য
                                                @else
                                                Comments
                                                @endif
                                            </label>
                                            <input class="form-control" type="text" name="comment" id="comment">



                                        </div>


                                </div>

                                <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        @if (app()->getLocale() === 'bn')
                                        বাতিল
                                        @else
                                        Cancel
                                        @endif
                                    </button>
                                    <button type="submit" class="btn btn-success"
                                        onclick="return confirm('আপনি নিশ্চিত স্থানান্তর  করতে চান?');">
                                        @if (app()->getLocale() === 'bn')
                                        নিশ্চিত করুন
                                        @else
                                        Confirm Transfer
                                        @endif
                                    </button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>




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