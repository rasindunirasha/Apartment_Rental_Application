<?php

namespace App\Entities\Cities;

use App\Entities\Countries\Country;
use App\Entities\Apartments\Apartment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ElegantMedia\SimpleRepository\Search\Eloquent\SearchableLike;
use EMedia\Formation\Entities\GeneratesFields;

class City extends Model
{
    use HasFactory;
    use SearchableLike;
    use GeneratesFields;

    protected $fillable = [
        'name',
        'country_id',
    ];

    protected $editable = [
        'name',
        'country_id',
    ];

    protected $searchable = [
        'name',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function apartments()
    {
        return $this->hasMany(Apartment::class);
    }

    /**
     * Add validation rules for creating a city
     */
    public function getCreateRules()
    {
        return [
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ];
    }

    /**
     * Add validation rules for updating a city
     */
    public function getUpdateRules()
    {
        return [
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ];
    }

    /**
     * Create validation messages (optional)
     */
    public function getCreateValidationMessages()
    {
        return [];
    }

    /**
     * Update validation messages (optional)
     */
    public function getUpdateValidationMessages()
    {
        return [];
    }
}
