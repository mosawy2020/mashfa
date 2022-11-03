<?php
/*
 * File name: EService.php
 * Last modified: 2022.01.05 at 22:45:08
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2022
 */

namespace App\Models;

use App\Casts\EServiceCast;
use App\Traits\HasTranslations;
use Doctrine\DBAL\Platforms\DateIntervalUnit;
use Eloquent as Model;
 use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use DateTime;
use DatePeriod;
use DateInterval;
/**
 * Class EService
 * @package App\Models
 * @version January 19, 2021, 1:59 pm UTC
 *
 * @property Collection category
 * @property EProvider eProvider
 * @property Collection Option
 * @property Collection EServicesReview
 * @property string name
 * @property integer id
 * @property double price
 * @property double discount_price
 * @property string price_unit
 * @property string quantity_unit
 * @property string duration
 * @property string description
 * @property boolean featured
 * @property boolean enable_booking
 * @property boolean available
 * @property integer e_provider_id
 */
class EService extends Model implements HasMedia, Castable
{
    use HasMediaTrait {
        getFirstMediaUrl as protected getFirstMediaUrlTrait;
    }

    use HasTranslations;

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
//        'name' => 'required|max:127',
        'price' => 'required|numeric|min:0|max:99999999,99',
        'discount_price' => 'nullable|numeric|min:0|max:99999999,99',
//        'price_unit' => "required|in:hourly,fixed",
        'duration' => 'required_if:provider_type,==,Doctor|numeric|min:5|max:60',
//        'description' => 'required',
        'e_provider_id' => 'required|exists:e_providers,id',
        'e_service_type_id' => 'required|exists:e_service_types,id'
    ];
    public $translatable = [
//        'name',
//        'description',
        // 'quantity_unit',
    ];
    public $table = 'e_services';
    protected $with = [];

    public $fillable = [
//        'name',
        'price',
        'discount_price',
        'price_unit',
        'quantity_unit',
        'duration',
//        'description',
        'featured',
        'enable_booking',
        'available',
        'e_provider_id',
        'e_service_type_id'
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'price' => 'double',
        'discount_price' => 'double',
        'price_unit' => 'string',
        'quantity_unit' => 'string',
        'duration' => 'string',
        'description' => 'string',
        'featured' => 'boolean',
        'enable_booking' => 'boolean',
        'available' => 'boolean',
        'e_provider_id' => 'integer',
        'e_service_type' => 'integer',
        'rate' => 'double',
        'total_reviews' => 'integer'
    ];
    /**
     * New Attributes
     *
     * @var array
     */
    protected $appends = [
        'custom_fields',
        'has_media',
        'available',
        'total_reviews',
        'is_favorite',
        'rate',
        'booking_times'
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    /**
     * @return CastsAttributes|CastsInboundAttributes|string
     */
    public static function castUsing()
    {
        return EServiceCast::class;
    }

    /**
     * @param Media|null $media
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 200, 200)
            ->sharpen(10);

        $this->addMediaConversion('icon')
            ->fit(Manipulations::FIT_CROP, 100, 100)
            ->sharpen(10);
    }

    /**
     * to generate media url in case of fallback will
     * return the file type icon
     * @param string $conversion
     * @return string url
     */
    public function getFirstMediaUrl($collectionName = 'default', $conversion = '')
    {
        $url = $this->getFirstMediaUrlTrait($collectionName);
        $array = explode('.', $url);
        $extension = strtolower(end($array));
        if (in_array($extension, config('medialibrary.extensions_has_thumb'))) {
            return asset($this->getFirstMediaUrlTrait($collectionName, $conversion));
        } else {
            return asset(config('medialibrary.icons_folder') . '/' . $extension . '.png');
        }
    }

    public function getCustomFieldsAttribute()
    {
        $hasCustomField = in_array(static::class, setting('custom_field_models', []));
        if (!$hasCustomField) {
            return [];
        }
        $array = $this->customFieldsValues()
            ->join('custom_fields', 'custom_fields.id', '=', 'custom_field_values.custom_field_id')
            ->where('custom_fields.in_table', '=', true)
            ->get()->toArray();

        return convertToAssoc($array, 'name');
    }

    public function customFieldsValues()
    {
        return $this->morphMany('App\Models\CustomFieldValue', 'customizable');
    }

    /**
     * Add Media to api results
     * @return bool
     */
    public function getHasMediaAttribute(): bool
    {
        return $this->hasMedia('image');
    }

    public function scopeNear($query, $latitude, $longitude)
    {
        // Calculate the distant in mile
        $distance = "SQRT(
                    POW(69.1 * (addresses.latitude - $latitude), 2) +
                    POW(69.1 * ($longitude - addresses.longitude) * COS(addresses.latitude / 57.3), 2))";

        // convert the distance to KM if the distance unit is KM
        if (setting('distance_unit') == 'km') {
            $distance .= " * 1.60934"; // 1 Mile = 1.60934 KM
        }

        return $query
            ->join('e_providers', 'e_providers.id', '=', 'e_services.e_provider_id')
            ->join('e_provider_addresses', 'e_provider_addresses.e_provider_id', '=', 'e_services.e_provider_id')
            ->join('addresses', 'e_provider_addresses.address_id', '=', 'addresses.id')
            ->whereRaw("$distance < e_providers.availability_range")
            ->select(DB::raw($distance . " AS distance"), "e_services.*")
            ->orderBy('distance');
    }

    /**
     * Check if is a favorite for current user
     * @return bool
     */
    public function getIsFavoriteAttribute(): bool
    {
        return $this->favorites()->count() > 0;
    }

    /**
     * @return HasMany
     **/
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'e_service_id')->where('favorites.user_id', auth()->id());
    }

    /**
     * Add Total Reviews to api results
     * @return int
     */
    public function getTotalReviewsAttribute(): int
    {
        return $this->eServiceReviews()->count();
    }

    /**
     * @return HasMany
     **/
    public function eServiceReviews()
    {
        return $this->hasMany(EServiceReview::class, 'e_service_id');
    }

    /**
     * Add Rate to api results
     * @return float
     */ //////
    public function getRateAttribute(): float
    {
        return (float)$this->eServiceReviews()->avg('rate');
    }

    /**
     * EService available when
     * This EService is marked as available
     * and his
     * Provider is ready so he is accepted by admin and marked as available and is open now
     */
    public function getAvailableAttribute(): bool
    {
        return isset($this->attributes['available']) && $this->attributes['available'] && isset($this->eProvider) && $this->eProvider->accepted;
    }
    public function getBookingTimesAttribute()
    {
        $availabilityHours =   isset($this->eProvider) ? $this->eProvider->availabilityHours:[];
        $data = [] ;
        $duration = isset($this->attributes["duration"])?$this->attributes["duration"] :60 ;
        foreach ($availabilityHours as $item) {
//            (date("d/M/Y", strtotime("$item->day")))  ;
            $pitchStart = new DateTime(  date("d-M-Y", strtotime("$item->day"))." ".$item->start_at);
            $pitchClose = new DateTime(  date("d-M-Y", strtotime("$item->day"))." ".$item->end_at);
//This is the time slots interval
            $slot_interval =  new DateInterval("PT".$duration."M"); //30 Minutes

//Get all slots between $pitchStart and $pitchClose
            $all_slots = [];

            $slots_start = $pitchStart;
            $slots_end = $pitchClose;

//This is how you can generate the intervals based on $pitchStart / $pitchClose and $slot_interval
            while($slots_start->getTimestamp() < $slots_end->getTimestamp()) {
                $all_slots[] = [
                    'start' => clone $slots_start,
                    'end' => min((clone $slots_start)->add($slot_interval) , (clone $slots_end))
                ];
                $slots_start->add($slot_interval);
            }
            $data [$item->day] = $all_slots ;
        }


 return $data ;
    }

    /**
     * @return BelongsTo
     **/
    public function eProvider()
    {
        return $this->belongsTo(EProvider::class);
    }

    /**
     * @return HasMany
     **/
    public function options()
    {
        return $this->hasMany(Option::class, 'e_service_id');
    }

    /**
     * @return BelongsToMany
     **/
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'e_service_categories');
    }

    public function categoriess()
    {
        return $this->hasManyThrough(Category::class, EServiceType::class);
    }

    public function EServiceType()
    {
        return $this->belongsTo(EServiceType::class);
    }


    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->discount_price > 0 ? $this->discount_price : $this->price;
    }

    /**
     * @return bool
     */
    public function hasDiscount(): bool
    {
        return $this->discount_price > 0;
    }

    public function discountables()
    {
        return $this->morphMany('App\Models\Discountable', 'discountable');
    }
}
