@extends('./layout/app')
@section('moreCss')
    <!-- DataTables -->
    <link href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/fixedHeader.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/datatables/scroller.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.css') }}" rel="stylesheet" type="text/css">
    <style>
        label{
            font-size: 12px;
        }
        .highlight-approved{
            background-color: #ECFCD8;
        }
        .highlight-cacelled{
            background-color: #D6D4D4;
        }
        .highlight-rejected{
            background-color: #FCDCD8;
        }
    </style>
@endsection
@section('content')

<!-- Page-Title -->
{{-- <div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row justify-content-between">
                <div class="col-md-4">
                    <h4 class="page-title mb-0">Approval</h4>
                </div>
                <div class="col-md-3">
                   <div class="float-right justify-content-between">
                        <button type="button" style="font-size: 11px;" class="btn btn-sm btn-primary btn-approve">
                            <i class="fas fa-check "></i>&nbsp;Approve&nbsp;
                        </button>
                        <button type="button" style="font-size: 11px;" class="btn btn-sm btn-danger btn-cancel">
                            <i class="fas fa-times "></i>&nbsp;&nbsp;Cancel&nbsp;&nbsp;
                        </button>
                        <button type="button" style="font-size: 11px;" class="btn btn-sm btn-warning btn-reject">
                            <i class="fas fa-times "></i>&nbsp;&nbsp;Reject&nbsp;&nbsp;
                        </button>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="row">
        <div class="col-12 mt-4">
            <div class="@if(in_array(auth()->user()->Position_id,[177,185,186])) col-12 @else col-5 @endif">
                <div class="input-group border">
                    @if (in_array(auth()->user()->Position_id,[177,185,186]))
                        <select name="category" id="" class="form-control">
                            <option value="">No Category</option>
                            @foreach($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->catname }}</option>
                            @endforeach
                        </select>
                        <input type="text" value="" class="form-control typeahead  border" name="clientname" autocomplete="off">
                    @else
                        <select name="status" id="" class="form-control">
                            <option value="all">All Status</option>
                            <option value="O">Pending/Open</option>
                            <option value="A">Approved</option>
                            <option value="R">Rejected</option>
                            <option value="C">Cancelled</option>
                        </select>
                    @endif
                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control border" name="from">
                    <input type="date" value="{{ date('Y-m-d') }}" class="form-control border" name="to">
                    <button class="btn btn-primary" id="filter">Filter</button>
                </div>
            </div>
          <div class="card mt-4">
            <div class="card-header">
                
                <div class="float-right justify-content-between">
                        <button type="button" style="font-size: 11px;" class="btn btn-sm btn-primary btn-approve">
                            <i class="fas fa-check "></i>&nbsp;Approve&nbsp;
                        </button>
                        <button type="button" style="font-size: 11px;" class="btn btn-sm btn-danger btn-cancel">
                            <i class="fas fa-times "></i>&nbsp;&nbsp;Cancel&nbsp;&nbsp;
                        </button>
                        <button type="button" style="font-size: 11px;" class="btn btn-sm btn-warning btn-reject">
                            <i class="fas fa-times "></i>&nbsp;&nbsp;Reject&nbsp;&nbsp;
                        </button>
                </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <!-- dt-responsive nowrap -->
                    <table id="datatable" class="table table-bordered" style="border-collapse: collapse; width: 100%;font-size:11px">
                        <thead class="table-dark">
                            <tr style="font-size:11px">
                                {{-- <td>&nbsp;</td> --}}
                                <td>&nbsp;</td>
                                <td width="15%">Category</td>
                                <td>DocDate</td>
                                {{-- <td>TotalAmount</td> --}}
                                <td>Client Name</td>
                                <td>EncodedBy</td>
                                <td>RebateAmount</td>
                                <td>Rebate Bal</td>
                                <td>Reference</td>
                                <td>Reason</td>
                                <td>SeriesCode</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
              </div>
            </div>
        </div>
    </div>
</div> <!-- end container-fluid -->
<x-modal-form></x-modal-form>
<x-credit-memo></x-credit-memo>
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
    <script src="{{  asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{  asset('assets/plugins/jquery-number/jquery.number.js') }} "></script>
    <script src="{{  asset('assets/plugins/datatables/dataTables.responsive.min.js') }} "></script>
    <script src="{{  asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }} "></script>
    <script src="{{  asset('assets/js/approval.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script>
         $('input.typeahead').typeahead({
            source:  function (query, process) {
            return $.get('approval/details/search/client-name', { query: query }, function (data) {
                    return process(data);
                });
            }
        });
    </script>
@endsection