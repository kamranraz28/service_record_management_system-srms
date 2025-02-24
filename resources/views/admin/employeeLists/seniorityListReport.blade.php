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
    </div>
</div>

<div class="col">
<a href="{{route('admin.seniority_list_report_download')}}" class="btn btn-success ms-1">
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
    <form action="{{ route('admin.downloadSeniorityListDesignation') }}" method="POST" class="p-3 border border-dark rounded">
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
                <select id="designation_id" name="designation_id[]" class="form-control select2 px-5" multiple required>
                    
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


    <!-- Pagination -->
    <div class="pagination">
        
    </div>
</div>
@endsection
