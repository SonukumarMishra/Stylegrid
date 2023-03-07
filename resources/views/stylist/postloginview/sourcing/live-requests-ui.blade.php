
@if (count($list))

    @foreach ($list as $key => $source_row)
        <tr>
            <td class="d-flex">
                <span class="dot"></span>
                @if ($source_row['p_status']=='Fulfilled' && isset($source_row['sourcing_accepted_details']) && !empty($source_row['sourcing_accepted_details']))
                    <a href="{{ route('stylist.sourcing.view', ['title' => $source_row['p_slug']])}}">{{$source_row['p_name']}}</a>
                @else
                    {{$source_row['p_name']}}
                @endif            
            </td>
            <td>{{$source_row['p_size']}}</td>
            <td>{{$source_row['p_type']}}</td>
            <td>{{$source_row['name']}}</td>
            <td>{{$source_row['country_name']}}</td>
            <td>{{date('m/d/Y',strtotime($source_row['p_deliver_date']))}}</td>
            <?php
                if(!$source_row['requested']){
                    if($source_row['p_status']=='Pending'){
                        ?>
                        <td class="green-color">Open</td>
                        <?php
                    }else{
                        ?>
                        <td><?php echo $source_row['p_status'];?></td>
                    <?php
                    }
                }else{

                    if(isset($source_row['stylist_offer_status'])){

                        if($source_row['stylist_offer_status'] == 0){
                            ?>
                            <td class="text-warning">Request Sent</td>
                            <?php
                        }else if($source_row['stylist_offer_status'] == 1){
                            ?>
                            <td class="text-success">Accepted</td>
                            <?php
                        }else if($source_row['stylist_offer_status'] == 2){
                            ?>
                            <td class="text-danger">Declined</td>
                            <?php
                        }
                    }

                    ?> 
                <?php
                }
                ?>
                
                <td>
                    <?php
                    if(!$source_row['requested']){
                        if($source_row['p_status']=='Fulfilled'){
                        ?>
                        <button class=" ticket-btn">Ticket Closed </button>
                        <?php
                        }else{
                        ?>
                        <a href="{{url('stylist-fulfill-source-request/'.$source_row['p_slug'])}}"><button class="px-2">Fufill</button></a>
                        <?php
                        }
                    }
                    ?>
                </td>
        </tr>
    @endforeach
@else 
        <tr>
            <td colspan="7" style="text-align:center">No Source Found</td>
        </tr>
@endif
