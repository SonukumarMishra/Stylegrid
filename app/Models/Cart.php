<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    
    protected $table='sg_cart';
    protected $primaryKey = 'cart_id';

    public function cart_items_details(){
        
        return $this->hasMany(CartDetails::class, 'cart_id', 'cart_id')
                    ->orderBy('sg_cart_details.created_at', 'desc');

    }
}
