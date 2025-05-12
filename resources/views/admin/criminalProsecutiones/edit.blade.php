@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.criminalProsecutione.title_singular') }}
            <br><strong class="text-dark classname">
                @if (app()->getLocale() === 'bn')
                    {{ trans('cruds.employeeList.fields.fullname_bn') }}:{{ $criminalProsecutione->employee->fullname_bn }}
                    &nbsp;
                    {{ trans('cruds.employeeList.fields.employeeid') }}:{{ $criminalProsecutione->employee->employeeid }}
                @else
                    {{ trans('cruds.employeeList.fields.fullname_en') }}:{{ $criminalProsecutione->employee->fullname_en }}
                    &nbsp;
                    {{ trans('cruds.employeeList.fields.employeeid') }}:{{ $criminalProsecutione->employee->employeeid }}
                @endif
            </strong>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.criminal-prosecutiones.update', [$criminalProsecutione->id]) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row row-cols-3">
                    <x-hidden-input name="id" value="{{ $criminalProsecutione->id }}" />

                    <div class="form-group">
                                    <label class="required"
                                        for="mamla_id">মামলার ধরণ</label>
                                    <select
                                        class="form-control select2 {{ $errors->has('mamla') ? 'is-invalid' : '' }}"
                                        name="mamla_id" id="mamla_id" required>
                                        @foreach ($mamlatypes as $id => $entry)
                                            <option value="{{ $id }}"
												{{ (old('mamla_id') ? old('mamla_id') : (isset($criminalProsecutione) && $criminalProsecutione->mamla_id == $id)) ? 'selected' : '' }}>
												{{ $entry }}
											</option>

                                        @endforeach
                                    </select>

                                    <span
                                        class="help-block">{{ trans('cruds.criminalproDisciplinary.fields.criminalprosecutione_helper') }}</span>
                                </div>

								<div class="form-group">
                                <label
                                    for="mamla_start">মামলা রুজুর নম্বর ও তারিখ</label>
									<input class="form-control" type="text" id="mamla_start" name="mamla_start"
									value="{{ old('mamla_start', isset($criminalProsecutione) ? $criminalProsecutione->mamla_start : '') }}">
                                </div>


						<div class="form-group">
                        <label for="court_order">মামলা রুজুর আদেশ সংযোজন</label>
                        <div class="needsclick dropzone {{ $errors->has('court_order') ? 'is-invalid' : '' }}"
                            id="court_order-dropzone">
                        </div>
                        @if ($errors->has('court_order'))
                            <div class="invalid-feedback">
                                {{ $errors->first('court_order') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.criminalProsecutione.fields.court_order_helper') }}</span>
                    </div>

                            <div class="form-group">
                                    <label
                                        for="situation_id">মামলার বর্তমান অবস্থা</label>
                                    <select
                                        class="form-control select2 {{ $errors->has('mamla') ? 'is-invalid' : '' }}"
                                        name="situation_id" id="situation_id">
                                        @foreach ($mamlasituations as $id => $entry)
                                            <option value="{{ $id }}"
												{{ (old('situation_id') ? old('situation_id') : (isset($criminalProsecutione) && $criminalProsecutione->situation_id == $id)) ? 'selected' : '' }}>
												{{ $entry }}
											</option>

                                        @endforeach
                                    </select>

                                    <span
                                        class="help-block">{{ trans('cruds.criminalproDisciplinary.fields.criminalprosecutione_helper') }}</span>
                                </div>






						<div class="form-group">
							<label
								for="mamla_end">মামলা নিস্পত্তির নম্বর ও তারিখ</label>
								<input class="form-control" type="text" id="mamla_end" name="mamla_end"
								        value="{{ old('mamla_end', isset($criminalProsecutione) ? $criminalProsecutione->mamla_end : '') }}"
>
                         </div>



						 <div class="form-group">
                        <label for="court_order_new">মামলা রুজুর আদেশ সংযোজন</label>
                        <div class="needsclick dropzone {{ $errors->has('court_order_new') ? 'is-invalid' : '' }}"
                            id="court_order_new-dropzone">
                        </div>
                        @if ($errors->has('court_order_new'))
                            <div class="invalid-feedback">
                                {{ $errors->first('court_order_new') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.criminalProsecutione.fields.court_order_helper') }}</span>
                    </div>

					<div class="form-group">
							<label
								for="mamla_result">মামলা নিস্পত্তির রায়</label>
								<input class="form-control" type="text" id="mamla_result" name="mamla_result"
								        value="{{ old('mamla_result', isset($criminalProsecutione) ? $criminalProsecutione->mamla_result : '') }}"
>
                         </div>



						 <div class="form-group">
							<label
								for="appeal_go">আপিলের আদেশ/প্রজ্ঞাপন নম্বর ও তারিখ</label>
								<input class="form-control" type="text" id="appeal_go" name="appeal_go"
								        value="{{ old('appeal_go', isset($criminalProsecutione) ? $criminalProsecutione->appeal_go : '') }}"
>
                         </div>


						<div class="form-group">
                        <label for="appeal_order">আপিলের আদেশ সংযোজন</label>
                        <div class="needsclick dropzone {{ $errors->has('appeal_order') ? 'is-invalid' : '' }}"
                            id="appeal_order-dropzone">
                        </div>
                        @if ($errors->has('appeal_order'))
                            <div class="invalid-feedback">
                                {{ $errors->first('appeal_order') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.criminalProsecutione.fields.court_order_helper') }}</span>
                    </div>

					<div class="form-group">
							<label
								for="appeal_result">আপিলের রায়</label>
								<input class="form-control" type="text" id="appeal_result" name="appeal_result"
								        value="{{ old('appeal_result', isset($criminalProsecutione) ? $criminalProsecutione->appeal_result : '') }}"
>
                         </div>



						 <div class="form-group">
							<label
								for="remzrk">মন্তব্য</label>
								<textarea class="form-control" id="remzrk" name="remzrk"
								>{{ old('remzrk', isset($criminalProsecutione) ? $criminalProsecutione->remzrk : '') }}</textarea>
                         </div>









						</div>

                        <div class="row row-cols-6">




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
        Dropzone.options.courtOrderDropzone = {
            url: '{{ route('admin.criminal-prosecutiones.storeMedia') }}',
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
                $('form').find('input[name="court_order"]').remove()
                $('form').append('<input type="hidden" name="court_order" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="court_order"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($criminalProsecutione) && $criminalProsecutione->court_order)
                    var file = {!! json_encode($criminalProsecutione->court_order) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="court_order" value="' + file.file_name + '">')
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
        Dropzone.options.appealOrderDropzone = {
            url: '{{ route('admin.criminal-prosecutiones.storeMedia') }}',
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
                $('form').find('input[name="appeal_order"]').remove()
                $('form').append('<input type="hidden" name="appeal_order" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="appeal_order"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($criminalProsecutione) && $criminalProsecutione->appeal_order)
                    var file = {!! json_encode($criminalProsecutione->appeal_order) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="appeal_order" value="' + file.file_name + '">')
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
        Dropzone.options.courtOrderNewDropzone = {
            url: '{{ route('admin.criminal-prosecutiones.storeMedia') }}',
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
                $('form').find('input[name="court_order_new"]').remove()
                $('form').append('<input type="hidden" name="court_order_new" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="court_order_new"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($criminalProsecutione) && $criminalProsecutione->court_order_new)
                    var file = {!! json_encode($criminalProsecutione->court_order_new) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="court_order_new" value="' + file.file_name + '">')
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
