@extends('./layout/app')

@section('moreCss')
<!-- DataTables -->
<link href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/datatables/fixedHeader.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/plugins/datatables/scroller.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">USER ACCESS FOR CATEGORY</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
               <div class="row">
                <div class="col-8">
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; width: 100%;">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Category Access</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                   </div>
                   <div class="col-4">
                    @if (session()->has('msg'))
                        <div class="alert alert-{{ session()->get('action') ?? 'success' }}" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> {{ session()->get('msg') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('authenticate.user.access.store') }}" method="POST">@csrf
                                <div class="form-group">
                                    <label for="my-input">Username</label>
                                    <input id="my-input" class="form-control" type="text" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="my-input">Category</label>
                                    <select name="category" class="form-control" id="">
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">{{ $item->catname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </form>
                        </div>
                    </div>
                   </div>
               </div>
            </div>
        </div>
    </div>
</div> <!-- end container-fluid -->
<!-- end container-fluid -->
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $("#datatable").DataTable({
            processing: true,
            language: {
                processing: `
                    <div class="spinner-border spinner-border-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>`,
            },

            ajax: `access/list`,
            columns: [
                {
                    data:"username"
                },
                {
                    data:"catname"
                },
                {
                    data:null,
                    render:function(data){
                        return `<button class="btn btn-sm btn-danger" name="btnRemove" value="${data.id}">Remove</button>`
                        console.log(data);
                    }
                },
            ]
            
        })

        $(document).on('click','button[name=btnRemove]',function(){
            let id = $(this).val()
            let _token = $("input[name=_token]").val()
            $.ajax({
                url:'access/remove',
                type:'post',
                data:{
                    id, _token
                }
            }).done(function(data){
                window.location.reload();
            }).fail(function(a,b,c){
                alert(b)
            })
        })

        $("#datatable1").DataTable()

        $("select[name=partners]").select2();
    </script>
@endsection