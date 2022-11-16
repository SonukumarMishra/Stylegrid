@extends('stylist.website.layouts.default')
@section('content')
<div class="container-fluid">
</div>
<div class="success_tab">
    <div class="container">
        <div id="signup-1">
            <div class="row justify-content-center">
                <h1>Thank you. Your application is now in review.</h1>
                <p class="text-center">Our team will be in touch within 24 hours to confirm your application
                    and
                    give you access to the StyleGrid platform, where you’ll be able to service and grow your
                    styling business all in one place.</p>
                <br>
                <a href="{{url('/')}}" class="mt-5" id="stylist-registration-success-url"><button class="back-to px-5" type="button">Return to Home</button></a>
            </div>

        </div>

    </div>
</div>
@stop