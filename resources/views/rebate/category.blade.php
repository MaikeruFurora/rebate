@extends('./layout/app')
@section('moreCss')
    <!-- DataTables -->
    <link href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/fixedHeader.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/datatables/scroller.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        label{
            font-size: 12px;
        }
    </style>
@endsection
@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row justify-content-between">
                <div class="col-md-4">
                    <h4 class="page-title m-0">CATEGORY</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-md-8">
        <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <!-- dt-responsive nowrap -->
              <table id="datatable" class="table table-striped table-bordered" style="border-collapse: collapse; width: 100%;">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Placeholder</th>
                            <th>Code</th>
                            <th>Depend On Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
              </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="card">
            <div class="card-body">
                <form id="formCategory" autocomplete="off">@csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="catname" required class="form-control" maxlength="45">
                        <input type="hidden" name="id">
                    </div>
                    <div class="form-row">
                            <div class="form-group col-6">
                                <label>Code</label>
                                <input type="text" name="code" class="form-control" maxlength="45">
                            </div>
                            <div class="form-group col-6">
                                <label>Placeholder</label>
                                <input type="text" name="placeholder" class="form-control" maxlength="45">
                            </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="depOnAmount" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Depend on Amount
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="catstatus" id="defaultCheck2">
                                <label class="form-check-label" for="defaultCheck2">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>
                   
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-warning">Cancel</button>
                </form>
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

        let catname     = $("input[name=catname]")
        let depOnAmount  = $("input[name=depOnAmount]")
        let id          = $("input[name=id]")
        let btnCancel   = $(".btn-warning")

        btnCancel.hide()

        let tableCategory = $("#datatable").DataTable({
            "serverSide": true,
                // pageLength: 5,
                paging:true,
                "ajax": {
                    url: "category/list", 
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
                        orderable: false,
                        data:"catname"
                    },
                    {   
                         orderable: false,
                         data:'placeholder',
                    },
                    {   
                         orderable: false,
                         data:"code"
                    },
                    {   
                         orderable: false,
                         data:null,
                         render:function(data){
                            return data.depOnAmount==1 ? 'Yes' : 'No'
                         }
                    },
                    {   
                         orderable: false,
                         data:null,
                         render:function(data){
                            return data.catstatus==1 ? 'Active' : 'Inactive'
                         }
                    },
                    {   
                         orderable: false,
                         data:null,
                         render:function(data){
                            return `<button class="btn btn-sm btn-primary btnEdit">Edit</button>`
                         }
                    },
                   
                ]
        })
        

        $("#formCategory").on('submit',function(e){
            e.preventDefault();
            $.ajax({
            url:`category/store`,
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend:function(){
                $("#formCategory *").prop("disabled", true);
            }
            }).done(function(data){
                tableCategory.ajax.reload()
                btnCancel.hide()
                $("input[name='id']").val('')
                $("#formCategory")[0].reset()
                $("#formCategory *").prop("disabled", false);
            }).fail(function (jqxHR, textStatus, errorThrown) {
                $("#formCategory *").prop("disabled", false);
                console.log(errorThrown);
            })
        })

        $(document).on('click','.btnEdit',function(){
            btnCancel.show()
            let data = tableCategory.row($(this).closest('tr')).data();
            console.log(data[Object.keys(data)[2]]);
            $("input[name='id']").val(data[Object.keys(data)[0]])
            $("input[name='catname']").val(data[Object.keys(data)[1]])
            $("input[name='depOnAmount']").prop('checked',data[Object.keys(data)[2]]==1)
            $("input[name='catstatus']").prop('checked',data[Object.keys(data)[2]]==1)
            $("input[name='placeholder']").val(data[Object.keys(data)[4]])
            $("input[name='code']").val(data[Object.keys(data)[5]])
        })

        btnCancel.on('click',function(){
            btnCancel.hide()
            $("#formCategory")[0].reset()
        })

        

    </script>
@endsection