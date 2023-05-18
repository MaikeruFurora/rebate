<!DOCTYPE html>
<html>
<head>
    <title>arvinintl.com</title>
</head>
<body>
    <h4>New Rebate Request</h4>
    <p>
    There is a new request for rebate waiting for your approval.
    Please see details below:
    </p>
    <table>
        <tr>
            <td>Reference#</td>
            <td>:</td>
            <td>{{ $data->reference }}</td>
        </tr>
        <tr>
            <td>Encoded By</td>
            <td>:</td>
            <td>{{ $data->encodedby ?? '' }}</td>
        </tr>
        <tr>
            <td>Type</td>
            <td>:</td>
            <td>{{ $data->category->catname ?? '' }}</td>
        </tr>
        <tr>
            <td>Amount</td>
            <td>:</td>
            <td>{{ number_format($data->rebateAmount,4) ?? ''}}</td>
        </tr>
        <tr>
            <td>Date</td>
            <td>:</td>
            <td>{{ date("m/d/Y",strtotime($data->created_at)) ?? '' }}</td>
        </tr>
        <tr>
            <td>Reason</td>
            <td>:</td>
            <td>{{ $data->reason ?? '' }}</td>
        </tr>
    </table>

    <p>#This is a system-generated email. Please do not reply.#</p>
</body>
</html>