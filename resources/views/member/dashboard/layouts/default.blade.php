@include('member.dashboard.includes.head') 
@include('member.dashboard.includes.header')
@include('member.dashboard.includes.left-nav')
<div class="app-content content bg-white">
    @yield('content')
</div>
@include('member.dashboard.includes.footer')
