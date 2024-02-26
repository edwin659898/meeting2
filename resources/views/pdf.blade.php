<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Minutes</title>
    <style type="text/css" media="screen">
        html {
            font-family: Sans-Serif;
            line-height: 0.5;
            margin: 0;
            font-size: 12px;
        }

        body {
            font-family: Sans-Serif;
            font-weight: 200;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
            margin: 36pt;
        }

        h4 {
            margin-top: 0;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
            font-weight: normal;
        }

        strong {
            font-weight: bolder;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        table {
            border-collapse: collapse;
            border: none;
        }

        th {
            text-align: inherit;
        }

        h4,
        .h4 {
            margin-bottom: 0.5rem;
            font-weight: 200;
            line-height: 1.2;
        }

        h4,
        .h4 {
            font-size: 15px;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.375rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 1px solid #dee2e6;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .pr-0,
        .px-0 {
            padding-right: 0 !important;
        }

        .pl-0,
        .px-0 {
            padding-left: 0 !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }

        * {
            font-family: "DejaVu Sans";
        }

        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        table,
        th,
        tr,
        td,
        p,
        div {
            line-height: 1.1;
        }

        .party-header {
            font-size: 1.5rem;
            font-weight: 400;
        }

        .total-amount {
            font-size: 12px;
            font-weight: 700;
        }

        .border-0 {
            border: none !important;
        }
    </style>
</head>

<body class="text-xs">
    <!-- invoice page -->
    <section class="card">
        <div class="card-body">
            <!-- Invoice Company Details -->
            <div class="row">
                <table style="width: 100%;">
                    <tr>
                        <td>
                            <div class="col-sm-6 col-12 text-left pt-1">
                                <div class="media pt-1">
                                    <img src="https://miti-magazine.betterglobeforestry.com/storage/logo.png" width="100" height="100" alt="company logo" />
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="col-sm-6 col-12 text-right">
                                <div class="invoice-details mt-2">
                                    <h2 class="text-dark mb-1">Minutes</h2>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>


            </div>
            <!--/ Invoice Company Details -->

            <!-- Invoice Recipient Details -->
            <div class="row">
                <table style="width: 100%;">
                    <tr>
                        <td>
                            <div>
                                <h5 class="text-dark mb-1">Meeting Name: </h5>
                                <p style=" font-size: 12px;">{{$data['meeting']['name']}}</p>
                            </div>
                        </td>
                        <td>
                            <div>
                                <h5 class="text-dark mb-1">Meeting Date: </h5>
                                <p style=" font-size: 12px;">{{date('d-m-Y', strtotime($data['created_at']))}}</p>
                            </div>
                        </td>
                        <td>
                            <div>
                                <h5 class="text-dark mb-1">Meeting Type: </h5>
                                <p style=" font-size: 12px;">{{$data['meeting_type']}}</p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="row">
                <table style="width: 100%;">
                    <tr>
                        <td>
                            <div>
                                <h5 class="text-dark mb-1">Meeting ID: </h5>
                                <p style="font-size: 12px;">{{$data['meeting']['meeting_id']}}</p>
                            </div>
                        </td>
                        <td>
                            <div>
                                <h5 class="text-dark mb-1">PassCode: </h5>
                                <p style=" font-size: 12px;">{{$data['meeting']['passcode']}}</p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <!--/ Invoice Recipient Details -->


            <div class="row mt-1">
                <h5 class="text-dark mb-1">Members Present</h5>
                <table style="width: 100%;">
                    <tbody>
                        @foreach($data['attendies'] as $attendie)
                        @if($attendie['attended'] == 'yes')
                        <tr>
                            <td>
                                <p style=" font-size: 12px;">{{$attendie['user']['name']}} - {{ App\Models\MeetingUser::where('user_id','=',$attendie['user_id'])->where('meeting_id','=',$data['meeting']['id'])->first()->member_role}}</p>
                                </p>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>


            <div class="row mt-1">
                <h5 class="text-dark mb-1">Members Absent with Apology</h5>
                <table style="width: 100%;">
                    <tbody>
                        @foreach($data['attendies'] as $attendie)
                        @if($attendie['attended'] == 'no' && $attendie['gave_apology'] == 'Yes')
                        <tr>
                            <td>
                                <p style=" font-size: 12px;">{{$attendie['user']['name']}} - {{App\Models\MeetingUser::where('user_id','=',$attendie['user_id'])->where('meeting_id','=',$data['meeting']['id'])->first()->member_role}}</p>
                                </p>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>


            <div class="row mt-1">
                <h5 class="text-dark mb-1">Members Absent with Apology</h5>
                <table style="width: 100%;">
                    <tbody>
                        @foreach($data['attendies'] as $attendie)
                        @if($attendie['attended'] == 'no' && $attendie['gave_apology'] == '')
                        <tr>
                            <td>
                                <p style=" font-size: 12px;">{{$attendie['user']['name']}} - {{App\Models\MeetingUser::where('user_id','=',$attendie['user_id'])->where('meeting_id','=',$data['meeting']['id'])->first()->member_role}}</p>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($data['invites'] != '')
            <div class="row mt-1">
                <h5 class="text-dark mb-1">Invites</h5>
                <table style="width: 100%;">
                    <tbody>
                        @foreach($data['invites'] as $attendie)
                        <tr>
                            <td>
                                <p style=" font-size: 12px;">{{$attendie['user']['name']}}</p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <div class="row mt-1">
                <table style="width: 100%;">
                    <tr>
                        <td>
                            <div>
                                <h5 class="text-dark mb-1">Meeting Started At: </h5>
                                <p style=" font-size: 12px;">{{date('d-m-Y H:i:s', strtotime($data['created_at']))}}</p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="row mt-1">
                <table style="width: 100%;">
                    <tr>
                        <td>
                            <div>
                                <h5 class="text-dark mb-1">Observation from previous meeting</h5>
                                <p style="font-size: 12px;">{!!$data['previous_observation']!!}</p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>


            @foreach($data['discussions'] as $discussion)
            <div class="row">
                <table style="width: 100%;">
                    <tr>
                        <td>
                            <h5 class="text-dark mb-1">{{ $discussion['department'] }}</h5>
                            <p style=" font-size: 12px;">{!!$discussion['discussion']!!}</p>
                            <h5 class="text-dark mb-1">AOB</h5>
                            <p style="font-size: 12px;">{!!$discussion['AOB']!!}</p>
                        </td>
                    </tr>
                </table>
            </div>
            @endforeach


            <div class="row mt-1">
                <table style="width: 100%;">
                    <tr>
                        <td>
                            <h5 class="text-dark mb-1">Meeting Ended At: </h5>
                            <p style=" font-size: 12px;">{{$data['end_time']}}</p>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="row mt-1">
                <table style="width: 100%;">
                    <tr>
                        <td>
                            <div>
                                <h5 class="text-dark mb-1">Chairperson Signature: </h5>
                                <p style=" font-size: 12px;">{{$data['chairperson']['name']}}</p>
                            </div>
                        </td>
                        <td>
                            <div>
                                <h5 class="text-dark mb-1">Chairperson Title: </h5>
                                <p style=" font-size: 12px;">{{App\Models\MeetingUser::where('user_id',$data['chairperson'])->where('meeting_id',$data['meeting']['id'])->first()->member_role}}</p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </section>
    <!-- invoice page end -->
</body>

</html>