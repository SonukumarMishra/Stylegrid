<!doctype html>
<html lang="en-US">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <style type="text/css">
        a:hover {
            text-decoration: underline !important;
        }
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
        style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;">
        <tr>
            <td>
                <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"
                    align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>


                                <tr>
                                    <td style="padding:0 35px;">
                                        <p><img src="{{ asset('images/logo.svg') }}" /></p>
                                        <h1
                                            style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;'Montserrat', sans-serif">
                                            Welcome To {{ env('APP_NAME')}} 👋</h1>
                                        <p
                                            style="text-align: start;font-size: 17px;line-height: 24px;margin-left: 1%;font-weight: 600;">
                                            Hi Poonam , </p>
                                        <p style="color: #2a292b;font-size: 16px;line-height: 24px;margin: 0;">
                                            Thank you for subscribing to {{ $data->subscription_name }}. Your subscription has been activated till {{ date('m-d-Y', strtotime($data->end_date)) }}.
                                        </p>

                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:0 35px;">

                                        <table style="margin-top:10px;">
                                            <tr>
                                                <td width="300">
                                                    <img src="{{url('/') . "/common/images/calender.jpg"}}" alt="" style="object-fit: cover;" height="80" width="80" onerror="this.src = '{{Helper::defaultImage()}}';">
                                                </td>
                                                <td width="300">
                                                    <img src="{{url('/') . "/common/images/star.png"}}" alt="" style="object-fit: cover;" height="60" width="60" onerror="this.src = '{{Helper::defaultImage()}}';">
                                                </td>
                                                <td width="300">
                                                    <img src="{{url('/') . "/common/images/dollar.jpg"}}" alt="" style="object-fit: cover;" height="80" width="80" onerror="this.src = '{{Helper::defaultImage()}}';">
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:0 35px;">
                                        <table style="">
                                            <tr>
                                                <td width="300" style="font-weight: 600;"># Invoice Date</td>
                                                <td width="300" style="font-weight: 600;"># Plan</td>
                                                <td width="300" style="font-weight: 600;"># Amount</td>
                                            </tr>

                                            <tr>
                                                <td width="300" style="">{{ date('m-d-Y', strtotime($data->invoice_date)) }}</td>
                                                <td width="300" style="">{{ $data->subscription_name }}</td>
                                                <td width="300" style="">$ {{ \Helper::format_number($data->price) }}</td>
                                            </tr>

                                        </table>

                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:0 35px;">
                                        <table style="margin-top:20px;">
                                            <tr height="40" style="background-color:#10464640">
                                                <td width="300" height="25" style="font-weight: 600;">Description</td>
                                                <td width="300" height="25" style="font-weight: 600;">Validity</td>
                                                <td width="300" height="25" style="font-weight: 600;">Amount</td>
                                            </tr>

                                            <tr height="35" style="background-color:#5f707014">
                                                <td width="300" style="">{{ $data->subscription_name }}</td>
                                                <td width="300" style="">{{ date('m-d-Y', strtotime($data->start_date)) }}-{{ date('m-d-Y', strtotime($data->end_date)) }}</td>
                                                <td width="300" style="">$ {{ \Helper::format_number($data->price) }}</td>
                                            </tr>

                                            <tr height="35">
                                                <td width="300" style=""></td>
                                                <td width="300" style="font-weight: 600;">TOTAL</td>
                                                <td width="300" style="background-color:#10464640;font-weight: 600;">$ {{ \Helper::format_number($data->price) }}</td>
                                            </tr>

                                        </table>

                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:0 35px;">
                                        <table style="margin-top:20px;">
                                            <tr height="40" style="background-color:#5f707014">
                                                <td width="300" height="25">
                                                    <span style="font-weight:600;">Payment Status:</span>
                                                    <span style="color:green; margin-left:10px;">PAID</span>
                                                </td>
                                                <td width="300" height="25">
                                                    <span style="font-weight:600;">Transaction ID:</span>
                                                    <span style="font-weight:0; margin-left:10px;">#{{ $data->payment_trans_id }}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>


                            </table>
                        </td>
                    </tr>




                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--/100% body table-->
</body>

</html>
