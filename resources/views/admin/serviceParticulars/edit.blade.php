@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.serviceParticular.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.service-particulars.update', [$serviceParticular->id]) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required"
                        for="designation_id">{{ trans('cruds.serviceParticular.fields.designation') }}</label>
                    <select class="form-select select2 {{ $errors->has('designation') ? 'is-invalid' : '' }}"
                        name="designation_id" id="designation_id" required>
                        @foreach ($designations as $id => $entry)
                            <option value="{{ $id }}"
                                {{ (old('designation_id') ? old('designation_id') : $serviceParticular->designation->id ?? '') == $id ? 'selected' : '' }}>
                                {{ $entry }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('designation'))
                        <div class="invalid-feedback">
                            {{ $errors->first('designation') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.serviceParticular.fields.designation_helper') }}</span>
                </div>
                <div class="form-group">
                    <label
                        for="designation_status">{{ trans('cruds.serviceParticular.fields.designation_status') }}</label>
                    <input class="form-control {{ $errors->has('designation_status') ? 'is-invalid' : '' }}" type="text"
                        name="designation_status" id="designation_status"
                        value="{{ old('designation_status', $serviceParticular->designation_status) }}">
                    @if ($errors->has('designation_status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('designation_status') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.serviceParticular.fields.designation_status_helper') }}</span>
                </div>
                <div class="form-group">
                    <label
                        for="office_organization_institute">{{ trans('cruds.serviceParticular.fields.office_organization_institute') }}</label>
                    <input class="form-control {{ $errors->has('office_organization_institute') ? 'is-invalid' : '' }}"
                        type="text" name="office_organization_institute" id="office_organization_institute"
                        value="{{ old('office_organization_institute', $serviceParticular->office_organization_institute) }}">
                    @if ($errors->has('office_organization_institute'))
                        <div class="invalid-feedback">
                            {{ $errors->first('office_organization_institute') }}
                        </div>
                    @endif
                    <span
                        class="help-block">{{ trans('cruds.serviceParticular.fields.office_organization_institute_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="joining_date">{{ trans('cruds.serviceParticular.fields.joining_date') }}</label>
                    <input class="form-control date {{ $errors->has('joining_date') ? 'is-invalid' : '' }}" type="text"
                        name="joining_date" id="joining_date"
                        value="{{ old('joining_date', $serviceParticular->joining_date) }}">
                    @if ($errors->has('joining_date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('joining_date') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.serviceParticular.fields.joining_date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="release_date">{{ trans('cruds.serviceParticular.fields.release_date') }}</label>
                    <input class="form-control date {{ $errors->has('release_date') ? 'is-invalid' : '' }}" type="text"
                        name="release_date" id="release_date"
                        value="{{ old('release_date', $serviceParticular->release_date) }}">
                    @if ($errors->has('release_date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('release_date') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.serviceParticular.fields.release_date_helper') }}</span>
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
