
@if (count($list))

    @foreach ($list as $key => $row)

        <tr>
            <td>{{$row->full_name}}</td>
            <td>{{$row->gender}}</td>
            <td>{{$row->country_name}}</td>
            <td>{{$row->email}}</td>
            <td>{{$row->phone}}</td>
            <td>{{ date('m-d-Y', strtotime($row->added_date)) }}</td>
        </tr>

    @endforeach
@else 
        <tr>
            <td colspan="6" style="text-align:center">No data Found</td>
        </tr>
@endif
