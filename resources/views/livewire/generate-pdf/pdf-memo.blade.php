<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>{{ $css }}</style>
    <style>
        .watermark {
            position: absolute;
            left: 0px;
            top: 0px;
            z-index: -1;
        }

        .cdo-logo {
            float: left;
        }

        .title {
            font-size: small;
            padding-top: 20px;
            padding-left: 10px;
        }

        .title2 {
            font-size: small;
            padding-left: 10px;
        }

        .title3 {
            padding-top: 15px;
            padding-left: 10px;
            font-weight: bolder;
            text-transform: uppercase;
        }

        .headergoldencdologo {
            float: right;
            position: absolute;
            left: 0px;
            top: 0px;
            z-index: -1;
        }

        .memo-body {
            padding-top: 75px;
            padding-left: 75px;
            padding-right: 75px;
        }

        /* Header part table */
        #header {
            padding-top: 20px;
            font-weight: bolder;
            /* border: 1px solid black; */
        }

        #header th,
        #header td {
            padding-bottom: 25px;
            vertical-align: top;
            /* border: 1px solid black; */
        }

        #header th {
            text-align: left;
            width: 50px;
        }

        #header td {
            text-transform: uppercase;
        }

        /* Memo message table part */
        #message table {
            /* width: 100%; */
            border-collapse: collapse;
            padding-left: 50px;
            padding-right: 50px;
        }

        #message table,
        #message th,
        #message td {
            border: 1px solid black;
        }

        #message th,
        #message td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="watermark">
        <img src="data:image/png;base64,{{ $cdo_logo }}" alt="rise-logo" width="500" />
    </div>

    <div class="cdo-logo">
        <img src="data:image/png;base64,{{ $cdo_logo }}" alt="rise-logo" width="120" />
    </div>

    <div>
        <br>
        <span class="title">
            Republic of the Philippines
        </span>
        <br>
        <span class="title2">
            City of Cagayan de Oro
        </span>
        <br> <br>
        <span class="title3">
            Office of the City Administrator
        </span>
    </div>

    <div class="headergoldencdologo">
        <img src="data:image/png;base64,{{ $headergoldencdologo }}" alt="headergoldencdo-logo" width="200" />
    </div>

    <div class="memo-body">
        <span style="text-transform: uppercase; font-weight: bolder; padding-left: 10px;">Memorandum <br> <span style="padding-left: 10px;">No. ___________</span></span>
        <table id="header">
            <tr>
                <th>For</th>
                <td>
                    @foreach($attendee as $item)
                    {{ $item }} <br>
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>Re</th>
                <td style="text-transform: uppercase !important;"> {{ $memo->subject }} </td>
            </tr>
            <tr>
                <th>Date</th>
                <td style="text-transform: capitalized !important;"> {{ $memo->formatted_created_at }} </td>
            </tr>
        </table>

        <hr>

        <span id="message">{!! base64_decode($memo->message) !!}</span>

    </div>

</body>

</html>