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
                    <h4>{{ trans('cruds.criminalProsecutione.title_singular') }}</h4>
                    <br>
                    <form method="POST"
                        action="{{ route('admin.criminal-prosecutiones.store', ['employee_id' => request()->query('id')]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <x-hidden-input name="employee_id" value="{{ request()->input('id') }}" />
                        <div class="row row-cols-2">

							<div class="form-group">
                                    <label class="required"
                                        for="mamla_id">মামলার ধরণ</label>
                                    <select
                                        class="form-control select2 {{ $errors->has('mamla') ? 'is-invalid' : '' }}"
                                        name="mamla_id" id="mamla_id" required>
                                        @foreach ($mamlatypes as $id => $entry)
                                            <option value="{{ $id }}"
                                                {{ old('mamla_id') == $id ? 'selected' : '' }}>
                                                {{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    
                                    <span
                                        class="help-block">{{ trans('cruds.criminalproDisciplinary.fields.criminalprosecutione_helper') }}</span>
                                </div>
								                               

							
								
                            
				
							<div class="form-group">
                                <label
                                    for="mamla_start">মামলা রুজুর নম্বর ও তারিখ</label>
									<input class="form-control" type="text" id="mamla_start" name="mamla_start">
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
					
					{{--<div class="form-group">
                                <label
                                    for="situation">মামলার বর্তমান অবস্থা</label>
                                    <input class="form-control" type="text" id="situation" name="situation">

					</div>--}}
					
					<div class="form-group">
                                    <label
                                        for="situation_id">মামলার বর্তমান অবস্থা</label>
                                    <select
                                        class="form-control select2 {{ $errors->has('mamla') ? 'is-invalid' : '' }}"
                                        name="situation_id" id="situation_id">
                                        @foreach ($mamlasituations as $id => $entry)
                                            <option value="{{ $id }}"
                                                {{ old('situation_id') == $id ? 'selected' : '' }}>
                                                {{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    
                                    <span
                                        class="help-block">{{ trans('cruds.criminalproDisciplinary.fields.criminalprosecutione_helper') }}</span>
                                </div>
								</div>
								<br>
					
					
                           
						<div class="form-group">
							শুধুমাত্র মামলা নিস্পত্তি হয়ে থাকলে
							</div>
							<div class="row row-cols-2">
						<div class="form-group">
							<label
								for="mamla_end">মামলা নিস্পত্তির নম্বর ও তারিখ</label>
								<input class="form-control" type="text" id="mamla_end" name="mamla_end">
                         </div>
						 
						 <div class="form-group">
                        <label for="court_order_new">মামলা নিস্পত্তির আদেশ সংযোজন</label>
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
								<input class="form-control" type="text" id="mamla_result" name="mamla_result">
                         </div>
						 </div>
						 <br>
						 
						 <div class="form-group">
							আপিল করা হয়ে থাকলে
							</div>
							<div class="row row-cols-2">
						 <div class="form-group">
							<label
								for="appeal_go">আপিলের আদেশ/প্রজ্ঞাপন নম্বর ও তারিখ</label>
								<input class="form-control" type="text" id="appeal_go" name="appeal_go">
                         </div>
						 
						 <div class="form-group">
                        <label for="appeal_order">আপিল আদেশ সংযোজন</label>
                        <div class="needsclick dropzone {{ $errors->has('appeal_order') ? 'is-invalid' : '' }}"
                            id="appeal_order-dropzone">
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
								for="appeal_result">আপিলের রায়</label>
								<input class="form-control" type="text" id="appeal_result" name="appeal_result">
                         </div>
						 </div>
						 
						 
						 
						 <div class="form-group">
							<label
								for="remzrk">মন্তব্য</label>
								<textarea class="form-control" id="remzrk" name="remzrk"></textarea>
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
        </div>
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
                @if (isset($criminalProsecutione) && $criminalProsecutione->court_order)
                    var file = {!! json_encode($criminalProsecutione->court_order) !!}
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