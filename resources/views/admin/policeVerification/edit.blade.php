@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.spouseInformatione.title_singular') }}
        <br><strong class="text-dark classname">
            @if (app()->getLocale() === 'bn')
                {{ trans('cruds.employeeList.fields.fullname_bn') }}: {{ $policeVerification->employee->fullname_bn }}
                &nbsp;
                {{ trans('cruds.employeeList.fields.employeeid') }}:{{ $policeVerification->employee->employeeid }}
            @else
                {{ trans('cruds.employeeList.fields.fullname_en') }}: {{ $policeVerification->employee->fullname_en }}
                &nbsp;
                {{ trans('cruds.employeeList.fields.employeeid') }}:{{ $policeVerification->employee->employeeid }}
            @endif
        </strong>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.police-verification.update', [$policeVerification->id]) }}"
            enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row row-cols-3">
                <x-hidden-input name="id" value="{{ $policeVerification->id }}" />

                <div class="form-group">
                    <label for="verification_type" class="required">
                        @if (app()->getLocale() === 'bn')
                            পুলিশ ভেরিফিকেশন হয়েছে কিনা?
                        @else
                            Police Verification Completed?
                        @endif
                    </label>
                    <select class="form-control {{ $errors->has('verification_type') ? 'is-invalid' : '' }}"
                            name="verification_type"
                            id="verification_type"
                            required>
                        <option value="">{{trans('global.pleaseSelect')}}</option>
                        <option value="1" {{ $policeVerification->verification_type == '1' ? 'selected' : '' }}>হ্যাঁ</option>
                        <option value="2" {{ $policeVerification->verification_type == '2' ? 'selected' : '' }}>না</option>
                    </select>

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
                    <span class="help-block">{{ trans('cruds.employeeList.fields.nid_upload_helper') }}</span>
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
                    <span class="help-block">{{ trans('cruds.employeeList.fields.nid_upload_helper') }}</span>
                </div>





                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
        </form>
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
            @if (isset($policeVerification) && $policeVerification->applicant_form)
                var file = {!! json_encode($policeVerification->applicant_form) !!}
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
            @if (isset($policeVerification) && $policeVerification->verified_form)
                var file = {!! json_encode($policeVerification->verified_form) !!}
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
