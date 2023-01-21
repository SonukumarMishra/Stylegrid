@extends('member.dashboard.layouts.default')

@section('content')



<!-- BEGIN: Content-->

<style>

    .messenger-listView .m-body{

        margin-top: 53px !important;

    }

    .messenger-list-item{

        box-shadow: 0px 0px 10px rgb(0 0 0 / 12%) !important;

    }

</style>



    <div class="content-wrapper">



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

            <div class="messenger">

                {{-- ----------------------Users/Groups lists side---------------------- --}}

                <div class="messenger-listView">

                    {{-- Header and search bar --}}

                    <div class="m-header">

                        {{-- <nav> --}}

                            {{-- <a href="#"><i class="fas fa-inbox"></i> <span class="messenger-headTitle">MESSAGES</span> </a> --}}

                            {{-- header buttons --}}

                            {{-- <nav class="m-header-right">

                                <a href="#"><i class="fas fa-cog settings-btn"></i></a>

                                <a href="#" class="listView-x"><i class="fas fa-times"></i></a>

                            </nav> --}}

                        {{-- </nav> --}}

                        {{-- Search input --}}

                        {{-- <input type="text" class="messenger-search" placeholder="Search" /> --}}

                        {{-- Tabs --}}

                        <div class="messenger-listView-tabs">

                            <a href="#" class="active-tab" data-view="users">

                                <span class="far fa-user"></span> People</a>

                        </div>

                    </div>

                    {{-- tabs and lists --}}

                    <div class="m-body contacts-container">

                       {{-- Lists [Users/Group] --}}

                       {{-- ---------------- [ User Tab ] ---------------- --}}

                       <div class="show messenger-tab users-tab app-scroll" data-view="users">

            

                           {{-- Favorites --}}

                           {{-- <div class="favorites-section">

                            <p class="messenger-title">Favorites</p>

                            <div class="messenger-favorites app-scroll-thin"></div>

                           </div> --}}

            

                           {{-- Contact --}}

                           <div class="listOfContacts" style="width: 100%;height: calc(100% - 200px);position: relative;"></div>

            

                       </div>

            

                         {{-- ---------------- [ Search Tab ] ---------------- --}}

                       <div class="messenger-tab search-tab app-scroll" data-view="search">

                            {{-- items --}}

                            <p class="messenger-title">Search</p>

                            <div class="search-records">

                                <p class="message-hint center-el"><span>Type to search..</span></p>

                            </div>

                         </div>

                    </div>

                </div>

            

                {{-- ----------------------Messaging side---------------------- --}}

                <div class="messenger-messagingView" style="border: 1px solid;">

                    {{-- header title [conversation name] amd buttons --}}

                    <div class="m-header m-header-messaging">

                        <nav class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">

                            {{-- header back button, avatar and user name --}}

                            <div class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">

                                <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i></a>

                                <div class="avatar av-s header-avatar" style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;">

                                </div>

                                <a href="#" class="user-name">StyleGrid</a>

                            </div>

                        </nav>

                    </div>

                    {{-- Internet connection --}}

                    <div class="internet-connection">

                        <span class="ic-connected">Connected</span>

                        <span class="ic-connecting">Connecting...</span>

                        <span class="ic-noInternet">No internet access</span>

                    </div>

                    {{-- Messaging area --}}

                    <div class="m-body messages-container app-scroll">

                        <div class="messages">

                            <p class="message-hint center-el"><span>Please select a chat to start messaging</span></p>

                        </div>

                        {{-- Typing indicator --}}

                        <div class="typing-indicator">

                            <div class="message-card typing">

                                <p>

                                    <span class="typing-dots">

                                        <span class="dot dot-1"></span>

                                        <span class="dot dot-2"></span>

                                        <span class="dot dot-3"></span>

                                    </span>

                                </p>

                            </div>

                        </div>

                        {{-- Send Message Form --}}



                        <div class="messenger-sendCard" style="border: 1px solid; padding: 5px;">

                            <form id="message-form" method="POST" action="{{ route('member.messanger.send.message') }}" enctype="multipart/form-data">

                                @csrf

                                <label>

                                    <span class="fas fa-paperclip">

                                        <img src="{{asset('member/dashboard/app-assets/images/icons/File Invoice.svg')}}"alt="">

                                    </span>

                                    <input disabled='disabled' type="file" class="upload-attachment" name="file" accept=".{{implode(', .',config('chat.attachments.allowed_images'))}}, .{{implode(', .',config('chat.attachments.allowed_files'))}}" />

                                </label>

                                <textarea readonly='readonly' name="message" class="m-send app-scroll" placeholder="Type a message.."></textarea>

                                <input type="hidden" name="type" value="text" />

                                <input type="hidden" name="receiver_id" value="" />

                                <input type="hidden" name="receiver_user" value="" />

                                <button class="btn btn-success" disabled='disabled'><span class="ft-zap text-primary" style="font-size:24px;" ></span></button>

                            </form>

                        </div>

                        

                    </div>

                </div>

                {{-- ---------------------- Info side ---------------------- --}}

                <div class="messenger-infoView app-scroll">

                    {{-- nav actions --}}

                    <nav>

                        <a href="#"><i class="fas fa-times"></i></a>

                    </nav>

                    {{-- user info and avatar --}}

                    <div class="avatar av-l chatify-d-flex"></div>

                    <p class="info-name">StyleGrid User</p>

                    <div class="messenger-infoView-btns">

                        {{-- <a href="#" class="default"><i class="fas fa-camera"></i> default</a> --}}

                        <a href="#" class="danger delete-conversation"><i class="fas fa-trash-alt"></i> Delete Conversation</a>

                    </div>

                    {{-- shared photos --}}

                    <div class="messenger-infoView-shared">

                        <p class="messenger-title">shared photos</p>

                        <div class="shared-photos-list"></div>

                    </div>



                </div>

            </div>





       </div>

   </div>

@stop