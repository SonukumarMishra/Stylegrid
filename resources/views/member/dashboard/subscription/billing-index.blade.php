@extends('member.dashboard.layouts.default')

@section('content')

<!-- BEGIN: Content-->

    <style>
        #browse-soursing .table thead th, #browse-soursing .table tbody tr{
            text-align: center;
        }
        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6{
            font-family: 'Silk Serif';
        }
    </style>

    <div class="content-wrapper">



        <div class="content-header row">

        </div>

        <div class="content-body">

            <!-- Revenue, Hit Rate & Deals -->

            <div class="mt-lg-3 row">

                <div class="col-8">

                    <h1>Billing</h1>

                    <h3>Manage your plan and billing details.</h3>

                </div>

            </div>

            <!--------------------souring hub--------->

            <div id="browse-soursing" class="mt-lg-5 mt-2">

            </div>

            <!--------------------end of souring Hub--------->

        </div>

    </div>



    {{-- page scripts --}}

    @section('page-scripts')

        @include('scripts.member.subscription.billing_js')

    @endsection

    @stop