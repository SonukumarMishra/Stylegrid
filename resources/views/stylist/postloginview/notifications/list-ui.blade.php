@if (count($list))

    @foreach ($list as $item)

        <div class="col-12">
            <div class="row notification-row">
                <div class="col-11 notification-div">
                    <span class="time">{{ date('Y-m-d', strtotime($item->created_at)) }}</span>
                    <h1>{{ $item->notification_title }}</h1>
                    <p>{{ $item->notification_description }}</p>
                </div>
                {{-- <div class="col-1 d-flex align-items-center">
                    <button class="btn btn-primary btn-sm">View</button>
                </div> --}}
            </div>
        </div>
        
    @endforeach    

@endif

