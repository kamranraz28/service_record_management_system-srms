@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.acrMonitoring.title_singular') }}
            <br><strong class="text-dark">
                @if (app()->getLocale() === 'bn')
                    {{ trans('cruds.employeeList.fields.fullname_bn') }}: {{ $acrMonitoring->employee->fullname_bn }}
                    &nbsp;
                    {{ trans('cruds.employeeList.fields.employeeid') }}:{{ $acrMonitoring->employee->employeeid }}
                @else
                    {{ trans('cruds.employeeList.fields.fullname_en') }}: {{ $acrMonitoring->employee->fullname_en }}
                    &nbsp;
                    {{ trans('cruds.employeeList.fields.employeeid') }}:{{ $acrMonitoring->employee->employeeid }}
                @endif


            </strong>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.acr-monitorings.update', [$acrMonitoring->id]) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row row-cols-3">
                    <x-hidden-input name="id" value="{{ $acrMonitoring->id }}" />

                    <div class="form-group">
                        <label class="required" for="year">{{ trans('cruds.acrMonitoring.fields.year') }}</label>
                        <input class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}" type="number" name="year"
                            id="year" value="{{ old('year', $acrMonitoring->year) }}" step="1" required>
                        @if ($errors->has('year'))
                            <div class="invalid-feedback">
                                {{ $errors->first('year') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.acrMonitoring.fields.year_helper') }}</span>
                    </div>

                    <div class="form-group">
                        <label for="remarks">
                            @if (app()->getLocale() === 'bn')
                                মন্তব্য
                            @else
                                Remarks
                            @endif
                        </label>
                        <input class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" type="text"
                            name="remarks" id="remarks" value="{{ old('remarks', $acrMonitoring->remarks) }}">

                    </div>

                    <div class="form-group">
                        <label for="fromdate">
                            @if (app()->getLocale() === 'bn')
                                তারিখ হতে
                            @else
                                From Date
                            @endif
                        </label>
                        <input class="form-control date {{ $errors->has('fromdate') ? 'is-invalid' : '' }}" type="text"
                            name="fromdate" id="fromdate" value="{{ old('fromdate', $acrMonitoring->fromdate) }}" >

                    </div>

                    <div class="form-group">
                        <label for="todate">
                            @if (app()->getLocale() === 'bn')
                                তারিখ পর্যন্ত
                            @else
                                To Date
                            @endif
                        </label>
                        <input class="form-control date {{ $errors->has('todate') ? 'is-invalid' : '' }}" type="text"
                            name="todate" id="todate" value="{{ old('todate', $acrMonitoring->todate) }}" >

                    </div>

                    <div class="form-group">
                        <label for="issubmitted" class="required">জমা দেওয়া হয়েছে?</label>
                        <select class="form-control {{ $errors->has('issubmitted') ? 'is-invalid' : '' }}"
                            name="issubmitted" id="issubmitted" required>
                            <option value="">{{trans('global.pleaseSelect')}}</option>
                        <option value="1" {{ $acrMonitoring->issubmitted == '1' ? 'selected' : '' }}>হ্যাঁ</option>
                        <option value="2" {{ $acrMonitoring->issubmitted == '2' ? 'selected' : '' }}>না</option>
                        </select>
                        @if ($errors->has('issubmitted'))
                            <div class="invalid-feedback">
                                {{ $errors->first('issubmitted') }}
                            </div>
                        @endif
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
        $(document).ready(function () {
            function SimpleUploadAdapter(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = function (loader) {
                    return {
                        upload: function () {
                            return loader.file
                                .then(function (file) {
                                    return new Promise(function (resolve, reject) {
                                        // Init request
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST',
                                            '{{ route('admin.acr-monitorings.storeCKEditorImages') }}',
                                            true);
                                        xhr.setRequestHeader('x-csrf-token', window._token);
                                        xhr.setRequestHeader('Accept', 'application/json');
                                        xhr.responseType = 'json';

                                        // Init listeners
                                        var genericErrorText =
                                            `Couldn't upload file: ${file.name}.`;
                                        xhr.addEventListener('error', function () {
                                            reject(genericErrorText)
                                        });
                                        xhr.addEventListener('abort', function () {
                                            reject()
                                        });
                                        xhr.addEventListener('load', function () {
                                            var response = xhr.response;

                                            if (!response || xhr.status !== 201) {
                                                return reject(response && response
                                                    .message ?
                                                    `${genericErrorText}\n${xhr.status} ${response.message}` :
                                                    `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`
                                                );
                                            }

                                            $('form').append(
                                                '<input type="hidden" name="ck-media[]" value="' +
                                                response.id + '">');

                                            resolve({
                                                default: response.url
                                            });
                                        });

                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function (
                                                e) {
                                                if (e.lengthComputable) {
                                                    loader.uploadTotal = e.total;
                                                    loader.uploaded = e.loaded;
                                                }
                                            });
                                        }

                                        // Send request
                                        var data = new FormData();
                                        data.append('upload', file);
                                        data.append('crud_id',
                                            '{{ $acrMonitoring->id ?? 0 }}');
                                        xhr.send(data);
                                    });
                                })
                        }
                    };
                }
            }

            var allEditors = document.querySelectorAll('.ckeditor');
            for (var i = 0; i < allEditors.length; ++i) {
                ClassicEditor.create(
                    allEditors[i], {
                    extraPlugins: [SimpleUploadAdapter]
                }
                );
            }
        });
    </script>
@endsection
