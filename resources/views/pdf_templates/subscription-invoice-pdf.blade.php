<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <meta name="x-apple-disable-message-reformatting" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <title></title>
        @include('common.pdf_common_styles')
        <style>

            body {
               margin: 0;
               font-family: "Silk Serif", -apple-system, BlinkMacSystemFont, "Genos", 'Roboto', "Genos-Light", 'Silk Serif Medium', 'Avenir';
               font-size: 1rem;
               font-weight: 400;
               line-height: 1.45;
               color: #6b6f80;
               text-align: left;
               background-color: #F9FAFD;
            }

            @page { 
                size: landscape;
                margin: 0px;
            }
            table,
            td,
            div,
            h1,
            p {
                font-family: Arial, sans-serif;
                font-size: 14px;
            }
            th {
                border: 0;
            }

            @media print {
             
                body {
                    font-size: 10px !important;
                }
    
                p {
                    font-size: 10px !important;
                } 
            }

        </style>
    </head>
    <body style="margin: 0; padding: 0;">
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
                                            <p>
                                                <img src="{{ asset('common/images/logo_icon.png') }}" style="height: 22px;margin-right: 5px;" />
                                                <img src="{{ asset('common/images/STYLEGRID-LOGO.png') }}" />
                                            </p>
                                            <h1
                                                style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;'Montserrat', sans-serif">
                                                Welcome To {{ env('APP_NAME')}}</h1>
                                            <p
                                                style="text-align: left;font-size: 18px;line-height: 24px;font-weight: 600;">
                                                Hi {{ @$user->full_name}} , </p>
                                            <p style="color: #2a292b;font-size: 16px;line-height: 24px;margin: 0;text-align: left;">
                                                Thank you for subscribing to {{ @$data->subscription_name }}. Your subscription has been activated till {{ date('m-d-Y', strtotime(@$data->end_date)) }}.
                                            </p>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="padding:0 35px;">

                                            <table style="margin-top:10px;">
                                                <tr>
                                                    <td width="300">
                                                        <img src="{{url('/') . "/common/images/calender.jpg"}}" alt="" style="object-fit: cover;" height="80" width="80" onerror="this.src = '{{\Helper::defaultImage()}}';">
                                                    </td>
                                                    <td width="300">
                                                        <img src="{{url('/') . "/common/images/star.png"}}" alt="" style="object-fit: cover;" height="60" width="60" onerror="this.src = '{{\Helper::defaultImage()}}';">
                                                    </td>
                                                    <td width="300">
                                                        <img src="{{url('/') . "/common/images/dollar.jpg"}}" alt="" style="object-fit: cover;" height="80" width="80" onerror="this.src = '{{\Helper::defaultImage()}}';">
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
                                                    <td width="300" style="">{{ date('m-d-Y', strtotime(@$data->invoice_date)) }}</td>
                                                    <td width="300" style="">{{ @$data->subscription_name }}</td>
                                                    <td width="300" style="">£{{ \Helper::format_number(@$data->price) }}</td>
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
                                                    <td width="300" style="">{{ @$data->subscription_name }}</td>
                                                    <td width="300" style="">{{ date('m-d-Y', strtotime(@$data->start_date)) }} - {{ date('m-d-Y', strtotime(@$data->end_date)) }}</td>
                                                    <td width="300" style="">£{{ \Helper::format_number(@$data->price) }}</td>
                                                </tr>

                                                <tr height="35">
                                                    <td width="300" style=""></td>
                                                    <td width="300" style="font-weight: 600;">TOTAL</td>
                                                    <td width="300" style="background-color:#10464640;font-weight: 600;">£{{ \Helper::format_number(@$data->price) }}</td>
                                                </tr>

                                            </table>

                                        </td>
                                    </tr>

                                    {{-- <tr>
                                        <td style="padding:0 35px;">
                                            <table style="margin-top:20px;">
                                                <tr height="40" style="background-color:#5f707014">
                                                    <td width="300" height="25">
                                                        <span style="font-weight:600;">Payment Status:</span>
                                                        <span style="color:green; margin-left:10px;">PAID</span>
                                                    </td>
                                                    <td width="300" height="25">
                                                        <span style="font-weight:600;">Transaction ID:</span>
                                                        <span style="font-weight:0; margin-left:10px;">#{{ @$data->payment_trans_id }}</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr> --}}

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
       
    </body>

</html>
