<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>
    <!--favicon-->
    <link rel="icon" href="{{ asset('assets/images/favicon-32x32.png') }}" type="image/png">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <!--=====-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet" />
    <link href="https://unpkg.com/@coreui/coreui@3.2/dist/css/coreui.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/css/perfect-scrollbar.min.css"
        rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />


    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/metismenu/metisMenu.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/metismenu/mm-vertical.css') }}">
    <!--bootstrap css-->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
    <!--main css-->
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/dark-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/semi-dark.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bordered-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet">
    <style>
        /* .dropzone {
            min-height: 40px !important;
            padding: 7px;
            background-color: #00662545;
            border: gainsboro;
            border-radius: 5px;
        } */

        .c-sidebar .c-sidebar-nav-dropdown.c-show .c-sidebar-nav-dropdown-toggle,
        .c-sidebar .c-sidebar-nav-dropdown.c-show .c-sidebar-nav-link {
            color: #f0fdf4;
        }

        .dropzone {
            min-height: 40px !important;
            padding: 7px;
            background-color: #dcfce7;
            border: #14532d;
            border-radius: 5px;
        }


        .dropzone .dz-message {
            margin: 0px;
        }

        .dropzone .dz-preview {
            position: relative;
            display: inline-block;
            vertical-align: top;
            margin: 0px 4px;
            min-height: 39px;
            width: 98%;
        }

        .dropzone .dz-preview .dz-details {
            padding: 0px !important;
        }

        .dropzone .dz-preview .dz-details {
            z-index: 1;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            font-size: 14px;
            min-width: unset;
            max-width: unset;
            padding: 0;
            text-align: center;
            color: rgba(0, 0, 0, 0.9);
            line-height: 150%;
        }

        .dropzone .dz-preview .dz-details .dz-size {
            margin: 0px;
        }

        .c-app {
            background: rgb(221, 255, 230) !important;
            background: radial-gradient(circle, rgb(113 163 107 / 21%) 0%, rgb(84 148 65 / 0%) 100%) !important;
        }

        /* ul.c-sidebar-nav.ps {
            background: #006625 !important;
        } */

        ul.c-sidebar-nav.ps {
            background: #006625 !important;
        }

        .btn-success {
            --bs-btn-color: #fff;
            --bs-btn-bg: #006625;
            --bs-btn-border-color: #006625;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #006625;
            --bs-btn-hover-border-color: #006625;
            --bs-btn-focus-shadow-rgb: 60, 153, 110;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #006625;
            --bs-btn-active-border-color: #006625;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #fff;
            --bs-btn-disabled-bg: #006625;
            --bs-btn-disabled-border-color: #198754;
        }

        .btn-outline-success {
            --bs-btn-color: #006625;
            --bs-btn-border-color: #006625;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #006625;
            --bs-btn-hover-border-color: #006625;
            --bs-btn-focus-shadow-rgb: 25, 135, 84;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #006625;
            --bs-btn-active-border-color: #006625;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #006625;
            --bs-btn-disabled-bg: transparent;
            --bs-btn-disabled-border-color: #006625;
            --bs-gradient: none;
        }

        .progress-bar {
            background-color: #006625;

        }

        .c-sidebar .c-sidebar-brand,
        .c-sidebar .c-sidebar-header {
            background: #f5f5f5 !important;
        }

        .c-sidebar .c-sidebar-nav-dropdown.c-show .c-sidebar-nav-dropdown-toggle,
        .c-sidebar .c-sidebar-nav-dropdown.c-show .c-sidebar-nav-link {
            color: #fff;
        }

        .c-sidebar .c-sidebar-nav-dropdown-toggle:hover,
        .c-sidebar .c-sidebar-nav-link:hover {
            background: #0d3f01d6 !important;
        }

        .border-secondary {
            border-color: rgb(108 117 125 / 14%) !important;
        }

        /* a.nav-link.c-active {
            font-weight: bold;
            color: #006625;
            border-color: #3d763e !important;
        } */
        .active>.page-link,
        .page-link.active,
        .c-sidebar .c-sidebar-nav-dropdown-toggle:hover,
        .c-sidebar .c-sidebar-nav-link:hover {
            background: #0d3f01d6 !important;
        }

        a.nav-link:hover,
        a.nav-link {
            border-left: 1px solid #d2d2d2;
            margin-bottom: 1px;
            padding: 6px 12px;
            margin-bottom: 0px;
            border-radius: 0 !important;
            /* border-bottom: 1px dashed #d1e3d1; */

            /*font-size: 12px; */
        }

        .buttons-pdf,
        .buttons-copy,
        .buttons-print,
        .buttons-csv {
            display: none;
        }

        .pagination a {
            font-size: 14px;
            /* Adjust the font size as needed */
        }

        .btn-danger {
            --bs-btn-color: #fff;
            --bs-btn-bg: #ad0505;
            --bs-btn-border-color: #ad0505;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #f34a4a;
            --bs-btn-hover-border-color: #ad0505ab;
            --bs-btn-focus-shadow-rgb: 225, 83, 97;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #ad0505;
            --bs-btn-active-border-color: #ad0505;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #fff;
            --bs-btn-disabled-bg: #ad0505;
            --bs-btn-disabled-border-color: #ad0505;
        }

        .btn-primary {
            --bs-btn-color: #fff;
            --bs-btn-bg: #006625;
            --bs-btn-border-color: #006625;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #006625;
            --bs-btn-hover-border-color: #006625;
            --bs-btn-focus-shadow-rgb: 49, 132, 253;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #006625;
            --bs-btn-active-border-color: #006625;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #fff;
            --bs-btn-disabled-bg: #006625;
            --bs-btn-disabled-border-color: #006625;
        }
    </style>
    @yield('styles')
    @stack('css')
    <style>
        html,
        body,
        div {
            font-size: 14px;
        }

        .table th:last-child,
        .table td:last-child {
            text-align: right;
        }


        a.btn.buttons-select-none.btn-primary.disabled,
        a.btn.buttons-select-all.btn-primary {
            background-color: #fff;
            color: #000;
            border: 0;
            font-size: inherit;
        }

        .dt-buttons a {
            padding: 1px 10px;
            border: 0px solid #d5d4d2 !important;
        }

        .mycustommenu .c-active {
            background: #dcfce7;
            color: #15803d;
        }

        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin-top: 0;
            margin-bottom: .5rem;
            font-weight: 900;
            line-height: 1.2;
            color: #052e16 !important;
        }

        div#v-pills-tabContent strong {
            font-size: 22px;
            font-weight: 900;
            color: #052e16;
        }

        label {
            display: inline-block;
            color: #052e16;
        }

        body {
            font-family: 'solaimanlipi', sans-serif;
        }

        .dz-filename {
            display: none;
        }

        .dropzone .dz-preview .dz-image {
            height: 39px;
            position: absolute;
            border-radius: 0;
        }

        .dropzone .dz-preview .dz-image img {
    height: 36px;
}
    </style>
    {{-- <link rel="stylesheet" href="styles.css" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="styles.css">
    </noscript> --}}

    @livewireStyles
