
@if (count($list))

    @foreach ($list as $key => $source_row)
        <tr>
            <td class="d-flex"><span class="dot"></span>{{$source_row['p_name']}}</td>
            <td>{{$source_row['p_size']}}</td>
            <td>{{$source_row['p_type']}}</td>
            <td>{{$source_row['name']}}</td>
            <td>{{$source_row['country_name']}}</td>
            <td>{{date('m/d/Y',strtotime($source_row['p_deliver_date']))}}</td>
            <?php

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
                    <td><a href="{{'/stylist-offer-received/'.$source_row['p_slug']}}"><button class="">View Order</button></a></td> 
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
                ?>
        </tr>
    @endforeach
@else 
        <tr>
            <td colspan="5" style="text-align:center">No Source Found</td>
        </tr>
@endif
