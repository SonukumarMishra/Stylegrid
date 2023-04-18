
@if (count($list))

    @foreach ($list as $key => $row)

        <tr>
        
            <td>{{$row->invoice_no}}</td>
            <td>{{$row->member_name}}</td>
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
        </tr>

    @endforeach
@else 
        <tr>
            <td colspan="7" style="text-align:center">No data Found</td>
        </tr>
@endif
