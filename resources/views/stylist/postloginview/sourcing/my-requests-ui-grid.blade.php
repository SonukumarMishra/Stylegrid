
@if (count($list))

    @foreach ($list as $key => $source_row)

    <div class="card">
            
        <img src="{{ asset('attachments/source/'.$source_row->p_image) }}" class="card-img-top img_preview img-fluid new-sourcing-active-req-img-border1 w-100" alt="">
    
        <div class="p-1">
            <div class="open-text">
                @if ($source_row['p_status']=='Fulfilled' && isset($source_row['sourcing_accepted_details']) && !empty($source_row['sourcing_accepted_details']))
                    <a href="{{ route('stylist.sourcing.view', ['title' => $source_row['p_slug']])}}">{{$source_row['p_name']}}</a>
                @else
                    {{$source_row['p_name']}}
                @endif 
            </div>
            <div class="active-request-product-name ">{{$source_row['p_type']}}</div>
            <div class="active-request-product-type">{{ isset($source_row['p_deliver_date']) && !empty($source_row['p_deliver_date']) ? date('m/d/Y',strtotime($source_row['p_deliver_date'])) : '' }}</div>
            <?php

                if($source_row['total_offer']>0 && $source_row['p_status']!='Fulfilled'){
                        $balance_offer=$source_row['total_offer']-$source_row['decline_offer'];
                    if($balance_offer==0){
                        ?>
                        <button class="active-request-product-pending mt-1">{{$source_row['p_status']}}</button>
                        <?php
                    }else{
                        if($source_row['total_offer']==1){
                        ?>
                        <button class="active-request-product-fulfill mt-1">Offer Received</button>
                        <?php
                    }else{

                        ?>
                        <button class="active-request-product-fulfill mt-1">
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
                        </button>
                        <?php
                    }
                    ?>
                    <a href="{{'/stylist-offer-received/'.$source_row['p_slug']}}"><button class="active-request-product-fulfill mt-1">View Offer</button></a>
                    <?php
                    }
                ?>
                <?php
                }else{
                    if($source_row['p_status']=='Fulfilled'){
                        ?>
                        <button class="active-request-product-fulfill mt-1">{{$source_row['p_status']}}</button>
                        
                        <?php
                    }else{
                        ?>
                        <button class="active-request-product-pending mt-1">{{$source_row['p_status']}}</button>
                        <?php
                    }
                    ?>
                    
                    <?php
                }
            ?>
        </div>
    </div>

    @endforeach
@else 
        <div>
            <h3 style="text-align:center">No Source Found</h3>
        </div>
@endif
