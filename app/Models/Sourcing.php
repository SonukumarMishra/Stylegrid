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

}
