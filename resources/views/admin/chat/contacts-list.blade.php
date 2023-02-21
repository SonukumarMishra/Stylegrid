@if (count($result['list']))

    @foreach ($result['list'] as $co_key => $contact)
        
        <div class="p-1 mb-2 chat-list messenger-list-item" data-room-id="{{ $contact->chat_room_id }}">
            <div class="d-flex">
                <div class="">
                    @php
                        $contact_profile = asset('common/images/default_user.jpeg');
                        
                        if(isset($contact->sender_profile) && !empty($contact->sender_profile)){
                            if($contact->sender_user == 'member'){
                                $contact_profile = config('custom.media_path_prefix.member').$contact->sender_profile;
                            }else{
                                $contact_profile = $contact->sender_profile;
                            }
                        }
                    @endphp
                    <img src="{{ $contact_profile }}" class="img-fluid chat-pic" alt="">
                </div>
                <div class="col-10 pl-1">
                    <div class="row justify-content-between">
                        <div class="chat-h1 col-8">{{ $contact->sender_name }} & {{ $contact->receiver_name }}</div>
                        <div class="chat-p col-4">{{ $contact->module == config('custom.chat_module.sourcing') ? 'Sourcing' : 'Private' }}</div>
                    </div>
                    <div>
                        <div class="chat-p">
                            @if (isset($contact->room_last_message) && !empty($contact->room_last_message))
                                @if ($contact->room_last_message->type == 'file')
                                    <i class="fa fa-file" aria-hidden="true"></i>                                 
                                @else
                                    {{ @$contact->room_last_message->message }} 
                                @endif
                                
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    @endforeach

@else
    @if (count($result['list']) == 0 && $result['current_page'] == 1)
        <div class="col-12">

            <h3 class="text-center text-muted">

                Contact list is empty.

            </h3>

        </div>
    @endif

@endif
