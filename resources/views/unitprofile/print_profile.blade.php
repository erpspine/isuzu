<html>

<head>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 10pt;
        }

        table {
            font-family: "Myriad Pro", "Myriad", "Liberation Sans", "Nimbus Sans L", "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 10pt;
        }

        table thead td {
            background-color: #BAD2FA;
            text-align: center;
            border: 0.1mm solid black;
            font-variant: small-caps;
        }

        td {
            vertical-align: top;
        }

        .bullets {
            width: 8px;
        }

        .items {
            border-bottom: 0.1mm solid black;
            font-size: 10pt;
            border-collapse: collapse;
            width: 100%;
            font-family: sans-serif;
        }

        .items td {
            border-left: 0.1mm solid black;
            border-right: 0.1mm solid black;
        }

        .align-r {
            text-align: right;
        }

        .align-c {
            text-align: center;
        }

        .bd {
            border: 1px solid black;
        }

        .bd-t {
            border-top: 1px solid
        }

        .ref {
            width: 100%;
            font-family: serif;
            font-size: 10pt;
            border-collapse: collapse;
        }

        .ref tr td {
            border: 0.1mm solid #888888;
        }

        .ref tr:nth-child(2) td {
            width: 50%;
        }

        .customer-dt {
            width: 100%;
            font-family: serif;
            font-size: 10pt;
        }

        .customer-dt tr td:nth-child(1) {
            border: 0.1mm solid #888888;
        }

        .customer-dt tr td:nth-child(3) {
            border: 0.1mm solid #888888;
        }

        .customer-dt-title {
            font-size: 7pt;
            color: #555555;
            font-family: sans;
        }

        .doc-title-td {
            text-align: center;
            width: 100%;
        }

        .doc-title {
            font-size: 15pt;
            color: #0f4d9b;
        }

        .doc-title-new {
            font-size: 10pt;
            color: #0f4d9b;
        }

        .doc-table {
            font-size: 10pt;
            margin-top: 5px;
            width: 100%;
        }

        .header-table {
            width: 100%;
            border-bottom: 0.8mm solid #fa1826;
        }

        .header-table tr td:first-child {
            color: #0f4d9b;
            font-size: 9pt;
            width: 60%;
            text-align: left;
        }

        .address {
            color: #000000;
            font-size: 10pt;
            width: 40%;
            text-align: right;
        }

        .header-table-text {
            color: #0f4d9b;
            font-size: 9pt;
            margin: 0;
        }

        .header-table-child {
            color: #0f4d9b;
            font-size: 8pt;
        }

        .header-table-child tr:nth-child(2) td {
            font-size: 9pt;
            padding-left: 50px;
        }

        .footer {
            font-size: 9pt;
            text-align: center;
        }

        .centerImage {
            text-align: center;
            display: block;
        }

        .dotted td {
            border-bottom: dotted 1px black;
        }

        .header td {
            border-bottom: solid 1px black;
        }

        .display td {
            border-bottom: dotted 1px black;
            line-height: 9px;
        }

        .displaytwo td {
            border-bottom: dotted 1px black;
            line-height: 15px;
        }
    </style>
</head>

