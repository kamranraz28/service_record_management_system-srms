@extends('layouts.admin')
@section('content')
    {{-- @can('acr_monitoring_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.acr-monitorings.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.acrMonitoring.title_singular') }}
                </a>
            </div>
        </div>
    @endcan --}}
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.acrMonitoring.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class="table-bordered table-striped table-hover ajaxTable datatable datatable-AcrMonitoring table">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        
                        <th>@if (app()->getLocale() === 'bn')
                        কর্মকর্তা/কর্মচারী আইডি
                    @else
                        Employee ID
                    @endif</th>
                    <th>@if (app()->getLocale() === 'bn')
                        কর্মকর্তা/কর্মচারী নাম
                    @else
                        Employee Name
                    @endif</th>
                    <th>
                            {{ trans('cruds.acrMonitoring.fields.reviewer') }}
                        </th>
                        <th>
                            {{ trans('cruds.acrMonitoring.fields.year') }}
                        </th>
                        
                        <th>@if (app()->getLocale() === 'bn')
                        মন্তব্য
                    @else
                    Remarks
                    @endif</th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    @parent

    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('acr_monitoring_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.acr-monitorings.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).data(), function(entry) {
                            return entry.id
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

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.acr-monitorings.index') }}",
                columns: [{
                        data: 'placeholder',
                        name: 'placeholder'
                    },
                    {
                        data: 'employee_employeeid',
                        name: 'employee.employeeid'
                    },
                    {
                        data: 'employee_fullname_en',
                        name: 'employee_fullname_en'
                    },
                    {
                        data: 'reviewer',
                        name: 'reviewer'
                    },
                    {
                        data: 'year',
                        name: 'year'
                    },
                    
                    {
                        data: 'remarks',
                        name: 'remarks'
                    },
                    {
                        data: 'actions',
                        name: '{{ trans('global.actions') }}'
                    }
                ],
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 10,
            };
            let table = $('.datatable-AcrMonitoring').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        });
    </script>
@endsection
