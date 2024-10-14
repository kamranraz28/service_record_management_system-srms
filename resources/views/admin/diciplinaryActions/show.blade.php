@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.diciplinaryAction.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.diciplinary-actions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.diciplinaryAction.fields.govt_order_no') }}
                        </th>
                        <td>
                            {{ $diciplinaryAction->govt_order_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.diciplinaryAction.fields.govt_order_date') }}
                        </th>
                        <td>
                            {{ $diciplinaryAction->govt_order_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.diciplinaryAction.fields.diciplinary_action') }}
                        </th>
                        <td>
                            {{ $diciplinaryAction->diciplinary_action->judgement_type ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.diciplinary-actions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection