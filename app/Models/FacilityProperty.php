<?php

namespace App\Models;

use App\Models\Facility;
use App\Models\Property;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FacilityProperty extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'facility_id',
        'tag_no',
        'date_acquired',
        'condition',
        'remarks',
    ];

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function property()
    {
        return $this->hasOne(Property::class);
    }
}
