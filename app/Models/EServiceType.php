<?php

namespace App\Models;

use App\Casts\EServiceCast;
use App\Casts\EServiceTypeCast;
use App\Traits\HasTranslations;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;
use Illuminate\Support\Facades\Lang;
use Spatie\MediaLibrary\Models\Media;

class EServiceType extends Model implements HasMedia, Castable
{
    use HasTranslations;
    use HasMediaTrait {
        getFirstMediaUrl as protected getFirstMediaUrlTrait;
    }
    public $fillable = ["name","description"] ;
    public $table = 'e_service_types';
    public static $rules = [
        'name' => 'required|max:127',
        'description' => 'required',
        'image' => 'nullable',
        "categories"=>"array",
        "categories.*"=>"exists:categories,id"
    ];
    protected $casts = [
        'name' => 'string',
        'duration' => 'string',
        'description' => 'string',

    ];
    public $translatable = [
        'name',
        'description',
    ];
    protected $appends = ["has_media"] ;
    public function eServices (){

        return $this->hasMany(EService::class);
    }
    public function eProviders (){

        return $this->belongsToMany(EProvider::class);
    }
    public function categories (){

        return $this->belongsToMany(Category::class);
    }
    public function getHasMediaAttribute(): bool
    {
        return $this->hasMedia('image');
    }
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
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 200, 200)
            ->sharpen(10);

        $this->addMediaConversion('icon')
            ->fit(Manipulations::FIT_CROP, 100, 100)
            ->sharpen(10);
    }

    public static function castUsing()
    {
        return EServiceTypeCast::class;
    }

    public function customFieldsValues()
    {
        return $this->morphMany('App\Models\CustomFieldValue', 'customizable');
    }
    public function getNameAttribute($name)
    {
        $infoArray = json_decode($name, true);
        return isset($infoArray[app()->getLocale()])?@$infoArray[app()->getLocale()] :@$infoArray[config('app.fallback_locale')] ;
    }
    public function getDescriptionAttribute($name)
    {

        $infoArray = json_decode($name, true);
        return isset($infoArray[app()->getLocale()])?@$infoArray[app()->getLocale()] :@$infoArray[config('app.fallback_locale')] ;
    }

}
