<!DOCTYPE html>
<html>
<head>
    <title>arvinintl.com</title>
</head>
<body>
    <h4>Edit Rebate Request</h4>
    <table style="width:50%">
        <tr>
            <td>Reference #</td>
            <td>&nbsp;:&nbsp;</td>
            <td>{{ $data->reference ?? '' }}</td>
        </tr>
        <tr>
            <td>Docnum</td>
            <td>&nbsp;:&nbsp;</td>
            <td>{{ $data->docnum ?? '' }}</td>
        </tr>
        <tr>
            <td>Amount</td>
            <td>&nbsp;:&nbsp;</td>
            <td>{{ number_format($data->rebateAmount,4) ?? '' }}</td>
        </tr>
        <tr>
            <td>Date</td>
            <td>&nbsp;:&nbsp;</td>
            <td>{{ date('m/d/Y',strtotime($data->created_at)) ?? '' }}</td>
        </tr>
        <tr>
            <td>Reason</td>
            <td>&nbsp;:&nbsp;</td>
            <td>{{ $data->reason ?? '' }}</td>
        </tr>
        <tr>
            <td>Reject remarks</td>
            <td>&nbsp;:&nbsp;</td>
            <td>{{ $data->rejectremarks ?? '' }}</td>
        </tr>
    </table>
    <p>#This is a system-generated email. Please do not reply.#</p>
</body>
</html>