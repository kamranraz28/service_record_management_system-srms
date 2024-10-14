@extends('layouts.admin')
@section('content')
    {{-- @can('criminal_prosecutione_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.criminal-prosecutiones.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.criminalProsecutione.title_singular') }}
            </a>
        </div>
    </div>
@endcan --}}
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.criminalProsecutione.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class="table-bordered table-striped table-hover ajaxTable datatable datatable-CriminalProsecutione table">
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
							@if (app()->getLocale() === 'bn')
								মামলার ধরণ
							@else
								Case Type
							@endif
                        </th>
						
						<th>
							@if (app()->getLocale() === 'bn')
								মামলার বর্তমান অবস্থা
							@else
								Case Current Situation
							@endif
                        </th>
						
						<th>
							@if (app()->getLocale() === 'bn')
								মামলা রুজুর তারিখ ও আদেশ নম্বর
							@else
								Case Start Date and Order Number
							@endif
                        </th>
						
						<th>
							@if (app()->getLocale() === 'bn')
								মামলা নিস্পত্তির তারিখ ও আদেশ নম্বর
							@else
								Case End Date and Order Number
							@endif
                        </th>
						<th>
                        @if (app()->getLocale() === 'bn')
                        মন্তব্য
                    @else
                        Comment
                    @endif
                        </th>
                        
                        <!-- <th>
                            {{ trans('cruds.criminalProsecutione.fields.court_order') }}
                        </th> -->
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
            @can('criminal_prosecutione_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.criminal-prosecutiones.massDestroy') }}",
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
                ajax: "{{ route('admin.criminal-prosecutiones.index') }}",
                columns: [{
                        data: 'placeholder',
                        name: 'placeholder'
                    },
                    {
                        data: 'employee_employeeid',
                        name: 'employee.employeeid'
                    },
                    {
                        data: 'employee_fullname_bn',
                        name: 'employee_fullname_bn'
                    },
					
					{
                        data: 'mamla_id',
                        name: 'mamla_id'
                    },
					
					{
                        data: 'situation',
                        name: 'situation'
                    },
					
					{
                        data: 'mamla_start',
                        name: 'mamla_start'
                    },
					
					{
                        data: 'mamla_end',
                        name: 'mamla_end'
                    },
									
                    {
                        data: 'remzrk',
                        name: 'remzrk'
                    },
                    
                    {
                        data: 'actions',
                        name: '{{ trans('global.actions') }}'
                    }
                ],
                orderCellsTop: true,
                order: [
                    [3, 'desc']
                ],
                pageLength: 10,
            };
            let table = $('.datatable-CriminalProsecutione').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        });
    </script>
@endsection
