<!DOCTYPE html>
<html>
<head>
    <title>arvinintl.com</title>
</head>
<body>
    <h4>Approved Rebate Request</h4>
    <p>We are happy to inform you that your request for rebate has been approved.</p>
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
    @else
    <table style="width:50%">
        <tr>
            <td>Reference#</td>
            <td>&nbsp;:&nbsp;</td>
            <td>{{ $data[0]->reference ?? '' }}</td>
        </tr>
        <tr>
            <td>Amount</td>
            <td>&nbsp;:&nbsp;</td>
            <td>{{ number_format($data[0]->rebateAmount,4) ?? '' }}</td>
        </tr>
        <tr>
            <td>Date</td>
            <td>&nbsp;:&nbsp;</td>
            <td>{{ date('m/d/Y',strtotime($data[0]->created_at)) ?? '' }}</td>
        </tr>
        <tr>
            <td>Reason</td>
            <td>&nbsp;:&nbsp;</td>
            <td>{{ $data[0]->reason ?? '' }}</td>
        </tr>
        <!-- <tr>
            <td>Status</td>
            <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
            <td>APPROVED</td>
        </tr> -->
    </table>
    @endif
    <p>#This is a system-generated email. Please do not reply.#</p>
</body>
</html>