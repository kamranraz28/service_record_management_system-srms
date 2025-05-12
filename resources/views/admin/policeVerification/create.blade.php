@extends('layouts.admin')

@section('content')
<div class="card p-2">
    <div class="container">
        <div class="row">
            @include('admin.commonemployee.commonmenu')
            <div class="col-md-8">
                <div class="tab-content my-1 border p-2" id="v-pills-tabContent">
                    <div class="text-center">
                        @if (app()->getLocale() === 'bn')
                            কর্মকর্তা/কর্মচারী আইডি : <b>{{ englishToBanglaNumber($employee['employeeid'] ?? 0) }}</b>
                        @else
                            Employee ID : <b>{{ $employee->employeeid }}</b>
                        @endif

                        <br>

                        @if (app()->getLocale() === 'bn')
                            কর্মকর্তা/কর্মচারী নাম : <b>{{ $employee->fullname_bn }}</b>
                        @else
                            Employee Name: <b>{{ $employee->fullname_en }}</b>
                        @endif
                    </div>
                    <hr>
                    <h4>
                        @if (app()->getLocale() === 'bn')
                            পুলিশ ভেরিফিকেশন
                        @else
                            Police Verification
                        @endif
                        <br>
                    </h4>
                    <form method="POST"
                        action="{{ route('admin.police-verification.store', ['employee_id' => request()->query('id')]) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">

                        <div class="form-group">
                            <label for="verification_type" class="required">
                                @if (app()->getLocale() === 'bn')
                                    পুলিশ ভেরিফিকেশন হয়েছে কিনা?
                                @else
                                    Police Verification Completed?
                                @endif
                            </label>
                            <select class="form-control {{ $errors->has('verification_type') ? 'is-invalid' : '' }}"
                                name="verification_type" id="verification_type" required>
                                <option value="" disabled {{ old('verification_type') === null ? 'selected' : '' }}>
                                    নির্বাচন করুন
                                </option>
                                <option value="1" {{ old('verification_type') === '1' ? 'selected' : '' }}>হ্যাঁ</option>
                                <option value="2" {{ old('verification_type') === '2' ? 'selected' : '' }}>না</option>
                            </select>
                            @if ($errors->has('verification_type'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('verification_type') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="applicant_form">
                                @if (app()->getLocale() === 'bn')
                                    প্রার্থী কর্তৃক পূরণীয় ফরম আপলোড
                                @else
                                    Applicant form upload

                                @endif
                            </label>
                            <div class="needsclick dropzone {{ $errors->has('applicant_form') ? 'is-invalid' : '' }}"
                                id="applicant_form-dropzone">
                            </div>
                            @if ($errors->has('applicant_form'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('applicant_form') }}
                                </div>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.spouseInformatione.fields.nid_upload_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label for="verified_form">
                                @if (app()->getLocale() === 'bn')
                                    ভেরিফাইড তথ্যাদি আপলোড (যা পুলিশ প্রেরণ করেছে)
                                @else
                                    Verified Information Sent by Police

                                @endif
                            </label>
                            <div class="needsclick dropzone {{ $errors->has('verified_form') ? 'is-invalid' : '' }}"
                                id="verified_form-dropzone">
                            </div>
                            @if ($errors->has('verified_form'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('verified_form') }}
                                </div>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.spouseInformatione.fields.nid_upload_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
    Dropzone.options.applicantFormDropzone = {
        url: '{{ route('admin.spouse-informationes.storeMedia') }}',
        maxFilesize: 2, // MB
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
            size: 2
        },
        success: function (file, response) {
            $('form').find('input[name="applicant_form"]').remove()
            $('form').append('<input type="hidden" name="applicant_form" value="' + response.name + '">')
        },
        removedfile: function (file) {
            file.previewElement.remove()
            if (file.status !== 'error') {
                $('form').find('input[name="applicant_form"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
            }
        },
        init: function () {
            @if (isset($spouseInformatione) && $spouseInformatione->nid_upload)
                var file = {!! json_encode($spouseInformatione->nid_upload) !!}
                this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="applicant_form" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
            @endif
        },
        error: function (file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends it's own error messages in string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }

            return _results
        }
    }
</script>


<script>
    Dropzone.options.verifiedFormDropzone = {
        url: '{{ route('admin.spouse-informationes.storeMedia') }}',
        maxFilesize: 2, // MB
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
            size: 2
        },
        success: function (file, response) {
            $('form').find('input[name="verified_form"]').remove()
            $('form').append('<input type="hidden" name="verified_form" value="' + response.name + '">')
        },
        removedfile: function (file) {
            file.previewElement.remove()
            if (file.status !== 'error') {
                $('form').find('input[name="verified_form"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
            }
        },
        init: function () {
            @if (isset($spouseInformatione) && $spouseInformatione->verified_form)
                var file = {!! json_encode($spouseInformatione->verified_form) !!}
                this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="verified_form" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
            @endif
        },
        error: function (file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends it's own error messages in string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }

            return _results
        }
    }
</script>

@endsection