</head>

<body class="c-app">
    @include('partials.menu')
    <div class="c-wrapper">
        <header class="c-header c-header-fixed px-3">
            <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar"
                data-class="c-sidebar-show">
                <i class="fas fa-fw fa-bars"></i>
            </button>

            <a class="c-header-brand d-lg-none" href="#">


                <img src="{{ asset('assets/images/logo1.png') }}" height="40" alt="Logo" />

            </a>

            <button class="c-header-toggler mfs-3 d-md-down-none" type="button" responsive="true">
                <i class="fas fa-fw fa-bars"></i>
            </button>

            <ul class="c-header-nav ml-auto">
                <li>{{ app()->getLocale() === 'bn' ? Auth::user()->name : Auth::user()->name_en }}
                </li>

                @if (app()->getLocale() === 'bn')
                    <li><a href="{{ request()->fullUrlWithQuery(['change_language' => 'en']) }}"
                            class="btn btn-sm btn-success mx-2">
                            English
                        </a></li>
                @else
                    <li><a href="{{ request()->fullUrlWithQuery(['change_language' => 'bn']) }}"
                            class="btn btn-sm btn-success mx-2">
                            বাংলা
                        </a></li>
                @endif




            </ul>
        </header>

        <div class="c-body">
            <main class="c-main">


                <div class="container-fluid">
                    @if (session('message'))
                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                            </div>
                        </div>
                    @endif
                    @if (session('status'))
                        <div class="alert alert-border-success alert-dismissible fade show bg-white">
                            <div class="d-flex align-items-center">
                                <div class="font-35 text-success"><span
                                        class="material-icons-outlined fs-2">check_circle</span>
                                </div>
                                <div class="ms-3">
                                    <h6 class="text-success mb-0">

                                        @if (app()->getLocale() === 'bn')
                                            অভিনন্দন !!
                                        @else
                                            Congratulations !!
                                        @endif
                                    </h6>
                                    <div class="">{{ session('status') }}</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if ($errors->count() > 0)
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @yield('content')

                </div>


            </main>
            <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
    <script src="https://unpkg.com/@coreui/coreui@3.2/dist/js/coreui.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        $(function() {
            let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
            let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
            let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
            let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
            let printButtonTrans = '{{ trans('global.datatables.print') }}'
            let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'
            let selectAllButtonTrans = '{{ trans('global.select_all') }}'
            let selectNoneButtonTrans = '{{ trans('global.deselect_all') }}'

            let languages = {
                'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json',
                'bn': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Bangla.json'
            };

            $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {
                className: 'btn'
            })
            $.extend(true, $.fn.dataTable.defaults, {
                language: {
                    url: languages['{{ app()->getLocale() }}']
                },
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0
                }, {
                    orderable: false,
                    searchable: false,
                    targets: -1
                }],
                select: {
                    style: 'multi+shift',
                    selector: 'td:first-child'
                },
                order: [],
                scrollX: true,
                pageLength: 100,
                dom: 'lBfrtip<"actions">',
                buttons: [{
                        extend: 'selectAll',
                        className: 'btn-primary',
                        text: selectAllButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        },
                        action: function(e, dt) {
                            e.preventDefault()
                            dt.rows().deselect();
                            dt.rows({
                                search: 'applied'
                            }).select();
                        }
                    },
                    {
                        extend: 'selectNone',
                        className: 'btn-primary',
                        text: selectNoneButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'copy',
                        className: 'btn-default',
                        text: copyButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        className: 'btn-default',
                        text: csvButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn-default',
                        text: excelButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn-default',
                        text: pdfButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn-default',
                        text: printButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        className: 'btn-default',
                        text: colvisButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            });

            $.fn.dataTable.ext.classes.sPageButton = '';
        });



        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5'
            });
        });
    </script>
    @yield('scripts')
    @livewireScripts
</body>

</html>
