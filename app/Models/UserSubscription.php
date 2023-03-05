<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;
    
    protected $table='sg_user_subscriptions';
    protected $primaryKey = 'user_subscription_id';

}
