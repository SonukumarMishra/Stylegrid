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
        ],
        'sourcing_offer_status' => [
            'pending' => 0,
            'accepted' => 1,
            'decline' => 2
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
    ],

    'subscription' => [
        'types' => [
            'trial' => 'trial',
            'paid' => 'paid',
            'free' => 'free'
        ],
        'interval' => [
            'days' => 'days',
            'month' => 'month',
            'year' => 'year'   
        ],
        'status' => [
            'pending' => 'pending',
            'active' => 'active',
            'cancelled' => 'cancelled',
            'expired' => 'expired'
        ]
    ],


    'payment_transaction' => [
        'type_debit' => 'debit',
        'trans_type' => [
            'subscription' => 'subscription'
        ]
    ],
    
    'payment_gatway' => [
        'stripe' => 'stripe'
    ],
    
    'stripe' => [
        'publishableKey' => 'pk_test_51MazanGhw3cYT5YK13cQNhHcY7thKoeRMD5QUfveEDFLais19e2bsr40WsSl02FSS3WGYwSvT7KhXgTYUuWeHObV00x7KyKD9d',
        'subscription_status' => [
            'active' => 'active',
            'trialing' => 'trialing',
            'canceled' => 'canceled',
            'past_due' => 'past_due',
            'unpaid' => 'unpaid',
        ]
    ],

    'card_brand' => [
        'visa' => 'visa',
        'mastercard' => 'mastercard',
        'amex' => 'amex',
        'discover' => 'discover',
        'jcb' => 'jcb'
    ]

];
