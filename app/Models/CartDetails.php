<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetails extends Model
{
    use HasFactory;
    
    protected $table='sg_cart_details';
    protected $primaryKey = 'cart_dtls_id';
}
