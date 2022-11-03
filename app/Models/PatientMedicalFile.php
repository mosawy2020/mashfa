<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class PatientMedicalFile extends Model
{

    use HasTranslations;

    public $translatable = [
        'diseases_suffers_from','medications_takes',"history_operations",
    ];
    
    public $table = 'patient_medical_files';

    public $fillable = [
        'diseases_suffers_from','married',
        'age','medications_takes','file',
        'user_id',"history_operations",
        'boold_type',
    ];
 const BLOOD_TYPES = ['A+', 'A-','B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] ;

    public static $rules = [
        'diseases_suffers_from' => 'required|max:255',
        'age' => 'required|max:255',
        'married' => 'required|boolean',
        'medications_takes' => 'required|max:255',
        'file' => 'nullable',
        'history_operations' => 'required|max:255',
          'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-'
        ];


    protected function UserName ()
    {
        return $this->belongsTo(User::class , 'user_id');
    }// get User  Id


     
    protected function bookes(): HasManyThrough
    {
        return $this->hasManyThrough(PatientMedicalFile::class, Booking::class , 'user_id' , 'user_id' ,'id','id');
    }
    

}// end of models

