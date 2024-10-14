@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.district.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.districts.update', [$district->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="divisions_id">{{ trans('cruds.district.fields.divisions') }}</label>
                    <select class="form-select select2 {{ $errors->has('divisions') ? 'is-invalid' : '' }}"
                        name="divisions_id" id="divisions_id" required>
                        @foreach ($divisions as $id => $entry)
                            <option value="{{ $id }}"
                                {{ (old('divisions_id') ? old('divisions_id') : $district->divisions->id ?? '') == $id ? 'selected' : '' }}>
                                {{ $entry }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('divisions'))
                        <div class="invalid-feedback">
                            {{ $errors->first('divisions') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.district.fields.divisions_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="name_bn">{{ trans('cruds.district.fields.name_bn') }}</label>
                    <input class="form-control {{ $errors->has('name_bn') ? 'is-invalid' : '' }}" type="text"
                        name="name_bn" id="name_bn" value="{{ old('name_bn', $district->name_bn) }}" required>
                    @if ($errors->has('name_bn'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name_bn') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.district.fields.name_bn_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="name_en">{{ trans('cruds.district.fields.name_en') }}</label>
                    <input class="form-control {{ $errors->has('name_en') ? 'is-invalid' : '' }}" type="text"
                        name="name_en" id="name_en" value="{{ old('name_en', $district->name_en) }}" required>
                    @if ($errors->has('name_en'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name_en') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.district.fields.name_en_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="grocode">{{ trans('cruds.district.fields.grocode') }}</label>
                    <input class="form-control {{ $errors->has('grocode') ? 'is-invalid' : '' }}" type="text"
                        name="grocode" id="grocode" value="{{ old('grocode', $district->grocode) }}">
                    @if ($errors->has('grocode'))
                        <div class="invalid-feedback">
                            {{ $errors->first('grocode') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.district.fields.grocode_helper') }}</span>
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
