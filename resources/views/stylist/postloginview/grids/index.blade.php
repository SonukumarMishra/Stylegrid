@include('stylist.postloginview.partials.header.header')

@include('stylist.postloginview.partials.navigate.navigate')

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- BEGIN: Content-->

<style>



</style>



<div class="app-content content bg-white">

   <div class="content-wrapper">



       <div class="content-header row">

       </div>

       <div class="content-body">

           <!-- Revenue, Hit Rate & Deals -->

           <div class="row mt-3">

               <div class="col-md-8">

                   <h1>Browse your recent StyleGrid’s.</h1>

                   <h3>Look through all your grids in one place.</h3>

                   <a href="{{ route('stylist.grid.create') }}"><button class="grid-btn">Create Grid</button></a>

               </div>

               <div class="col-md-4 quick-link text-right">

                   <span class="mr-5"><a hrf="">Quick Link</a></span>

                   <div class="row justify-content-end my-2">

                       <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/Chat.svg')}}" alt=""></a>

                       <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/File Invoice.svg')}}" alt=""></a>

                       <a href="" class="mx-1"><img src="{{asset('stylist/app-assets/images/icons/Gear.svg')}}" alt=""></a>



                   </div>



               </div>

           </div>

           <!-------------------- fulfil souring request--------->

           <div id="create-grid-1" class="mt-2">



            <div class="row">

         

                @if (count($style_grids))



                  @foreach ($style_grids as $g_key => $grid)



                        <div class="col-lg-4 mt-2 col-12">

                           <div class="stylegrid-bg-img height_350" style="background: url({{asset($grid->feature_image)}})">

                                 <div class="">

                                    <div class="row bottom-text my-2 w-100">

                                       <div class="col-8">

                                             <h1 class="ml-2 mt-3">{{ $grid->title }}</h1>

                                       </div>

                                       <div class="col-4 text-lg-center text-right">

                                             <a href="{{ route('stylist.grid.view', [ 'grid_id' => $grid->stylegrid_id ]) }}"><button class="go-to-grid-btn mt-4">Go to Grid</button></a>

                                       </div>

                                    </div>

                                 </div>

                           </div>

                        </div>

                  @endforeach

                @else 

                        <div class="col-12">

                            <h3 class="text-center">

                                No grid created yet!

                            </h3>

                        </div>

               @endif

            </div>

   

           </div>

       </div>

   </div>

</div>



@include('stylist.postloginview.partials.footer.footerjs')



