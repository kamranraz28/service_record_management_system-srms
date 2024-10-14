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
                    <h4>{{ trans('cruds.employeePromotion.title_singular') }}</h4>
                    <br>
                    <form method="POST"
                        action="{{ route('admin.employee-promotions.store', ['employee_id' => request()->query('id')]) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row row-cols-2">

                            <div class="form-group">
                                <label class="required"
                                    for="new_designation_id">{{ trans('cruds.employeePromotion.fields.new_designation') }}</label>
                                <select
                                    class="form-control select2 {{ $errors->has('new_designation') ? 'is-invalid' : '' }}"
                                    name="new_designation_id" id="new_designation_id" required>
                                    @foreach ($new_designations as $id => $entry)
                                        <option value="{{ $id }}" {{ old('new_designation_id') == $id ? 'selected' : '' }}>
                                            {{ $entry }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('new_designation'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('new_designation') }}
                                    </div>
                                @endif
                                <span
                                    class="help-block">{{ trans('cruds.employeePromotion.fields.new_designation_helper') }}</span>
                            </div>
							
							<div class="form-group">
                                <label for="grade_id">{{ trans('cruds.jobHistory.fields.grade') }}</label>
                                <select class="form-select select2 {{ $errors->has('grade') ? 'is-invalid' : '' }}"
                                    name="grade_id" id="grade_id">
                                    @foreach ($grades as $id => $entry)
                                        <option value="{{ $id }}"
                                            {{ old('grade_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('grade'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('grade') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.jobHistory.fields.grade_helper') }}</span>
                            </div>
							
                            <div class="form-group">
                                <label
                                    for="go_issue_date">{{ trans('cruds.employeePromotion.fields.go_issue_date') }}</label>
                                <input class="form-control date {{ $errors->has('go_issue_date') ? 'is-invalid' : '' }}"
                                    type="text" name="go_issue_date" id="go_issue_date"
                                    value="{{ old('go_issue_date') }}">
                                @if ($errors->has('go_issue_date'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('go_issue_date') }}
                                    </div>
                                @endif
                                <span
                                    class="help-block">{{ trans('cruds.employeePromotion.fields.go_issue_date_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label
                                    for="office_order_date">{{ trans('cruds.employeePromotion.fields.office_order_number') }}</label>
                                <input class="form-control {{ $errors->has('office_order_date') ? 'is-invalid' : '' }}"
                                    type="text" name="office_order_date" id="office_order_date"
                                    value="{{ old('office_order_date') }}" >
                                @if ($errors->has('office_order_date'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('office_order_date') }}
                                    </div>
                                @endif
                                <span
                                    class="help-block">{{ trans('cruds.employeePromotion.fields.office_order_number_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label
                                    for="office_order">{{ trans('cruds.employeePromotion.fields.office_order') }}</label>
                                <div class="needsclick dropzone {{ $errors->has('office_order') ? 'is-invalid' : '' }}"
                                    id="office_order-dropzone">
                                </div>
                                @if ($errors->has('office_order'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('office_order') }}
                                    </div>
                                @endif
                                <span
                                    class="help-block">{{ trans('cruds.employeePromotion.fields.office_order_helper') }}</span>
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
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    Dropzone.options.officeOrderDropzone = {
        url: '{{ route('admin.employee-promotions.storeMedia') }}',
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
            $('form').find('input[name="office_order"]').remove()
            $('form').append('<input type="hidden" name="office_order" value="' + response.name + '">')
        },
        removedfile: function (file) {
            file.previewElement.remove()
            if (file.status !== 'error') {
                $('form').find('input[name="office_order"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
            }
        },
        init: function () {
            @if (isset($employeePromotion) && $employeePromotion->office_order)
                var file = {!! json_encode($employeePromotion->office_order) !!}
                this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="office_order" value="' + file.file_name + '">')
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