<!DOCTYPE html>
<html>
<head>
    <title>arvinintl.com</title>
</head>
<body>
    <h4>Cancelled Request for Rebate</h4>
    <p>We are sorry to inform you that your request for rebate has been cancelled. See below notes for cancellation:</p>
    @if(count($data)>=2)
        <table>
            <tr>
                <td style="text-align:center">Date cancelled</td>
                <td style="text-align:center">:</td>
                <td style="text-align:center">{{ date("m/d/Y") }}</td>
            </tr>
        </table><br>
        <table border="1" style="width:50%">
            <thead>
                <tr>
                    <td style="text-align:center">Reference#</td>
                    <td style="text-align:center">Amount</td>
                    <td>Reason</td>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $value)
                    <tr>
                        <td style="text-align:center">{{ $value->reference }}</td>
                        <td style="text-align:center">{{ $value->rebateAmount }}</td>
                        <td>{{ $value->reason }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p>Reason for cancellation:</p>
        <p>{{ $data[0]->cancelremarks ?? '' }}</p>
    @else
    <table style="width:50%">
        <tr>
            <th>Reference#</th>
            <td>&nbsp;:&nbsp;</td>
            <td>{{ $data[0]->reference ?? '' }}</td>
        </tr>
        <tr>
            <th>Amount</th>
            <td>&nbsp;:&nbsp;</td>
            <td>{{ number_format($data[0]->rebateAmount,4) ?? '' }}</td>
        </tr>
        <tr>
            <th>Date</th>
            <td>&nbsp;:&nbsp;</td>
            <td>{{ date('m/d/Y',strtotime($data[0]->created_at)) ?? '' }}</td>
        </tr>
        <tr>
            <th>Reason</th>
            <td>&nbsp;:&nbsp;</td>
            <td>{{ $data[0]->reason ?? '' }}</td>
        </tr>
        <tr>
            <th>Cancel Remarks</th>
            <td>&nbsp;:&nbsp;</td>
            <td>{{ $data[0]->cancelremarks ?? '' }}</td>
        </tr>
        <!-- <tr>
            <td>Status</td>
            <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
            <td>CANCELLED</td>
        </tr> -->
    </table>

    @endif

    
    <p>#This is a system-generated email. Please do not reply.#</p>
</body>
</html>