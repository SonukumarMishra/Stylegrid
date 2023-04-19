

@if (count($list))

    @foreach ($list as $key => $row)

        <tr>
        
            <td>{{$row->invoice_no}}</td>
            <td>{{$row->stylist_name}}</td>
            <td>{{$row->no_of_items}}</td>
            <td>£{{\Helper::format_number($row->invoice_amount)}}</td>
            <td>{{ isset($row->invoice_paid_on) && !empty($row->invoice_paid_on) ? date('m-d-Y', strtotime($row->invoice_paid_on)) : '' }}</td>
            <td>{{ date('m-d-Y', strtotime($row->created_at)) }}</td>
            <td>
                @if ($row->invoice_status == config('custom.product_invoice.status.pending'))
                    <span class="text-warning">Pending</span>
                @elseif ($row->invoice_status == config('custom.product_invoice.status.paid'))
                    <span class="text-success">Paid</span>
                @endif
            </td>
            @if ($row->invoice_status == config('custom.product_invoice.status.pending'))

                <td><button class="pay-invoice-btn" style="width: 100%; height: 25px; font-size:14px;" data-amount="{{ @$row->invoice_amount }}" data-invoice-id="{{ @$row->product_invoice_id }}" data-title="{{ $row->invoice_no }}">Pay Invoice</button></td>
            
            @elseif ($row->invoice_status == config('custom.product_invoice.status.paid'))

                @if (isset($row->invoice_pdf) && !empty($row->invoice_pdf))
            
                    <td><a href="{{ asset($row->invoice_pdf) }}" target="_blank" class="pay-invoice-btn1" style="width: 100%; height: 25px; font-size:16px;">View Invoice</a></td>                    
                
                @endif

            @endif
        </tr>

    @endforeach
@else 
        <tr>
            <td colspan="7" style="text-align:center">No data Found</td>
        </tr>
@endif
