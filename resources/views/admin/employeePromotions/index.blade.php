@extends('layouts.admin')
@section('content')
    {{-- @can('employee_promotion_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.employee-promotions.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.employeePromotion.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'EmployeePromotion', 'route' => 'admin.employee-promotions.parseCsvImport'])
        </div>
    </div>
@endcan --}}
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.employeePromotion.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class="table-bordered table-striped table-hover ajaxTable datatable datatable-EmployeePromotion table">
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
                            {{ trans('cruds.employeePromotion.fields.new_designation') }}
                        </th>
						<th>
                        @if (app()->getLocale() === 'bn')
							গ্রেড
						@else
							Grade
						@endif
                        </th>
                        <th>
                            {{ trans('cruds.employeePromotion.fields.go_issue_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeePromotion.fields.office_order_date') }}
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
            @can('employee_promotion_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.employee-promotions.massDestroy') }}",
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
                ajax: "{{ route('admin.employee-promotions.index') }}",
                columns: [{
                        data: 'placeholder',
                        name: 'placeholder'
                    },
                    {
                        data: 'employee_employeeid',
                        name: 'employee.employeeid'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'new_designation_name_bn',
                        name: 'new_designation.name_bn'
                    },
					{
                        data: 'grade_bn',
                        name: 'grade_bn'
                    },
                    {
                        data: 'memo_date',
                        name: 'memo_date'
                    },
                    {
                        data: 'memo_number',
                        name: 'memo_number'
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
            let table = $('.datatable-EmployeePromotion').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        });
    </script>
@endsection
