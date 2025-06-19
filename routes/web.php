<?php


use App\Http\Controllers\Admin\EmployeeListController;
use App\Http\Controllers\Admin\AddressdetaileController;

Route::get('/', function () {
    return view('auth.login');
})->name('home');

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);
Route::get('dfo', [EmployeeListController::class,'dfo'])->name('dfo');
Route::get('pending-change', [EmployeeListController::class,'pendingChange'])->name('pending-change');
Route::post('/admin/changes/approve-multiple', [EmployeeListController::class, 'approveMultiple'])->name('changeApproval');

Route::get('pending-review', [EmployeeListController::class,'pending_review'])->name('pending-review');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', '2fa']], function () {

    Route::get('add-employee', [EmployeeListController::class,'Commonemployeecreate'])->name('creatrmployee');
    Route::get('show-employee', [EmployeeListController::class,'commonemployeeshow'])->name('commonemployeeshow');
    Route::get('employee-data/{id}', [EmployeeListController::class,'employeedata'])->name('employeedata');
    Route::get('employee-pdf/{id}', [EmployeeListController::class,'employeedata_pdf'])->name('employeedata.pdf');
	Route::get('employee-delete/{id}', [EmployeeListController::class,'employeedata_delete'])->name('employeedata.delete');

    Route::post('search-retirement', [EmployeeListController::class,'search_retirement'])->name('search_retirement');
    Route::post('search-employee-transfer', [EmployeeListController::class,'search_employee_transfer'])->name('search_employee_transfer');
    Route::post('search-employee-by-name', [EmployeeListController::class,'search_employee_by_name'])->name('search_employee_by_name');

    Route::post('search-employee', [EmployeeListController::class,'search_employee'])->name('search_employee');
    Route::post('search-designation', [EmployeeListController::class,'search_designation'])->name('search_designation');
    Route::post('search-designation-three', [EmployeeListController::class,'search_designation_three'])->name('search_designation_three');

    Route::post('search-district-three', [EmployeeListController::class,'search_district_three'])->name('search_district_three');

    Route::get('upcoming_retirement_list', [EmployeeListController::class,'upcoming_retirement_list'])->name('upcoming_retirement_list');
	Route::get('entry_list', [EmployeeListController::class,'entry_list'])->name('entry_list');

    Route::get('transfer', [EmployeeListController::class,'transfer'])->name('transfer');
    Route::get('transfer-list', [EmployeeListController::class,'transferList'])->name('transferList');

    Route::get('exemption-list', [EmployeeListController::class,'exemptionList'])->name('exemptionList');

    Route::post('transfer_confirm/{id}', [EmployeeListController::class,'transferConfirm'])->name('transferConfirm');

    Route::post('exemption_confirm/{id}', [EmployeeListController::class,'exemption_confirm'])->name('exemption_confirm');

    Route::post('/approve', [EmployeeListController::class, 'approve'])->name('employee.approve');

	//Reports
	Route::get('office_wise_entry_report', [EmployeeListController::class,'office_wise_entry_report'])->name('office_wise_entry_report');
    Route::get('office_wise_entry_report_pdf', [EmployeeListController::class,'office_wise_entry_report_pdf'])->name('office_entry_report_pdf');

	Route::get('three_months_report', [EmployeeListController::class,'three_months_report'])->name('three_months_report');
	Route::get('three_months_report_download', [EmployeeListController::class,'downloadThreeMonthsReport'])->name('downloadThreeMonthsReport');
	Route::get('seniority_list_report', [EmployeeListController::class,'seniority_list_report'])->name('seniority_list_report');
	Route::get('seniority_list_report_download', [EmployeeListController::class,'seniority_list_report_download'])->name('seniority_list_report_download');
        Route::post('seniority_list_designation_report_download', [EmployeeListController::class, 'downloadSeniorityListDesignation'])->name('downloadSeniorityListDesignation');

	Route::get('three_months_report_filtering', [EmployeeListController::class,'three_months_report_designation'])->name('three_months_report_designation');
 Route::post('three_months_designation_report_download', [EmployeeListController::class, 'downloadThreeMonthsDesignation'])->name('downloadThreeMonthsDesignation');
    Route::post('three_months_district_report_download', [EmployeeListController::class, 'downloadThreeMonthsDistrict'])->name('downloadThreeMonthsDistrict');
    Route::post('three_months_quota_report_download', [EmployeeListController::class, 'downloadThreeMonthsQuota'])->name('downloadThreeMonthsQuota');
