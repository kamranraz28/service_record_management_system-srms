@extends('layouts.admin')
@section('content')
    @can('freedom_fighte_relation_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.freedom-fighte-relations.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.freedomFighteRelation.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.freedomFighteRelation.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table-bordered table-striped table-hover datatable datatable-FreedomFighteRelation table">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.freedomFighteRelation.fields.name_bn') }}
                            </th>
                            <th>
                                {{ trans('cruds.freedomFighteRelation.fields.name_en') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($freedomFighteRelations as $key => $freedomFighteRelation)
                            <tr data-entry-id="{{ $freedomFighteRelation->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $freedomFighteRelation->name_bn ?? '' }}
                                </td>
                                <td>
                                    {{ $freedomFighteRelation->name_en ?? '' }}
                                </td>
                                <td>
                                    @can('freedom_fighte_relation_show')
                                        <a class="btn btn-sm btn-success px-2"
                                            href="{{ route('admin.freedom-fighte-relations.show', $freedomFighteRelation->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('freedom_fighte_relation_edit')
                                        <a class="btn btn-sm btn-warning px-2"
                                            href="{{ route('admin.freedom-fighte-relations.edit', $freedomFighteRelation->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('freedom_fighte_relation_delete')
                                        <form
                                            action="{{ route('admin.freedom-fighte-relations.destroy', $freedomFighteRelation->id) }}"
                                            method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-sm btn-danger px-2"
                                                value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('freedom_fighte_relation_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.freedom-fighte-relations.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 10,
            });
            let table = $('.datatable-FreedomFighteRelation:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
