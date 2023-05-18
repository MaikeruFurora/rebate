<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <title>Document</title>
</head>
<body onload="window.print()">
    @foreach($data as $category)
    <h5>{{ $category->catname }}</h6>
    <table class="table table-bordered table-sm" style="font-size: 12px;">
        <thead>
            <tr>
                <th class="text-center">No.</th>
                <th>Doc Date</th>
                <th>Doc Num</th>
                <th>Name</th>
                <!-- <th>Reference1</th>
                <th>Reference2</th>
                <th>Detail1</th>
                <th>Detail2</th> -->
                <th>Total Amount</th>
                <th>Rebate Amount</th>
                <th>EncodedBy</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($category->header as $key => $value)
                <tr>
                    <td class="text-center">{{ ++$key }} </td>
                    <td class="table-primary">{{ $value->docdate }} </td>
                    <td>{{ $value->docnum }} </td>
                    <td>{{ $value->cardname }} </td>
                    <td>{{ number_format($value->totalamount,4) }} </td>
                    <td>{{ number_format($value->rebateAmount,4) }} </td>
                    <td>{{ $value->encodedby }} </td>
                    <td>
                        @if(!empty($value->approved_at) && empty($value->cancelled_at) && empty($value->rejected_at))
                            Approved
                        @elseif(!empty($value->rejected_at) && empty($value->cancelled_at) && empty($value->approved_at))
                            Rejected
                        @elseif(!empty($value->cancelled_at) && empty($value->rejected_at) && empty($value->approved_at))
                            Cancelled
                        @else
                            Open / Pending
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                   <td colspan="7" class="text-center">No data available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @endforeach
</body>
</html>