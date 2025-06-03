<?php

namespace App\Entities\Apartments;

use App\Entities\Cities\City;
use App\Models\User;
use App\Entities\Inquiries\Inquiry;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ElegantMedia\SimpleRepository\Search\Eloquent\SearchableLike;
use EMedia\Formation\Entities\GeneratesFields;

class Apartment extends Model
{
    use HasFactory;
    use SearchableLike;
    use GeneratesFields;

    protected $fillable = [
        'name',
        'description',
        'city_id',
        'owner_id',
    ];

    protected $editable = [
        'name',
        'description',
        'city_id',
        'owner_id',
    ];

    protected $searchable = [
        'name',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: belongs to a city
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Relationship: belongs to an owner (user)
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Relationship: has many inquiries
     */
    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    /**
     * Validation rules for creating an apartment
     */
    public function getCreateRules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'city_id' => 'required|exists:cities,id',
            'owner_id' => 'required|exists:users,id',
        ];
    }

    /**
     * Validation rules for updating an apartment
     */
    public function getUpdateRules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'city_id' => 'required|exists:cities,id',
            'owner_id' => 'required|exists:users,id',
        ];
    }

    /**
     * Custom messages for create validation (optional)
     */
    public function getCreateValidationMessages()
    {
        return [];
    }

    /**
     * Custom messages for update validation (optional)
     */
    public function getUpdateValidationMessages()
    {
        return [];
    }
}
