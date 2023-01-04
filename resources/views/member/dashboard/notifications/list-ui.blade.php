@if (count($list))

    @foreach ($list as $item)

        <div class="col-12 notification-card">
            <div class="row notification-row">
                <div class="col-12 notification-div mt-1">
                    
                    <div class="d-flex justify-content-between">

                        <h1>{{ $item->notification_title }}</h1>
                        <p class="time">{{ date('m-d-Y', strtotime($item->created_at)) }}</p>

                    </div>
                    <div class="d-flex justify-content-between">
                        <p>{{ $item->notification_description }}</p>
                        {{-- <button class="view-btn">View</button> --}}
                    </div>
                </div>
                
            </div>
        </div>
        
    @endforeach    

@endif

