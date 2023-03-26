
@if (count($list))

    @foreach ($list as $key => $source_row)
        <tr>
            <td class="d-flex"><span class="dot"></span>
                @if (in_array($source_row['p_status'], [ config('custom.sourcing.status.Fulfilled'), config('custom.sourcing.status.invoice_paid') ]) && isset($source_row['sourcing_accepted_details']) && !empty($source_row['sourcing_accepted_details']))
                    <a href="{{ route('member.sourcing.view', ['title' => $source_row['p_slug']])}}">{{$source_row['p_name']}}</a>
                @else
                    {{$source_row['p_name']}}
                @endif 
            </td>
            <td>{{$source_row['p_size']}}</td>
            <td>{{$source_row['p_type']}}</td>
            <td>{{$source_row['name']}}</td>
            <td>{{$source_row['country_name']}}</td>
            <td>{{date('m/d/Y', strtotime($source_row['p_deliver_date']))}}</td>


            @if ($source_row['p_status'] == config('custom.sourcing.status.invoice_generated'))
            
                <td class="green-color">{{$source_row['p_status']}}</td>
                <td><button class="pay-invoice-btn" style="width: 100%; height: 25px; font-size:14px;" data-amount="{{ @$source_row['sourcing_invoice']->invoice_amount }}" data-invoice-id="{{ @$source_row['sourcing_invoice']->sourcing_invoice_id }}" data-sourcing-id="{{ $source_row['id'] }}">Pay Invoice</button></td>

            @elseif ($source_row['p_status'] == config('custom.sourcing.status.invoice_paid'))
            
                <td class="green-color">{{$source_row['p_status']}}</td>
                <td></td>

            @elseif ($source_row['total_offer']>0 && $source_row['p_status']!='Fulfilled')
               
                @php
                    $balance_offer = $source_row['total_offer']-$source_row['decline_offer'];
                @endphp

                @if ($balance_offer==0)
                
                    <td class="orange-color">{{$source_row['p_status']}}</td>

                @else

                    @if ($source_row['total_offer']==1)
                    
                        <td class="green-color">Offer Received</td> 

                    @else

                        <td class="green-color">
                            <?php
                            $balance_offer=$source_row['total_offer']-$source_row['decline_offer'];
                            if($balance_offer==1){
                                echo "Offer Received";
                            }else{
                                echo $balance_offer. " Offers Received";
                            } 
                            if($source_row['decline_offer']){
                                echo "/ ".$source_row['decline_offer']." Declined";
                            }
                            ?>
                        </td> 
                        
                    @endif

                    <td><a href="{{'/offer-received/'.$source_row['p_slug']}}"><button class="">View Order</button></a></td> 
                    
                @endif

            @else 

                <td class="orange-color">{{$source_row['p_status']}}</td>

            @endif
            {{-- <?php

                if($source_row['total_offer']>0 && $source_row['p_status']!='Fulfilled'){
                    $balance_offer=$source_row['total_offer']-$source_row['decline_offer'];
                    if($balance_offer==0){
                        ?>
                        <td class="orange-color">{{$source_row['p_status']}}</td>
                        <?php
                    }else{
                        if($source_row['total_offer']==1){
                        ?>
                        <td class="green-color">Offer Received</td> 
                        <?php
                        }else{

                            ?>
                            <td class="green-color">
                                <?php
                                $balance_offer=$source_row['total_offer']-$source_row['decline_offer'];
                                if($balance_offer==1){
                                    echo "Offer Received";
                                }else{
                                    echo $balance_offer. " Offers Received";
                                } 
                                if($source_row['decline_offer']){
                                    echo "/ ".$source_row['decline_offer']." Declined";
                                }
                                ?>
                            </td> 
                            <?php
                        }
                        ?>
                        <td><a href="{{'/offer-received/'.$source_row['p_slug']}}"><button class="">View Order</button></a></td> 
                        <?php
                    }
                ?>
                <?php
                }else{
                    if($source_row['p_status']=='Fulfilled'){
                        ?>
                        <td class="blue-color">{{$source_row['p_status']}}</td>
                        
                        <?php
                    }else{
                        ?>
                        <td class="orange-color">{{$source_row['p_status']}}</td>
                        <?php
                    }
                    ?>
                    
                    <?php
                }
            ?> --}}
        </tr>
    @endforeach
@else 
        <tr>
            <td colspan="7" style="text-align:center">No Source Found</td>
        </tr>
@endif
