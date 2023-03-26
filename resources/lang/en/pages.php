<?php
return [

   'crud' => [
       'no_data' => ':attr not found.',
       'added_success' => 'The :attr added successfully.',
       'updated_success' => 'The :attr updated successfully.',
       'deleted_success' =>'Your :attr removed successfully.',
       'is_active_update' => ':attr status has been updated successfully.'
   ],

   'unauthorized_action' => 'Sorry! You are not authorized to perform this operation',
   'something_wrong' => 'Unable to process your request.',
   'invalid_mobile' => 'Invalid mobile number.',
   'invalid_input' => 'Invalid Input',
   'email_already_use' => 'Email address is already in use.',
   'token_expired' => 'Token expired.' ,
	'invalid_token' => 'Invalid token.',
   'invalid_email_password' => 'Invalid email or password.',
   'current_password_wrong' => 'The current password is incorrect.',
   'password_not_match' => 'Password doesn\'t match',
   'mail_configure_error' => 'Something went wrong in mail configuration',
   'no_result_found' => 'No Results Found',
   'mail_not_found' => 'Mail ID not Found' ,
   'password_not_match' => 'Password doesn\'t match',
   'failed_to_upload'=>'Failed To Upload, Your File length is different from original File Length',
   'failed_to_export_pdf'=>'Unable to export pdf!',
   'unknown_error' => 'Unknown error occurred.',
   'action_success' => 'Done Successfully',
   'saved_success' => 'Saved Successfully',
   'signup_success' => 'Congratulations! Your account has been successfully created.',
   'logged_out' => 'Logged out',
   'sourcing_chat_default_message' => 'Say hello to :name! :gender is sourcing your :sourcing_title',
   'product_chat_default_message' => 'Give me details for :product.',
   'grid_sent_to_client_success' => 'Grid has been sent successfully.',
   'add_to_cart_success' => 'Product has been added to your cart.',
   'remove_cart_item_success' => 'Product has been removed to your cart.',
   'already_active_subscription_action' => 'You\'re already subscribed!',
   'already_cancelled_subscription' => 'Subscription has already been canceled.',
   'subscription_success' => 'Thank you for subscribing!',
   'cancel_subscription_success' => 'Your subscription has been successfully cancelled.',
   'unable_to_create_subscription' => 'Unable to create subscription.',
   'stripe_user_not_found' => 'User\'s stripe account not found.',
   'stripe_payment_method_not_found' => 'User\'s stripe payment method not found.',
   'sourcing_invoice_already_generated' => 'Invoice already generated.',
   'sourcing_invoice_generated' => 'Sourcing invoice successfully generated.',
   'sourcing_invoice_payment_success' => 'Your payment has been processed successfully.',

   // notificaions description

   'notifications' => [

      'sourcing_new_request_title' => 'New request received!',
      'sourcing_new_request_des' => 'New request received for :product_title',

      'sourcing_offer_received_title' => 'New offer received!',
      'sourcing_offer_received_des' => 'New offer received for :product_title',

      'sourcing_offer_accepted_title' => 'Offer accepted!',
      'sourcing_offer_accepted_des' => 'Offer accepted for :product_title',

      'sourcing_offer_decline_title' => 'Offer decline!',
      'sourcing_offer_decline_des' => 'Offer decline for :product_title',

      'sourcing_invoice_generated_title' => 'New request received!',
      'sourcing_invoice_generated_des' => 'You have received invoice for :product_title.',

      'sourcing_invoice_paid_title' => 'New request received!',
      'sourcing_invoice_paid_des' => ':user has paid £:amount for :product_title.',
   ]
];
?>
