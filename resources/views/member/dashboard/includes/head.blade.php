<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('member/dashboard/app-assets/vendors/css/vendors.min.css') }}">
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('member/dashboard/app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('member/dashboard/app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('member/dashboard/app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('member/dashboard/app-assets/css/components.css') }}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('member/dashboard/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('member/dashboard/app-assets/css/core/colors/palette-gradient.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('member/dashboard/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('member/dashboard/assets/css/jquery-ui.css') }}">
    <!-- END: Custom CSS-->

    {{-- Extensions --}}
    <link rel="stylesheet" href="{{ asset('extensions/toastr/css/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('extensions/sweetalert/css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('extensions/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('extensions/temp_chat/style.css') }}">

</head>