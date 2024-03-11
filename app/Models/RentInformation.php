<?php

namespace App\Models;

use App\Models\RenewApartmentContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RentInformation extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [

        'date',
        'room_number',
        'tenant_name',
        'rent_fee',
        'status',

    ];

    public function renewcontracts(){

       return $this->hasMany(RenewApartmentContract::class, 'rent_info_id', 'id');
    }


}
