@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.forestState.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.forest-states.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.forestState.fields.id') }}
                        </th>
                        <td>
                            {{ $forestState->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.forestState.fields.name_bn') }}
                        </th>
                        <td>
                            {{ $forestState->name_bn }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.forestState.fields.name_en') }}
                        </th>
                        <td>
                            {{ $forestState->name_en }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.forestState.fields.bbs_code') }}
                        </th>
                        <td>
                            {{ $forestState->bbs_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.forestState.fields.status') }}
                        </th>
                        <td>
                            {{ $forestState->status->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.forest-states.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection