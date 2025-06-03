<?php

namespace App\Entities\Inquiries;

use App\Entities\Apartments\Apartment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ElegantMedia\SimpleRepository\Search\Eloquent\SearchableLike;
use EMedia\Formation\Entities\GeneratesFields;

class Inquiry extends Model
{
    use HasFactory;
    use SearchableLike;
    use GeneratesFields;

    protected $fillable = [
        'message',
        'apartment_id',
        'user_id',
    ];

    protected $editable = [
        'message',
        'apartment_id',
        'user_id',
    ];

    protected $searchable = [
        'message',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Validation rules for creating an inquiry
     */
    public function getCreateRules()
    {
        return [
            'message' => 'required|string|max:1000',
            'apartment_id' => 'required|exists:apartments,id',
            'user_id' => 'required|exists:users,id',
        ];
    }

    /**
     * Validation rules for updating an inquiry
     */
    public function getUpdateRules()
    {
        return [
            'message' => 'required|string|max:1000',
            'apartment_id' => 'required|exists:apartments,id',
            'user_id' => 'required|exists:users,id',
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