Route::post('three_months_circle_report_download', [EmployeeListController::class, 'downloadThreeMonthsCircle'])->name('downloadThreeMonthsCircle');
    Route::post('three_months_division_report_download', [EmployeeListController::class, 'downloadThreeMonthsDivision'])->name('downloadThreeMonthsDivision');
    Route::post('three_months_multiple_report_download', [EmployeeListController::class, 'downloadThreeMonthsMultiple'])->name('downloadThreeMonthsMultiple');
    Route::post('three_months_circle_office_report_download', [EmployeeListController::class, 'downloadThreeMonthsCircleOffice'])->name('downloadThreeMonthsCircleOffice');

   Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::resource('permissions', 'PermissionsController', ['except' => ['destroy']]);

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Divisions
    Route::delete('divisions/destroy', 'DivisionsController@massDestroy')->name('divisions.massDestroy');
    Route::post('divisions/parse-csv-import', 'DivisionsController@parseCsvImport')->name('divisions.parseCsvImport');
    Route::post('divisions/process-csv-import', 'DivisionsController@processCsvImport')->name('divisions.processCsvImport');
    Route::resource('divisions', 'DivisionsController');

    // District
    Route::delete('districts/destroy', 'DistrictController@massDestroy')->name('districts.massDestroy');
    Route::post('districts/parse-csv-import', 'DistrictController@parseCsvImport')->name('districts.parseCsvImport');
    Route::post('districts/process-csv-import', 'DistrictController@processCsvImport')->name('districts.processCsvImport');
    Route::resource('districts', 'DistrictController');

    // Maritalstatu
    Route::post('maritalstatuses/parse-csv-import', 'MaritalstatuController@parseCsvImport')->name('maritalstatuses.parseCsvImport');
    Route::post('maritalstatuses/process-csv-import', 'MaritalstatuController@processCsvImport')->name('maritalstatuses.processCsvImport');
    Route::resource('maritalstatuses', 'MaritalstatuController', ['except' => ['destroy']]);

    // Gender
    Route::delete('genders/destroy', 'GenderController@massDestroy')->name('genders.massDestroy');
    Route::post('genders/parse-csv-import', 'GenderController@parseCsvImport')->name('genders.parseCsvImport');
    Route::post('genders/process-csv-import', 'GenderController@processCsvImport')->name('genders.processCsvImport');
    Route::resource('genders', 'GenderController');

    // Religion
    Route::delete('religions/destroy', 'ReligionController@massDestroy')->name('religions.massDestroy');
    Route::post('religions/parse-csv-import', 'ReligionController@parseCsvImport')->name('religions.parseCsvImport');
    Route::post('religions/process-csv-import', 'ReligionController@processCsvImport')->name('religions.processCsvImport');
    Route::resource('religions', 'ReligionController');

    // Blood Group
    Route::delete('blood-groups/destroy', 'BloodGroupController@massDestroy')->name('blood-groups.massDestroy');
    Route::post('blood-groups/parse-csv-import', 'BloodGroupController@parseCsvImport')->name('blood-groups.parseCsvImport');
    Route::post('blood-groups/process-csv-import', 'BloodGroupController@processCsvImport')->name('blood-groups.processCsvImport');
    Route::resource('blood-groups', 'BloodGroupController');

    // Quota
    Route::delete('quota/destroy', 'QuotaController@massDestroy')->name('quota.massDestroy');
    Route::post('quota/parse-csv-import', 'QuotaController@parseCsvImport')->name('quota.parseCsvImport');
    Route::post('quota/process-csv-import', 'QuotaController@processCsvImport')->name('quota.processCsvImport');
    Route::resource('quota', 'QuotaController');

    // Examination
    Route::post('examinations/parse-csv-import', 'ExaminationController@parseCsvImport')->name('examinations.parseCsvImport');
    Route::post('examinations/process-csv-import', 'ExaminationController@processCsvImport')->name('examinations.processCsvImport');
    Route::resource('examinations', 'ExaminationController', ['except' => ['destroy']]);

    // Exam Board
    Route::delete('exam-boards/destroy', 'ExamBoardController@massDestroy')->name('exam-boards.massDestroy');
    Route::post('exam-boards/parse-csv-import', 'ExamBoardController@parseCsvImport')->name('exam-boards.parseCsvImport');
    Route::post('exam-boards/process-csv-import', 'ExamBoardController@processCsvImport')->name('exam-boards.processCsvImport');
    Route::resource('exam-boards', 'ExamBoardController');

    // Office Unit
    Route::delete('office-units/destroy', 'OfficeUnitController@massDestroy')->name('office-units.massDestroy');
    Route::post('office-units/parse-csv-import', 'OfficeUnitController@parseCsvImport')->name('office-units.parseCsvImport');
    Route::post('office-units/process-csv-import', 'OfficeUnitController@processCsvImport')->name('office-units.processCsvImport');
    Route::resource('office-units', 'OfficeUnitController');

    // Designation
    Route::delete('designations/destroy', 'DesignationController@massDestroy')->name('designations.massDestroy');
    Route::post('designations/parse-csv-import', 'DesignationController@parseCsvImport')->name('designations.parseCsvImport');
    Route::post('designations/process-csv-import', 'DesignationController@processCsvImport')->name('designations.processCsvImport');
    Route::resource('designations', 'DesignationController');

    // Leave Category
    Route::delete('leave-categories/destroy', 'LeaveCategoryController@massDestroy')->name('leave-categories.massDestroy');
    Route::post('leave-categories/parse-csv-import', 'LeaveCategoryController@parseCsvImport')->name('leave-categories.parseCsvImport');
    Route::post('leave-categories/process-csv-import', 'LeaveCategoryController@processCsvImport')->name('leave-categories.processCsvImport');
    Route::resource('leave-categories', 'LeaveCategoryController');

    // Leave Type
    Route::delete('leave-types/destroy', 'LeaveTypeController@massDestroy')->name('leave-types.massDestroy');
    Route::post('leave-types/parse-csv-import', 'LeaveTypeController@parseCsvImport')->name('leave-types.parseCsvImport');
    Route::post('leave-types/process-csv-import', 'LeaveTypeController@processCsvImport')->name('leave-types.processCsvImport');
    Route::resource('leave-types', 'LeaveTypeController');

    // Training Type
    Route::delete('training-types/destroy', 'TrainingTypeController@massDestroy')->name('training-types.massDestroy');
    Route::resource('training-types', 'TrainingTypeController');

    // Countrie
    Route::delete('countries/destroy', 'CountrieController@massDestroy')->name('countries.massDestroy');
    Route::post('countries/parse-csv-import', 'CountrieController@parseCsvImport')->name('countries.parseCsvImport');
    Route::post('countries/process-csv-import', 'CountrieController@processCsvImport')->name('countries.processCsvImport');
    Route::resource('countries', 'CountrieController');

    // Travel Purpose
    Route::delete('travel-purposes/destroy', 'TravelPurposeController@massDestroy')->name('travel-purposes.massDestroy');
    Route::post('travel-purposes/media', 'TravelPurposeController@storeMedia')->name('travel-purposes.storeMedia');
    Route::post('travel-purposes/ckmedia', 'TravelPurposeController@storeCKEditorImages')->name('travel-purposes.storeCKEditorImages');
    Route::post('travel-purposes/parse-csv-import', 'TravelPurposeController@parseCsvImport')->name('travel-purposes.parseCsvImport');
    Route::post('travel-purposes/process-csv-import', 'TravelPurposeController@processCsvImport')->name('travel-purposes.processCsvImport');
    Route::resource('travel-purposes', 'TravelPurposeController');

    // Employee List
	Route::get('admin/addressdetailes/waiting-list', [EmployeeListController::class, 'waitingList'])->name('employee-lists.waitingList');
    Route::delete('employee-lists/destroy', 'EmployeeListController@massDestroy')->name('employee-lists.massDestroy');
    Route::post('employee-lists/media', 'EmployeeListController@storeMedia')->name('employee-lists.storeMedia');
    Route::post('employee-lists/ckmedia', 'EmployeeListController@storeCKEditorImages')->name('employee-lists.storeCKEditorImages');
    Route::resource('employee-lists', 'EmployeeListController');

    // License Type
    Route::delete('license-types/destroy', 'LicenseTypeController@massDestroy')->name('license-types.massDestroy');
    Route::post('license-types/parse-csv-import', 'LicenseTypeController@parseCsvImport')->name('license-types.parseCsvImport');
    Route::post('license-types/process-csv-import', 'LicenseTypeController@processCsvImport')->name('license-types.processCsvImport');
    Route::resource('license-types', 'LicenseTypeController');

    // Job Type
    Route::delete('job-types/destroy', 'JobTypeController@massDestroy')->name('job-types.massDestroy');
    Route::resource('job-types', 'JobTypeController');

    // Grade
    Route::delete('grades/destroy', 'GradeController@massDestroy')->name('grades.massDestroy');
    Route::resource('grades', 'GradeController');

    // Education Informatione
    Route::delete('education-informationes/destroy', 'EducationInformationeController@massDestroy')->name('education-informationes.massDestroy');
    Route::post('education-informationes/media', 'EducationInformationeController@storeMedia')->name('education-informationes.storeMedia');
    Route::post('education-informationes/ckmedia', 'EducationInformationeController@storeCKEditorImages')->name('education-informationes.storeCKEditorImages');
    Route::resource('education-informationes', 'EducationInformationeController');

    // Professionale
    Route::delete('professionales/destroy', 'ProfessionaleController@massDestroy')->name('professionales.massDestroy');
    Route::post('professionales/parse-csv-import', 'ProfessionaleController@parseCsvImport')->name('professionales.parseCsvImport');
    Route::post('professionales/process-csv-import', 'ProfessionaleController@processCsvImport')->name('professionales.processCsvImport');
    Route::resource('professionales', 'ProfessionaleController');

    // Addressdetaile
