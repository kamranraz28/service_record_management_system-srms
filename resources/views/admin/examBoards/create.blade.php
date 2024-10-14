@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.examBoard.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.exam-boards.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="examination_id">{{ trans('cruds.examBoard.fields.examination') }}</label>
                    <select class="form-select select2 {{ $errors->has('examination') ? 'is-invalid' : '' }}"
                        name="examination_id" id="examination_id">
                        @foreach ($examinations as $id => $entry)
                            <option value="{{ $id }}" {{ old('examination_id') == $id ? 'selected' : '' }}>
                                {{ $entry }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('examination'))
                        <div class="invalid-feedback">
                            {{ $errors->first('examination') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.examBoard.fields.examination_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="name_bn">{{ trans('cruds.examBoard.fields.name_bn') }}</label>
                    <input class="form-control {{ $errors->has('name_bn') ? 'is-invalid' : '' }}" type="text"
                        name="name_bn" id="name_bn" value="{{ old('name_bn', '') }}" required>
                    @if ($errors->has('name_bn'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name_bn') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.examBoard.fields.name_bn_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="name_en">{{ trans('cruds.examBoard.fields.name_en') }}</label>
                    <input class="form-control {{ $errors->has('name_en') ? 'is-invalid' : '' }}" type="text"
                        name="name_en" id="name_en" value="{{ old('name_en', '') }}">
                    @if ($errors->has('name_en'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name_en') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.examBoard.fields.name_en_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="description">{{ trans('cruds.examBoard.fields.description') }}</label>
                    <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text"
                        name="description" id="description" value="{{ old('description', '') }}">
                    @if ($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.examBoard.fields.description_helper') }}</span>
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
