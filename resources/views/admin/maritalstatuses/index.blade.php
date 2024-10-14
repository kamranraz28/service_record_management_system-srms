@extends('layouts.admin')
@section('content')
    @can('maritalstatus_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.maritalstatuses.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.maritalstatus.title_singular') }}
                </a>
                {{-- <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Maritalstatus', 'route' => 'admin.maritalstatuses.parseCsvImport']) --}}

            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.maritalstatus.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class="table-bordered table-striped table-hover ajaxTable datatable datatable-Maritalstatus table">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.maritalstatus.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.maritalstatus.fields.name_en') }}
                        </th>
                        <th>
                            {{ trans('cruds.maritalstatus.fields.value') }}
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

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.maritalstatuses.index') }}",
                columns: [{
                        data: 'placeholder',
                        name: 'placeholder'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'name_en',
                        name: 'name_en'
                    },
                    {
                        data: 'value',
                        name: 'value'
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
            let table = $('.datatable-Maritalstatus').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        });
    </script>
@endsection
