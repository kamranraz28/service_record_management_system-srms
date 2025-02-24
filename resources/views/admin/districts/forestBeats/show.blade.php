@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.forestBeat.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.forest-beats.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.forestBeat.fields.id') }}
                        </th>
                        <td>
                            {{ $forestBeat->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.forestBeat.fields.forest_range') }}
                        </th>
                        <td>
                            {{ $forestBeat->forest_range->name_bn ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.forestBeat.fields.name_bn') }}
                        </th>
                        <td>
                            {{ $forestBeat->name_bn }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.forestBeat.fields.name_en') }}
                        </th>
                        <td>
                            {{ $forestBeat->name_en }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.forest-beats.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection