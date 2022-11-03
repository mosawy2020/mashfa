<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Speciality extends Model
{

    use HasTranslations;

    public $translatable = ['name'];
    
    public $table = 'specialities';

    public $fillable = ['name'];

    public static $rules = ['name' => 'required|max:127'];

    protected $casts = ['name' => 'string'];

    


}// end of models
