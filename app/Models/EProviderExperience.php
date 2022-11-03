<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EProviderExperience extends Model
{

    public $table = 'e_providers_experiences';
    public $timestamps = false;
    public $fillable = ['e_provider_id','experiences_id',];

}
