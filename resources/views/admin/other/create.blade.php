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
                অন্যান্য
                @else
            Others
                
                @endif
                        <br>
                    </h4>
                    <form method="POST"
                        action="{{ route('admin.other.store', ['employee_id' => request()->query('id')]) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">

                        <div class="form-group">
                            <label for="health_paper">
                                @if (app()->getLocale() === 'bn')
                                    স্বাস্থ্য পরীক্ষার জন্য কাগজপত্র আপলোড
                                @else
                                Paper upload for health test

                                @endif
                            </label>
                            <div class="needsclick dropzone {{ $errors->has('health_paper') ? 'is-invalid' : '' }}"
                                id="health_paper-dropzone">
                            </div>
                            @if ($errors->has('health_paper'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('health_paper') }}
                                </div>
                            @endif
                            <span
                                class="help-block">{{ trans('cruds.spouseInformatione.fields.nid_upload_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label for="possible_date">
                                @if (app()->getLocale() === 'bn')
                                পরবর্তী শ্রান্তি বিনোদনে যাওয়ার সম্ভাব্য তারিখ
                                @else
                                Possible date for the next Shranti Paswan
                                @endif
                            </label>
                            <input
                                class="form-control date {{ $errors->has('possible_date') ? 'is-invalid' : '' }}"
                                type="text" name="possible_date" id="possible_date"
                                value="{{ old('possible_date') }}">
                            @if ($errors->has('possible_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('possible_date') }}
                                </div>
                            @endif

                            <span
                                class="help-block">{{ trans('cruds.employeeList.fields.first_joining_g_o_date_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label for="office">
                                @if (app()->getLocale() === 'bn')
                                কর্মকর্তা/কর্মচারী সংযুক্তি হলে বর্তমান কর্মস্থল 
                                @else
                                Current workplace if officer/employee joins
                                @endif
                            </label>
                            <input
                                class="form-control {{ $errors->has('office') ? 'is-invalid' : '' }}"
                                type="text" name="office" id="office"
                                value="{{ old('office') }}">
                            @if ($errors->has('office'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('office') }}
                                </div>
                            @endif

                            <span
                                class="help-block">{{ trans('cruds.employeeList.fields.first_joining_g_o_date_helper') }}</span>
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
    Dropzone.options.healthPaperDropzone = {
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
            $('form').find('input[name="health_paper"]').remove()
            $('form').append('<input type="hidden" name="health_paper" value="' + response.name + '">')
        },
        removedfile: function (file) {
            file.previewElement.remove()
            if (file.status !== 'error') {
                $('form').find('input[name="health_paper"]').remove()
                this.options.maxFiles = this.options.maxFiles + 1
            }
        },
        init: function () {
            @if (isset($other) && $other->health_paper)
                var file = {!! json_encode($other->health_paper) !!}
                this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="health_paper" value="' + file.file_name + '">')
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