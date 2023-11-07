<?php

namespace App\Models;

use App\Models\FacilityProperty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_name',
        'description',
    ];

    public function facilityProperty()
    {
        return $this->belongsTo(FacilityProperty::class);
    }
}
