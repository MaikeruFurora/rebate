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
<div class="container-fluid">
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
                    <th>TAGGED REBATE REPORT</th>
                </tr>
                <tr>
                    <th>{{ $category }}</th>
                </tr>
            </table>
        </div>
    </div>
    <table class="table table-sm table-bordered table-hover" style="font-size:10px">
        <thead>
            <tr>
                <th class="text-center" width="3%">#</th>
                <th class="text-center" width="3%">Doc No.</th>
                <th class="text-center" width="5%">DELIVERY DATE</th>
                <th class="text-center" width="5%">REBATE VOUCHER</th>
                <th class="text-center" width="5%">POSTING DATE</th>
                <th width="20%">CLIENT NAME</th>
                <th width="20%">ITEM DESCRIPTION</th>
                @if ($category=="LACKING FROM MIP")
                <th width="20%">INVOICE</th>
                @endif
                <th width="10%">REBATE AMOUNT</th>
                <th width="10%">AMOUNT</th>
                <th width="10%">REBATE`BAL</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($data as $key => $item)
        @php
            $totalRebate = array_sum(array_unique(array_column($item['data'],'rebateAmount')));
            $CreditSum   = array_sum(array_unique(array_column($item['data'],'CreditSum')));
            $rebateBalance = $totalRebate-$CreditSum;
        @endphp
           <tr>
            <th class="text-center">{{ ++$key }}</th>
            <th class="text-center">{{ $item['docnum'] }}</th>
            <th class="text-center">{{ $item['DeliveryDate'] }}</th>
            <th class="text-center">{{ $item['seriescode'] }}</th>
            <th class="text-center" width="8%">{{ $item['dateRebateApplied'] }}</th>
            <th width="20%">{{ $item['clientname'] }}</th>
            <th width="20%">
                @foreach (array_unique(array_column($item['data'],'description')) as $dd)
                    {!!  ((!empty($dd))?$dd.'</br>':'') !!}
                @endforeach
            </th>
            @if ($category=="LACKING FROM MIP")
            <th width="20%">{{ $item['reference_2'] }}</th>
            @endif
            <th width="10%">
                {{ number_format($totalRebate,4) }}
            </th>
            <th width="10%">
               {!! empty($rebateBalance)?'-':  number_format($CreditSum,4) !!}
            </th>
            <th width="10%">
                {!! empty($rebateBalance)?'-':  number_format($rebateBalance,4) !!}
             </th>
           </tr>
           {{-- @endforeach --}}
        @endforeach
       </tbody>
    </table>   
</div>
</body>
</html>