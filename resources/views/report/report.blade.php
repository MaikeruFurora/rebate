@extends('./layout/app')
@section('moreCss')
    <!-- DataTables -->
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
@endsection
@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row justify-content-between">
                <div class="col-md-4">
                    <h4 class="page-title m-0">Report</h4>
                </div>
                <div class="col-md-7">
                    <form id="formReport" autocomplete="off">@csrf
                        <div class="input-group">
                            <select name="category" class="form-control bg-white" required>
                                    <option value="" selected disabled>Select Type</option>
                                    <option value="all">All</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" id="{{$category}}">{{ $category->catname }}</option>
                                @endforeach
                            </select>
                            <select name="status" class="form-control bg-white" required>
                                    <option value="" selected disabled>Select Status</option>
                                    <option value="open">Open</option>
                                    <option value="approved">Approved</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="rejected">Rejected</option>
                            </select>
                            <input type="text" class="form-control bg-white datepicker" placeholder="Date from" name="start">
                            <input type="text" class="form-control bg-white datepicker" placeholder="Date to" name="end">
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

<div class="row">
   <div class="col-12">
        <div class="card">
            <div class="card-header"><button style="font-size:12px" class="btn btn-warning btn-sm" id="print">Print&nbsp;<i class="fas fa-print"></i></button></div>
            <div class="card-body pb-2">
                <!-- <div id="table-scroll" class="table-scroll"> id="main-table"  main-table -->
                <table  class=" table table-sm table-bordered" style="font-size: 11px;">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Doc Date</th>
                            <th>Doc Num</th>
                            <th>Name</th>
                            <!-- <th>Reference1</th>
                            <th>Reference2</th>
                            <th>Detail1</th>
                            <th>Detail2</th> -->
                            <th>Total Amount</th>
                            <th>Rebate Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="10" class="text-center">No Data Available</td>
                        </tr>
                    </tbody>
                </table>
                <!-- </div> -->
            </div>
        </div>
   </div>
</div> <!-- end container-fluid -->
@endsection

@section('moreJs')

<script>
    const print = $('button[id="print"]');
    print.hide()
    $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true
    });

    


    $("select[name=category]").on('change',function(){
        // if($(this).val()==='all'){
        //     print.show()
        //     $(".btn-outline-success").hide()
        // }else{
        //     $(".btn-outline-success").show()
        //     print.hide()   
        // }
        $("select[name=status]").prop("required",($(this).val()=="all")).prop("selectedIndex", 0).val();
        $("input[name=start]").val('')
        $("input[name=end]").val('')
    })

    $("select[name=status]").on('change',function(){
        // $("input[name=start]").prop('disabled',($(this).val()=="open")).val('')
        // $("input[name=end]").prop('disabled',($(this).val()=="open")).val('')
    })

    // <td>${element.reference_1 ?? ''}</td>
    // <td>${element.reference_2 ?? ''}</td>
    // <td>${element.detail_1 ?? ''}</td>
    // <td>${element.detail_2 ?? ''}</td>
    const tableResult = (data) =>{
            let _holdHTML=''
            if (data.length>0) {
                data.forEach((element,i) => {
                    _holdHTML+=`
                    <tr>
                    <td>${ ++i }</td>
                    <td>${element.docdate ?? ''}</td>
                    <td>${element.docnum ?? ''}</td>
                    <td>${element.cardname ?? ''}</td>
                   
                    <td>${element.totalamount ?? ''}</td>
                    <td>${element.rebateAmount ?? ''}</td>
                    </tr>
                    `
                });
            }else{
                _holdHTML=` <tr><td colspan="10" class="text-center">No Data Available</td></tr>`
            }
                $("tbody").html(_holdHTML)
        }
    $("#formReport").on('submit',function(e){
            e.preventDefault();
            $.ajax({
            url:`report/list`,
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend:function(){
                $("#formReport *").prop("disabled", true);
            }
            }).done(function(data){
                // (data.length>0) ? print.show() : print.hide()
                print.show()
                tableResult(data)
                $("#formReport *").prop("disabled", false);
            }).fail(function (jqxHR, textStatus, errorThrown) {
                $("#formReport *").prop("disabled", false);
                console.log(errorThrown);
            })
        })

    $('#print').on('click',function(){
        
        let url_string = "report/print";
        let start      = $("input[name='start']").val()
        let end        = $("input[name='end']").val()
        let category   = $("select[name='category']").val()
        let status   = $("select[name='status']").val()
        let _token     = BaseModel._token
        let adsURL     = url_string+"?_token="+_token+"&start="+start+"&end="+end+"&category="+category+"&status="+status;
        
        BaseModel.loadToPrint(adsURL)
    
    })
</script>
@endsection