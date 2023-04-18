<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Aloha!</title>

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
    .invoice-box table td.pt{
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

    .tr_border{
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
                    <img src="https://images.pexels.com/photos/1337380/pexels-photo-1337380.jpeg" style="width: 25%; max-width: 200px" />
                </td>
                <td>
                    <table style="text-align:left;padding-left: 40%;">
                        <tr><td>INVOICE #000123</td></tr>
                        <tr><td>ISSUED: 01/01/2023</td></tr>
                        <tr><td>REF: SG-MM-001</td></tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td class="pt">
                    <b><u>BILL TO:</u></b><br />
                    12345 Sunny Road<br />
                    Sunnyville, CA 12345
                </td>
                <td class="pt" style="text-align:left;padding-left: 20%;">
                    <b><u>STYLIST:</u></b><br />
                    John Doe<br />
                    john@example.com
                </td>
                <td class="pt" style="float: right;padding-left: 40%;">
                    <b><u>PAYABLE TO:</u></b><br />
                    John Doe<br />
                    john@example.com
                </td>
            </tr>
            <tr class="heading">
                <td>Description</td>
                <td style="padding-left: 50%;">QTY</td>
                <td style="padding-left: 80%;">Total</td>
            </tr>
                <tr class="details" style="padding-top: 20px;">
                <td>Check</td>
                <td style="padding-left: 50%;">1000</td>
                <td style="padding-left: 80%;">1000</td>
            </tr>
            <tr class="details">
                <td>Check</td>
                <td style="padding-left: 50%;">1000</td>
                <td style="padding-left: 80%;">1000</td>
            </tr>
           <tr class="heading">
                <td colspan="2">Total</td>
                <td style="text-align: start;">2,548</td>
            </tr>
            <tr class="top" style="float: unset;">
                <td colspan="2"></td>
                <td style="padding-top:20px;">
                    <table style="border-top: 1px solid black;border-bottom: 1px solid black;">
                        <tr style="float: right;">
                            <td> Total amount: </td>
                            <td> 3434554 </td>
                        </tr>  
                               
                        <tr style="float: right;">
                            <td> shipping:  </td>
                            <td>   3434554 </td>
                        </tr>  
                               
                        <tr style="float: right;">
                            <td> tax: </td>
                            <td> 3434554 </td>
                        </tr>  
                              
                        <tr style="float: right;">
                            <td><span style="color: green;">amount rate: </span></td>
                            <td><span style="color: green;">  3434554 </span> </td>
                        </tr> 
                    </table>
                </td>
            </tr>
            <tr class="">
                 <td colspan="2"></td>
                 <td style="padding-top:20px;"><img src="https://images.pexels.com/photos/1337380/pexels-photo-1337380.jpeg" style="width: 25%; max-width: 200px" /></td>
             </tr>
        </table>
    </div>
</body>
</html>