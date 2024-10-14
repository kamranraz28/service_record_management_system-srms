@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.socialAssPrAttachment.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.social-ass-pr-attachments.update', [$socialAssPrAttachment->id]) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required"
                        for="degree_membership_organization">{{ trans('cruds.socialAssPrAttachment.fields.degree_membership_organization') }}</label>
                    <input class="form-control {{ $errors->has('degree_membership_organization') ? 'is-invalid' : '' }}"
                        type="text" name="degree_membership_organization" id="degree_membership_organization"
                        value="{{ old('degree_membership_organization', $socialAssPrAttachment->degree_membership_organization) }}"
                        required>
                    @if ($errors->has('degree_membership_organization'))
                        <div class="invalid-feedback">
                            {{ $errors->first('degree_membership_organization') }}
                        </div>
                    @endif
                    <span
                        class="help-block">{{ trans('cruds.socialAssPrAttachment.fields.degree_membership_organization_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="description">{{ trans('cruds.socialAssPrAttachment.fields.description') }}</label>
                    <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text"
                        name="description" id="description"
                        value="{{ old('description', $socialAssPrAttachment->description) }}">
                    @if ($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.socialAssPrAttachment.fields.description_helper') }}</span>
                </div>
                <div class="form-group">
                    <label
                        for="certificate_achievement">{{ trans('cruds.socialAssPrAttachment.fields.certificate_achievement') }}</label>
                    <input class="form-control {{ $errors->has('certificate_achievement') ? 'is-invalid' : '' }}"
                        type="text" name="certificate_achievement" id="certificate_achievement"
                        value="{{ old('certificate_achievement', $socialAssPrAttachment->certificate_achievement) }}">
                    @if ($errors->has('certificate_achievement'))
                        <div class="invalid-feedback">
                            {{ $errors->first('certificate_achievement') }}
                        </div>
                    @endif
                    <span
                        class="help-block">{{ trans('cruds.socialAssPrAttachment.fields.certificate_achievement_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                        for="employee_id">{{ trans('cruds.socialAssPrAttachment.fields.employee') }}</label>
                    <select class="form-select select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}"
                        name="employee_id" id="employee_id" required>
                        @foreach ($employees as $id => $entry)
                            <option value="{{ $id }}"
                                {{ (old('employee_id') ? old('employee_id') : $socialAssPrAttachment->employee->id ?? '') == $id ? 'selected' : '' }}>
                                {{ $entry }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('employee'))
                        <div class="invalid-feedback">
                            {{ $errors->first('employee') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.socialAssPrAttachment.fields.employee_helper') }}</span>
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
