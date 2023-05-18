<!DOCTYPE html>
<html>

<head>
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
  <style>
     /* body
    {
        background-image:url('https://media.glassdoor.com/sqll/561082/arvin-international-marketing-squarelogo-1637307639526.png');
        background-repeat:repeat-y;
        background-position: center;
        background-attachment:fixed;
        background-size:100%;
    } */
    /* Styles go here */

    .page-header, .page-header-space {
    height: 40px;
    }

    .page-footer, .page-footer-space {
    height: 100px;

    }

    .page-footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    /* border-top: 1px solid black; for demo */
    /* background: yellow; for demo */
    }

    .page-header {
    position: fixed;
    top: 0mm;
    width: 100%;
    border-bottom: 2px solid black; /* for demo */
    /* background: yellow; for demo */
    }

    /* .page {
    page-break-after: always;
    } */

    table.table-bordered{
        border:1.1px solid black;
        margin-top:20px;
    }
    table.table-bordered > thead > tr > th{
        border:1.1px solid black;
    }
    table.table-bordered > tbody > tr > td{
        border:1.1px solid black;
    }

    @page {
    margin: 15mm
    }

    @media print {
    thead {display: table-header-group;} 
    tfoot {display: table-footer-group;}
    
    button {display: none;}
    
    body {margin: 0;}
    }
  </style>
</head>

<body onload="window.print()">

  <div class="page-header" style="text-align: center">
    <h5>REBATE SHEET</h5>
    <br/>
  </div>

  <table style="width: 100%;">

    <thead>
      <tr>
        <td>
          <!--place holder for the fixed-position header-->
          <div class="page-header-space"></div>
        </td>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td>
          <!--*** CONTENT GOES HERE ***-->
          <div class="page content-box">
            
          <div class="row justify-content-between mt-2">
                <div class="col-4">
                    <table class="table table-sm">
                        <tr>
                            <td><b>Category</b></td>
                            <td>{{ $data[0]->catname ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><b>Status</b></td>
                            <td>{{  (empty($start) && empty($end))?'OPEN':(!empty($data->approved_at)?'APPROVED':'CANCELLED') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-4">
                    <table class="table table-sm">
                        <tr>
                            <td><b>Date from</b></td>
                            <td>{{ $start ?? '' }}</td>
                        </tr>
                    
                        <tr>
                            <td><b>Date to</b></td>
                            <td>{{ $end ?? '' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        
            <table class="table table-bordered table-sm" style="font-size: 12px">
                <thead >
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
                    @foreach($data as $key => $value)
                        <tr>
                            <td class="text-center">{{ ++$key }} </td>
                            <td>{{ $value->docdate }} </td>
                            <td>{{ $value->docnum }} </td>
                            <td>{{ $value->cardname }} </td>
                            <!-- <td>{{ $value->reference_1 }} <w -->
                            <td>{{ $value->totalamount }} </td>
                            <td>{{ $value->rebateAmount }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

          </div>
        </td>
      </tr>
    </tbody>

    <tfoot>
      <tr>
        <td>
          <!--place holder for the fixed-position footer-->
          <div class="page-footer-space"></div>
        </td>
      </tr>
    </tfoot>

  </table>

</body>

</html>

