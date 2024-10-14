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
                        <h4>{{ trans('cruds.leaveRecord.title_singular') }}</h4>
                        <br>
                        <form method="POST"
                            action="{{ route('admin.leave-records.store', ['employee_id' => request()->query('id')]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row row-cols-2">

                                <div class="form-group">
                                    <label class="required"
                                        for="leave_category_id">{{ trans('cruds.leaveRecord.fields.leave_category') }}</label>
                                    <select
                                        class="form-control select2 {{ $errors->has('leave_category') ? 'is-invalid' : '' }}"
                                        name="leave_category_id" id="leave_category_id" required>
                                        @foreach ($leave_categories as $id => $entry)
                                            <option value="{{ $id }}"
                                                {{ old('leave_category_id') == $id ? 'selected' : '' }}>
                                                {{ $entry }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('leave_category'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('leave_category') }}
                                        </div>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.leaveRecord.fields.leave_category_helper') }}</span>

                                </div>
                                <div class="form-group">
                                    <label class="required"
                                        for="type_of_leave_id">{{ trans('cruds.leaveRecord.fields.type_of_leave') }}</label>
                                    <select
                                        class="form-control select2 {{ $errors->has('type_of_leave') ? 'is-invalid' : '' }}"
                                        name="type_of_leave_id" id="type_of_leave_id" required>
                                        @foreach ($type_of_leaves as $id => $entry)
                                            <option value="{{ $id }}"
                                                {{ old('type_of_leave_id') == $id ? 'selected' : '' }}>
                                                {{ $entry }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('type_of_leave'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('type_of_leave') }}
                                        </div>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.leaveRecord.fields.type_of_leave_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="required"
                                        for="start_date">{{ trans('cruds.leaveRecord.fields.start_date') }}</label>
                                    <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}"
                                        type="text" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                        required>
                                    @if ($errors->has('start_date'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('start_date') }}
                                        </div>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.leaveRecord.fields.start_date_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="required"
                                        for="end_date">{{ trans('cruds.leaveRecord.fields.end_date') }}</label>
                                    <input class="form-control date {{ $errors->has('end_date') ? 'is-invalid' : '' }}"
                                        type="text" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                        required>
                                    @if ($errors->has('end_date'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('end_date') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveRecord.fields.end_date_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="required"
                                        for="leave_orderumber">{{ trans('cruds.leaveRecord.fields.leave_orderumber') }}</label>
                                    <input class="form-control {{ $errors->has('leave_orderumber') ? 'is-invalid' : '' }}"
                                        type="text" name="leave_orderumber" id="leave_orderumber"
                                        value="{{ old('leave_orderumber') }}" required>
                                    @if ($errors->has('leave_orderumber'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('leave_orderumber') }}
                                        </div>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.leaveRecord.fields.leave_orderumber_helper') }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="required"
                                        for="leave_order_date">{{ trans('cruds.leaveRecord.fields.leave_order_date') }}</label>
                                    <input
                                        class="form-control date {{ $errors->has('leave_order_date') ? 'is-invalid' : '' }}"
                                        type="text" name="leave_order_date" id="leave_order_date"
                                        value="{{ old('leave_order_date') }}" required>
                                    @if ($errors->has('leave_order_date'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('leave_order_date') }}
                                        </div>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.leaveRecord.fields.leave_order_date_helper') }}</span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="reason">{{ trans('cruds.leaveRecord.fields.reason') }}</label>
                                <textarea class="form-control ckeditor {{ $errors->has('reason') ? 'is-invalid' : '' }}" name="reason" id="reason">{!! old('reason') !!}</textarea>
                                @if ($errors->has('reason'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('reason') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.leaveRecord.fields.reason_helper') }}</span>
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
        $(document).ready(function() {
            function SimpleUploadAdapter(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
                    return {
                        upload: function() {
                            return loader.file
                                .then(function(file) {
                                    return new Promise(function(resolve, reject) {
                                        // Init request
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST',
                                            '{{ route('admin.leave-records.storeCKEditorImages') }}',
                                            true);
                                        xhr.setRequestHeader('x-csrf-token', window._token);
                                        xhr.setRequestHeader('Accept', 'application/json');
                                        xhr.responseType = 'json';

                                        // Init listeners
                                        var genericErrorText =
                                            `Couldn't upload file: ${file.name}.`;
                                        xhr.addEventListener('error', function() {
                                            reject(genericErrorText)
                                        });
                                        xhr.addEventListener('abort', function() {
                                            reject()
                                        });
                                        xhr.addEventListener('load', function() {
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
                                            xhr.upload.addEventListener('progress', function(
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
                                        data.append('crud_id', '{{ $leaveRecord->id ?? 0 }}');
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
