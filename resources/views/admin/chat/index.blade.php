@extends('admin.layouts.default')

@section('content')

    <style>
        /*******chat module******/
            #admin-chat{
            /* background: #EDEDED;
            border-radius: 10px; */
            }
            .chat-list{
                background: #FFFFFF;
                border-radius: 8.22785px;
            }
            .chat-h1{
                font-family: 'Genos';
                font-style: normal;
                font-weight: 400;
                font-size: 21px;
                line-height: 29px;
                color: #000000;
            }
            .chat-p{
                font-family: 'Genos-Light';
                font-style: normal;
                font-weight: 300;
                font-size: 17.7468px;
                line-height: 24px;
                color: #000000;
            }
            .chat-list-bg{
                background: #E0E0E0;
                border-radius: 10px;
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
                height: 100vh;
                overflow-y: auto;
                scrollbar-width: 6px;
            }
            .scrollbar-thin {
                scrollbar-width: thin;
                /* background-color: lightgreen; */
                /* height: 150px; */
                width: 10px;
                overflow-y: scroll;
            }
            .msg-bg{
                background: #EDEDED;
                border-radius: 10px;
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            ::-webkit-scrollbar {
                width: 10px;
                height:20px;
            }

            /* Track */
            ::-webkit-scrollbar-track {
                box-shadow: inset 0 0 5px grey; 
                border-radius: 10px;
                height:20px;
            }
            
            /* Handle */
            ::-webkit-scrollbar-thumb {
            /* background: red;  */
                border-radius: 10px;
                height:20px;
                background-color: #C1C1C1;
            }

            .choose-chat-view{
                font-family: 'Genos';
                font-style: normal;
                font-weight: 500;
                font-size: 24.2341px;
                line-height: 29px;
                text-align: center;
                color: #000000;
                background: #FFFFFF;
                border-radius: 36.8172px;
                border: 0;
            }

            /* Handle on hover */
            ::-webkit-scrollbar-thumb:hover {
                /* background: #b30000;  */
                background: #C1C1C1;
            }
            .msg-overview-bg{
                background: #EDEDED;
                border-radius: 10px;
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            
            }
            .chat-header{
                background: #FAFAFA;
                border-radius: 0px 10px 0px 0px;
            }
            .chat-date{
                font-family: 'Genos';
                font-style: normal;
                font-weight: 300;
                font-size: 14px;
                line-height: 17px;
                display: flex;
                align-items: center;
                justify-content: center;

                color: #000000;
            }
            .msg-box{
                background: #FFFFFF;
            }
            .msg-h1{
                font-family: 'Genos';
                font-style: normal;
                font-weight: 500;
                font-size: 18px;
                line-height: 22px;
                display: flex;
                align-items: flex-end;

                color: #000000;
            }
            .msg-p{
                font-family: 'Genos-Light';
                font-style: normal;
                font-weight: 300;
                font-size: 16px;
                line-height: 19px;

                color: #000000;
            }
            .msg-box-right{
                background: #FEFEEE;
            }
            .chat-contact-active{
                background: #FEFEEE;
            }
            .msg-time{
                font-family: 'Genos-Light';
                font-style: normal;
                font-weight: 300;
                font-size: 14px;
                line-height: 17px;
                display: flex;
                align-items: center;

                color: #000000;
            }
        
            /* .contacts-list{
                width: 100%;
                height: calc(100%);
                position: relative;
            } */

            .chat-list-container{
                height: 100vh;
                overflow-y: auto;
                scrollbar-width: 6px;
            }

            .chat-media {
                height: 150px;
                width: 150px;
                border-radius: 5px;
                object-fit: cover;
            }

            .chat-media-doc {
                height: 150px;
                width: 110px;
                border-radius: 5px;
                object-fit: cover;
            }

            .download-attachment {
                position: absolute;
                bottom: 5px;
                font-size: 15px;
                left: 120px;
                color: white;
                background: #000;
                padding: 6px;
                border-radius: 100%;
            }

            .download-attachment-doc {
                position: absolute;
                bottom: 7px;
                font-size: 15px;
                left: 79px;
                color: white;
                background: #000;
                padding: 6px;
                border-radius: 100%;
            }

            .download-all-btn {
                background: transparent;
                padding: 0.3em 1.7em;
                border: 0.16em solid rgb(0 0 0);
                border-radius: 2em;
                box-sizing: border-box;
                color: #000000;
                text-align: center;
            }
   
            .chat-pic {
                width: 52px;
                height: 52px;
                border-radius: 50%;
            }
            
    </style>

    <div class="app-content content bg-white">

        <div class="content-wrapper">

            
            <input type="hidden" id="default_chat_room_id" value="{{ @$chat_room_id }}">

            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Revenue, Hit Rate & Deals -->
                <div class=" mt-lg-3 ">
                    <div class="">
                        <h1>Chat Overview</h1>
                        <h3>.View communications between stylist and members.</h3>
                    </div>

                </div>
                <div id="admin-chat" class=" mt-3">
                    <div class="row">

                        <div class="col-lg-4 chat-list-bg p-2 " id="chatContactRow">
                            <form class="form-inline my-2 my-lg-0 pb-2">
                                <input class="form-control mr-sm-2 w-100" type="search" placeholder="Search chat..." aria-label="Search" id="search_input">
                            </form>

                            <div id="listOfContacts" class="contacts-list">

                            </div>
                            
                        </div>

                        <div class="col-lg-8 msg-overview-bg pl-0 pr-0" style="display:none;" id="chat_messages_container">
                            <div class="chat-header p-2">
                                <div class="row">
                                    <div class="col-md-1">
                                        <img src="" id="active-chat-box-user-profile" class="img-fluid" alt="">
                                    </div>
                                    <div class="col-md-11 pl-0">
                                        <div class="d-flex justify-content-between">
                                            <div class="chat-h1" id="active-chat-box-user-name"></div>
                                            <div class="chat-p"  id="active-chat-module"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="chat_list_container" class="chat-list-container">
                               
                            </div>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('page-scripts')

        <script src="{{ asset('extensions/jszip/js/jszip-utils.min.js') }}"></script>
        <script src="{{ asset('extensions/jszip/js/jszip.min.js') }}"></script>
        <script src="{{ asset('extensions/jszip/js/FileSaver.min.js') }}"></script>

        @include('scripts.admin.messanger.index')

    @endsection

    @include('admin.includes.footer')

 @stop




