@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.child.title_singular') }}
            <br><strong class="text-dark classname">
                @if (app()->getLocale() === 'bn')
                    {{ trans('cruds.employeeList.fields.fullname_bn') }}:{{ $child->employee->fullname_bn }}
                    &nbsp;
                    {{ trans('cruds.employeeList.fields.employeeid') }}:{{ $child->employee->employeeid }}
                @else
                    {{ trans('cruds.employeeList.fields.fullname_en') }}:{{ $child->employee->fullname_en }}
                    &nbsp;
                    {{ trans('cruds.employeeList.fields.employeeid') }}:{{ $child->employee->employeeid }}
                @endif
            </strong>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.children.update', [$child->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row row-cols-3">
                    <x-hidden-input name="employee_id" value="{{ $child->employee->id }}" />

                    {{-- <div class="form-group">
                    <label for="employee_id">{{ trans('cruds.child.fields.employee') }}</label>
                    <select class="form-select select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id"
                        id="employee_id">
                        @foreach ($employees as $id => $entry)
                            <option value="{{ $id }}"
                                {{ (old('employee_id') ? old('employee_id') : $child->employee->id ?? '') == $id ? 'selected' : '' }}>
                                {{ $entry }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('employee'))
                        <div class="invalid-feedback">
                            {{ $errors->first('employee') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.child.fields.employee_helper') }}</span>
                </div> --}}
                    <div class="form-group">
                        <label class="required" for="name_bn">{{ trans('cruds.child.fields.name_bn') }}</label>
                        <input class="form-control {{ $errors->has('name_bn') ? 'is-invalid' : '' }}" type="text"
                            name="name_bn" id="name_bn" value="{{ old('name_bn', $child->name_bn) }}" required>
                        @if ($errors->has('name_bn'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name_bn') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.child.fields.name_bn_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="name_en">{{ trans('cruds.child.fields.name_en') }}</label>
                        <input class="form-control {{ $errors->has('name_en') ? 'is-invalid' : '' }}" type="text"
                            name="name_en" id="name_en" value="{{ old('name_en', $child->name_en) }}" required>
                        @if ($errors->has('name_en'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name_en') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.child.fields.name_en_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="date_of_birth">{{ trans('cruds.child.fields.date_of_birth') }}</label>
                        <input class="form-control date {{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}"
                            type="text" name="date_of_birth" id="date_of_birth"
                            value="{{ old('date_of_birth', $child->date_of_birth) }}">
                        @if ($errors->has('date_of_birth'))
                            <div class="invalid-feedback">
                                {{ $errors->first('date_of_birth') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.child.fields.date_of_birth_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="birth_certificate">{{ trans('cruds.child.fields.birth_certificate') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('birth_certificate') ? 'is-invalid' : '' }}"
                            id="birth_certificate-dropzone">
                        </div>
                        @if ($errors->has('birth_certificate'))
                            <div class="invalid-feedback">
                                {{ $errors->first('birth_certificate') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.child.fields.birth_certificate_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="complite_21">{{ trans('cruds.child.fields.complite_21') }}</label>
                        <input class="form-control {{ $errors->has('complite_21') ? 'is-invalid' : '' }}" type="text"
                            name="complite_21" id="complite_21" value="{{ old('complite_21', $child->complite_21) }}"
                            required>
                        @if ($errors->has('complite_21'))
                            <div class="invalid-feedback">
                                {{ $errors->first('complite_21') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.child.fields.complite_21_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="gender_id">{{ trans('cruds.child.fields.gender') }}</label>
                        <select class="form-select select2 {{ $errors->has('gender') ? 'is-invalid' : '' }}"
                            name="gender_id" id="gender_id" required>
                            @foreach ($genders as $id => $entry)
                                <option value="{{ $id }}"
                                    {{ (old('gender_id') ? old('gender_id') : $child->gender->id ?? '') == $id ? 'selected' : '' }}>
                                    {{ $entry }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('gender'))
                            <div class="invalid-feedback">
                                {{ $errors->first('gender') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.child.fields.gender_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="nid_number">{{ trans('cruds.child.fields.nid_number') }}</label>
                        <input class="form-control {{ $errors->has('nid_number') ? 'is-invalid' : '' }}" type="text"
                            name="nid_number" id="nid_number" value="{{ old('nid_number', $child->nid_number) }}">
                        @if ($errors->has('nid_number'))
                            <div class="invalid-feedback">
                                {{ $errors->first('nid_number') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.child.fields.nid_number_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="passport_number">{{ trans('cruds.child.fields.passport_number') }}</label>
                        <input class="form-control {{ $errors->has('passport_number') ? 'is-invalid' : '' }}"
                            type="text" name="passport_number" id="passport_number"
                            value="{{ old('passport_number', $child->passport_number) }}">
                        @if ($errors->has('passport_number'))
                            <div class="invalid-feedback">
                                {{ $errors->first('passport_number') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.child.fields.passport_number_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="childdren_nid">{{ trans('cruds.child.fields.childdren_nid') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('childdren_nid') ? 'is-invalid' : '' }}"
                            id="childdren_nid-dropzone">
                        </div>
                        @if ($errors->has('childdren_nid'))
                            <div class="invalid-feedback">
                                {{ $errors->first('childdren_nid') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.child.fields.childdren_nid_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="childdren_passporft">{{ trans('cruds.child.fields.childdren_passporft') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('childdren_passporft') ? 'is-invalid' : '' }}"
                            id="childdren_passporft-dropzone">
                        </div>
                        @if ($errors->has('childdren_passporft'))
                            <div class="invalid-feedback">
                                {{ $errors->first('childdren_passporft') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.child.fields.childdren_passporft_helper') }}</span>
                    </div>
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
        Dropzone.options.birthCertificateDropzone = {
            url: '{{ route('admin.children.storeMedia') }}',
            maxFilesize: 2, // MB
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2
            },
            success: function(file, response) {
                $('form').find('input[name="birth_certificate"]').remove()
                $('form').append('<input type="hidden" name="birth_certificate" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="birth_certificate"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($child) && $child->birth_certificate)
                    var file = {!! json_encode($child->birth_certificate) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="birth_certificate" value="' + file.file_name +
                        '">')
                    this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function(file, response) {
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
        Dropzone.options.childdrenNidDropzone = {
            url: '{{ route('admin.children.storeMedia') }}',
            maxFilesize: 2, // MB
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2
            },
            success: function(file, response) {
                $('form').find('input[name="childdren_nid"]').remove()
                $('form').append('<input type="hidden" name="childdren_nid" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="childdren_nid"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($child) && $child->childdren_nid)
                    var file = {!! json_encode($child->childdren_nid) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="childdren_nid" value="' + file.file_name + '">')
                    this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function(file, response) {
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
        Dropzone.options.childdrenPassporftDropzone = {
            url: '{{ route('admin.children.storeMedia') }}',
            maxFilesize: 2, // MB
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2
            },
            success: function(file, response) {
                $('form').find('input[name="childdren_passporft"]').remove()
                $('form').append('<input type="hidden" name="childdren_passporft" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="childdren_passporft"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($child) && $child->childdren_passporft)
                    var file = {!! json_encode($child->childdren_passporft) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="childdren_passporft" value="' + file.file_name +
                        '">')
                    this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function(file, response) {
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
