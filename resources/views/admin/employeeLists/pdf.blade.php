<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List PDF</title>
    <!-- Include any CSS styles if needed -->
    <style>
        body {
            font-family: 'nsikosh', sans-serif;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {

            font-weight: normal;
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            padding: 4;
            margin: 0;
        }

        strong {
            font-size: 18px;
            line-height: 20px;
            margin-top: 20px;
        }

        @page {
            header: page-header;
            footer: page-footer;
        }
    </style>
</head>

<body style="padding: 20px">
    {{-- <htmlpageheader name="page-header">
        Your Header Content
    </htmlpageheader> --}}

    <table class="header w-100" cellspacing="0" cellpadding="0">
        <tr>
            <td style="text-align: left; border: 0;" width="82">
                @php
                $imagePath = public_path('assets/images/logo1.png');
                @endphp

                @if (file_exists($imagePath))
                <img src="{{ asset('assets/images/logo1.png') }}" height="80" alt="Logo" />
                @else
                <p>Logo not found</p>
                @endif

            </td>
            <td style="text-align: center;" style="border: 0;">
                <center>
                    <h1 style="color: #006625; margin:0">বন অধিদপ্তর-গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</h1>
                    @if (app()->getLocale() === 'bn')
                    <h3 style=" margin:0"> সার্ভিস রেকর্ড ম্যানেজমেন্ট সিস্টেম<br>
                        নাম: {{ $employeeList->fullname_bn }}</h3>
                    @else
                    <h3 style=" margin:0"> Service Record Management System
                        <br> Name:{{ $employeeList->fullname_en }}
                    </h3>
                    @endif
                    <b> {{ trans('cruds.employeeList.fields.employeeid') }}:
                        {{ englishToBanglaNumber($employeeList->employeeid) }}</b><br>
                </center>
            </td>


            @if ($employeeList->employee_photo)
            <td style="text-align: right;border: 0;" width="82">
                <img src="{{ $employeeList->employee_photo->getUrl('thumb') }}" class="rounded-circle" width="80">
            </td>
            @else
            <td style="text-align: center;" width="82">
                NO<br>
                PHOTO
            </td>
            @endif

        </tr>
    </table><br />

    <div class="col-md-12">
        <div class="tab-content my-1 border p-2" id="v-pills-tabContent">
            <div>
                <strong>{{ trans('cruds.employeeList.title_singular') }}</strong>

                {{-- @dd($employeeList); --}}
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
                                {{ $employeeList->fullname_en ?? 'N/A' }}
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
                                {{ $employeeList->fname_en ?? 'N/A' }}
                            </td>
                        </tr>


                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.mname_bn') }}
                            </th>
                            <td>
                                {{ $employeeList->mname_bn ?? 'N/A' }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.mname_en') }}
                            </th>
                            <td>
                                {{ $employeeList->mname_en ?? 'N/A' }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.cadreid') }}
                            </th>
                            <td>
                                {{ englishToBanglaNumber($employeeList->cadreid ?? 'N/A') }}

                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.batch') }}
                            </th>
                            <td>

                                {{ app()->getLocale() === 'bn' ? $employeeList->batch->batch_bn ?? 'N/A' :
                                $employeeList->batch->batch_en ?? 'N/A' }}

                            </td>
                        </tr>




                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.date_of_birth') }}
                            </th>
                            <td>
                                {{ englishToBanglaNumber($employeeList->date_of_birth ?? 'N/A') }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.prl_date') }}
                            </th>
                            <td>
                                {{ englishToBanglaNumber($employeeList->prl_date ?? 'N/A') }}

                            </td>
                        </tr>
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
                                {{ trans('cruds.employeeList.fields.height') }}
                            </th>
                            <td>
                                {{ englishToBanglaNumber($employeeList->height ?? 'N/A') }}

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
                                {{ $employeeList->home_district->{$columname} ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.marital_statu') }}
                            </th>
                            <td>
                                @if (app()->getLocale() === 'bn')
                                {{ $employeeList->marital_statu->name ?? 'N/A' }}
                                @else
                                {{ $employeeList->marital_statu->name_en ?? 'N/A' }}
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.gender') }}
                            </th>
                            <td>
                                {{ $employeeList->gender->{$columname} ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.religion') }}
                            </th>
                            <td>
                                {{ $employeeList->religion->{$columname} ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.blood_group') }}
                            </th>
                            <td>
                                {{ $employeeList->blood_group->{$columname} ?? 'N/A' }}
                            </td>
                        </tr>
                        

                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.nid_number') }}
                            </th>
                            <td>
                                {{ englishToBanglaNumber($employeeList->nid ?? 'N/A') }}

                            </td>
                        </tr>
                        

                        

                        <tr>
                            <th>
                                {{ trans('cruds.child.fields.passport_number') }}
                            </th>
                            <td>
                                {{ englishToBanglaNumber($employeeList->passport ?? 'N/A') }}

                            </td>
                        </tr>
                        



                        @if ($employeeList->license_type_id !== null)
                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.has_license') }}
                            </th>
                            <td>
                                {{ trans('cruds.employeeList.fields.yes') }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.license_type') }}
                            </th>
                            <td>
                                {{ $employeeList->license_type->{$columname} ?? 'N/A' }}

                            </td>
                        </tr>

                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.license_number') }}
                            </th>
                            <td>
                                {{ englishToBanglaNumber($employeeList->license_number ?? 'N/A') }}


                            </td>
                        </tr>
                        @else
                        <tr>
                            <th>{{ trans('cruds.employeeList.fields.has_license') }}</th>
                            <td>N/A</td>
                        </tr>
                        @endif

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
                                {{ englishToBanglaNumber($employeeList->mobile_number ?? 'N/A') }}

                            </td>
                        </tr>

                        @if ($employeeList->joiningexaminfo_id == 2)
                        <tr>
                            <th>{{ trans('cruds.employeeList.fields.joiningexaminfo') }}</th>
                            <td>{{ trans('cruds.employeeList.fields.project_revenue') }}</td>
                        </tr>
                        @if ($employeeList->projectrevenue_id == 2)
                        <tr>
                            <th>{{ trans('cruds.employeeList.fields.cadre/noncadre') }}</th>
                            <td>{{ trans('cruds.employeeList.fields.cadre') }}</td>
                        </tr>

                        @else
                        <tr>
                            <th>{{ trans('cruds.employeeList.fields.cadre/noncadre') }}</th>
                            <td>{{ trans('cruds.employeeList.fields.noncadre') }}</td>
                        </tr>
                        @endif
                        @elseif($employeeList->joiningexaminfo_id == 1)
                        <tr>
                            <th>{{ trans('cruds.employeeList.fields.joiningexaminfo') }}</th>
                            <td>{{ trans('cruds.employeeList.fields.project') }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.employeeList.fields.projectname') }}</th>
                            <td>
                                @if (app()->getLocale() === 'bn')
                                {{ $employeeList->project->name_bn ?? 'N/A' }}
                                @else
                                {{ $employeeList->project->name_en ?? 'N/A' }}
                                @endif
                            </td>
                        </tr>
                        @elseif($employeeList->joiningexaminfo_id == 3)
                        <tr>
                            <th>{{ trans('cruds.employeeList.fields.joiningexaminfo') }}</th>
                            <td>{{ trans('cruds.employeeList.fields.adhoc') }}</td>
                        </tr>

                        @endif
						
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
                        @if ($employeeList->joiningexaminfo_id == 1)
                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.date_of_regularization') }}
                            </th>
                            <td>
                                {{ englishToBanglaNumber($employeeList->date_of_regularization ?? 'N/A') }}

                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.regularization_issue_date') }}
                            </th>
                            <td>
                                {{ englishToBanglaNumber($employeeList->regularization_issue_date ?? 'N/A') }}

                            </td>
                        </tr>
                        @endif












                        </tr> --}}

                        @if ($employeeList->date_of_gazette)
                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.date_of_gazette') }}
                            </th>
                            <td>
                                {{ englishToBanglaNumber($employeeList->date_of_gazette ?? 'N/A') }}

                            </td>
                        </tr>
                        @endif







                        @if ($employeeList->date_of_con_serviec)
                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.date_of_con_serviec') }}
                            </th>
                            <td>
                                {{ englishToBanglaNumber($employeeList->date_of_con_serviec ?? 'N/A') }}

                            </td>
                        </tr>
                        @endif


                        @if ($employeeList->quota_id == 1)
                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.quota') }}
                            </th>
                            <td>
                                {{ $employeeList->quota->{$columname} ?? 'N/A' }}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.freedomfighter') }}
                            </th>
                            <td>
                                {{ $employeeList->freedom_fighter->name_bn ?? 'N/A' }}
                            </td>
                        </tr>
                        @else
                        <tr>
                            <th>
                                {{ trans('cruds.employeeList.fields.quota') }}
                            </th>
                            <td>
                                {{ $employeeList->quota->{$columname} ?? 'N/A' }}
                            </td>
                        </tr>
                        @endif


                    </tbody>
                </table><br />
                {{-- @dd($employeeList->educations); --}}

                @if ($employeeList->educations->isNotEmpty())
                <strong>{{ trans('cruds.educationInformatione.title_singular') }}</strong>


                <table class="table-bordered table-striped table" id="Education">
                    <tbody>
                        <!-- Column Headers -->
                        <tr>
                            <th>ক্রমিক নং</th> <!-- Serial Number Header -->
                            <th>
                                @if (app()->getLocale() === 'bn')
                                ডিগ্রী
                                @else
                                {{ trans('Level of Education') }}
                                @endif
                            </th>
                            <th>
                                {{ trans('cruds.educationInformatione.fields.name_of_exam') }}
                            </th>
                            <th>
                                {{ trans('cruds.educationInformatione.fields.exam_board') }}
                            </th>
                            <th>
                                {{ trans('cruds.educationInformatione.fields.school_university_name') }}
                            </th>
                            <th>
                                @if (app()->getLocale() === 'bn')
                                প্রধান বিষয়
                                @else
                                Principal Subjects
                                @endif
                            </th>
                            <th>
                                {{ trans('cruds.educationInformatione.fields.achivement') }}
                            </th>
                            <th>
                                {{ trans('cruds.educationInformatione.fields.passing_year') }}
                            </th>
                        </tr>

                        <!-- Data Rows -->
                        @foreach ($employeeList->educations ?? [] as $index => $educationInformatione)
                        <tr>
                            <td>{{ englishToBanglaNumber($index + 1) }}</td> <!-- Serial Number Column -->
                            <td>{{ $educationInformatione->name_of_exam->{$columname} ?? 'N/A' }}</td>
                            <td>
                                @if ($deucationDegree)
                                @foreach ($deucationDegree->where('id', $educationInformatione->exam_degree) as
                                $educationDegree)
                                {{ $educationDegree[$columname] ?? 'N/A' }}
                                @endforeach
                                @endif
                            </td>
                            <td>{{ $educationInformatione->exam_board->{$columname} ?? 'N/A' }}</td>
                            <td>{{ $educationInformatione->school_university_name ?? 'N/A' }}</td>
                            <td>{{ $educationInformatione->concentration_major_group ?? 'N/A' }}</td>
                            <td>{{ $educationInformatione->achivement }}{{ englishToBanglaNumber($educationInformatione->cgpa) }}{{
                                $educationInformatione->result->name_bn ?? '' }}</td>
                            <td>{{ englishToBanglaNumber($educationInformatione->passing_year ?? 'N/A') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>




                @endif
                <br>

                @if ($employeeList->professionales->isNotEmpty())
                <strong> {{ trans('cruds.professionale.title') }}</strong>



                <table class="table-bordered table-striped table" id="Professionales">
                    <tbody>
                        <!-- Column Headers inside tbody -->
                        <tr>
                            <th>ক্রমিক নং</th> <!-- Serial Number Header -->
                            <th>
                                {{ trans('cruds.professionale.fields.qualification_title') }}
                            </th>
                            <th>
                                {{ trans('cruds.professionale.fields.institution') }}
                            </th>
                            <th>
                                {{ trans('cruds.professionale.fields.from_date') }}
                            </th>
                            <th>
                                {{ trans('cruds.professionale.fields.to_date') }}
                            </th>
                        </tr>

                        <!-- Data Rows -->
                        @foreach ($employeeList->professionales ?? [] as $index => $professionale)
                        <tr>
                            <td>{{ englishToBanglaNumber($index + 1) }}</td> <!-- Serial Number Column -->
                            <td>{{ $professionale->qualification_title ?? 'N/A' }}</td>
                            <td>{{ $professionale->institution ?? 'N/A' }}</td>
                            <td>{{ englishToBanglaNumber($professionale->from_date ?? 'N/A') }}</td>
                            <td>{{ englishToBanglaNumber($professionale->to_date ?? 'N/A') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @endif

                <br>

                @if ($employeeList->addressdetailes->isNotEmpty())
                <strong>ঠিকানা</strong>



                <table class="table-bordered table-striped table" id="addressdetaile">
                    <tbody>
                        <!-- Column Headers inside tbody -->
                        <tr>
                            <th>ক্রমিক নং</th> <!-- Serial Number Header -->
                            <th>ঠিকানার ধরণ</th>
                            <th>
                                {{ trans('cruds.addressdetaile.fields.flat_house') }}
                            </th>
                            <th>
                                {{ trans('cruds.addressdetaile.fields.post_office') }}
                            </th>
                            <th>
                                {{ trans('cruds.addressdetaile.fields.post_code') }}
                            </th>
                            <th>
                                {{ trans('cruds.addressdetaile.fields.thana_upazila') }}
                            </th>
                            <th>
                                {{ trans('cruds.addressdetaile.fields.phone_number') }}
                            </th>
                        </tr>

                        <!-- Data Rows -->
                        @foreach ($employeeList->addressdetailes ?? [] as $index => $addressdetaile)
                        <tr>
                            <td>{{ englishToBanglaNumber($index + 1) }}</td> <!-- Serial Number Column -->
                            <td>
                                @if($addressdetaile->address_type === 'permanent')
                                স্থায়ী ঠিকানা
                                @else
                                বর্তমান ঠিকানা
                                @endif
                            </td>
                            <td>{{ $addressdetaile->flat_house ?? 'N/A' }}</td>
                            <td>{{ $addressdetaile->post_office ?? 'N/A' }}</td>
                            <td>{{ $addressdetaile->post_code ?? 'N/A' }}</td>
                            <td>{{ $addressdetaile->thana_upazila->name_bn ?? 'N/A' }}</td>
                            <td>{{ englishToBanglaNumber($addressdetaile->phone_number ?? 'N/A') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>



                @endif
                <br>


                @if ($employeeList->emergencecontactes->isNotEmpty())
                <strong>{{ trans('cruds.emergenceContacte.title') }}</strong>

                <table class="table-bordered table-striped table" id="emergenceContacte">
                    <tbody>
                        <!-- Column Headers inside tbody -->
                        <tr>
                            <th>ক্রমিক নং</th> <!-- Serial Number Header -->
                            <th>
                                {{ trans('cruds.emergenceContacte.fields.contact_person_name') }}
                            </th>
                            <th>
                                {{ trans('cruds.emergenceContacte.fields.contact_person_relation') }}
                            </th>
                            <th>
                                {{ trans('cruds.emergenceContacte.fields.address') }}
                            </th>
                            <th>
                                {{ trans('cruds.emergenceContacte.fields.contact_person_number') }}
                            </th>
                        </tr>

                        <!-- Data Rows -->
                        @foreach ($employeeList->emergencecontactes ?? [] as $index => $emergenceContacte)
                        <tr>
                            <td>{{ englishToBanglaNumber($index + 1) }}</td> <!-- Serial Number Column -->
                            <td>{{ $emergenceContacte->contact_person_name ?? 'N/A' }}</td>
                            <td>{{ $emergenceContacte->contact_person_relation ?? 'N/A' }}</td>
                            <td>{{ $emergenceContacte->address ?? 'N/A' }}</td>
                            <td>{{ englishToBanglaNumber($emergenceContacte->contact_person_number ?? 'N/A') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>



                @endif
                <br>

                @if ($employeeList->spouseinformationes->isNotEmpty())
                <strong> {{ trans('cruds.spouseInformatione.title') }}</strong>



                <table class="table-bordered table-striped table" id="spouseInformationes">
                    <tbody>
                        <!-- Column Headers inside tbody -->
                        <tr>
                            <th>
                                {{ trans('cruds.spouseInformatione.fields.name_bn') }}
                            </th>
                            <th>
                                {{ trans('cruds.spouseInformatione.fields.name_en') }}
                            </th>
                            <th>
                                {{ trans('cruds.spouseInformatione.fields.occupation') }}
                            </th>
                            <th>
                                {{ trans('cruds.spouseInformatione.fields.phone_number') }}
                            </th>
                            <th>
                                {{ trans('cruds.spouseInformatione.fields.present_addess') }}
                            </th>
                            <th>
                                {{ trans('cruds.spouseInformatione.fields.permanent_addess') }}
                            </th>
                        </tr>

                        <!-- Data Rows -->
                        @foreach ($employeeList->spouseinformationes ?? [] as $spouseInformatione)
                        <tr>
                            <td>{{ $spouseInformatione->name_bn ?? 'N/A' }}</td>
                            <td>{{ $spouseInformatione->name_en ?? 'N/A' }}</td>
                            <td>{{ $spouseInformatione->occupation ?? 'N/A' }}</td>
                            <td>{{ $spouseInformatione->phone_number ?? 'N/A' }}</td>
                            <td>{!! $spouseInformatione->present_addess ?? 'N/A' !!}</td>
                            <td>{!! $spouseInformatione->permanent_addess ?? 'N/A' !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @endif
                <br>

                @if ($employeeList->childinformationes->isNotEmpty())
                <strong> {{ trans('cruds.child.title') }}</strong>



                <table class="table-bordered table-striped table" id="child">
                    <thead>
                        <tr>
                            <th>ক্রমিক নং</th> <!-- Serial Number Header -->
                            <th>{{ trans('cruds.child.fields.name_bn') }}</th>
                            <th>{{ trans('cruds.child.fields.name_en') }}</th>
                            <th>{{ trans('cruds.child.fields.date_of_birth') }}</th>
                            <th>{{ trans('cruds.child.fields.complite_21') }}</th>
                            <th>{{ trans('cruds.child.fields.gender') }}</th>
                            <th>{{ trans('cruds.child.fields.nid_number') }}</th>
                            <th>{{ trans('cruds.child.fields.passport_number') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeList->childinformationes ?? [] as $index => $child)
                        <tr>
                            <td>{{ englishToBanglaNumber($index + 1) }}</td> <!-- Serial Number Column -->
                            <td>{{ $child->name_bn ?? 'N/A' }}</td>
                            <td>{{ $child->name_en ?? 'N/A' }}</td>
                            <td>{{ englishToBanglaNumber($child->date_of_birth ?? 'N/A') }}</td>
                            <td>{{ englishToBanglaNumber($child->complite_21 ?? 'N/A') }}</td>
                            <td>{{ $child->gender->name_bn ?? 'N/A' }}</td>
                            <td>{{ $child->nid_number ?? 'N/A' }}</td>
                            <td>{{ $child->passport_number ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


                @endif
                <br>

                @if ($employeeList->jobhistories->isNotEmpty())
                <strong> {{ trans('cruds.jobHistory.title') }}</strong>


                <table class="table-bordered table-striped table" id="jobHistory">
                    <thead>
                        <tr>
                            <th>ক্রমিক নং</th>
                            <th>অফিস</th>
                            <th>অফিসের নাম</th>
                            <th>সার্কেল</th>
                            <th>ডিভিশন</th>
                            <th>রেঞ্জ/ এসএফএনটিসি/ স্টেশন</th>
                            <th>বিট/ এসএফপিসি/ ক্যাম্প</th>
                            <th>{{ trans('cruds.jobHistory.fields.designation') }}</th>
                            <th>গ্রেড</th>
                            <th>{{ trans('cruds.jobHistory.fields.joining_date') }}</th>
                            <th>{{ trans('cruds.jobHistory.fields.release_date') }}</th>
							<th>মন্তব্য</th>
                                            
                                    
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeList->jobhistories ?? [] as $index => $jobHistory)
                        <tr>
                            <td>{{ englishToBanglaNumber($index + 1) }}</td> <!-- Serial Number Column -->
                            <td>{{ $jobHistory->office_unit->name_bn ?? 'N/A' }}</td>
                            <td> 
							@if($jobHistory->institutename == null)
							{{ $jobHistory->level_2 ?? 'N/A' }}
							@else
							{{ $jobHistory->institutename ?? '' }}- {{ $jobHistory->academy_type ?? '' }}
							@endif
							</td>
                            <td>{{ $jobHistory->circle_list->name_bn ?? 'N/A' }}</td>
                            <td>{{ $jobHistory->division_list->name_bn ?? 'N/A' }}</td>
                            <td>{{ $jobHistory->range_list->name_bn ?? 'N/A' }}</td>
                            <td>{{ $jobHistory->beat_list->name_bn ?? 'N/A' }}</td>
                            <td>{{ $jobHistory->designation->name_bn ?? 'N/A' }}</td>
                            <td>{{ $jobHistory->grade->name_bn ?? 'N/A' }}</td>
                            <td>{{ englishToBanglaNumber($jobHistory->joining_date ?? 'N/A') }}</td>
                            <td>{{ englishToBanglaNumber($jobHistory->release_date ?? 'N/A') }}</td>
							<td>{{ $jobHistory->comment ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @endif
                <br>

                @if ($employeeList->employeepromotions->isNotEmpty())
                <strong> {{ trans('cruds.employeePromotion.title') }}</strong>



                <table class="table-bordered table-striped table" id="employeePromotion">
                    <thead>
                        <tr>
                            <th>ক্রমিক নং</th>
                            <th>{{ trans('cruds.employeePromotion.fields.new_designation') }}</th>
                            <th>গ্রেড</th>
                            <th>{{ trans('cruds.employeePromotion.fields.go_issue_date') }}</th>
                            <th>অফিস আদেশ/প্রজ্ঞাপন/স্মারক নাম্বার</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeList->employeepromotions ?? [] as $index => $employeePromotion)
                        <tr>
                            <td>{{ englishToBanglaNumber($index + 1) }}</td> <!-- Serial Number Column -->
                            <td>{{ $employeePromotion->new_designation->name_bn ?? 'N/A' }}</td>
                            <td>{{ $employeePromotion->grade->name_bn ?? 'N/A' }}</td>
                            <td>{{ englishToBanglaNumber($employeePromotion->go_issue_date ?? 'N/A') }}</td>
                            <td>{{ $employeePromotion->office_order_date ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @endif
                <br>

                @if ($employeeList->leaverecords->isNotEmpty())
                <strong> {{ trans('cruds.leaveRecord.title') }}</strong>

                <table class="table-bordered table-striped table" id="leaveRecord">
                    <thead>
                        <tr>
                            <th>ক্রমিক নং</th>
                            <th>{{ trans('cruds.leaveRecord.fields.leave_category') }}</th>
                            <th>{{ trans('cruds.leaveRecord.fields.type_of_leave') }}</th>
                            <th>{{ trans('cruds.professionale.fields.from_date') }}</th>
                            <th>{{ trans('cruds.professionale.fields.to_date') }}</th>
                            <th>ছুটির আদেশ নম্বর</th>
                            <th>ছুটির আদেশের তারিখ</th>
                            <th>মন্তব্য</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeList->leaverecords ?? [] as $index => $leaveRecord)
                        <tr>
                            <td>{{ englishToBanglaNumber($index + 1) }}</td> <!-- Serial Number Column -->
                            <td>{{ $leaveRecord->leave_category->name_bn ?? 'N/A' }}</td>
                            <td>{{ $leaveRecord->type_of_leave->name_bn ?? 'N/A' }}</td>
                            <td>{{ englishToBanglaNumber($leaveRecord->start_date ?? 'N/A') }}</td>
                            <td>{{ englishToBanglaNumber($leaveRecord->end_date ?? 'N/A') }}</td>
                            <td>{{ $leaveRecord->leave_orderumber ?? 'N/A' }}</td>
                            <td>{{ englishToBanglaNumber($leaveRecord->leave_order_date ?? 'N/A') }}</td>
                            <td>{!! $leaveRecord->reason ?? 'N/A' !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>



                @endif
                <br>

                @if ($employeeList->trainings->isNotEmpty())
                <strong>
                    {{ trans('cruds.training.title') }}
                </strong>

                <table class="table-bordered table-striped table" id="training">
                    <thead>
                        <tr>
                            <th>ক্রমিক নং</th>
                            {{--<th>{{ trans('cruds.training.fields.training_type') }}</th>--}}
                            <th>{{ trans('cruds.training.fields.training_name') }}</th>
                            <th>{{ trans('cruds.training.fields.institute_name') }}</th>
                            {{--<th>{{ trans('cruds.training.fields.country') }}</th>--}}
                            <th>{{ trans('cruds.training.fields.start_date') }}</th>
                            <th>{{ trans('cruds.training.fields.end_date') }}</th>
                            {{--<th>
                                @if (app()->getLocale() === 'bn')
                                লোকেশন
                                @else
                                Location
                                @endif
                            </th>--}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeList->trainings ?? [] as $index => $training)
                        <tr>
                            <td>{{ englishToBanglaNumber($index + 1) }}</td> <!-- Serial Number Column -->
                            {{--<td>{{ $training->training_type->{$columname} ?? 'N/A' }}</td>--}}
                            <td>{{ $training->training_name ?? 'N/A' }}</td>
                            <td>{{ $training->institute_name ?? 'N/A' }}</td>
                            {{--<td>{{ $training->country->{$columname} ?? 'N/A' }}</td>--}}
                            <td>{{ englishToBanglaNumber($training->start_date ?? 'N/A') }}</td>
                            <td>{{ englishToBanglaNumber($training->end_date ?? 'N/A') }}</td>
                            {{--<td>{{ $training->location ?? 'N/A' }}</td>--}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>



                @endif
                <br>

                @if ($employeeList->travelRecords->isNotEmpty())
                <strong id="travelRecords">{{ trans('cruds.travelRecord.title') }}</strong>


                <table class="table-bordered table-striped table">
                    <thead>
                        <tr>
                            <th>ক্রমিক নং</th>
                            <th>{{ trans('cruds.travelRecord.fields.purpose') }}</th>
                            <th>
                                @if (app()->getLocale() === 'bn')
                                টাইটেল
                                @else
                                Title
                                @endif
                            </th>
                            <th>{{ trans('cruds.travelRecord.fields.country') }}</th>
                            <th>{{ trans('cruds.professionale.fields.from_date') }}</th>
                            <th>{{ trans('cruds.professionale.fields.to_date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeList->travelRecords ?? [] as $index => $travelRecord)
                        <tr>
                            <td>{{ englishToBanglaNumber($index + 1) }}</td> <!-- Serial Number Column -->
                            <td>{{ $travelRecord->title->name_bn ?? 'N/A' }}</td>
                            <td>{{ $travelRecord->new_title ?? 'N/A' }}</td>
                            <td>{{ $travelRecord->country->name_bn ?? 'N/A' }}</td>
                            <td>{{ englishToBanglaNumber($travelRecord->start_date ?? 'N/A') }}</td>
                            <td>{{ englishToBanglaNumber($travelRecord->end_date ?? 'N/A') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>



                @endif
                <br>

                {{--@if ($employeeList->foreigntravelpersonals->isNotEmpty())
                <strong id="foreignTravelPersonal"> {{ trans('cruds.foreignTravelPersonal.title') }}</strong>

                <table class="table-bordered table-striped table">
                    <thead>
                        <tr>
                            <th>ক্রমিক নং</th>
                            <th>{{ trans('cruds.foreignTravelPersonal.fields.purpose') }}</th>
                            <th>{{ trans('cruds.foreignTravelPersonal.fields.country') }}</th>
                            <th>{{ trans('cruds.professionale.fields.from_date') }}</th>
                            <th>{{ trans('cruds.professionale.fields.to_date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeList->foreigntravelpersonals ?? [] as $index => $foreignTravelPersonal)
                        <tr>
                            <td>{{ englishToBanglaNumber($index + 1) }}</td> <!-- Serial Number Column -->
                            <td>{{ $foreignTravelPersonal->title->{$columname} ?? 'N/A' }}</td>
                            <td>{{ $foreignTravelPersonal->country->{$columname} ?? 'N/A' }}</td>
                            <td>{{ englishToBanglaNumber($foreignTravelPersonal->from_date ?? 'N/A') }}</td>
                            <td>{{ englishToBanglaNumber($foreignTravelPersonal->to_date ?? 'N/A') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>



                @endif
                <br>--}}

                @if ($employeeList->extracurriculams->isNotEmpty())
                <strong id="extracurriculam"> {{ trans('cruds.extracurriculam.title') }}</strong>

                <table class="table-bordered table-striped table">
                    <thead>
                        <tr>
                            <th>ক্রমিক নং</th>
                            <th>{{ trans('cruds.extracurriculam.fields.activity_name') }}</th>
                            <th>{{ trans('cruds.extracurriculam.fields.organization') }}</th>
                            <th>{{ trans('cruds.extracurriculam.fields.position') }}</th>
                            <th>{{ trans('cruds.extracurriculam.fields.start_date') }}</th>
                            <th>{{ trans('cruds.extracurriculam.fields.end_date') }}</th>
                            <th>{{ trans('cruds.extracurriculam.fields.description') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeList->extracurriculams ?? [] as $index => $extracurriculam)
                        <tr>
                            <td>{{ englishToBanglaNumber($index + 1) }}</td> <!-- Serial Number Column -->
                            <td>{{ $extracurriculam->activity_name ?? 'N/A' }}</td>
                            <td>{{ $extracurriculam->organization ?? 'N/A' }}</td>
                            <td>{{ $extracurriculam->position ?? 'N/A' }}</td>
                            <td>{{ englishToBanglaNumber($extracurriculam->start_date ?? 'N/A') }}</td>
                            <td>{{ englishToBanglaNumber($extracurriculam->end_date ?? 'N/A') }}</td>
                            <td>{!! $extracurriculam->description ?? 'N/A' !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


                @endif

                <br>

                @if ($employeeList->publications->isNotEmpty())
                <strong id="publication"> {{ trans('cruds.publication.title') }}</strong>


                <table class="table-bordered table-striped table">
                    <thead>
                        <tr>
                            <th>ক্রমিক নং</th>
                            <th>{{ trans('cruds.publication.fields.title') }}</th>
                            <th>{{ trans('cruds.publication.fields.publication_type') }}</th>
                            <th>{{ trans('cruds.publication.fields.publication_media') }}</th>
                            <th>{{ trans('cruds.publication.fields.publication_date') }}</th>
                            <th>{{ trans('cruds.publication.fields.publication_link') }}</th>
                            <th>{{ trans('cruds.publication.fields.description') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeList->publications ?? [] as $index => $publication)
                        <tr>
                            <td>{{ englishToBanglaNumber($index + 1) }}</td> <!-- Serial Number Column -->
                            <td>{{ $publication->title ?? 'N/A' }}</td>
                            <td>{{ App\Models\Publication::PUBLICATION_TYPE_SELECT[$publication->publication_type] ??
                                'N/A' }}</td>
                            <td>{{ $publication->publication_media ?? 'N/A' }}</td>
                            <td>{{ englishToBanglaNumber($publication->publication_date ?? 'N/A') }}</td>
                            <td>{{ $publication->publication_link ?? 'N/A' }}</td>
                            <td>{!! $publication->description ?? 'N/A' !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


                @endif
                <br>

                @if ($employeeList->awards->isNotEmpty())
                <strong id="awards"> {{ trans('cruds.award.title') }}</strong>


                <table class="table-bordered table-striped table">
                    <thead>
                        <tr>
                            <th>ক্রমিক নং</th>
                            <th>{{ trans('cruds.award.fields.title') }}</th>
                            <th>
                                @if (app()->getLocale() === 'bn')
                                পুরস্কার প্রদানকারী
                                @else
                                Awardee
                                @endif
                            </th>
                            <th>{{ trans('cruds.award.fields.ground_area') }}</th>
                            <th>সাল</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeList->awards ?? [] as $index => $award)
                        <tr>
                            <td>{{ englishToBanglaNumber($index + 1) }}</td> <!-- Serial Number Column -->
                            <td>{{ $award->title ?? 'N/A' }}</td>
                            <td>{{ $award->institution ?? 'N/A' }}</td>
                            <td>{{ $award->ground_area ?? 'N/A' }}</td>
                            <td>{{ englishToBanglaNumber($award->year ?? 'N/A') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


                @endif
                <br>

                @if ($employeeList->otherservicejobs->isNotEmpty())
                <strong id="otherservicejobs"> {{ trans('cruds.otherServiceJob.title') }}</strong>

                <table class="table-bordered table-striped table">
                    <thead>
                        <tr>
                            <th>ক্রমিক নং</th> <!-- Serial Number Header -->
                            <th>{{ trans('cruds.otherServiceJob.fields.employer') }}</th>
                            <th>{{ trans('cruds.otherServiceJob.fields.address') }}</th>
                            <th>{{ trans('cruds.otherServiceJob.fields.service_type') }}</th>
                            <th>{{ trans('cruds.otherServiceJob.fields.position') }}</th>
                            <th>{{ trans('cruds.otherServiceJob.fields.from') }}</th>
                            <th>{{ trans('cruds.otherServiceJob.fields.to') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeList->otherservicejobs ?? [] as $index => $otherServiceJob)
                        <tr>
                            <td>{{ englishToBanglaNumber($index + 1) }}</td> <!-- Serial Number Column -->
                            <td>{{ $otherServiceJob->employer ?? 'N/A' }}</td>
                            <td>{{ $otherServiceJob->address ?? 'N/A' }}</td>
                            <td>{{ $otherServiceJob->service_type ?? 'N/A' }}</td>
                            <td>{{ $otherServiceJob->position ?? 'N/A' }}</td>
                            <td>{{ englishToBanglaNumber($otherServiceJob->from ?? 'N/A') }}</td>
                            <td>{{ englishToBanglaNumber($otherServiceJob->to ?? 'N/A') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>



                @endif
                <br>

                @if ($employeeList->languages->isNotEmpty())
                <strong id="languages"> {{ trans('cruds.language.title') }}</strong>



                <table class="table-bordered table-striped table">
                    <thead>
                        <tr>
                            <th>ক্রমিক নং</th> <!-- Serial Number Header -->
                            <th>{{ trans('cruds.language.fields.language') }}</th>
                            <th>{{ trans('cruds.language.fields.read') }}</th>
                            <th>{{ trans('cruds.language.fields.write') }}</th>
                            <th>{{ trans('cruds.language.fields.speak') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeList->languages ?? [] as $index => $language)
                        <tr>
                            <td>{{ englishToBanglaNumber($index + 1) }}</td> <!-- Serial Number Column -->
                            <td>
                                @if (app()->getLocale() === 'bn')
                                {{ $language->language->name ?? 'N/A' }}
                                @else
                                {{ $language->language->name_en ?? 'N/A' }}
                                @endif
                            </td>
                            <td>
                                @if (app()->getLocale() === 'bn')
                                {{ $language->read->name ?? 'N/A' }}
                                @else
                                {{ $language->read->name_en ?? 'N/A' }}
                                @endif
                            </td>
                            <td>
                                @if (app()->getLocale() === 'bn')
                                {{ $language->write->name ?? 'N/A' }}
                                @else
                                {{ $language->write->name_en ?? 'N/A' }}
                                @endif
                            </td>
                            <td>
                                @if (app()->getLocale() === 'bn')
                                {{ $language->speak->name ?? 'N/A' }}
                                @else
                                {{ $language->speak->name_en ?? 'N/A' }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @endif
                <br>

                @if ($employeeList->criminalprosecutiones->isNotEmpty())
                <strong id="criminalProsecutione"> {{ trans('cruds.criminalProsecutione.title') }}</strong>


                <table class="table-bordered table-striped table">
                    <thead>
                        <tr>
                            <th>ক্রমিক নং</th>
                            <th>মামলার ধরণ</th>
                            <th>মামলার নম্বর ও তারিখ</th>
                            <th>মামলার বর্তমান অবস্থা</th>
                            <th>মামলা নিস্পত্তির আদেশ নম্বর ও তারিখ</th>
                            <th>মামলা নিস্পত্তির রায়</th>
                            <th>আপিলের আদেশ/নম্বর ও তারিখ</th>
                            <th>আপিলের রায়</th>
                            <th>{{ trans('cruds.criminalProsecutione.fields.remzrk') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeList->criminalprosecutiones ?? [] as $index => $criminalProsecutione)
                        <tr>
                            <td>{{ englishToBanglaNumber($index + 1) }}</td> <!-- Serial Number Column -->
                            <td>{{ $criminalProsecutione->mamla->name_bn ?? 'N/A' }}</td>
                            <td>{{ $criminalProsecutione->mamla_start ?? 'N/A' }}</td>
                            <td>{{ $criminalProsecutione->situation->name_bn ?? 'N/A' }}</td>
                            <td>{{ $criminalProsecutione->mamla_end ?? 'N/A' }}</td>
                            <td>{{ $criminalProsecutione->mamla_result ?? 'N/A' }}</td>
                            <td>{{ $criminalProsecutione->appeal_go ?? 'N/A' }}</td>
                            <td>{{ $criminalProsecutione->appeal_result ?? 'N/A' }}</td>
                            <td>{!! $criminalProsecutione->remzrk ?? 'N/A' !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


                @endif
				<br>


                {{--@if ($employeeList->criminalprodisciplinaries->isNotEmpty())
                <strong id="criminalproDisciplinary">
                    {{ trans('cruds.criminalproDisciplinary.title') }}</strong>
                @endif


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
                                {{ trans('cruds.criminalproDisciplinary.fields.remarks') }}
                                {{ trans('cruds.criminalproDisciplinary.fields.remarks') }}
                            </th>
                            <td>
                                {{ $criminalproDisciplinary->remarks ?? 'N/A' }}
                            </td>
                        </tr>

                    </tbody>
                </table><br />
                @endforeach--}}

                @if ($employeeList->acrmonitorings->isNotEmpty())
                <strong id="acrMonitoring">{{ trans('cruds.acrMonitoring.title') }}</strong>

                <table class="table-bordered table-striped table">
                    <thead>
                        <tr>
                            <th>ক্রমিক নং</th> <!-- Serial Number Header -->
                            <th>{{ trans('cruds.acrMonitoring.fields.year') }}</th>
                            <th>{{ trans('cruds.acrMonitoring.fields.remarks') }}</th>
                            <th>{{ trans('cruds.professionale.fields.from_date') }}</th>
                            <th>{{ trans('cruds.professionale.fields.to_date') }}</th>
                            <th>জমা দেওয়া হয়েছে?</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeList->acrmonitorings ?? [] as $index => $acrMonitoring)
                        <tr>
                            <td>{{ englishToBanglaNumber($index + 1) }}</td> <!-- Serial Number Column -->
                            <td>{{ englishToBanglaNumber($acrMonitoring->year ?? 'N/A') }}</td>
                            <td>{!! $acrMonitoring->remarks ?? 'N/A' !!}</td>
                            <td>{{ englishToBanglaNumber($acrMonitoring->fromdate ?? 'N/A') }}</td>
                            <td>{{ englishToBanglaNumber($acrMonitoring->todate ?? 'N/A') }}</td>
                            <td>
                                @if($acrMonitoring->issubmitted == 1)
                                হ্যাঁ
                                @else
                                না
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


                @endif
            </div>
        </div>
    </div>
    <htmlpagefooter name="page-footer">

        @if (app()->getLocale() === 'bn')
        পৃষ্ঠা নং: {PAGENO}
        @else
        Page No {PAGENO}
        @endif

        <br><br>
    </htmlpagefooter>
</body>

</html>