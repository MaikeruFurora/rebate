@extends('./layout/app')
@section('moreCss')
<style>
    label{
        /* font-size: 12px; */
    }
</style>
<!-- Sweet Alert -->
<link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css">
  
@endsection
@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row justify-content-between">
                <div class="col-md-4">
                    <h4 class="page-title m-0">REBATE ENTRY</h4>
                </div>
                <div class="col-md-5">
                    <form id="searchInvoice">@csrf
                        <div class="input-group">
                            <select name="category" class="form-control bg-white" required>
                                    <option value="" selected disabled>Select Type</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" id="{{$category}}">{{ $category->catname }}</option>
                                @endforeach
                            </select>
                            <input type="text" class="form-control bg-white" placeholder="Please Select" name="search" required autocomplete="off" maxlength="10">
                            <div class="input-group-append">
                                <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i> Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card" id="mainCard">
    <div class="card-body">
        <form id="storeRebateForm" autocomplete="off">@csrf
       <div class="row">
            <div class="col-lg-7">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-info-circle"></i> Details</button>
                      <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-history"></i> Transaction History</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active p-4" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="">Doc Number</label>
                            <input type="text" class="form-control" name="docnum" readonly >
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Doc Date</label>
                            <input type="text" class="form-control" name="docdate" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Doc status</label>
                            <input type="text" class="form-control" name="docstatus" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        
                        <div class="form-group col-md-4">
                            <label for="">Reference 1</label>
                            <input type="text" class="form-control" name="reference_1" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Reference 2</label>
                            <input type="text" class="form-control" name="reference_2" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="cardname" readonly>
                        </div>
                        
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="">Detail 1</label>
                            <input type="text" class="form-control" name="detail_1" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Detail 2</label>
                            <input type="text" class="form-control" name="detail_2" readonly >
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Total Amount</label>
                            <input type="text" class="form-control" name="totalamount" readonly>
                        </div>
                        
                    </div>   
                    <div class="form-group">
                        <label for="my-textarea">Comment</label>
                        <textarea id="my-textarea" class="form-control" name="comments" readonly rows="4" placeholder="" required></textarea>
                    </div>
                    <table class="table table-bordered table-sm" style="font-size: 12px;">
                        <thead class="table-primary">
                            <tr>
                                <td>Item Description</td>
                                <td>Item Code</td>
                                <td>Quantity</td>
                                <td>Price</td>
                                <td>LineTotal</td>
                            </tr>
                        </thead>
                        <tbody class="tbl-details">
                            <tr>
                                <td colspan="5" class="text-center">No data available</td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
                <div class="tab-pane fade p-3" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="font-size: 12px;">
                            <thead class="table-primary">
                                <tr>
                                    <td>Docnum</td>
                                    <td>RebateAmount</td>
                                    <td>EncodedBy</td>
                                    <td>Transaction Date</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody class="tbl-header">
                                <tr>
                                    <td colspan="5" class="text-center">
                                        No data available
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total Rebate Amount</td>
                                    <td colspan="4" class="totalRebateAmount">0</td>
                                </tr>
                                <tr style="display:none">
                                    <td>Total Amount</td>
                                    <td colspan="4" class="orginalTotalAmount">0</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card mt-5">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="">Rebate Amount</label>
                                <input type="text" class="form-control" name="rebateAmount" required maxlength="20" onpaste="return false;">
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="">Reference</label>
                                <input type="text" class="form-control" name="reference" required readonly>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="">Client Name</label>
                            <input type="text" name="clientname" class="form-control form-control-sm" placeholder="" required maxlength="50" />
                            <span id="clientnameList" style="position: absolute;  border: 1px solid #d4d4d4; border-bottom: none; border-top: none; z-index: 99;"></span>
                        </div>
                        <div class="form-group">
                            <label for="my-textarea">Reason</label>
                            <textarea id="my-textarea" class="form-control" name="reason" rows="5" placeholder="Type here" required onkeyup="BaseModel.countChar(this)" maxlength="500"></textarea>
                            <span class="text-muted"><span class="showCountChar">0</span>/500</span>
                        </div>
                        <div class="form-group">
                            <label for="">Rebate Balance</label>
                            <input type="text" class="form-control" name="rebateBalance" readonly>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">Submit</button>
                    </div>
                </div>
            </div>
       </div>
    </form>
    </div>
</div>


@endsection

@section('moreJs')
    <script src="{{  asset('assets/plugins/jquery-number/jquery.number.js') }} "></script>
    <!-- Sweet-Alert  -->
    <script src="{{  asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{  asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{  asset('assets/js/dashboard.js') }}"></script>
@endsection