@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.leaveCategory.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.leave-categories.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name_bn">{{ trans('cruds.leaveCategory.fields.name_bn') }}</label>
                <input class="form-control {{ $errors->has('name_bn') ? 'is-invalid' : '' }}" type="text" name="name_bn" id="name_bn" value="{{ old('name_bn', '') }}" required>
                @if($errors->has('name_bn'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name_bn') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leaveCategory.fields.name_bn_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name_en">{{ trans('cruds.leaveCategory.fields.name_en') }}</label>
                <input class="form-control {{ $errors->has('name_en') ? 'is-invalid' : '' }}" type="text" name="name_en" id="name_en" value="{{ old('name_en', '') }}" required>
                @if($errors->has('name_en'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name_en') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leaveCategory.fields.name_en_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="value">{{ trans('cruds.leaveCategory.fields.value') }}</label>
                <input class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" type="number" name="value" id="value" value="{{ old('value', '') }}" step="1">
                @if($errors->has('value'))
                    <div class="invalid-feedback">
                        {{ $errors->first('value') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leaveCategory.fields.value_helper') }}</span>
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