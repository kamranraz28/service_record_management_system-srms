@extends('layouts.admin')
@section('content')
    {{-- @can('job_history_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.job-histories.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.jobHistory.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'JobHistory', 'route' => 'admin.job-histories.parseCsvImport'])
        </div>
    </div>
@endcan --}}
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.jobHistory.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class="table-bordered table-striped table-hover ajaxTable datatable datatable-JobHistory table">
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
                            {{ trans('cruds.jobHistory.fields.designation') }}
                        </th>

						<th>
							@if(app()->getLocale() === 'bn')
								অফিস/ইউনিট
							@else
								Office/Unit
							@endif
						</th>
						<th>
							
							@if(app()->getLocale() === 'bn')
								অফিসের নাম
							@else
								Office Name
							@endif
						</th>
						<th>
							
							@if(app()->getLocale() === 'bn')
								সার্কেল
							@else
								Circle
							@endif
						</th>
						<th>
							
							@if(app()->getLocale() === 'bn')
								ডিভিশন
							@else
								Division
							@endif
						</th>
						<th>
							
							@if(app()->getLocale() === 'bn')
								রেঞ্জ/এসএফএনটিসি
							@else
								Range/SFNTC
							@endif
						</th>
						<th>
							
							@if(app()->getLocale() === 'bn')
								বিট/এসএফপিসি
							@else
								Beat/SFPC
							@endif
						</th>
						<th>
							
							@if(app()->getLocale() === 'bn')
								গ্রেড
							@else
								Grade
							@endif
						</th>
						<th>
							@if(app()->getLocale() === 'bn')
								যোগদানের তারিখ
							@else
								Joining Date
							@endif
						</th>
						<th>
							@if(app()->getLocale() === 'bn')
								অব্যাহতির তারিখ
							@else
								Release Date
							@endif
						</th>
						<th>
							@if(app()->getLocale() === 'bn')
								মন্তব্য
							@else
								Comment
							@endif
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
            @can('job_history_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.job-histories.massDestroy') }}",
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
                ajax: "{{ route('admin.job-histories.index') }}",
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
                        data: 'designation_name_bn',
                        name: 'designation.name_bn'
                    },
					{
                        data: 'office_unit',
                        name: 'office_unit'
                    },
                    {
                        data: 'level_2',
                        name: 'level_2'
                    },
					{
                        data: 'forest_circle',
                        name: 'forest_circle'
                    },
					{
                        data: 'forest_division',
                        name: 'forest_division'
                    },
					{
                        data: 'forest_range',
                        name: 'forest_range'
                    },
					{
                        data: 'forest_beat',
                        name: 'forest_beat'
                    },
					{
                        data: 'grade_name_bn',
                        name: 'grade_name_bn'
                    },
					{
                        data: 'joining_date',
                        name: 'joining_date'
                    },
					{
                        data: 'release_date',
                        name: 'release_date'
                    },
					{
                        data: 'comment',
                        name: 'comment'
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
            let table = $('.datatable-JobHistory').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        });
    </script>
@endsection
