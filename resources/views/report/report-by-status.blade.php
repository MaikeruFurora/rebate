<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        @media print{@page {size: landscape}}
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-4 mb-3 mt-3" style="font-size:11px">
            <table>
                <tr>
                    <th>Date Generate:</th>
                    <td>{{ date("F d, Y") }}</td>
                </tr>
                <tr>
                    <th>Date from/to</th>
                    <td>{{ date("m-d-Y",strtotime($dateFrom)) }} / {{ date("m-d-Y",strtotime($dateTo)) }}</td>
                </tr>
                <tr>
                    <th>ALL STATUS</th>
                </tr>
                
            </table>
        </div>
    </div>

    @foreach ($status as $item)
    <h6 style="font-size:12px">{{ $item->statusname }}</h6>
    @php
        $total =  $totalRU = $totalRB = 0;
        $data = DB::select('exec dbo.sp_reportGetHeader ?,?,?,?,?',array(null,'status',$item->status, $dateFrom, $dateTo ));
    @endphp
    @if (count($data)>0)
    <table class="table table-sm table-bordered table-hove" style="font-size:10px">
        <thead >
            <tr>
                <th width="3%">#</th>
                <th width="7%">CREATED`AT</th>
                <th width="8%">APPROVED`AT</th>
                <th width="30%">NAME</th>
                <th width="10%">REFERENCE</th>
                <th width="5%">VOUCHER</th>
                <th width="10%">CATEGORY</th>
                <th width="10%">REBATE AMOUNT</th>
                <th width="10%">REBATE USED</th>
                <th width="10%">REBTE`BAL</th>
            </tr>
        </thead>
        <tbody>
         @forelse ($data as $key => $value)
         <tr>
             <td>{{ ++$key }}</td>
             <td>{{ date("m-d-Y",strtotime($value->created_at)) }}</td>
             <td>{{ (!is_null($value->approved_at)) ? date("m-d-Y",strtotime($value->approved_at)) : '' }}</td>
             <td>{{ $value->clientname ?? 'N/A' }}</td>
             <td>{{ strtoupper($value->reference) }}</td>
             <th>{{ $value->seriescode ?? '-------' }}</th>
             <td>{{ $value->catname }}</td>
             <td>{{ $value->rebateAmount }}</td>
             <td>{{ number_format($value->rebateUsed,4) }}</td>
             <td>{{ ($value->status!='C' && $value->status!='R')?(number_format($value->rebateBalance,4)): number_format(0,4); }}</td>
         </tr>
     @php 
      if ($item->status!='C' && $item->status!='R') {
        $total  +=$value->rebateAmount;
        $totalRU+=$value->rebateUsed;
        $totalRB+=$value->rebateBalance;
      }
     @endphp
     @empty
         <tr>
             <td colspan="10" class="text-center">No data available</td>
         </tr>
     @endforelse
     @php 
        array_push($grandTotal,$total);
        array_push($grandTotalRU,$totalRU);
        array_push($grandTotalRB,$totalRB);
     @endphp
         <tr>
             <th colspan="7" class="text-right">Total</td>
             <th class="text-left">{{ number_format($total,4) }}</th>
             <th class="text-left">{{ number_format($totalRU,4) }}</th>
             <th class="text-left">{{ number_format($totalRB,4) }}</th>
         </tr>
        </tbody>
    </table>
    @endif
    @endforeach

    <table class="table table-sm table-bordered"  style="font-size:10px">
        <tr>
            <th width="70%" colspan="7" class="text-right">Grand Total</th>
            <th width="10%" class="text-center">{{ number_format(array_sum($grandTotal),4) ?? null }}</th>
            <th width="10%" class="text-center">{{ number_format(array_sum($grandTotalRU),4) }}</th>
            <th width="10%" class="text-center">{{ number_format(array_sum($grandTotalRB),4) }}</th>
        </tr>
    </table>
</div>
</body>
</html>