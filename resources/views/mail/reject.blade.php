<!DOCTYPE html>
<html>
<head>
    <title>arvinintl.com</title>
</head>
<body>
    <h4>Reject Rebate Request</h4>
    <p>We are sorry to inform you that your request for rebate has been rejected. See below notes for rejection:</p>
    @if(count($data)>=2)
    <table>
            <tr>
                <td style="text-align:center">Date rejected</td>
                <td style="text-align:center">:</td>
                <td style="text-align:center">{{ date("m/d/Y") }}</td>
            </tr>
        </table><br>
        <table border="1" style="width:50%">
            <thead>
                <tr>
                    <td style="text-align:center">Reference</td>
                    <td style="text-align:center">Amount</td>
                    <td>Reject Remarks</td>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $value)
                    <tr>
                        <td style="text-align:center">{{ $value->reference }}</td>
                        <td style="text-align:center">{{ $value->rebateAmount }}</td>
                        <td>{{ $value->rejectremarks }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
    <table style="width:50%">
        <tr>
            <td>Reference #</td>
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
            <td>Reject Remarks</td>
            <td>&nbsp;:&nbsp;</td>
            <td>{{ $data[0]->rejectremarks ?? '' }}</td>
        </tr>
    </table>
    @endif
    <p>#This is a system-generated email. Please do not reply.#</p>
</body>
</html>