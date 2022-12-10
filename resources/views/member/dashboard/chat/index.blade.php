@extends('member.dashboard.layouts.default')
@section('content')

<!-- BEGIN: Content-->
<style>
    .messenger-messagingView .m-body {
        padding-top: 15px;
        height: calc(100%);
        overflow-x: hidden;
        overflow-y: auto;
    }
    hr{
        border: 0;
        border-top: 1px solid rgba(0, 0, 0, 0.1) !important;
    }
    .m-list-active{
        background-color: #000000 !important;
        padding: 1.5rem !important;
        border-radius: 0.25rem !important;
        color: #ffffff !important;
    }
    .m-list-active .list-name, .m-list-active .list-msg, .m-list-active .list-time{
        color: #fff !important;
    }
    .messenger-list-item{
        border-bottom: 1px solid #F5F7FA;
    }
</style>

    <div class="content-wrapper">
        <input type="hidden" id="default_chat_room_id" value="{{ @$chat_room_id }}">
        <div class="content-body">

            <div class="flex-column-reverse flex-md-row mt-lg-3 row">
                <div class="col-md-8">
                    <div class="col-md-8">
                        <h1>Hi, {{Session::get('member_data')->name}}</h1>
                        <h3>Chat to your clients about all things style.</h3>
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
            <div id="client-chat" class="mt-3">
                
                <div class="row">
                
                    <div class="col-lg-3 px-0">
                        <div class="client-search-container">
                            {{-- <form action="#" method="post">
                                <input type="text" placeholder="Search in Messages" name="search "
                                    class="px-2 search-top">
                                <button type="submit"><img src="{{asset('stylist/app-assets/images/icons/Search-right.png')}}"
                                        alt=""></button>
                            </form>
                            <hr class="client-hr my-1"> --}}
                            <div class="">
                    
                                <div data-mdb-perfect-scrollbar="true" style="">
                                    
                                    <ul class="list-unstyled mb-0 listOfContacts"  style="width: 100%;height: calc(100% - 200px);position: relative;">
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9 mt-lg-0 mt-3" id="chat-section" style="display: none;">
                    
                        <div class="row">
                        
                            <div class="col-md-12 col-12">
                                <div class="d-flex justify-content-center m-header-messaging">
                                    <span class="dot"></span>
                                    <div class="client-name user-name"></div>
                                </div>
                            </div>

                        </div>
                        <hr class="client-hr my-2">

                        <div id="client-inbox-msg" class="messenger-messagingView py-2">

                            <div class="m-body scrollstyle">
                                
                                <div class="messages">

                                </div>
                             
                            </div>

                        </div>

                        {{-- preview selected files before upload --}}
                        
                        <div class="row col-12">

                            <div id="attachment_container" class="d-flex">

                            </div>
    
                        </div>

                        {{-- Send Message Form --}}

                        <div class="messenger-sendCard mt-1">

                            <form id="message-form" method="POST" action="{{ route('member.messanger.send.message') }}" enctype="multipart/form-data">
                                @csrf

                                <!-- BEGINING OF INPUT BOTTOM -->
                                <div class="text-muted d-flex justify-content-start align-items-center pe-3" id="chat-footer">
                                    
                                    <label for="file-input">
                                        <img src="{{asset('stylist/app-assets/images/gallery/paperclip-solid.svg')}}" alt="">
                                        <input disabled='disabled' type="file" class="upload-attachment hidden" name="file" id="file-input" multiple accept=".{{implode(', .',config('chat.attachments.allowed_images'))}}, .{{implode(', .',config('chat.attachments.allowed_files'))}}" />
                                    </label>

                                    {{-- <a class="px-1" href="#">
                                        <img src="{{asset('stylist/app-assets/images/gallery/face-smile-solid.svg')}}" alt="">
                                    </a> --}}
                                    
                                    <textarea readonly='readonly' rows="4" name="message" class="form-control m-send app-scroll" placeholder="Type message..."> </textarea>
                                    
                                    <a class="pl-1 send-msg-btn" href="#">
                                        <img src="{{asset('stylist/app-assets/images/gallery/paper-plane-solid.svg')}}" alt="">
                                    </a>

                                </div>

                                <!-- END OF INPUT BOTTOM-->
                                <input type="hidden" name="type" value="text" />
                                <input type="hidden" name="receiver_id" value="" />
                                <input type="hidden" name="receiver_user" value="" />

                            </form>
                        </div>
                        
                    </div>

                </div>

            </div>

       </div>

   </div>

   {{-- page scripts --}}
    @section('page-scripts')

        @include('scripts.member.messanger.index')

    @endsection

@stop

