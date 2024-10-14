@extends('layouts.admin')

@section('content')
<div>
    <div class="row">
        <div class="col-md-6 h4">
            @if (app()->getLocale() === 'bn')
                কর্মকর্তা/কর্মচারীর অফিস স্থানান্তর তালিকা
            @else
                Employee Office Transfer List
            @endif 
        </div>
        <div class="col-md-6 h4 text-end">
            @if (app()->getLocale() === 'bn')
				স্থানান্তরকৃত মোট কর্মকর্তা/কর্মচারী
            @else
                Transferred Total Employee
            @endif
            : {{ englishToBanglaNumber($total) }}
        </div>
    </div>


    <!-- Employee Table -->
<div class="card mb-1 p-2">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>@if (app()->getLocale() === 'bn') ক্রমিক নং @else SN @endif</th>
                    <th>@if (app()->getLocale() === 'bn') কর্মকর্তা/কর্মচারীর নাম @else Employee Name @endif</th>
                    <th>@if (app()->getLocale() === 'bn') কর্মকর্তা/কর্মচারী আইডি @else Employee ID @endif</th>
                    <th>@if (app()->getLocale() === 'bn') পদবী @else Designation @endif</th>
                    <th>@if (app()->getLocale() === 'bn') স্থানান্তরকৃত অফিস @else Current Office @endif</th>
					<th>@if (app()->getLocale() === 'bn') স্থানান্তরের  তারিখ  ও সময় @else Transfer Date & Time @endif</th>
					<th>@if (app()->getLocale() === 'bn') মন্তব্য @else Comment @endif</th>


                </tr>
            </thead>
            <tbody>
                @foreach ($data as $result)
                <tr>
                    <td>
						@if (app()->getLocale() === 'bn')
                            {{ englishToBanglaNumber ($loop->iteration) }}
                        @else
                            {{ $loop->iteration }}
                        @endif
					</td>
                    <td>
                        @if (app()->getLocale() === 'bn')
                            {{ $result->employee['fullname_bn'] }}
                        @else
                            {{ $result->employee['fullname_en'] }}
                        @endif
                    </td>
                    <td>
                        @if (app()->getLocale() === 'bn')
                            {{ englishToBanglaNumber($result->employee['employeeid']) ?? '' }}
                        @else
                            {{ $result->employee['employeeid'] ?? '' }}
                        @endif
                    </td>
                    <td>
                        @if (app()->getLocale() === 'bn')
                            {{ $result->employee->designation['name_bn'] ?? '' }}
                        @else
                            {{ $result->employee->designation['name_en'] ?? '' }}
                        @endif
                    </td>
                    <td>
                        @if (app()->getLocale() === 'bn')
                            {{ $result->circle->circle['name_bn'] ?? '' }} <br>
                            {{ $result->division->division['name_bn'] ?? '' }}
                        @else
                            {{ $result->circle->circle['name_en'] ?? '' }} <br>
                            {{ $result->division->division['name_en'] ?? '' }}
                        @endif
                    </td>
					<td>
                        @if (app()->getLocale() === 'bn')
							{{ englishToBanglaNumber ($result->created_at) ?? '' }}
                        @else
                            {{ $result->created_at ?? '' }}
                        @endif
                    </td>
					<td>
                        @if (app()->getLocale() === 'bn')
							{{ $result->comment ?? '' }}
                        @else
                            {{ $result->comment ?? '' }}
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
        {{ $data->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
