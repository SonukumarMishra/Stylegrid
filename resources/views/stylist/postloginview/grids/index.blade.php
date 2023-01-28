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

            <div class="row" id="grid_container">

            </div>

           </div>

       </div>

   </div>

</div>



@include('stylist.postloginview.partials.footer.footerjs')

@include('scripts.stylist.grid.index_js')
