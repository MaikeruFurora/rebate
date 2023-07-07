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
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fullname</th>
                            <th>Active</th>
                            <th>RebateRole</th>
                            <th>Employee ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>User level</th>
                            <th>System</th>
                            <th>DateCreated</th>
                            <th>Warehouse</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div> <!-- end container-fluid -->
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
        $("#datatable").DataTable({
            "serverSide": true,
                // pageLength: 5,
                paging:true,
                "ajax": {
                    url: "user/list", 
                    method: "get"
                },
                order: [[0, 'desc']],
                columns:[
                    {
                        orderable: false,
                        data:"ID",
                        target: 0,
                        visible: false,
                        searchable: false                    },
                    {
                        orderable: false,
                        data:"fullname"
                    },
                    {
                        orderable: false,
                        data:null,
                        render:function(data){
                            return data.Active!=null? `<span class="badge badge-pill text-center badge-${data.Active==1?'success':'info'}">${data.Active==1?'Yes':'No'}</spa>` :''
                        }
                    },
                    {
                        orderable: false,
                        data:null,
                        render:function(data){
                            return `<span class="badge badge-pill text-center badge-info">${data.RebateRole ?? 'None'}</spa>`
                        }
                    },
                    {
                        orderable: false,
                        data:"Employee_id"
                    },
                    {
                        orderable: false,
                        data:"Username"
                    },
                    {
                        orderable: false,
                        data:"Email"
                    },
                    {
                        orderable: false,
                        data:"Userlevel"
                    },
                    {
                        orderable: false,
                        data:"System"
                    },
                    {
                        orderable: false,
                        data:"DateCreated"
                    },
                    {
                        orderable: false,
                        data:"Warehouse"
                    },
                ]
        })
    </script>
@endsection