<?php

return [

    'default_page_limit' => 20,
    
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
        'offer_received' => 'offer_received',
        'offer_accepted' => 'offer_accepted',
        'offer_decline' => 'offer_decline',
        
    ],

    'sourcing' => [
        'sourcing_user_type' => [
            'stylist' => 1,
            'member' => 0
        ]
    ],

    'cart' => [
        
        'module_type' => [
            'stylegrid' => 'stylegrid'
        ],
        'item_type' => [
            'stylegrid_product' => 'stylegrid_product'    // This is Main grid's sub grids type
        ]

    ],

    'notification_types' => [
        'sourcing_new_request' => 'sourcing_new_request',
        'sourcing_offer_accepted' => 'sourcing_offer_accepted',
        'sourcing_offer_decline' => 'sourcing_offer_decline',
        'sourcing_offer_received' => 'sourcing_offer_received',
    ]
];
