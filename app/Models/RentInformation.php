<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentInformation extends Model
{
    use HasFactory;

    protected $fillable = [

        'date',
        'room_number',
        'tenant_name',
        'rent_fee',
        'status',

    ];
}
