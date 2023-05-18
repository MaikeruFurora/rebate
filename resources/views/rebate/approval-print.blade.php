<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
</head>
<body onload="window.print()"> @php
    $i=0;
    @endphp
    @while ($i < 2)
        <h2 class="mt-5"><img src="{{ asset('assets/images/rebate-1.png') }}" class="logo-lg" alt="" height="60"></h2>
        <p>Date: {{ date("d-m-Y") }}</p>
        <table class="table table-sm table-bordered">
            <tr>
                <th width="20%">CATEGORY</th>
                <td>{{ $header->category->catname }}</td>
            </tr>
        
            <tr>
                <th>CLIENT NAME</th>
                <td>{{ $header->clientname }}</td>
            </tr>
            <tr>
                <th>REFERENCE</th>
                <td>{{ $header->docnum }}</td>
            </tr>
            <tr>
                <th>SERIES CODE</th>
                <td>{{ $header->seriescode }}</td>
            </tr>
            <tr>
                <th>DETAIL 1</th>
                <td>{{ $header->detail_1 }}</td>
            </tr>
            <tr>
                <th>DETAIL 2</th>
                <td>{{ $header->detail_2 }}</td>
            </tr>
            <tr>
                <th>TOTAL AMOUNT</th>
                <td>{{ number_format($header->totalamount,4) }}</td>
            </tr>
            <tr>
                <th>REBATE AMOUNT</th>
                <td>{{ number_format($header->rebateAmount,4) }}</td>
            </tr>
            <tr>
                <th>REASON</th>
                <td>{{ $header->reason }}</td>
            </tr>
        </table>
        <div class="col-4">
            APPROVED BY:
            <p class="mt-2" style="border-bottom:1px solid black;font-size:20px;margin-bottom:1px">&nbsp;</p>
        </div>
        <br><br><br>
        <hr>
            @php
            $i++;
            @endphp
        @endwhile

</body>
</html>