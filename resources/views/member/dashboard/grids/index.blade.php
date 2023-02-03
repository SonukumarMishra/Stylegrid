@extends('member.dashboard.layouts.default')

@section('content')

    <div class="content-wrapper">

        <div class="content-body">



            <div class="flex-column-reverse flex-md-row mt-lg-3 row">

                <div class="col-md-8">

                    <div class="col-md-8">

                        <h1>Browse your recent StyleGrid’s.</h1>

                        <h3>Look through all your grids in one place.</h3>

                    </div>

                </div>

                <div class="col-md-4 quick-link text-right">

                    <span class="mr-5"><a hrf="">Quick Link</a></span>

                    <div class="row justify-content-end my-2">

                        <a href="" class="mx-1"><img src="{{asset('member/dashboard/app-assets/images/icons/Chat.svg')}}"

                                alt=""></a>

                        <a href="" class="mx-1"><img src="{{asset('member/dashboard/app-assets/images/icons/File Invoice.svg')}}"

                                alt=""></a>

                        <a href="" class="mx-1"><img src="{{asset('member/dashboard/app-assets/images/icons/Gear.svg')}}" alt=""></a>



                    </div>



                </div>

            </div>



            {{-- Chat Container  --}}

            <div id="create-grid-1" class="mt-2">

                <div class="row" id="grid_container">

                </div>
    
            </div>
       </div>

   </div>



   {{-- page scripts --}}

    @section('page-scripts')
    
        @include('scripts.member.grid.index_js')

    @endsection

@stop



