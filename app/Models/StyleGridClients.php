<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StyleGridClients extends Model
{
    use HasFactory;
    
    protected $table='sg_grid_clients';
    protected $primaryKey = 'grid_client_id';
}
