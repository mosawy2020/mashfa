<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EProvidersAward extends Model
{
    
    public $table = 'e_providers_awards';
    public $timestamps = false;
    public $fillable = ['e_provider_id','award_id',];
    
}