Route::get('admin/addressdetailes/present-address', [AddressdetaileController::class, 'presentAddress'])->name('address.presentAddress');
    Route::post('admin/addressdetailes/present-address_store', [AddressdetaileController::class, 'presentAddressStore'])->name('address.presentAddressStore');


    Route::get('admin/addressdetailes/permanent-address', [AddressdetaileController::class, 'permanentAddress'])->name('address.permanentAddress');
    Route::post('admin/addressdetailes/permanent-address_store', [AddressdetaileController::class, 'permanentAddressStore'])->name('address.permanentAddressStore');
    Route::delete('addressdetailes/destroy', 'AddressdetaileController@massDestroy')->name('addressdetailes.massDestroy');
    Route::post('addressdetailes/parse-csv-import', 'AddressdetaileController@parseCsvImport')->name('addressdetailes.parseCsvImport');
    Route::post('addressdetailes/process-csv-import', 'AddressdetaileController@processCsvImport')->name('addressdetailes.processCsvImport');
    Route::resource('addressdetailes', 'AddressdetaileController');

    // Upazila
    Route::delete('upazilas/destroy', 'UpazilaController@massDestroy')->name('upazilas.massDestroy');
    Route::post('upazilas/parse-csv-import', 'UpazilaController@parseCsvImport')->name('upazilas.parseCsvImport');
    Route::post('upazilas/process-csv-import', 'UpazilaController@processCsvImport')->name('upazilas.processCsvImport');
    Route::resource('upazilas', 'UpazilaController');

    // Emergence Contacte
    Route::delete('emergence-contactes/destroy', 'EmergenceContacteController@massDestroy')->name('emergence-contactes.massDestroy');
    Route::resource('emergence-contactes', 'EmergenceContacteController');

    // Spouse Informatione
    Route::delete('spouse-informationes/destroy', 'SpouseInformationeController@massDestroy')->name('spouse-informationes.massDestroy');
    Route::post('spouse-informationes/media', 'SpouseInformationeController@storeMedia')->name('spouse-informationes.storeMedia');
    Route::post('spouse-informationes/ckmedia', 'SpouseInformationeController@storeCKEditorImages')->name('spouse-informationes.storeCKEditorImages');
    Route::resource('spouse-informationes', 'SpouseInformationeController');

    // Child
    Route::delete('children/destroy', 'ChildController@massDestroy')->name('children.massDestroy');
    Route::post('children/media', 'ChildController@storeMedia')->name('children.storeMedia');
    Route::post('children/ckmedia', 'ChildController@storeCKEditorImages')->name('children.storeCKEditorImages');
    Route::resource('children', 'ChildController');

    // Job Historie
    Route::delete('job-histories/destroy', 'JobHistorieController@massDestroy')->name('job-histories.massDestroy');
    Route::post('job-histories/media', 'JobHistorieController@storeMedia')->name('job-histories.storeMedia');
    Route::post('job-histories/ckmedia', 'JobHistorieController@storeCKEditorImages')->name('job-histories.storeCKEditorImages');
    Route::post('job-histories/parse-csv-import', 'JobHistorieController@parseCsvImport')->name('job-histories.parseCsvImport');
    Route::post('job-histories/process-csv-import', 'JobHistorieController@processCsvImport')->name('job-histories.processCsvImport');
    Route::resource('job-histories', 'JobHistorieController');

    // Employee Promotion
    Route::delete('employee-promotions/destroy', 'EmployeePromotionController@massDestroy')->name('employee-promotions.massDestroy');
    Route::post('employee-promotions/media', 'EmployeePromotionController@storeMedia')->name('employee-promotions.storeMedia');
    Route::post('employee-promotions/ckmedia', 'EmployeePromotionController@storeCKEditorImages')->name('employee-promotions.storeCKEditorImages');
    Route::post('employee-promotions/parse-csv-import', 'EmployeePromotionController@parseCsvImport')->name('employee-promotions.parseCsvImport');
    Route::post('employee-promotions/process-csv-import', 'EmployeePromotionController@processCsvImport')->name('employee-promotions.processCsvImport');
    Route::resource('employee-promotions', 'EmployeePromotionController');

    // Leave Record
    Route::delete('leave-records/destroy', 'LeaveRecordController@massDestroy')->name('leave-records.massDestroy');
    Route::post('leave-records/media', 'LeaveRecordController@storeMedia')->name('leave-records.storeMedia');
    Route::post('leave-records/ckmedia', 'LeaveRecordController@storeCKEditorImages')->name('leave-records.storeCKEditorImages');
    Route::post('leave-records/parse-csv-import', 'LeaveRecordController@parseCsvImport')->name('leave-records.parseCsvImport');
    Route::post('leave-records/process-csv-import', 'LeaveRecordController@processCsvImport')->name('leave-records.processCsvImport');
    Route::resource('leave-records', 'LeaveRecordController');

       // Training
       Route::delete('trainings/destroy', 'TrainingController@massDestroy')->name('trainings.massDestroy');
       Route::post('trainings/media', 'TrainingController@storeMedia')->name('trainings.storeMedia');
       Route::post('trainings/ckmedia', 'TrainingController@storeCKEditorImages')->name('trainings.storeCKEditorImages');
       Route::resource('trainings', 'TrainingController');

    // Traveltype
    Route::delete('traveltypes/destroy', 'TraveltypeController@massDestroy')->name('traveltypes.massDestroy');
    Route::post('traveltypes/parse-csv-import', 'TraveltypeController@parseCsvImport')->name('traveltypes.parseCsvImport');
    Route::post('traveltypes/process-csv-import', 'TraveltypeController@processCsvImport')->name('traveltypes.processCsvImport');
    Route::resource('traveltypes', 'TraveltypeController');

    // Travel Record
    Route::delete('travel-records/destroy', 'TravelRecordController@massDestroy')->name('travel-records.massDestroy');
    Route::resource('travel-records', 'TravelRecordController');

    // Extracurriculam
    Route::delete('extracurriculams/destroy', 'ExtracurriculamController@massDestroy')->name('extracurriculams.massDestroy');
    Route::post('extracurriculams/media', 'ExtracurriculamController@storeMedia')->name('extracurriculams.storeMedia');
    Route::post('extracurriculams/ckmedia', 'ExtracurriculamController@storeCKEditorImages')->name('extracurriculams.storeCKEditorImages');
    Route::resource('extracurriculams', 'ExtracurriculamController');

    // Publication
    Route::delete('publications/destroy', 'PublicationController@massDestroy')->name('publications.massDestroy');
    Route::post('publications/media', 'PublicationController@storeMedia')->name('publications.storeMedia');
    Route::post('publications/ckmedia', 'PublicationController@storeCKEditorImages')->name('publications.storeCKEditorImages');
    Route::resource('publications', 'PublicationController');

    // Language
    Route::delete('languages/destroy', 'LanguageController@massDestroy')->name('languages.massDestroy');
    Route::resource('languages', 'LanguageController');

    // Criminal Prosecutione
    Route::delete('criminal-prosecutiones/destroy', 'CriminalProsecutioneController@massDestroy')->name('criminal-prosecutiones.massDestroy');
    Route::post('criminal-prosecutiones/media', 'CriminalProsecutioneController@storeMedia')->name('criminal-prosecutiones.storeMedia');
    Route::post('criminal-prosecutiones/ckmedia', 'CriminalProsecutioneController@storeCKEditorImages')->name('criminal-prosecutiones.storeCKEditorImages');
    Route::resource('criminal-prosecutiones', 'CriminalProsecutioneController');

    // Criminalpro Disciplinary
    Route::delete('criminalpro-disciplinaries/destroy', 'CriminalproDisciplinaryController@massDestroy')->name('criminalpro-disciplinaries.massDestroy');
    Route::post('criminalpro-disciplinaries/media', 'CriminalproDisciplinaryController@storeMedia')->name('criminalpro-disciplinaries.storeMedia');
    Route::post('criminalpro-disciplinaries/ckmedia', 'CriminalproDisciplinaryController@storeCKEditorImages')->name('criminalpro-disciplinaries.storeCKEditorImages');
    Route::resource('criminalpro-disciplinaries', 'CriminalproDisciplinaryController');

    // Acr Monitoring
    Route::delete('acr-monitorings/destroy', 'AcrMonitoringController@massDestroy')->name('acr-monitorings.massDestroy');
    Route::post('acr-monitorings/media', 'AcrMonitoringController@storeMedia')->name('acr-monitorings.storeMedia');
    Route::post('acr-monitorings/ckmedia', 'AcrMonitoringController@storeCKEditorImages')->name('acr-monitorings.storeCKEditorImages');
    Route::resource('acr-monitorings', 'AcrMonitoringController');

	// Time Scale
    Route::delete('time-scale/destroy', 'TimeScaleController@massDestroy')->name('time-scale.massDestroy');
    Route::post('time-scale/media', 'TimeScaleController@storeMedia')->name('time-scale.storeMedia');
    Route::post('time-scale/ckmedia', 'TimeScaleController@storeCKEditorImages')->name('time-scale.storeCKEditorImages');
    Route::resource('time-scale', 'TimeScaleController');

    // Other
    Route::delete('other/destroy', 'OtherController@massDestroy')->name('other.massDestroy');
    Route::post('other/media', 'OtherController@storeMedia')->name('other.storeMedia');
    Route::post('other/ckmedia', 'OtherController@storeCKEditorImages')->name('other.storeCKEditorImages');
    Route::resource('other', 'OtherController');

