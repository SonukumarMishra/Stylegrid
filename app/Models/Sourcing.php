<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sourcing extends Model
{
    use HasFactory;
    protected $table='sg_sourcing';
    protected $primaryKey = 'id';

    public function sourcing_offers() 
    {
        return $this->hasMany(SourcingOffer::class, 'sourcing_id', 'id');
    }

    public function sourcing_accepted_details() 
    {
        return $this->hasOne(SourcingOffer::class, 'sourcing_id', 'id')->where('sg_sourcing_offer.status', config('custom.sourcing.sourcing_offer_status.accepted'));
    }

    public function sourcing_chat_room() 
    {
        return $this->hasOne(ChatRoom::class, 'module_ref_id', 'id')->where('sg_chat_room.module', config('custom.chat_module.sourcing'));
    }

}
