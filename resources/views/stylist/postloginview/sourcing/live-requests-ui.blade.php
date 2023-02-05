
@if (count($list))

    @foreach ($list as $key => $source_row)
        <tr>
            <td class="d-flex"><span class="dot"></span>{{$source_row['p_name']}}</td>
            <td>{{$source_row['p_size']}}</td>
            <td>{{$source_row['p_type']}}</td>
            <td>{{$source_row['name']}}</td>
            <td>{{$source_row['country_name']}}</td>
            <td>{{date('d/m/Y',strtotime($source_row['p_deliver_date']))}}</td>
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
                    ?>
                    <td class="red-color">Request Sent</td>
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
