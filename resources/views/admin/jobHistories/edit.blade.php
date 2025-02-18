@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.jobHistory.title_singular') }}
            <br><strong class="text-dark classname">
                @if (app()->getLocale() === 'bn')
                    {{ trans('cruds.employeeList.fields.fullname_bn') }}: {{ $jobHistory->employee->fullname_bn }}
                    &nbsp;
                    {{ trans('cruds.employeeList.fields.employeeid') }}:{{ $jobHistory->employee->employeeid }}
                @else
                    {{ trans('cruds.employeeList.fields.fullname_en') }}: {{ $jobHistory->employee->fullname_en }}
                    &nbsp;
                    {{ trans('cruds.employeeList.fields.employeeid') }}:{{ $jobHistory->employee->employeeid }}
                @endif
            </strong>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.job-histories.update', [$jobHistory->id]) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row row-cols-3">
				{{--<div class="form-group">
                        <label class="required"
                            for="institute_name">{{ trans('cruds.jobHistory.fields.institute_name') }}</label>
                        <input class="form-control {{ $errors->has('institute_name') ? 'is-invalid' : '' }}" type="text"
                            name="institute_name" id="institute_name"
                            value="{{ old('institute_name', $jobHistory->institute_name) }}" required>
                        @if ($errors->has('institute_name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('institute_name') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.jobHistory.fields.institute_name_helper') }}</span>
				</div>--}}
					
					<div class="form-group">
						<label for="office_unit_id">অফিস</label>
						<select class="form-select select2 {{ $errors->has('office_unit_id') ? 'is-invalid' : '' }}"
							name="office_unit_id" id="office_unit_id">
							@foreach ($office_units as $id => $entry)
								<option value="{{ $id }}"
									{{ (old('office_unit_id') ? old('office_unit_id') : $jobHistory->office_unit_id ?? '') == $id ? 'selected' : '' }}>
									{{ $entry }}
								</option>
							@endforeach
						</select>
					</div>
					
					<div class="form-group">
                        <label for="level_2">অফিসের নাম (হেড অফিসে পোস্টিং হলে)</label>
                        <input class="form-control {{ $errors->has('level_2') ? 'is-invalid' : '' }}" type="text"
                            name="level_2" id="level_2" value="{{ old('level_2', $jobHistory->level_2) }}">
                        
                    </div>
					
					<div class="form-group">
						<label for="circle_list_id">সার্কেল</label>
						<select class="form-select select2 {{ $errors->has('circle_list_id') ? 'is-invalid' : '' }}"
							name="circle_list_id" id="circle_list_id">
							@foreach ($circle_lists as $id => $entry)
								<option value="{{ $id }}"
									{{ (old('circle_list_id') ? old('circle_list_id') : $jobHistory->circle_list_id ?? '') == $id ? 'selected' : '' }}>
									{{ $entry }}
								</option>
							@endforeach
						</select>
					</div>
					
					<div class="form-group">
						<label for="division_list_id">ডিভিশন</label>
						<select class="form-select select2 {{ $errors->has('division_list_id') ? 'is-invalid' : '' }}"
							name="division_list_id" id="division_list_id">
							@foreach ($division_lists as $id => $entry)
								<option value="{{ $id }}"
									{{ (old('division_list_id') ? old('division_list_id') : $jobHistory->division_list_id ?? '') == $id ? 'selected' : '' }}>
									{{ $entry }}
								</option>
							@endforeach
						</select>
					</div>
					
					<div class="form-group">
						<label for="range_list_id">রেঞ্জ/এসএফএনটিসি</label>
						<select class="form-select select2 {{ $errors->has('range_list_id') ? 'is-invalid' : '' }}"
							name="range_list_id" id="range_list_id">
							@foreach ($range_lists as $id => $entry)
								<option value="{{ $id }}"
									{{ (old('range_list_id') ? old('range_list_id') : $jobHistory->range_list_id ?? '') == $id ? 'selected' : '' }}>
									{{ $entry }}
								</option>
							@endforeach
						</select>
					</div>
					
					<div class="form-group">
						<label for="beat_list_id">বিট/এসএফপিসি</label>
						<select class="form-select select2 {{ $errors->has('beat_list_id') ? 'is-invalid' : '' }}"
							name="beat_list_id" id="beat_list_id">
							@foreach ($beat_lists as $id => $entry)
								<option value="{{ $id }}"
									{{ (old('beat_list_id') ? old('beat_list_id') : $jobHistory->beat_list_id ?? '') == $id ? 'selected' : '' }}>
									{{ $entry }}
								</option>
							@endforeach
						</select>
					</div>
					
					

					
                    
                    <div class="form-group">
                        <label for="designation_id">{{ trans('cruds.jobHistory.fields.designation') }}</label>
                        <select class="form-select select2 {{ $errors->has('designation') ? 'is-invalid' : '' }}"
                            name="designation_id" id="designation_id">
                            @foreach ($designations as $id => $entry)
                                <option value="{{ $id }}"
                                    {{ (old('designation_id') ? old('designation_id') : $jobHistory->designation->id ?? '') == $id ? 'selected' : '' }}>
                                    {{ $entry }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('designation'))
                            <div class="invalid-feedback">
                                {{ $errors->first('designation') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.jobHistory.fields.designation_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required"
                            for="joining_date">{{ trans('cruds.jobHistory.fields.joining_date') }}</label>
                        <input class="form-control date {{ $errors->has('joining_date') ? 'is-invalid' : '' }}"
                            type="text" name="joining_date" id="joining_date"
                            value="{{ old('joining_date', $jobHistory->joining_date) }}" required>
                        @if ($errors->has('joining_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('joining_date') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.jobHistory.fields.joining_date_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="release_date">{{ trans('cruds.jobHistory.fields.release_date') }}</label>
                        <input class="form-control date {{ $errors->has('release_date') ? 'is-invalid' : '' }}"
                            type="text" name="release_date" id="release_date"
                            value="{{ old('release_date', $jobHistory->release_date) }}">
                        @if ($errors->has('release_date'))
                            <div class="invalid-feedback">
                                {{ $errors->first('release_date') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.jobHistory.fields.release_date_helper') }}</span>
                    </div>
				

                    
                    <div class="form-group">
                        <label class="required" for="grade_id">{{ trans('cruds.jobHistory.fields.grade') }}</label>
                        <select class="form-select select2 {{ $errors->has('grade') ? 'is-invalid' : '' }}"
                            name="grade_id" id="grade_id" required>
                            @foreach ($grades as $id => $entry)
                                <option value="{{ $id }}"
                                    {{ (old('grade_id') ? old('grade_id') : $jobHistory->grade->id ?? '') == $id ? 'selected' : '' }}>
                                    {{ $entry }}</option>
                            @endforeach
                        </select>
                        
                        <span class="help-block">{{ trans('cruds.jobHistory.fields.grade_helper') }}</span>
                    </div>

                    <div class="form-group">
                        <label for="go_upload">{{ trans('cruds.jobHistory.fields.go_upload') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('go_upload') ? 'is-invalid' : '' }}"
                            id="go_upload-dropzone">
                        </div>
                        @if ($errors->has('go_upload'))
                            <div class="invalid-feedback">
                                {{ $errors->first('go_upload') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.jobHistory.fields.go_upload_helper') }}</span>
                    </div>
					
					<div class="form-group">
                        <label for="comment">মন্তব্য</label>
                        <input class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" type="text"
                            name="comment" id="comment" value="{{ old('comment', $jobHistory->comment) }}">
                        
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
        Dropzone.options.goUploadDropzone = {
            url: '{{ route('admin.job-histories.storeMedia') }}',
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
                $('form').find('input[name="go_upload"]').remove()
                $('form').append('<input type="hidden" name="go_upload" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="go_upload"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($jobHistory) && $jobHistory->go_upload)
                    var file = {!! json_encode($jobHistory->go_upload) !!}
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="go_upload" value="' + file.file_name + '">')
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
