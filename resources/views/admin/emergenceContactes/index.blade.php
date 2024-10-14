@extends('layouts.admin')
@section('content')
    {{-- @can('emergence_contacte_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.emergence-contactes.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.emergenceContacte.title_singular') }}
                </a>
            </div>
        </div>
    @endcan --}}
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.emergenceContacte.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class="table-bordered table-striped table-hover ajaxTable datatable datatable-EmergenceContacte table">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                        @if (app()->getLocale() === 'bn')
                        কর্মকর্তা/কর্মচারী আইডি
                    @else
                        Employee ID
                    @endif
                        </th>
                        <th>
                        @if (app()->getLocale() === 'bn')
                        কর্মকর্তা/কর্মচারী নাম
                    @else
                        Employee Name
                    @endif
                        </th>
                        
                        <th>
                            {{ trans('cruds.emergenceContacte.fields.contact_person_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.emergenceContacte.fields.contact_person_relation') }}
                        </th>
                        <th>
                            {{ trans('cruds.emergenceContacte.fields.contact_person_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.emergenceContacte.fields.address') }}
                        </th>
                        
                        
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
            @can('emergence_contacte_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.emergence-contactes.massDestroy') }}",
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
                ajax: "{{ route('admin.emergence-contactes.index') }}",
                columns: [{
                        data: 'placeholder',
                        name: 'placeholder'
                    },
                    {
                        data: 'employee_employeeid',
                        name: 'employee.employeeid'
                    },
                    {
                        data: 'employee.fullname_bn',
                        name: 'employee.fullname_bn'
                    },
                    
                    {
                        data: 'contact_person_name',
                        name: 'contact_person_name'
                    },
                    {
                        data: 'contact_person_relation',
                        name: 'contact_person_relation'
                    },
                   
                    {
                        data: 'contact_person_number',
                        name: 'contact_person_number'
                    },
                    {
                        data: 'address',
                        name: 'address'
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
            let table = $('.datatable-EmergenceContacte').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        });
    </script>
@endsection
