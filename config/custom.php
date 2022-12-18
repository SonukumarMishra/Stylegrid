<?php

return [

    'user_type' => [
        'member' => 'member',
        'stylist' => 'stylist'
    ],

    'chat_module' => [
        'private' => 'private',
        'sourcing' => 'sourcing'
    ],

    'media_path_prefix' => [
        'stylist_porfile' => 'stylist/attachments/profileImage/',
        'member_porfile' => 'member/attachments/profileImage/'
    ],

    'sourcing_pusher_action_type' => [
        'new_request' => 'new_request',
        'offer_send' => 'offer_send',
        'offer_received' => 'offer_received',
        'offer_accepted' => 'offer_accepted',
        'offer_decline' => 'offer_decline',
        
    ],

    'sourcing' => [
        'sourcing_user_type' => [
            'stylist' => 1,
            'member' => 0
        ]
    ]
];
