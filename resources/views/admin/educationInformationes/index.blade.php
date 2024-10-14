@extends('layouts.admin')
@section('content')
    {{-- @can('education_informatione_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.education-informationes.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.educationInformatione.title_singular') }}
            </a>
        </div>
    </div>
@endcan --}}
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.educationInformatione.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table
                class="table-bordered table-striped table-hover ajaxTable datatable datatable-EducationInformatione table">
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
                            {{ trans('cruds.educationInformatione.fields.exam_degree') }}
                        </th>
                        <th>
                            {{ trans('cruds.educationInformatione.fields.name_of_exam') }}
                        </th>
						<th>
                            {{ trans('cruds.educationInformatione.fields.school_university_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.educationInformatione.fields.exam_board') }}
                        </th>
                        <th>
                            {{ trans('cruds.educationInformatione.fields.concentration_major_group') }}
                        </th>
                        
                        
						
                        <th>
                            @if(app()->getLocale() === 'bn')
								পাস করার সাল
							@else
								Passing Year
							@endif
                        </th>
						<th>
                            জিপিএ
                        </th>
                        <th>
                            {{ trans('cruds.educationInformatione.fields.result') }}
                        </th>
                        
                        
                        <th>
                            {{ trans('cruds.educationInformatione.fields.achivement') }}
                        </th>
                        
                        
                        
                        
						<th>
                            {{ trans('cruds.educationInformatione.fields.catificarte') }}
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
            @can('education_informatione_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.education-informationes.massDestroy') }}",
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
                ajax: "{{ route('admin.education-informationes.index') }}",
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
                        data: 'exam_degree',
                        name: 'exam_degree'
                    },
                    {
                        data: 'name_of_exam_name_bn',
                        name: 'name_of_exam.name_bn'
                    },
					{
                        data: 'school_university_name',
                        name: 'school_university_name'
                    },
                    {
                        data: 'exam_board_name_bn',
                        name: 'exam_board.name_bn'
                    },
                    {
                        data: 'concentration_major_group',
                        name: 'concentration_major_group'
                    },
                    
                   
                    
                    
                    {
                        data: 'passing_year',
                        name: 'passing_year'
                    },
					
                    
					{
                        data: 'cgpa',
                        name: 'cgpa'
                    },
                    {
                        data: 'result_name_bn',
                        name: 'result.name_bn'
                    },
                    
                    {
                        data: 'achivement',
                        name: 'achivement'
                    },
                    
                    {
                        data: 'catificarte',
                        name: 'catificarte',
                        sortable: false,
                        searchable: false
                    },
                    
                    
                    {
                        data: 'actions',
                        name: '{{ trans('global.actions') }}'
                    },
					
                ],
                orderCellsTop: true,
                order: [
                    [2, 'desc']
                ],
                pageLength: 10,
            };
            let table = $('.datatable-EducationInformatione').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        });
    </script>
@endsection
