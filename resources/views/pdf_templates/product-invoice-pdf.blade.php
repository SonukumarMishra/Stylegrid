<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table td.pt {
            padding-top: 30px;
            padding-bottom: 30px;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            /* padding-bottom: 20px; */
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            /* background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold; */

            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
            padding-top: 20px;

        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }

        .tr_border {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }
    </style>


</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2" class="title">
                    <img src="{{ asset('common/images/logo_icon.png') }}"
                        style="width: 25%; max-width: 200px" />
                </td>
                <td>
                    <table style="text-align:left;padding-left: 40%;">
                        <tr>
                            <td>INVOICE #{{ @$invoice_dtls->invoice_no }}</td>
                        </tr>
                        <tr>
                            <td>ISSUED: {{ date('m-d-Y', strtotime(@$invoice_dtls->created_at)) }}</td>
                        </tr>
                        <tr>
                            <td>REF: SG-MM-001</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td class="pt">
                    <b><u>BILL TO:</u></b><br />
                    {{@$invoice_dtls->member_name}}<br />
                </td>
                <td class="pt" style="text-align:left;padding-left: 20%;">
                    <b><u>STYLIST:</u></b><br />
                    {{@$invoice_dtls->stylist_name}}<br />
                    {{@$invoice_dtls->stylist_email}}
                </td>
                <td class="pt" style="float: right;padding-left: 40%;">
                    <b><u>PAYABLE TO:</u></b><br />
                    STYLEGRID LTD<br />
                    ACCOUNT NUMBER: 91771013<br />
                    SORT CODE: 60-04-02<br />
                    BANK: NATWEST
                </td>
            </tr>

            @if (isset($invoice_items) && count($invoice_items))
                
                <tr class="heading">
                    <td>Description</td>
                    <td style="padding-left: 50%;">QTY</td>
                    <td style="padding-left: 80%;">Total</td>
                </tr>
                
                @foreach ($invoice_items as $item)
                    
                    <tr class="details" style="padding-top: 20px;">
                        <td>
                            <div>
                                @if (isset($item->product_image) && !empty($item->product_image))

                                <img src="{{asset($item->product_image)}}" style="width: 25%; max-width: 150px" />

                                @endif
                               
                            </div>
                            <div style="padding-left: 10%;"> {{ @$item->product_name }} </div>
                        </td>
                        <td style="padding-left: 50%;">1</td>
                        <td style="padding-left: 80%;">£{{ \Helper::format_number(@$item->price) }}</td>
                    </tr>
                    
                @endforeach
            @endif
            
            <tr class="heading">
                <td colspan="2">Total</td>
                <td style="text-align: start;">£{{ \Helper::format_number(@$invoice_dtls->invoice_amount) }}</td>
            </tr>
            <tr class="top" style="float: unset;">
                <td colspan="2"></td>
                <td style="padding-top:20px;">
                    <table style="border-top: 1px solid black;border-bottom: 1px solid black;">
                        <tr style="float: right;">
                            <td> Total Amount: </td>
                            <td>  £{{ \Helper::format_number(@$invoice_dtls->invoice_amount) }} </td>
                        </tr>

                        <tr style="float: right;">
                            <td> Shipping: </td>
                            <td> £0.00 </td>
                        </tr>

                        <tr style="float: right;">
                            <td> Tax: </td>
                            <td> £0.00 </td>
                        </tr>

                        <tr style="float: right;">
                            <td><span style="color: green;">Amount Due: </span></td>
                            <td><span style="color: green;"> £{{ \Helper::format_number(@$invoice_dtls->invoice_amount) }} </span> </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="">
                <td colspan="2"></td>
                <td style="padding-top:20px;"><img
                        src="{{ asset('common/images/logo_icon.png') }}"
                        style="width: 25%; max-width: 200px" /></td>
            </tr>
        </table>
    </div>
</body>

</html>