Route::delete('police-verification/destroy', 'PoliceVerificationController@massDestroy')->name('police-verification.massDestroy');
    Route::post('police-verification/media', 'PoliceVerificationController@storeMedia')->name('police-verification.storeMedia');
    Route::post('police-verification/ckmedia', 'PoliceVerificationController@storeCKEditorImages')->name('police-verification.storeCKEditorImages');
    Route::resource('police-verification', 'PoliceVerificationController');
    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Faq Category
    Route::delete('faq-categories/destroy', 'FaqCategoryController@massDestroy')->name('faq-categories.massDestroy');
    Route::resource('faq-categories', 'FaqCategoryController');

    // Faq Question
    Route::delete('faq-questions/destroy', 'FaqQuestionController@massDestroy')->name('faq-questions.massDestroy');
    Route::resource('faq-questions', 'FaqQuestionController');

    // Site Setting
    Route::delete('site-settings/destroy', 'SiteSettingController@massDestroy')->name('site-settings.massDestroy');
    Route::post('site-settings/media', 'SiteSettingController@storeMedia')->name('site-settings.storeMedia');
    Route::post('site-settings/ckmedia', 'SiteSettingController@storeCKEditorImages')->name('site-settings.storeCKEditorImages');
    Route::resource('site-settings', 'SiteSettingController');

    // Batch
    Route::delete('batches/destroy', 'BatchController@massDestroy')->name('batches.massDestroy');
    Route::post('batches/parse-csv-import', 'BatchController@parseCsvImport')->name('batches.parseCsvImport');
    Route::post('batches/process-csv-import', 'BatchController@processCsvImport')->name('batches.processCsvImport');
    Route::resource('batches', 'BatchController');

    // Joininginfo
    Route::delete('joininginfos/destroy', 'JoininginfoController@massDestroy')->name('joininginfos.massDestroy');
    Route::resource('joininginfos', 'JoininginfoController');

    // Project Revenuelone
    Route::delete('project-revenuelones/destroy', 'ProjectRevenueloneController@massDestroy')->name('project-revenuelones.massDestroy');
    Route::resource('project-revenuelones', 'ProjectRevenueloneController');

    // Project Revenue Exam
    Route::post('project-revenue-exams/media', 'ProjectRevenueExamController@storeMedia')->name('project-revenue-exams.storeMedia');
    Route::post('project-revenue-exams/ckmedia', 'ProjectRevenueExamController@storeCKEditorImages')->name('project-revenue-exams.storeCKEditorImages');
    Route::resource('project-revenue-exams', 'ProjectRevenueExamController', ['except' => ['destroy']]);

    // Service Particulars
    Route::delete('service-particulars/destroy', 'ServiceParticularsController@massDestroy')->name('service-particulars.massDestroy');
    Route::resource('service-particulars', 'ServiceParticularsController');

    // Foreign Travel Personal
    Route::delete('foreign-travel-personals/destroy', 'ForeignTravelPersonalController@massDestroy')->name('foreign-travel-personals.massDestroy');
    Route::post('foreign-travel-personals/media', 'ForeignTravelPersonalController@storeMedia')->name('foreign-travel-personals.storeMedia');
    Route::post('foreign-travel-personals/ckmedia', 'ForeignTravelPersonalController@storeCKEditorImages')->name('foreign-travel-personals.storeCKEditorImages');
    Route::resource('foreign-travel-personals', 'ForeignTravelPersonalController');

    // Social Ass Pr Attachment
    Route::resource('social-ass-pr-attachments', 'SocialAssPrAttachmentController', ['except' => ['destroy']]);

    // Awards
    Route::delete('awards/destroy', 'AwardsController@massDestroy')->name('awards.massDestroy');
    Route::post('awards/media', 'AwardsController@storeMedia')->name('awards.storeMedia');
    Route::post('awards/ckmedia', 'AwardsController@storeCKEditorImages')->name('awards.storeCKEditorImages');
    Route::resource('awards', 'AwardsController');

    // Other Service Job
    Route::delete('other-service-jobs/destroy', 'OtherServiceJobController@massDestroy')->name('other-service-jobs.massDestroy');
    Route::resource('other-service-jobs', 'OtherServiceJobController');

    // Language Proficiency
    Route::delete('language-proficiencies/destroy', 'LanguageProficiencyController@massDestroy')->name('language-proficiencies.massDestroy');
    Route::resource('language-proficiencies', 'LanguageProficiencyController');

    // Language List
    Route::delete('language-lists/destroy', 'LanguageListController@massDestroy')->name('language-lists.massDestroy');
    Route::post('language-lists/parse-csv-import', 'LanguageListController@parseCsvImport')->name('language-lists.parseCsvImport');
    Route::post('language-lists/process-csv-import', 'LanguageListController@processCsvImport')->name('language-lists.processCsvImport');
    Route::resource('language-lists', 'LanguageListController');

    // Status
    Route::delete('statuses/destroy', 'StatusController@massDestroy')->name('statuses.massDestroy');
    Route::resource('statuses', 'StatusController');

    // Year
    Route::delete('years/destroy', 'YearController@massDestroy')->name('years.massDestroy');
    Route::resource('years', 'YearController');

    // Freedom Fighte Relation
    Route::delete('freedom-fighte-relations/destroy', 'FreedomFighteRelationController@massDestroy')->name('freedom-fighte-relations.massDestroy');
    Route::resource('freedom-fighte-relations', 'FreedomFighteRelationController');

    // Achievementschools Universities
    Route::delete('achievementschools-universities/destroy', 'AchievementschoolsUniversitiesController@massDestroy')->name('achievementschools-universities.massDestroy');
    Route::resource('achievementschools-universities', 'AchievementschoolsUniversitiesController');

    // Project
    Route::delete('projects/destroy', 'ProjectController@massDestroy')->name('projects.massDestroy');
    Route::post('projects/parse-csv-import', 'ProjectController@parseCsvImport')->name('projects.parseCsvImport');
    Route::post('projects/process-csv-import', 'ProjectController@processCsvImport')->name('projects.processCsvImport');
    Route::resource('projects', 'ProjectController');

        // Forest States
        Route::delete('forest-states/destroy', 'ForestStatesController@massDestroy')->name('forest-states.massDestroy');
        Route::post('forest-states/parse-csv-import', 'ForestStatesController@parseCsvImport')->name('forest-states.parseCsvImport');
        Route::post('forest-states/process-csv-import', 'ForestStatesController@processCsvImport')->name('forest-states.processCsvImport');
        Route::resource('forest-states', 'ForestStatesController');

        // Forest Ranges
        Route::delete('forest-ranges/destroy', 'ForestRangesController@massDestroy')->name('forest-ranges.massDestroy');
        Route::resource('forest-ranges', 'ForestRangesController');

        // Forest Beats
        Route::delete('forest-beats/destroy', 'ForestBeatsController@massDestroy')->name('forest-beats.massDestroy');
        Route::resource('forest-beats', 'ForestBeatsController');

        // Forest Divisions
        Route::delete('forest-divisions/destroy', 'ForestDivisionsController@massDestroy')->name('forest-divisions.massDestroy');
        Route::resource('forest-divisions', 'ForestDivisionsController');

        // Exam Degree
        Route::delete('exam-degrees/destroy', 'ExamDegreeController@massDestroy')->name('exam-degrees.massDestroy');
        Route::resource('exam-degrees', 'ExamDegreeController');

        // Result Group
        Route::delete('result-groups/destroy', 'ResultGroupController@massDestroy')->name('result-groups.massDestroy');
        Route::resource('result-groups', 'ResultGroupController');

        // Result
        Route::delete('results/destroy', 'ResultController@massDestroy')->name('results.massDestroy');
        Route::resource('results', 'ResultController');

         // Criminal Prosecution Derails
    Route::delete('criminal-prosecution-derails/destroy', 'CriminalProsecutionDerailsController@massDestroy')->name('criminal-prosecution-derails.massDestroy');
    Route::resource('criminal-prosecution-derails', 'CriminalProsecutionDerailsController');

    // Diciplinary Action
    Route::delete('diciplinary-actions/destroy', 'DiciplinaryActionController@massDestroy')->name('diciplinary-actions.massDestroy');
    Route::resource('diciplinary-actions', 'DiciplinaryActionController');


    // Travel Title
    Route::delete('travel-titles/destroy', 'TravelTitleController@massDestroy')->name('travel-titles.massDestroy');
    Route::resource('travel-titles', 'TravelTitleController');

    });
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
        Route::post('profile/two-factor', 'ChangePasswordController@toggleTwoFactor')->name('password.toggleTwoFactor');
    }
});
Route::group(['namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Two Factor Authentication
    if (file_exists(app_path('Http/Controllers/Auth/TwoFactorController.php'))) {
        Route::get('two-factor', 'TwoFactorController@show')->name('twoFactor.show');
        Route::post('two-factor', 'TwoFactorController@check')->name('twoFactor.check');
        Route::get('two-factor/resend', 'TwoFactorController@resend')->name('twoFactor.resend');
    }
});


Route::get('/user-approve/{id}', [EmployeeListController::class, 'approve'])->name('user.approve');
Route::get('/user-send/{id}', [EmployeeListController::class, 'send'])->name('user.send');
Route::get('/user-send-back/{id}', [EmployeeListController::class, 'send_back'])->name('user.send_back');

Route::get('/final-approve/{id}', [EmployeeListController::class, 'final_approve'])->name('final_approve');
Route::get('/exemption-cancel/{id}', [EmployeeListController::class, 'exemption_cancel'])->name('exemption_cancel');


