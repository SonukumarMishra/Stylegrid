@if (count($result['list']))

    @foreach ($result['list'] as $item)

        <div class="col-12 notification-card">
            <div class="row notification-row">
                <div class="col-12 notification-div mt-1">
                    
                    <div class="d-flex justify-content-between">

                        <h1>{{ $item->notification_title }}</h1>
                        <p class="time">{{ date('m/d/Y', strtotime($item->created_at)) }}</p>

                    </div>
                    <div class="d-flex justify-content-between">
                        <p>{{ $item->notification_description }}</p>
                        {{-- <button class="view-btn">View</button> --}}
                    </div>
                </div>
                
            </div>
        </div>
        
    @endforeach    

@else
    @if (count($result['list']) == 0 && $result['current_page'] == 1)
        <div class="col-12">

            <h3 class="text-center text-muted">

                No notification yet!

            </h3>

        </div>
    @endif

@endif

