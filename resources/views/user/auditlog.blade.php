@extends('./layout/app')

@section('moreCss')
<!-- DataTables -->
<link href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/datatables/fixedHeader.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/plugins/datatables/scroller.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">USER LIST</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                <table cellpadding="0" cellspacing="0" id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;font-size:11px">
                    <thead>
                        <tr>
                            <th>ID(s)</th>
                            <th>Referece No</th>
                            <th>Event</th>
                            <th>Date & Time</th>
                            <th>IP Address</th>
                            <th>Old Value</th>
                            <th>New Value</th>
                            <th>Url</th>
                            <th>User Agent</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('moreJs')
    <!-- Required datatable js-->
    <script src="{{  asset('assets/plugins/datatables/jquery.dataTables.min.js') }} "></script>
    <script src="{{  asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }} "></script>
    <!-- Buttons examples -->
    <script src="{{  asset('assets/plugins/datatables/dataTables.buttons.min.js') }} "></script>
    <script src="{{  asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }} "></script>

    <script src="{{  asset('assets/plugins/datatables/jszip.min.js') }} "></script>
    <script src="{{  asset('assets/plugins/datatables/pdfmake.min.js') }} "></script>
    <script src="{{  asset('assets/plugins/datatables/vfs_fonts.js') }} "></script>
    <script src="{{  asset('assets/plugins/datatables/buttons.html5.min.js') }} "></script>
    <script src="{{  asset('assets/plugins/datatables/buttons.print.min.js') }} "></script>
    <script src="{{  asset('assets/plugins/datatables/dataTables.fixedHeader.min.js') }} "></script>
    <script src="{{  asset('assets/plugins/datatables/dataTables.keyTable.min.js') }} "></script>
    <script src="{{  asset('assets/plugins/datatables/dataTables.scroller.min.js') }} "></script>

    <!-- Responsive examples -->
    <script src="{{  asset('assets/plugins/datatables/dataTables.responsive.min.js') }} "></script>
    <script src="{{  asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }} "></script>

    <script>
        let tableOpenAmount = $('#datatable').DataTable({
                    "serverSide": true,
                    // pageLength: 5,
                    paging:true,
                    "ajax": {
                        url: "audit-log/list", 
                        method: "get"
                    },
                    order: [[0, 'desc']],
                    columns:[
                        {
                            data: "id",
                            target: 0,
                            visible: false,
                            searchable: false
                        },
                      { 
                        orderable:false,
                        data:'auditable_id'
                    },
                    // { 
                    //     orderable:false,
                    //     data:'name'
                    // },
                    { 
                        orderable:false,
                        data:'event'
                    },
                    { 
                        orderable:false,
                        data:'created_at'
                    },
                    { 
                        orderable:false,
                        data:'ip_address'
                    },
                    { 
                        orderable:false,
                        data:'old_values'
                    },
                    { 
                        orderable:false,
                        data:'new_values'
                    },
                    { 
                        orderable:false,
                        data:'url'
                    },
                    { 
                        orderable:false,
                        data:'user_agent'
                    },
                    ]
                });
    </script>
@endsection