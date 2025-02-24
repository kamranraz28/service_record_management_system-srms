@extends('layouts.admin')
@section('content')
    @can('grade_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.grades.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.grade.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.grade.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table-bordered table-striped table-hover datatable datatable-Grade table">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.grade.fields.name_bn') }}
                            </th>
                            <th>
                                {{ trans('cruds.grade.fields.name_en') }}
                            </th>
                            <th>
                                {{ trans('cruds.grade.fields.salary_range') }}
                            </th>
                            <th>
                                {{ trans('cruds.grade.fields.current_basic_pay') }}
                            </th>
                            <th>
                                {{ trans('cruds.grade.fields.basic_pay_scale') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grades as $key => $grade)
                            <tr data-entry-id="{{ $grade->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $grade->name_bn ?? '' }}
                                </td>
                                <td>
                                    {{ $grade->name_en ?? '' }}
                                </td>
                                <td>
                                    {{ $grade->salary_range ?? '' }}
                                </td>
                                <td>
                                    {{ $grade->current_basic_pay ?? '' }}
                                </td>
                                <td>
                                    {{ $grade->basic_pay_scale ?? '' }}
                                </td>
                                <td>
                                    @can('grade_show')
                                        <a class="btn btn-sm btn-success px-2"
                                            href="{{ route('admin.grades.show', $grade->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('grade_edit')
                                        <a class="btn btn-sm btn-warning px-2"
                                            href="{{ route('admin.grades.edit', $grade->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('grade_delete')
                                        <form action="{{ route('admin.grades.destroy', $grade->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
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
            @can('grade_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.grades.massDestroy') }}",
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
            let table = $('.datatable-Grade:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
