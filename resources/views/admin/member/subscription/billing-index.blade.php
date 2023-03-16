@extends('admin.layouts.default')
@section('content')


<style>
    #browse-soursing .table thead th, #browse-soursing .table tbody tr{
        text-align: center;
    }
    h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6{
        font-family: 'Silk Serif';
    }
</style>

<div class="app-content content bg-white">

    <div class="content-wrapper">

        <div class="content-header row">

        </div>

        <div class="content-body">

            <input type="hidden" id="user_id" value="{{ $member_details->id }}">
            <input type="hidden" id="user_type" value="{{ config('custom.user_type.member') }}">

            <!-- Revenue, Hit Rate & Deals -->

            <div class="mt-lg-3 row">

                <div class="col-8">

                    <h1>StyleGrid Member: {{$member_details->full_name}}</h1>

                    <h3>View subscription plan and billing details.</h3>

                </div>

                <div class="col-4 text-right">
                    <a href="{{ route('admin.member.view', ['title' => $member_details->slug ])}}" class="h4 text-primary">View Member Profile <i class="ft-arrow-up-right"></i></a>
                </div>

            </div>

            <!--------------------souring hub--------->

            <div id="browse-soursing" class="mt-lg-5 mt-2">

            </div>

            <!--------------------end of souring Hub--------->

        </div>

    </div>
</div>

@section('page-scripts')

    @include('scripts.admin.member.subscription_billing_js')

@endsection

@include('admin.includes.footer')

@stop