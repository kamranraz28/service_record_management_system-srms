@extends('layouts.admin')
@section('styles')
    @parent
    <style>
        th {
            font-weight: 100;
        }
    </style>
@endsection
@section('content')
    <div class="card p-2">
        <div class="container">
            <div class="row">
                @include('admin.commonemployee.commonmenuemployeeshow')
                <div class="col-md-9">

<!-- updated -->
                    <div class="tab-content my-1 border p-2" id="v-pills-tabContent">
                        <div>
                            <strong>{{ trans('cruds.employeeList.title_singular') }}</strong>
                            <table class="table-bordered table-striped table" id="General">
                                <tbody>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.employeeid') }}
                                        </th>
                                        <td>
                                            
											{{ englishToBanglaNumber($employeeList->employeeid ?? 'N/A') }}
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.fullname_bn') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->fullname_bn ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.fullname_en') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->fullname_en ?? 'N/A'  }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.fname_bn') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->fname_bn ?? 'N/A' }}
                                        </td>
                                    </tr>
									
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.fname_en') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->fname_en }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.mname_bn') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->mname_bn }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.mname_en') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->mname_en }}
                                        </td>
                                    </tr>
									<tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.cadreid') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->cadreid ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.batch') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->batch->batch_bn ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.date_of_birth') }}
                                        </th>
                                        <td>
                                            {{ englishToBanglaNumber($employeeList->date_of_birth) }}
                                        </td>
                                    </tr>
                                    {{--<tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.birth_certificate_upload') }}
                                        </th>
                                        <td>
                                            @if ($employeeList->birth_certificate_upload)
                                                <a href="{{ $employeeList->birth_certificate_upload->getUrl() }}"
                                                    target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
												@else
													N/A
                                            @endif
                                        </td>
                                    </tr>--}}
									
									<tr>
                                        <th>
												পদবি (বর্তমানে যে পদে কর্মরত আছেন)
                                        </th>
                                        <td>
                                            {{ englishToBanglaNumber($employeeList->designation->name_bn ?? 'N/A') }}
                                        </td>
                                    </tr>
									
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.prl_date') }}
                                        </th>
                                        <td>
                                            {{ englishToBanglaNumber($employeeList->prl_date) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.height') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->height ?? 'N/A' }}
											
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.special_identity') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->special_identity ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.home_district') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->home_district->name_bn ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.marital_statu') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->marital_statu->name ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.gender') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->gender->name_bn ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.religion') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->religion->name_bn ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.blood_group') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->blood_group->name_bn ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.nid') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->nid ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.nid_upload') }}
                                        </th>
                                        <td>
                                            @if ($employeeList->nid_upload)
                                                <a href="{{ $employeeList->nid_upload->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
												@else
													N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.passport') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->passport ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.passport_upload') }}
                                        </th>
                                        <td>
                                            @if ($employeeList->passport_upload)
                                                <a href="{{ $employeeList->passport_upload->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
												@else
													N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.license_type') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->license_type->name_bn ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.license_upload') }}
                                        </th>
                                        <td>
                                            @if ($employeeList->license_upload)
                                                <a href="{{ $employeeList->license_upload->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
												@else
													N/A
                                            @endif
											
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.email') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->email ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.mobile_number') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->mobile_number ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.joiningexaminfo') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->projectrevenue->project_revenue_bn ?? 'N/A' }}
                                        </td>
                                    </tr>
									<tr>
                                        <th>
											{{ trans('cruds.employeeList.fields.cadre/noncadre') }}                                        </th>
                                        <td>
                                            {{ $employeeList->cadre->name_bn ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            @if (app()->getLocale() === 'bn')
												প্রথম যোগদানের পদবি ও গ্রেড
											@else
												First Joining Designation & Grade
											@endif
                                        </th>
                                        <td>
                                            {{ $employeeList->first_designation->name_bn ?? '' }}, {{ $employeeList->grade->name_bn ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.fjoining_date') }}
                                        </th>
                                        <td>
                                            
											{{ englishToBanglaNumber($employeeList->fjoining_date ?? 'N/A') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.first_joining_office_name') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->first_joining_office_name ?? 'N/A' }}
                                        </td>
                                    </tr>
									<tr>
                                        <th>
												প্রথম নিয়োগের আদেশ/প্রজ্ঞাপন/স্মারক নম্বর
                                        </th>
                                        <td> 
                                            {{ $employeeList->first_joining_memo_no ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
												প্রথম নিয়োগের আদেশ/প্রজ্ঞাপন/স্মারক তারিখ
                                        </th>
                                        <td>
                                            
											{{ englishToBanglaNumber($employeeList->first_joining_g_o_date ?? 'N/A') }}
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <th>
											প্রথম নিয়োগের প্রজ্ঞাপন/আদেশ/স্মারক সংযোজন
                                        </th>
                                        <td>
                                            @if ($employeeList->first_joining_order)
                                                <a href="{{ $employeeList->first_joining_order->getUrl() }}"
                                                    target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
												@else
													N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
												প্রথম যোগদানপত্র সংযোজন
                                        </th>
                                        <td>
                                            @if ($employeeList->fjoining_letter)
                                                <a href="{{ $employeeList->fjoining_letter->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
												@else
													N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.date_of_gazette') }}
                                        </th>
                                        <td>
                                            
											{{ englishToBanglaNumber($employeeList->date_of_gazette ?? 'N/A') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
											গেজেট আদেশ সংযোজন
                                        </th>
                                        <td>
                                            @if ($employeeList->date_of_gazette_if_any)
                                                <a href="{{ $employeeList->date_of_gazette_if_any->getUrl() }}"
                                                    target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
												@else
													N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
											নিয়মিত করনের আদেশ জারির তারিখ
                                        </th>
                                        <td>
                                            
											{{ englishToBanglaNumber($employeeList->date_of_regularization ?? 'N/A') }}
                                        </td>
                                    </tr>
                                    {{--<tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.regularization_issue_date') }}
                                        </th>
                                        <td>
                                            
											{{ englishToBanglaNumber($employeeList->regularization_issue_date ?? 'N/A') }}
                                        </td>
                                    </tr>--}}
                                    <tr>
                                        <th>
											নিয়মিত করনের আদেশ সংযোজন
                                        </th>
                                        <td>
                                            @if ($employeeList->regularization_office_orde_go)
                                                <a href="{{ $employeeList->regularization_office_orde_go->getUrl() }}"
                                                    target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
												@else
													N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.date_of_con_serviec') }}
                                        </th>
                                        <td>
                                            
											{{ englishToBanglaNumber($employeeList->date_of_con_serviec ?? 'N/A') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
											স্থায়ীকরণের আদেশ সংযোজন
                                        </th>
                                        <td>
                                            @if ($employeeList->confirmation_in_service)
                                                <a href="{{ $employeeList->confirmation_in_service->getUrl() }}"
                                                    target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
												@else
												N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.quota') }}
                                        </th>
                                        <td>
                                            {{ $employeeList->quota->name_bn ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.electric_signature') }}
                                        </th>
                                        <td>
                                            @if ($employeeList->electric_signature)
                                                <a href="{{ $employeeList->electric_signature->getUrl() }}" target="_blank"
                                                    style="display: inline-block">
                                                    <img src="{{ $employeeList->electric_signature->getUrl('thumb') }}">
                                                </a>
												@else
													N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.employeeList.fields.employee_photo') }}
                                        </th>
                                        <td>
                                            @if ($employeeList->employee_photo)
                                                <a href="{{ $employeeList->employee_photo->getUrl() }}" target="_blank"
                                                    style="display: inline-block">
                                                    <img src="{{ $employeeList->employee_photo->getUrl('thumb') }}">
                                                </a>
												@else
													N/A
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th> &nbsp;</th>
                                        <td>
                                            <!-- Edit button -->
                                            <a href="{{ route('admin.employee-lists.edit', ['employee_list' => $employeeList->id]) }}"
                                                class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

                                            {{-- 
                                            <form
                                                action="{{ route('admin.employee-lists.destroy', ['employee_list' => $employeeList->id]) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-danger">{{ trans('global.delete') }}</button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>


                            <strong>{{ trans('cruds.educationInformatione.title_singular') }}</strong>
							<br>
                            @foreach ($employeeList->educations ?? [] as $educationInformatione)
							@if(count($employeeList->educations) > 1)
								<h6>শিক্ষাগত তথ্য - {{ $loop->iteration }}</h6>
							@endif
                                <table class="table-bordered table-striped table" id="Education">
                                    <tbody>
                                        <tr>
                                            <th>
													ডিগ্রী
                                            </th>
                                            <td>
                                                {{ $educationInformatione->name_of_exam->name_bn ?? '' }}
                                            </td>
                                        </tr>
										<tr>
                                            <th>
												 {{ trans('cruds.educationInformatione.fields.name_of_exam') }}

                                            </th>
                                            <td>
                                                {{ $educationInformatione->examdegree->name_bn ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.educationInformatione.fields.exam_board') }}
                                            </th>
                                            <td>
                                                {{ $educationInformatione->exam_board->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.educationInformatione.fields.school_university_name') }}
                                            </th>
                                            <td>
                                                {{ $educationInformatione->school_university_name ?? 'N/A' }}
                                            </td>
                                        </tr>
										<tr>
                                            <th>
													প্রধান বিষয়
                                            </th>
                                            <td>
                                                {{ $educationInformatione->concentration_major_group ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.educationInformatione.fields.achivement') }}
                                            </th>
                                            <td>
                                                {{ $educationInformatione->achivement }}{{ $educationInformatione->cgpa }}{{ $educationInformatione->result->name_bn ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.educationInformatione.fields.passing_year') }}
                                            </th>
                                            <td>
                                                
												{{ englishToBanglaNumber($educationInformatione->passing_year ?? 'N/A') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.educationInformatione.fields.catificarte') }}
                                            </th>
                                            <td>
                                                @if ($educationInformatione->catificarte)
                                                    <a href="{{ $educationInformatione->catificarte->getUrl() }}"
                                                        target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
													@else
														N/A
                                                @endif
											
                                            </td>
                                        </tr>
                                        
                                        <tr>
											<th> </th>
											<td>
												<!-- Edit button -->
												<a href="{{ route('admin.education-informationes.edit', ['education_informatione' => $educationInformatione->id]) }}"
													class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

												<!-- Delete button -->
												<form action="{{ route('admin.education-informationes.destroy', ['education_informatione' => $educationInformatione->id]) }}"
													method="POST" style="display: inline;">
													@csrf
													@method('DELETE')
													<button type="submit" class="btn btn-sm btn-danger"
														onclick="return confirm('আপনি নিশ্চিত এটা মুছে দিতে চান?');">{{ trans('global.delete') }}</button>
												</form>
											</td>
										</tr>


                                    </tbody>
                                </table>
                            @endforeach





                            <strong> {{ trans('cruds.professionale.title') }}</strong>
<br>
                            @foreach ($employeeList->professionales ?? [] as $professionale)
							
								
								@if(count($employeeList->professionales) > 1)
								<h6>যোগ্যতা - {{ $loop->iteration }}</h6>
							@endif
                                <table class="table-bordered table-striped table" id="Professionales">
                                    <tbody>
                                        
                                        <tr>
                                            <th>
                                                {{ trans('cruds.professionale.fields.qualification_title') }}
                                            </th>
                                            <td>
                                                {{ $professionale->qualification_title ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.professionale.fields.institution') }}
                                            </th>
                                            <td>
                                                {{ $professionale->institution ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.professionale.fields.from_date') }}
                                            </th>
                                            <td>
                                                {{ $professionale->from_date ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.professionale.fields.to_date') }}
                                            </th>
                                            <td>
                                                {{ $professionale->to_date ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <th> </th>
                                            <td>
                                                <!-- Edit button -->
                                                <a href="{{ route('admin.professionales.edit', ['professionale' => $professionale->id]) }}"
                                                    class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

                                                <!-- Delete button -->
                                                <form
                                                    action="{{ route('admin.professionales.destroy', ['professionale' => $professionale->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
													onclick="return confirm('আপনি নিশ্চিত এটা মুছে দিতে চান?');">>{{ trans('global.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            @endforeach


                        
							<br>
                            @foreach ($employeeList->addressdetailes ?? [] as $addressdetaile)
							@if(count($employeeList->addressdetailes) > 1)
								<strong>
									@if($addressdetaile->address_type === "present")
										বর্তমান ঠিকানা
									@elseif($addressdetaile->address_type === "permanent")
										স্থায়ী ঠিকানা
									@endif
								</strong>
							@endif

                                <table class="table-bordered table-striped table" id="addressdetaile">
                                    <tbody>
                                        
                                        
                                        <tr>
                                            <th>
                                                {{ trans('cruds.addressdetaile.fields.flat_house') }}
                                            </th>
                                            <td>
                                                {{ $addressdetaile->flat_house ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.addressdetaile.fields.post_office') }}
                                            </th>
                                            <td>
                                                {{ $addressdetaile->post_office ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.addressdetaile.fields.post_code') }}
                                            </th>
                                            <td>
                                                {{ $addressdetaile->post_code ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.addressdetaile.fields.thana_upazila') }}
                                            </th>
                                            <td>
                                                {{ $addressdetaile->thana_upazila->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.addressdetaile.fields.phone_number') }}
                                            </th>
                                            <td>
                                                {{ $addressdetaile->phone_number ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> </th>
                                            <td>
                                                <!-- Edit button -->
                                                <a href="{{ route('admin.addressdetailes.edit', ['addressdetaile' => $addressdetaile->id]) }}"
                                                    class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

                                                <!-- Delete button -->
                                                <form
                                                    action="{{ route('admin.addressdetailes.destroy', ['addressdetaile' => $addressdetaile->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
													onclick="return confirm('আপনি নিশ্চিত এটা মুছে দিতে চান?');">{{ trans('global.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach
                            <strong>{{ trans('cruds.emergenceContacte.title') }}</strong>
							<br>
                            @foreach ($employeeList->emergencecontactes ?? [] as $emergenceContacte)
							
							@if(count($employeeList->emergencecontactes) > 1)
								<h6>যোগাযোগ - {{ $loop->iteration }}</h6>
							@endif
                                <table class="table-bordered table-striped table" id="emergenceContacte">
                                    <tbody>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.emergenceContacte.fields.contact_person_name') }}
                                            </th>
                                            <td>
                                                {{ $emergenceContacte->contact_person_name ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.emergenceContacte.fields.contact_person_relation') }}
                                            </th>
                                            <td>
                                                {{ $emergenceContacte->contact_person_relation ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.emergenceContacte.fields.address') }}
                                            </th>
                                            <td>
                                                {{ $emergenceContacte->address ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.emergenceContacte.fields.contact_person_number') }}
                                            </th>
                                            <td>
                                                {{ $emergenceContacte->contact_person_number ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <th> </th>
                                            <td>
                                                <!-- Edit button -->
                                                <a href="{{ route('admin.emergence-contactes.edit', ['emergence_contacte' => $emergenceContacte->id]) }}"
                                                    class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

                                                <!-- Delete button -->
                                                <form
                                                    action="{{ route('admin.emergence-contactes.destroy', ['emergence_contacte' => $emergenceContacte->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
													onclick="return confirm('আপনি নিশ্চিত এটা মুছে দিতে চান?');">{{ trans('global.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach


                            <strong> {{ trans('cruds.spouseInformatione.title') }}</strong>
							<br>

                            @foreach ($employeeList->spouseinformationes ?? [] as $spouseInformatione)
							@if(count($employeeList->spouseinformationes) > 1)
								<h6>স্বামী/স্ত্রীর তথ্য - {{ $loop->iteration }}</h6>
							@endif
                                <table class="table-bordered table-striped table" id="spouseInformatione">
                                    <tbody>
                                        
                                        <tr>
                                            <th>
                                                {{ trans('cruds.spouseInformatione.fields.name_bn') }}
                                            </th>
                                            <td>
                                                {{ $spouseInformatione->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.spouseInformatione.fields.name_en') }}
                                            </th>
                                            <td>
                                                {{ $spouseInformatione->name_en ?? 'N/A' }}
                                            </td>
                                        </tr>
										<tr>
                                            <th>
                                                {{ trans('cruds.spouseInformatione.fields.occupation') }}
                                            </th>
                                            <td>
                                                {{ $spouseInformatione->occupation ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.spouseInformatione.fields.nid_upload') }}
                                            </th>
                                            <td>
                                                @if ($spouseInformatione->nid_upload)
                                                    <a href="{{ $spouseInformatione->nid_upload->getUrl() }}"
                                                        target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
													@else
														N/AF
                                                @endif
                                            </td>
                                        </tr>
                                        
                                        
                                        <tr>
                                            <th>
                                                {{ trans('cruds.spouseInformatione.fields.phone_number') }}
                                            </th>
                                            <td>
                                                {{ $spouseInformatione->phone_number ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.spouseInformatione.fields.present_addess') }}
                                            </th>
                                            <td>
                                                {!! $spouseInformatione->present_addess ?? 'N/A' !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.spouseInformatione.fields.permanent_addess') }}
                                            </th>
                                            <td>
                                                {!! $spouseInformatione->permanent_addess ?? 'N/A' !!}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th> </th>
                                            <td>
                                                <!-- Edit button -->
                                                <a href="{{ route('admin.spouse-informationes.edit', ['spouse_informatione' => $spouseInformatione->id]) }}"
                                                    class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

                                                <!-- Delete button -->
                                                <form
                                                    action="{{ route('admin.spouse-informationes.destroy', ['spouse_informatione' => $spouseInformatione->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
													onclick="return confirm('আপনি নিশ্চিত এটা মুছে দিতে চান?');">{{ trans('global.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach


                            <strong> {{ trans('cruds.child.title') }}</strong>
							<br>

                            @foreach ($employeeList->childinformationes ?? [] as $child)
							@if(count($employeeList->childinformationes) > 1)
								<h6>সন্তানদের তথ্য - {{ $loop->iteration }}</h6>
							@endif
                                <table class="table-bordered table-striped table" id="child">
                                    <tbody>
                                        
                                        <tr>
                                            <th>
                                                {{ trans('cruds.child.fields.name_bn') }}
                                            </th>
                                            <td>
                                                {{ $child->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <th>
                                                {{ trans('cruds.child.fields.name_en') }}
                                            </th>
                                            <td>
                                                {{ $child->name_en ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.child.fields.date_of_birth') }}
                                            </th>
                                            <td>
                                                
												{{ englishToBanglaNumber($child->date_of_birth ?? 'N/A') }}
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <th>
                                                {{ trans('cruds.child.fields.complite_21') }}
                                            </th>
                                            <td>
                                                
												{{ englishToBanglaNumber($child->complite_21 ?? 'N/A') }}
                                            </td>
                                        </tr>
										<tr>
                                            <th>
                                                {{ trans('cruds.child.fields.birth_certificate') }}
                                            </th>
                                            <td>
                                                @if ($child->birth_certificate)
                                                    <a href="{{ $child->birth_certificate->getUrl() }}" target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
													@else
														N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.child.fields.gender') }}
                                            </th>
                                            <td>
                                                {{ $child->gender->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.child.fields.nid_number') }}
                                            </th>
                                            <td>
                                                {{ $child->nid_number ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.child.fields.passport_number') }}
                                            </th>
                                            <td>
                                                {{ $child->passport_number ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.child.fields.childdren_nid') }}
                                            </th>
                                            <td>
                                                @if ($child->childdren_nid)
                                                    <a href="{{ $child->childdren_nid->getUrl() }}" target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
													@else
														N/A
                                                @endif

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.child.fields.childdren_passporft') }}
                                            </th>
                                            <td>
                                                @if ($child->childdren_passporft)
                                                    <a href="{{ $child->childdren_passporft->getUrl() }}" target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
													@else
														N/A
                                                @endif

                                            </td>
                                        </tr>
                                        <tr>
                                            <th> </th>
                                            <td>
                                                <!-- Edit button -->
                                                <a href="{{ route('admin.children.edit', ['child' => $child->id]) }}"
                                                    class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

                                                <!-- Delete button -->
                                                <form
                                                    action="{{ route('admin.children.destroy', ['child' => $child->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
													onclick="return confirm('আপনি নিশ্চিত এটা মুছে দিতে চান?');">{{ trans('global.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach

                            <strong> {{ trans('cruds.jobHistory.title') }}</strong>
							<br>

                            @foreach ($employeeList->jobhistories ?? [] as $jobHistory)
							@if(count($employeeList->jobhistories) > 1)
								<h6>চাকরি - {{ $loop->iteration }}</h6>
							@endif
                                <table class="table-bordered table-striped table" id="jobHistory">
                                    <tbody>
                                        
										<tr>
                                            <th>
													অফিস
                                            </th>
                                            <td>
                                                {{ $jobHistory->office_unit->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
										
										<tr>
                                            <th>
													অফিসের নাম
                                            </th>
                                            <td>
                                                {{ $jobHistory->level_2 ?? 'N/A' }}
                                            </td>
                                        </tr>
										
										<tr>
                                            <th>
													সার্কেল
                                            </th>
                                            <td>
                                                {{ $jobHistory->circle_list->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
										
										<tr>
                                            <th>
													ডিভিশন
                                            </th>
                                            <td>
                                                {{ $jobHistory->division_list->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
										
										<tr>
                                            <th>
													রেঞ্জ/এসএফএনটিসি/স্টেশন
                                            </th>
                                            <td>
                                                {{ $jobHistory->range_list->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
										
                                        <tr>
                                            <th>
													বিট/এসএফপিসি/ক্যাম্প
                                            </th>
                                            <td>
                                                {{ $jobHistory->beat_list->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
										
										
										
                                        
                                        <tr>
                                            <th>
                                                {{ trans('cruds.jobHistory.fields.designation') }}
                                            </th>
                                            <td>
                                                {{ $jobHistory->designation->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
										
										<tr>
                                            <th>
													গ্রেড
                                            </th>
                                            <td>
                                                {{ $jobHistory->grade->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
										
                                        <tr>
                                            <th>
                                                {{ trans('cruds.jobHistory.fields.joining_date') }}
                                            </th>
                                            <td>
                                                
												{{ englishToBanglaNumber($jobHistory->joining_date ?? 'N/A') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.jobHistory.fields.release_date') }}
                                            </th>
                                            <td>
                                                
												{{ englishToBanglaNumber($jobHistory->release_date ?? 'N/A') }}
                                            </td>
                                        </tr>
										<tr>
                                            <th>
													মন্তব্য
                                            </th>
                                            <td>
                                                {{ $jobHistory->comment ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        
                                        
                                        <tr>
                                            <th> </th>
                                            <td>
                                                <!-- Edit button -->
                                                <a href="{{ route('admin.job-histories.edit', ['job_history' => $jobHistory->id]) }}"
                                                    class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

                                                <!-- Delete button -->
                                                <form
                                                    action="{{ route('admin.job-histories.destroy', ['job_history' => $jobHistory->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
													onclick="return confirm('আপনি নিশ্চিত এটা মুছে দিতে চান?');">{{ trans('global.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach


                            <strong> {{ trans('cruds.employeePromotion.title') }}</strong>
							<br>

                            @foreach ($employeeList->employeepromotions ?? [] as $employeePromotion)
							@if(count($employeeList->employeepromotions) > 1)
								<h6>পদোন্নতির তথ্য - {{ $loop->iteration }}</h6>
							@endif
                                <table class="table-bordered table-striped table" id="employeePromotion">
                                    <tbody>
                                        
                                        <tr>
                                            <th>
                                                {{ trans('cruds.employeePromotion.fields.new_designation') }}
                                            </th>
                                            <td>
                                                {{ $employeePromotion->new_designation->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
										
										<tr>
                                            <th>
													গ্রেড
                                            </th>
                                            <td>
                                                {{ $employeePromotion->grade->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
										
                                        <tr>
                                            <th>
                                                {{ trans('cruds.employeePromotion.fields.go_issue_date') }}
                                            </th>
                                            <td>
                                                
												{{ englishToBanglaNumber($employeePromotion->go_issue_date ?? 'N/A') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
													অফিস আদেশ/প্রজ্ঞাপন/স্মারক নাম্বার
                                            </th>
                                            <td>
                                                {{ $employeePromotion->office_order_date ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.employeePromotion.fields.office_order') }}
                                            </th>
                                            <td>
                                                @if ($employeePromotion->office_order)
                                                    <a href="{{ $employeePromotion->office_order->getUrl() }}"
                                                        target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
													@else 
														N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> </th>
                                            <td>
                                                <!-- Edit button -->
                                                <a href="{{ route('admin.employee-promotions.edit', ['employee_promotion' => $employeePromotion->id]) }}"
                                                    class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

                                                <!-- Delete button -->
                                                <form
                                                    action="{{ route('admin.employee-promotions.destroy', ['employee_promotion' => $employeePromotion->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
													onclick="return confirm('আপনি নিশ্চিত এটা মুছে দিতে চান?');">{{ trans('global.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach


                            <strong> {{ trans('cruds.leaveRecord.title') }}</strong>
							<br>

                            @foreach ($employeeList->leaverecords ?? [] as $leaveRecord)
							@if(count($employeeList->addressdetailes) > 1)
								<h6>তালিকা - {{ $loop->iteration }}</h6>
							@endif
                                <table class="table-bordered table-striped table" id="leaveRecord">
                                    <tbody>
                                        
                                        <tr>
                                            <th>
                                                {{ trans('cruds.leaveRecord.fields.leave_category') }}
                                            </th>
                                            <td>
                                                {{ $leaveRecord->leave_category->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.leaveRecord.fields.type_of_leave') }}
                                            </th>
                                            <td>
                                                {{ $leaveRecord->type_of_leave->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
													{{ trans('cruds.professionale.fields.from_date') }}
                                            </th>
                                            <td>
											
											{{ englishToBanglaNumber($leaveRecord->start_date ?? 'N/A') }}

                                            </td>
                                        </tr>
										
										<tr>
                                            <th>
													{{ trans('cruds.professionale.fields.to_date') }}
                                            </th>
                                            <td>
											
											{{ englishToBanglaNumber($leaveRecord->end_date ?? 'N/A') }}

                                            </td>
                                        </tr>
										
										<tr>
                                            <th>
												ছুটির অর্ডার নম্বর
                                            </th>
                                            <td>
                                                {{ $leaveRecord->leave_orderumber ?? 'N/A' }}
                                            </td>
                                        </tr>
										
										<tr>
                                            <th>
												ছুটির আদেশের তারিখ
                                            </th>
                                            <td>
											{{ englishToBanglaNumber($leaveRecord->leave_order_date ?? 'N/A') }}
                                                
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <th>
                                                {{ trans('cruds.leaveRecord.fields.reason') }}
                                            </th>
                                            <td>
                                                {!! $leaveRecord->reason ?? 'N/A' !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> </th>
                                            <td>
                                                <!-- Edit button -->
                                                <a href="{{ route('admin.leave-records.edit', ['leave_record' => $leaveRecord->id]) }}"
                                                    class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

                                                <!-- Delete button -->
                                                <form
                                                    action="{{ route('admin.leave-records.destroy', ['leave_record' => $leaveRecord->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
													onclick="return confirm('আপনি নিশ্চিত এটা মুছে দিতে চান?');">{{ trans('global.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            @endforeach

                            {{-- <strong> {{ trans('cruds.serviceParticular.title') }}</strong>
                            @foreach ($employeeList->serviceparticulars ?? [] as $serviceParticular)
                                <table class="table-bordered table-striped table" id="serviceParticular">
                                    <tbody>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.serviceParticular.fields.id') }}
                                            </th>
                                            <td>
                                                {{ $serviceParticular->id }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.serviceParticular.fields.designation') }}
                                            </th>
                                            <td>
                                                {{ $serviceParticular->designation->name_bn ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.serviceParticular.fields.designation_status') }}
                                            </th>
                                            <td>
                                                {{ $serviceParticular->designation_status }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.serviceParticular.fields.office_organization_institute') }}
                                            </th>
                                            <td>
                                                {{ $serviceParticular->office_organization_institute }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.serviceParticular.fields.joining_date') }}
                                            </th>
                                            <td>
                                                
												{{ englishToBanglaNumber($serviceParticular->joining_date ?? 'N/A') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.serviceParticular.fields.release_date') }}
                                            </th>
                                            <td>
                                              
												{{ englishToBanglaNumber($serviceParticular->release_date ?? 'N/A') }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th> </th>
                                            <td>
                                                <!-- Edit button -->
                                                <a href="{{ route('admin.service-particulars.edit', ['service_particular' => $serviceParticular->id]) }}"
                                                    class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

                                                <!-- Delete button -->
                                                <form
                                                    action="{{ route('admin.service-particulars.destroy', ['service_particular' => $serviceParticular->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">{{ trans('global.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach --}}
							
                            <strong>
                                {{ trans('cruds.training.title') }}
                            </strong>
							<br>

                            @foreach ($employeeList->trainings ?? [] as $training)
							@if(count($employeeList->trainings) > 1)
								<h6>প্রশিক্ষণ - {{ $loop->iteration }}</h6>
							@endif
                                <table class="table-bordered table-striped table" id="training">
                                    <tbody>
                                        
                                        {{--<tr>
                                            <th>
                                                {{ trans('cruds.training.fields.training_type') }}
                                            </th>
                                            <td>
                                                {{ $training->training_type->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>--}}
                                        <tr>
                                            <th>
                                                {{ trans('cruds.training.fields.training_name') }}
                                            </th>
                                            <td>
                                                {{ $training->training_name ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.training.fields.institute_name') }}
                                            </th>
                                            <td>
                                                {{ $training->institute_name ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        {{--<tr>
                                            <th>
                                                {{ trans('cruds.training.fields.country') }}
                                            </th>
                                            <td>
                                                {{ $training->country->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>--}}
                                        <tr>
                                            <th>
                                                {{ trans('cruds.training.fields.start_date') }}
                                            </th>
                                            <td>
                                                
												{{ englishToBanglaNumber($training->start_date ?? 'N/A') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.training.fields.end_date') }}
                                            </th>
                                            <td>
                                                
												{{ englishToBanglaNumber($training->end_date ?? 'N/A') }}
                                            </td>
                                        </tr>
                                        
                                    
									{{--<tr>
                                            <th>
													লোকেশন
                                            </th>
                                            <td>
                                                {{ $training->location ?? 'N/A' }}
                                            </td>
									</tr>--}}
										
										<tr>
                                            <th> </th>
                                            <td>
                                                <!-- Edit button -->
                                                <a href="{{ route('admin.trainings.edit', ['training' => $training->id]) }}"
                                                    class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

                                                <!-- Delete button -->
                                                <form
                                                    action="{{ route('admin.trainings.destroy', ['training' => $training->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">{{ trans('global.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach
							
                            <strong id="travelRecords">{{ trans('cruds.travelRecord.title') }}</strong>
							<br>


                            @foreach ($employeeList->travelRecords ?? [] as $travelRecord)
							@if(count($employeeList->travelRecords) > 1)
								<h6>দাপ্তরিক ভ্রমণ  - {{ $loop->iteration }}</h6>
							@endif
                                <table class="table-bordered table-striped table">
                                    <tbody>
                                        
                                        
                                        <tr>
                                            <th>
                                                {{ trans('cruds.travelRecord.fields.purpose') }}
                                            </th>
                                            <td>
                                                {{ $travelRecord->title->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
										
										<tr>
                                            <th>
													টাইটেল
                                            </th>
                                            <td>
                                                {{ $travelRecord->new_title ?? 'N/A' }}
                                            </td>
                                        </tr>
										
										<tr>
                                            <th>
                                                {{ trans('cruds.travelRecord.fields.country') }}
                                            </th>
                                            <td>
                                                {{ $travelRecord->country->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        
                                        <tr>
											<td>
													{{ trans('cruds.professionale.fields.from_date') }}
                                            </td>
                                            <td>
												{{ englishToBanglaNumber($travelRecord->start_date ?? 'N/A') }}
                                            </td>
                                        </tr>
										
										<tr>
											<td>
													{{ trans('cruds.professionale.fields.to_date') }}
                                            </td>
                                            <td>
												{{ englishToBanglaNumber($travelRecord->end_date ?? 'N/A') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> </th>
                                            <td>
                                                <!-- Edit button -->
                                                <a href="{{ route('admin.travel-records.edit', ['travel_record' => $travelRecord->id]) }}"
                                                    class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

                                                <!-- Delete button -->
                                                <form
                                                    action="{{ route('admin.travel-records.destroy', ['travel_record' => $travelRecord->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
													onclick="return confirm('আপনি নিশ্চিত এটা মুছে দিতে চান?');">{{ trans('global.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach



                            {{--<strong id="foreignTravelPersonal"> {{ trans('cruds.foreignTravelPersonal.title') }}</strong>
							<br>

                            @foreach ($employeeList->foreigntravelpersonals ?? [] as $foreignTravelPersonal)
							@if(count($employeeList->foreigntravelpersonals) > 1)
								<h6>ব্যক্তিগত ভ্রমণ  - {{ $loop->iteration }}</h6>
							@endif
                                <table class="table-bordered table-striped table">
                                    <tbody>

                                        
                                        <tr>
                                            <th>
                                                {{ trans('cruds.travelRecord.fields.purpose') }}
                                            </th>
                                            <td>

                                                {{ $foreignTravelPersonal->title->name_bn ?? 'N/A' }}

                                            </td>

                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.foreignTravelPersonal.fields.country') }}
                                            </th>
                                            <td>
                                                {{ $foreignTravelPersonal->country->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
										
										<tr>
											<td>
													{{ trans('cruds.professionale.fields.from_date') }}
                                            </td>
                                            <td>
												{{ englishToBanglaNumber($foreignTravelPersonal->from_date ?? 'N/A') }}
                                            </td>
                                        </tr>
										
										<tr>
											<td>
													{{ trans('cruds.professionale.fields.to_date') }}
                                            </td>
                                            <td>
												{{ englishToBanglaNumber($foreignTravelPersonal->to_date ?? 'N/A') }}
                                            </td>
                                        </tr>
										
										<tr>
											<th> </th>
											<td>
												<!-- Edit button -->
												<a href="{{ route('admin.foreign-travel-personals.edit', ['foreign_travel_personal' => $foreignTravelPersonal->id]) }}"
													class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

												<!-- Delete button -->
												<form action="{{ route('admin.foreign-travel-personals.destroy', ['foreign_travel_personal' => $foreignTravelPersonal->id]) }}"
													method="POST" style="display: inline;">
													@csrf
													@method('DELETE')
													<button type="submit" class="btn btn-sm btn-danger"
														onclick="return confirm('আপনি নিশ্চিত এটা মুছে দিতে চান?');">{{ trans('global.delete') }}</button>
												</form>
											</td>
										</tr>

                                        
                                        
                                        
                                    </tbody>
                                </table>
                            @endforeach--}}




                            <strong id="extracurriculam"> {{ trans('cruds.extracurriculam.title') }}</strong>
							<br>
                            @foreach ($employeeList->extracurriculams ?? [] as $extracurriculam)
							@if(count($employeeList->extracurriculams) > 1)
								<h6>কার্যক্রম - {{ $loop->iteration }}</h6>
							@endif
                                <table class="table-bordered table-striped table">
                                    <tbody>
                                        
                                        
                                        <tr>
                                            <th>
                                                {{ trans('cruds.extracurriculam.fields.activity_name') }}
                                            </th>
                                            <td>
                                                {{ $extracurriculam->activity_name ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.extracurriculam.fields.organization') }}
                                            </th>
                                            <td>
                                                {{ $extracurriculam->organization ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.extracurriculam.fields.position') }}
                                            </th>
                                            <td>
                                                {{ $extracurriculam->position ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.extracurriculam.fields.start_date') }}
                                            </th>
                                            <td>
                                                
												{{ englishToBanglaNumber($extracurriculam->start_date ?? 'N/A') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.extracurriculam.fields.end_date') }}
                                            </th>
                                            <td>
                                                
												{{ englishToBanglaNumber($extracurriculam->end_date ?? 'N/A') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.extracurriculam.fields.description') }}
                                            </th>
                                            <td>
                                                {!! $extracurriculam->description ?? 'N/A' !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.extracurriculam.fields.attatchment') }}
                                            </th>
                                            <td>
                                                @if ($extracurriculam->attatchment)
                                                    <a href="{{ $extracurriculam->attatchment->getUrl() }}"
                                                        target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
													@else
														N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> </th>
                                            <td>
                                                <!-- Edit button -->
                                                <a href="{{ route('admin.extracurriculams.edit', ['extracurriculam' => $extracurriculam->id]) }}"
                                                    class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

                                                <!-- Delete button -->
                                                <form
                                                    action="{{ route('admin.extracurriculams.destroy', ['extracurriculam' => $extracurriculam->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
													onclick="return confirm('আপনি নিশ্চিত এটা মুছে দিতে চান?');">{{ trans('global.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach

                            <strong id="publication"> {{ trans('cruds.publication.title') }}</strong>
							<br>

                            @foreach ($employeeList->publications ?? [] as $publication)
							@if(count($employeeList->publications) > 1)
								<h6>প্রকাশনা - {{ $loop->iteration }}</h6>
							@endif
                                <table class="table-bordered table-striped table">
                                    <tbody>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.publication.fields.title') }}
                                            </th>
                                            <td>
                                                {{ $publication->title ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.publication.fields.publication_type') }}
                                            </th>
                                            <td>
                                                {{ App\Models\Publication::PUBLICATION_TYPE_SELECT[$publication->publication_type] ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.publication.fields.publication_media') }}
                                            </th>
                                            <td>
                                                {{ $publication->publication_media ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.publication.fields.publication_date') }}
                                            </th>
                                            <td>
                                                
												{{ englishToBanglaNumber($publication->publication_date ?? 'N/A') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.publication.fields.publication_link') }}
                                            </th>
                                            <td>
                                                {{ $publication->publication_link ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.publication.fields.description') }}
                                            </th>
                                            <td>
                                                {!! $publication->description ?? 'N/A' !!}
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <th> </th>
                                            <td>
                                                <!-- Edit button -->
                                                <a href="{{ route('admin.publications.edit', ['publication' => $publication->id]) }}"
                                                    class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

                                                <!-- Delete button -->
                                                <form
                                                    action="{{ route('admin.publications.destroy', ['publication' => $publication->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
													onclick="return confirm('আপনি নিশ্চিত এটা মুছে দিতে চান?');">{{ trans('global.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach
							
							
                            <strong id="awards"> {{ trans('cruds.award.title') }}</strong>
							<br>

                            @foreach ($employeeList->awards ?? [] as $award)
							@if(count($employeeList->awards) > 1)
								<h6>পুরস্কার - {{ $loop->iteration }}</h6>
							@endif
                                <table class="table-bordered table-striped table">
                                    <tbody>

                                        <tr>
                                            <th>
                                                {{ trans('cruds.award.fields.title') }}
                                            </th>
                                            <td>
                                                {{ $award->title ?? 'N/A' }}
                                            </td>
                                        </tr>
										<tr>
                                            <th>
                                                @if (app()->getLocale() === 'bn')
                            পুরস্কার প্রদানকারী </b>
                        @else
                           Awardee</b>
                        @endif
                                            </th>
                                            <td>
                                                {{ $award->institution ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.award.fields.ground_area') }}
                                            </th>
                                            <td>
                                                {{ $award->ground_area ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                সাল
                                            </th>
                                            <td>
                                                
												{{ englishToBanglaNumber($award->year ?? 'N/A') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.award.fields.certificate') }}
                                            </th>
                                            <td>
                                                @if ($award->certificate)
                                                    <a href="{{ $award->certificate->getUrl() }}" target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
													@else
														N/A
                                                @endif
                                            </td>
                                        </tr>
                                        

                                        <tr>
                                            <th>

                                            </th>
                                            <td>
                                                <!-- Edit button -->
                                                <a href="{{ route('admin.awards.edit', ['award' => $award->id]) }}"
                                                    class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

                                                <!-- Delete button -->
                                                <form
                                                    ="{{ route('admin.awards.destroy', ['award' => $award->id]) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
												onclick="return confirm('আপনি নিশ্চিত এটা মুছে দিতে চান?');">{{ trans('global.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            @endforeach


                            <strong id="otherservicejobs"> {{ trans('cruds.otherServiceJob.title') }}</strong>
							<br>

                            @foreach ($employeeList->otherservicejobs ?? [] as $otherServiceJob)
							@if(count($employeeList->otherservicejobs) > 1)
								<h6>পরিষেবা/চাকরি - {{ $loop->iteration }}</h6>
							@endif
                                <table class="table-bordered table-striped table">
                                    <tbody>
                                        
                                        <tr>
                                            <th>
                                                {{ trans('cruds.otherServiceJob.fields.employer') }}
                                            </th>
                                            <td>
                                                {{ $otherServiceJob->employer ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.otherServiceJob.fields.address') }}
                                            </th>
                                            <td>
                                                {{ $otherServiceJob->address ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.otherServiceJob.fields.service_type') }}
                                            </th>
                                            <td>
                                                {{ $otherServiceJob->service_type ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.otherServiceJob.fields.position') }}
                                            </th>
                                            <td>
                                                {{ $otherServiceJob->position ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.otherServiceJob.fields.from') }}
                                            </th>
                                            <td>
                                                
												{{ englishToBanglaNumber($otherServiceJob->from ?? 'N/A') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.otherServiceJob.fields.to') }}
                                            </th>
                                            <td>
                                                
												{{ englishToBanglaNumber($otherServiceJob->to ?? 'N/A') }}
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <th> </th>
                                            <td>
                                                <!-- Edit button -->
                                                <a href="{{ route('admin.other-service-jobs.edit', ['other_service_job' => $otherServiceJob->id]) }}"
                                                    class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

                                                <!-- Delete button -->
                                                <form
                                                    action="{{ route('admin.other-service-jobs.destroy', ['other_service_job' => $otherServiceJob->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
													onclick="return confirm('আপনি নিশ্চিত এটা মুছে দিতে চান?');">{{ trans('global.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach
                            <strong id="languages"> {{ trans('cruds.language.title') }}</strong>
							<br>

                            @foreach ($employeeList->languages ?? [] as $language)
							@if(count($employeeList->languages) > 1)
								<h6>ভাষা - {{ $loop->iteration }}</h6>
							@endif
                                <table class="table-bordered table-striped table">
                                    <tbody>
                                        
                                        <tr>
                                            <th>
                                                {{ trans('cruds.language.fields.language') }}
                                            </th>
                                            <td>
                                                @if (app()->getLocale() === 'bn')
                                                    {{ $language->language->name ?? 'N/A' }}
                                                @else
                                                    {{ $language->language->nmae_en ?? 'N/A' }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.language.fields.read') }}
                                            </th>
                                            <td>


                                                @if (app()->getLocale() === 'bn')
                                                    {{ $language->read->name ?? 'N/A' }}
                                                @else
                                                    {{ $language->read->nmae_en ?? 'N/A' }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.language.fields.write') }}
                                            </th>
                                            <td>
                                                @if (app()->getLocale() === 'bn')
                                                    {{ $language->write->name ?? 'N/A' }}
                                                @else
                                                    {{ $language->language->nmae_en ?? 'N/A' }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.language.fields.speak') }}
                                            </th>
                                            <td>
                                                @if (app()->getLocale() === 'bn')
                                                    {{ $language->speak->name ?? 'N/A' }}
                                                @else
                                                    {{ $language->language->nmae_en ?? 'N/A' }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> </th>
                                            <td>
                                                <!-- Edit button -->
                                                <a href="{{ route('admin.languages.edit', ['language' => $language->id]) }}"
                                                    class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

                                                <!-- Delete button -->
                                                <form
                                                    action="{{ route('admin.languages.destroy', ['language' => $language->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
													onclick="return confirm('আপনি নিশ্চিত এটা মুছে দিতে চান?');">{{ trans('global.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach

                            <strong id="criminalProsecutione"> {{ trans('cruds.criminalProsecutione.title') }}</strong>
							<br>

                            @foreach ($employeeList->criminalprosecutiones ?? [] as $criminalProsecutione)
							@if(count($employeeList->criminalprosecutiones) > 1)
								<h6>মামলা - {{ $loop->iteration }}</h6>
							@endif
                                <table class="table-bordered table-striped table">
                                    <tbody>
                                        
                                        <tr>
                                            <th>
												মামলার ধরণ
                                            </th>
                                            <td>
                                                {{ $criminalProsecutione->mamla->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
										
										
										<tr>
                                            <th>
												মামলা রুজুর নম্বর ও তারিখ
                                            </th>
                                            <td>
                                                {{ $criminalProsecutione->mamla_start ?? 'N/A' }}
                                            </td>
                                        </tr>
										
										<tr>
                                            <th>
													মামলা রুজুর আদেশ সংযোজন
                                            </th>
                                            <td>
                                           
                                                @if ($criminalProsecutione->court_order)
                                                    <a href="{{ $criminalProsecutione->court_order->getUrl() }}"
                                                        target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
													@else
														N/A
                                                @endif
												
                                          
											
                                            </td>
                                        </tr>
										
										<tr>
                                            <th>
												মামলার বর্তমান অবস্থা
                                            </th>
                                            <td>
                                                {{ $criminalProsecutione->situation->name_bn ?? 'N/A' }}
                                            </td>
                                        </tr>
										
										
										<tr>
                                            <th>
												মামলা নিস্পত্তির নম্বর ও তারিখ
                                            </th>
                                            <td>
                                                {{ $criminalProsecutione->mamla_end ?? 'N/A' }}
                                            </td>
                                        </tr>
										
										<tr>
                                            <th>
													মামলা নিস্পত্তির আদেশ সংযোজন
                                            </th>
                                            <td>
                                           
                                                @if ($criminalProsecutione->court_order_new)
                                                    <a href="{{ $criminalProsecutione->court_order_new->getUrl() }}"
                                                        target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
													@else
														N/A
                                                @endif
												
                                          
											
                                            </td>
                                        </tr>
										
										<tr>
                                            <th>
												মামলা নিস্পত্তির রায়
                                            </th>
                                            <td>
                                                {{ $criminalProsecutione->mamla_result ?? 'N/A' }}
                                            </td>
                                        </tr>
										
										
										<tr>
                                            <th>
												আপিলের আদেশ/প্রজ্ঞাপন নম্বর ও তারিখ
                                            </th>
                                            <td>
                                                {{ $criminalProsecutione->appeal_go ?? 'N/A' }}
                                            </td>
                                        </tr>
										
										
										<tr>
                                            <th>
													আপিলের আদেশ সংযোজন
                                            </th>
                                            <td>
                                           
                                                @if ($criminalProsecutione->appeal_order)
                                                    <a href="{{ $criminalProsecutione->appeal_order->getUrl() }}"
                                                        target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
													@else
														N/A
                                                @endif
												
                                          
											
                                            </td>
                                        </tr>
										
										<tr>
                                            <th>
												আপিলের রায়
                                            </th>
                                            <td>
                                                {{ $criminalProsecutione->appeal_result?? 'N/A' }}
                                            </td>
                                        </tr>

                                        

                                        


                                        {{--<tr>
                                            <th>
                                                {{ trans('cruds.criminalProsecutione.fields.court_order') }}
                                            </th>
                                            <td>
                                                @if ($criminalProsecutione->court_order)
                                                    <a href="{{ $criminalProsecutione->court_order->getUrl() }}"
                                                        target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
													@else
														N/A
                                                @endif
												
                                            </td>
                                        </tr>--}}
                                        <tr>
                                            <th>
                                                {{ trans('cruds.criminalProsecutione.fields.remzrk') }}
                                            </th>
                                            <td>
                                                {!! $criminalProsecutione->remzrk ?? 'N/A' !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> </th>
                                            <td>
                                                <!-- Edit button -->
                                                <a href="{{ route('admin.criminal-prosecutiones.edit', ['criminal_prosecutione' => $criminalProsecutione->id]) }}"
                                                    class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

                                                <!-- Delete button -->
                                                <form
                                                    action="{{ route('admin.criminal-prosecutiones.destroy', ['criminal_prosecutione' => $criminalProsecutione->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger"
														onclick="return confirm('আপনি নিশ্চিত এটা মুছে দিতে চান?');">{{ trans('global.delete') }}>{{ trans('global.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>


                                    </tbody>
                                </table>
                            @endforeach

                            {{--<strong id="criminalproDisciplinary">
                                {{ trans('cruds.criminalproDisciplinary.title') }}</strong>
								<br>

                            @foreach ($employeeList->criminalprodisciplinaries ?? [] as $criminalproDisciplinary)
							@if(count($employeeList->criminalprodisciplinaries) > 1)
								<h6>শাস্তিমূলক ব্যবস্থা - {{ $loop->iteration }}</h6>
							@endif
                                <table class="table-bordered table-striped table">
                                    <tbody>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.criminalproDisciplinary.fields.criminalprosecutione') }}
                                            </th>
                                            <td>
                                                {{ $criminalproDisciplinary->natureof_offence ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.criminalproDisciplinary.fields.judgement_type') }}
                                            </th>
                                            <td>
                                                {{ $criminalproDisciplinary->judgement_type ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.criminalproDisciplinary.fields.government_order_no') }}
                                            </th>
                                            <td>
                                                {{ $criminalproDisciplinary->government_order_no ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.criminalproDisciplinary.fields.order_upload_file') }}
                                            </th>
                                            <td>
                                                @if ($criminalproDisciplinary->order_upload_file)
                                                    <a href="{{ $criminalproDisciplinary->order_upload_file->getUrl() }}"
                                                        target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
													@else
														N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                {{ trans('cruds.criminalproDisciplinary.fields.remarks') }}
                                            </th>
                                            <td>
                                                {{ $criminalproDisciplinary->remarks ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> </th>
                                            <td>
                                                
                                                <a href="{{ route('admin.criminalpro-disciplinaries.edit', ['criminalpro_disciplinary' => $criminalproDisciplinary->id]) }}"
                                                    class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>
 
                                                <form
                                                    action="{{ route('admin.criminalpro-disciplinaries.destroy', ['criminalpro_disciplinary' => $criminalproDisciplinary->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
													onclick="return confirm('আপনি নিশ্চিত এটা মুছে দিতে চান?');">{{ trans('global.delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach --}}





                            <strong id="acrMonitoring">{{ trans('cruds.acrMonitoring.title') }}</strong>
							<br>

                            @foreach ($employeeList->acrmonitorings ?? [] as $acrMonitoring)
							@if(count($employeeList->acrmonitorings) > 1)
								<h6>পর্যবেক্ষণ - {{ $loop->iteration }}</h6>
							@endif
                                <table class="table-bordered table-striped table">
                                    <tbody>
                                        
                                        <tr>
                                            <th>
                                                {{ trans('cruds.acrMonitoring.fields.year') }}
                                            </th>
                                            <td>
                                                
												{{ englishToBanglaNumber($acrMonitoring->year ?? 'N/A') }}
                                            </td>
                                        </tr>
                                        
                                        
                                        <tr>
                                            <th>
                                                {{ trans('cruds.acrMonitoring.fields.remarks') }}
                                            </th>
                                            <td>
                                                {!! $acrMonitoring->remarks ?? 'N/A' !!}
                                            </td>
                                        </tr>
										<tr>
                                            <th>
                                                {{ trans('cruds.professionale.fields.from_date') }}
                                            </th>
                                            <td>
                                                
												{{ englishToBanglaNumber($acrMonitoring->fromdate ?? 'N/A') }}
                                            </td>
                                        </tr>
										<tr>
                                            <th>
                                                {{ trans('cruds.professionale.fields.to_date') }}
                                            </th>
                                            <td>
                                                
												{{ englishToBanglaNumber($acrMonitoring->todate ?? 'N/A') }}
                                            </td>
                                        </tr>
										<tr>
                                            <th>
													জমা দেওয়া হয়েছে?
                                            </th>
                                            <td>
                                                @if($acrMonitoring->issubmitted == 1)
													হ্যাঁ
												@else
													না
												
												@endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> </th>
                                            <td>
                                                <!-- Edit button -->
                                                <a href="{{ route('admin.acr-monitorings.edit', ['acr_monitoring' => $acrMonitoring->id]) }}"
                                                    class="btn btn-sm btn-primary">{{ trans('global.edit') }}</a>

                                                <!-- Delete button -->
                                                <form
                                                    action="{{ route('admin.acr-monitorings.destroy', ['acr_monitoring' => $acrMonitoring->id]) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('{{ trans('global.areYouSure') }}');">
                                                        {{ trans('global.delete') }}
                                                    </button>

                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endsection

            @section('scripts')
                @parent

                <script>
                    $(document).ready(function() {
                        // Add active class to clicked menu item and remove from others
                        $('.nav-link').on('click', function() {
                            $('.nav-link').removeClass('active');
                            $(this).addClass('active');
                        });

                        // Add active class on page load based on URL hash
                        var hash = window.location.hash;
                        $('.nav-link[href="' + hash + '"]').addClass('active');
                    });
                </script>
            @endsection
