
@if (count($result['list']))

    @foreach ($result['list'] as $g_key => $grid)

        <div class="col-lg-4 mt-2 col-12">
        
            <div class="stylegrid-bg-img height_350" style="background: url({{asset($grid->feature_image)}})">

                <div class="">

                    <div class="row bottom-text my-2 w-100">

                        <div class="col-8">

                            <h1 class="ml-2 mt-3 img-grid-name">{{ $grid->title }}</h1>

                        </div>

                        <div class="col-4 text-lg-center text-right">

                            <a href="{{ route('member.grid.view', [ 'grid_id' => $grid->stylegrid_id ]) }}"><button class="go-to-grid-btn mt-4">Go to Grid</button></a>

                        </div>

                    </div>

                </div>

            </div>

        </div>
        
    @endforeach

@else

    @if (count($result['list']) == 0 && $result['current_page'] == 1)
        
        <div class="col-12">
        
            <h3 class="text-center text-muted">

                No grids yet!

            </h3>

        </div>
        
    @endif

@endif

