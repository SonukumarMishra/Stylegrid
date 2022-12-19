<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourcingOffer extends Model
{
    use HasFactory;
    protected $table='sg_sourcing_offer';
    protected $primaryKey = 'id';

}
