<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class EproviderEservice extends Model
{
    
//    use HasTranslations;
//
//    /**
//     * Validation rules
//     *
//     * @var array
//     */
//
//    public $translatable = [
//        'name',
//        'description',
//        'quantity_unit',
//    ];
//    public $table = 'e_provider_e_services';
//    public $fillable = [
//
//        'price',
//        'discount_price',
//        'price_unit',
//        'quantity_unit',
//        'duration',
//        'user_id',
//        'e_provider_id',
//        'e_services_id',
//    ];
//
//    public static $rules = [
//        'List_Classes.*.price' => 'required|numeric|min:0|max:99999999,99',
//        'List_Classes.*.discount_price' => 'nullable|numeric|min:0|max:99999999,99',
//        'List_Classes.*.price_unit' => ["nullable", "regex:/^(hourly|fixed)$/i"],
//        'List_Classes.*.duration' => 'nullable|max:16',
//        'List_Classes.*.quantity_unit' => 'nullable',
//        'List_Classes.*.e_services_id' => 'nullable|exists:e_services,id',
//    ];
//    /**
//     * The attributes that should be casted to native types.
//     *
//     * @var array
//     */
//    protected $casts = [
//
//        'price' => 'double',
//        'discount_price' => 'double',
//        'price_unit' => 'string',
//        'quantity_unit' => 'string',
//        'duration' => 'string',
//        'e_services_id' => 'integer',
//
//    ];
//
//
//    public function eService()
//    {
//        return $this->belongsTo(EService::class, 'e_services_id');
//    }
//
//    public function eProvider()
//    {
//        return $this->belongsTo(EProvider::class, 'e_provider_id');
//    }
//
//    public function UserName()
//    {
//        return $this->belongsTo(User::class, 'user_id');
//    }


}
