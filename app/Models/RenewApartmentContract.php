<?php

namespace App\Models;

use App\Models\RentInformation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RenewApartmentContract extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $dates = ['deleted_at'];
    protected $fillable = [

        'renew_start_date',
        'renew_end_date',
        'rent_info_id',
        'status',

    ];

    public function rentinformation(){

        return $this->belongsTo(RentInformation::class,'rent_info_id', 'id')->withDefault();
    }


}
