<?php
 
namespace App\Entities\Countries;
 
use App\Entities\Cities\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use EMedia\Formation\Entities\GeneratesFields;
use Illuminate\Database\Eloquent\Model;
use ElegantMedia\SimpleRepository\Search\Eloquent\SearchableLike;
use App\Entities\Cities;

 
class Country extends Model
{
 
    use HasFactory;
    use SearchableLike;
    use GeneratesFields;
 
    // Auto-generate UUIDs for new records
    // use \ElegantMedia\OxygenFoundation\Database\Eloquent\Traits\AssignsUuid;
 
    // Uncomment the following if you want to use slug generation
    // use \Spatie\Sluggable\HasSlug;
 
    /*
    public function getSlugOptions(): \Spatie\Sluggable\SlugOptions
    {
        return \Spatie\Sluggable\SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug');
    }
    */
    protected $editable = [
        'code',
        'name',
    ];
 
    protected $fillable = [
        'code',
        'name',
    ];
 
    protected $searchable = [
        'code',
        'name',
    ];
 
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
 
    public function cities(){
 
        return $this->hasMany(City::class);
    }
 
    /**
     *
     * Add any update only validation rules for this model
     *
     * @return array
     */
    public function getCreateRules()
    {
        return [
            'name' => 'required',
        ];
    }
 
    /**
     *
     * Add any update only validation rules for this model
     *
     * @return array
     */
    public function getUpdateRules()
    {
        return [
            'name' => 'required',
        ];
    }
 
    /**
     *
     * Add any update only validation messations
     *
     * @return array
     */
    public function getCreateValidationMessages()
    {
        return [];
    }
 
    /**
     *
     * Add any update only validation messations
     *
     * @return array
     */
    public function getUpdateValidationMessages()
    {
        return [];
    }
 
}
 
 