<body>
    <htmlpagefooter name="myfooter">
        <div class="footer">
            Page {PAGENO} of {nb}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            {DATE d-m-Y}
        </div>
    </htmlpagefooter>
    <sethtmlpagefooter name="myfooter" value="on" />
    @php
        //storage_path('app/public/img/logo.jpg')
        //public_path('upload/default.jpg')
        //echo $vehicle_data->model->icon;
    @endphp
    <table class="header-table">
        <tr>
            <td>
                <img src="{{ storage_path('app\public\img\logo.jpg') }}" style="width:250px;  border-radius: 50%;" /><br>
            </td>
            <td class="address"><br><br>
                Enterprise/Mombasa Road<br>
                Industrial Area<br>
                P.O Box 30527 - 00100.<br>
                Tell : +254 703 013 111<br>
                info.kenya@isuzu.co.ke<br>
                www.isuzutrucks.co.ke
            </td>
        </tr>
    </table>
    <table class="doc-table">
        <tr>
            <td class="doc-title-td">
                <span class='doc-title'>
                    <b>
                        VEHICLE INSPECTION REPORT
                    </b>
                </span>
            </td>
        </tr>
    </table><br>
    <table class="customer-dt">
        <tr>
            <td width="50%">
                @php
                    $img = '<img src="' . public_path('upload/' . $vehicle_data->model->icon) . '" style="width:150px" />';
                    if ($vehicle_data->model->icon == 'default.jpg') {
                        $img = '<img src="' . public_path('upload/default/' . $vehicle_data->model->icon) . '" style="width:150px" />';
                    }
                @endphp
                {!! $img !!}
            </td>
            <td width="5%">&nbsp;</td>
            <td width="45%">
                <span class="customer-dt-title">VEHICLE DETAILS:</span><br><br><br>
                <b>Vin No :</b> {{ $vehicle_data->vin_no }}<br>
                <b>Model :</b> {{ $vehicle_data->model->model_name }}<br>
                <b>Engine No :</b> {{ $vehicle_data->engine_no }}<br>
                <b>Lot No :</b> {{ $vehicle_data->lot_no }}<br>
                <b>Job No :</b> {{ $vehicle_data->job_no }}<br>
                <b>Offline Date:</b> {{ $offlinedate }}<br>
                <b>FCW Date :</b> {{ $fcw }}<br>
            </td>
        </tr>
    </table>
    <table class="doc-table">
        <tr>
            <td class="doc-title-td">
                <span class='doc-title-new'>
                    <b>
                        MOVEMENT HISTORY
                    </b>
                </span>
            </td>
        </tr>
    </table><br>
    <table class="items" cellpadding="8">
        <thead>
            <tr>
                <td width="20%">SHOP</td>
                <td width="20%">DATE IN </td>
                <td width="20%">DATE OUT</td>
                <td width="20%">INSPECTED BY</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($unit_movements as $unit_movement)
                <tr class="dotted display">
                    <td>{{ $unit_movement->shop->shop_name }}</td>
                    <td>{{ dateFormat($unit_movement->datetime_in) }}</td>
                    <td>{{ dateFormat($unit_movement->datetime_out) }}</td>
                    <td>{{ $unit_movement->user->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="page-break-after:always"></div>
    <table class="doc-table">
        <tr>
            <td class="doc-title-td">
                <span class='doc-title-new'>
                    <b>
                        DEFECT LIST
                    </b>
                </span>
            </td>
        </tr>
    </table><br>
    <table class="items" cellpadding="8">
        <thead>
            <tr>
                <td width="12%">Date</td>
                <td width="30%">Query Name </td>
                <td width="25%">Defect</td>
                <td width="9%">GCA</td>
                <td width="9%">Drl Score</td>
                <td width="15%">Inspected bY</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($unit_defects as $defect)
                <tr class="dotted displaytwo">
                    <td>{{ dateFormat($defect->created_at) }}</td>
                    <td>{{ $defect->getqueryanswer->routing->query_name }}</td>
                    <td>{{ $defect->defect_name }} </td>
                    <td>{{ $defect->value_given }}</td>
                    <td>{{ $defect->is_defect }}</td>
                    <td>{{ $defect->getqueryanswer->doneby->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="doc-table">
        <tr>
            <td class="doc-title-td">
                <span class='doc-title-new'>
                    <b>
                        ROUTINGS
                    </b>
                </span>
            </td>
        </tr>
    </table><br>
    @foreach ($shops as $shop)
        <div class="card-header bg-info">
            <h4 class="mb-0 text-white">{{ $shop->shop_name }}</h4>
        </div>
        @php
            $i = 0;
        @endphp
        @foreach ($shop->querycategory as $row)
            @php
                $i++;
            @endphp
            <div class="card-body">
                <h4 class="card-title"> {{ $i }}. {{ $row->query_code }} : {{ $row->category_name }}</h4>
            </div>
            <table class="items" cellpadding="8">
                <thead>
                    <tr>
                        <td width="35%">Query Name</td>
                        <td width="15%">Answer</td>
                        <td width="25">Defects</td>
                        <td width="15%">User</td>
                        <td width="10%">Signature</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($row->queryanswers as $rowdata)
                        @php
                            $defect_name = '--';
                            $signature = '--';
                            if ($rowdata->has_error == 'Yes') {
                                $defect_name = $rowdata->get_defects->defect_name;
                            }
                            if (!empty($rowdata->signature)) {
                                $url = public_path('upload/' . $rowdata->signature);
                                if (file_exists($url)) {
                                    $signature = '<img src="' . $url . '" border="0" width="40" class="img-rounded" align="center" />';
                                }
                            }
                        @endphp
                        <tr class="dotted displaytwo">
                            <td>{{(isset($rowdata->queries)) ?  $rowdata->queries->query_name : '' }}</td>
                            <td>{{ $rowdata->answer }}</td>
                            <td>{{ $defect_name }}</td>
                            <td>{{ $rowdata->doneby->name }}</td>
                            <td>{!! $signature !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endforeach
</body>

</html>
