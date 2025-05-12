@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.spouseInformatione.title_singular') }}
        <br><strong class="text-dark classname">
            @if (app()->getLocale() === 'bn')
                {{ trans('cruds.employeeList.fields.fullname_bn') }}: {{ $timeScale->employee->fullname_bn }}
                &nbsp;
                {{ trans('cruds.employeeList.fields.employeeid') }}:{{ $timeScale->employee->employeeid }}
            @else
                {{ trans('cruds.employeeList.fields.fullname_en') }}: {{ $timeScale->employee->fullname_en }}
                &nbsp;
                {{ trans('cruds.employeeList.fields.employeeid') }}:{{ $timeScale->employee->employeeid }}
            @endif
        </strong>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.time-scale.update', [$timeScale->id]) }}"
            enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row row-cols-3">
                <x-hidden-input name="id" value="{{ $timeScale->id }}" />

                <div class="form-group">
                            <label for="type" class="required">
                                @if (app()->getLocale() === 'bn')
                                    ধরণ
                                @else
                                    Type
                                @endif
                            </label>
                            <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}"
                                name="type" id="type" required>
                                <option value="" disabled {{ old('type') === null ? 'selected' : '' }}>
                                    {{trans('global.pleaseSelect')}}
                                </option>
                                <option value="1" {{ $timeScale->type == '1' ? 'selected' : '' }}>
                                    @if (app()->getLocale() === 'bn')
                                        টাইম স্কেল
                                    @else
                                        Time Scale
                                    @endif
                                </option>
                                <option value="2" {{ $timeScale->type == '2' ? 'selected' : '' }}>
                                    @if (app()->getLocale() === 'bn')
                                        উচ্চতর গ্রেড
                                    @else
                                        Higher Grade

                                    @endif
                                </option>

                                <option value="3" {{ $timeScale->type == '3' ? 'selected' : '' }}>
                                    @if (app()->getLocale() === 'bn')
                                        বেতন সংরক্ষণ
                                    @else
                                        Salary Reservation

                                    @endif
                                </option>
                            </select>

                        </div>

                        <div class="form-group">
                            <label for="receipt_date">
                                @if (app()->getLocale() === 'bn')
                                প্রাপ্তির তারিখ
                                @else
                                Date of receipt
                                @endif
                            </label>
                            <input
                                class="form-control date {{ $errors->has('receipt_date') ? 'is-invalid' : '' }}"
                                type="text" name="receipt_date" id="receipt_date"
                                value="{{$timeScale->receipt_date}}">

                        </div>

                        <div class="form-group">
                            <label for="order_date">
                                @if (app()->getLocale() === 'bn')
                                অফিস আদেশ নম্বর ও তারিখ
                                @else
                                Office Order Number and Date
                                @endif
                            </label>
                            <input
                                class="form-control {{ $errors->has('receipt_date') ? 'is-invalid' : '' }}"
                                type="text" name="order_date" id="order_date"
                                value="{{$timeScale->order_date}}">

                        </div>

                        <div class="form-group">
                            <label for="office_order">
                                @if (app()->getLocale() === 'bn')
                                অফিস আদেশ আপলোড
                                @else
                                Office Order upload

                                @endif
                            </label>
                            <div class="needsclick dropzone {{ $errors->has('office_order') ? 'is-invalid' : '' }}"
                                id="office_order-dropzone">
                            </div>
                            @if ($errors->has('office_order'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('office_order') }}
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
@endsection

@section('scripts')
<script>
    Dropzone.options.officeOrderDropzone = {
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
            @if (isset($timeScale) && $timeScale->office_order)
                var file = {!! json_encode($timeScale->office_order) !!}
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
