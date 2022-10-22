<?php

namespace Modules\Form\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\LanguageScope;
use Modules\Client\Entities\Client;
class Form extends Model
{
    use SoftDeletes;
        // protected $appends = ['original_status','health_problems','patient_taking_medication','suggested_services'];

        protected $hidden = ['locale'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'main_lang',
        'client_id',
        'transfer_date',
        'name_doctor',
        'specialization',
        'phone_no_doctor',
        'institution_made_transfer',
        'phone_no_institution',
        'name_patient',
        'birth_date',
        'sex',
        'name_parent',
        'phone_no_patient',
        'reason_conversion',
        'symptoms_seen',
        'presumed_diagnosis',
        'health_problems',
        'patient_taking_medication',
        'suggested_services',
        'date',        
        'order'
    ];
   
    
    
    
    //   public function getHealthProblemsAttribute(){
    //     return  $this->attributes['health_problems'];
    // }
    // public function getOriginalHealthProblemsAttribute(){
    //     $value=$this->attributes['health_problems'];
    //     if($value==0){
    //         return 'No';
    //     }elseif ($value==1) {
    //         return 'Yes';
    //     }
    // } 
    
    
    //       public function getPatientTakingMedicationAttribute(){
    //     return  $this->attributes['patient_taking_medication'];
    // }
    // public function getOriginalPatientTakingMedicationAttribute(){
    //     $value=$this->attributes['patient_taking_medication'];
    //     if($value==0){
    //         return 'No';
    //     }elseif ($value==1) {
    //         return 'Yes';
    //     }
    // } 
    
    
       public function getSuggestedServicesAttribute(){

        return  $this->attributes['suggested_services'];
    }
    public function getOriginalSuggestedServicesAttribute(){
        $value=$this->attributes['suggested_services'];
        
                if($value==1){
            return trans('Pediatric Neurology Clinic');
        }elseif ($value==2) {
            return trans('Cerebral palsy clinic');
        }elseif ($value==3) {
            return trans('Optometry and visual rehabilitation clinic');
        }elseif ($value==4) {
            return trans('Clinical Psychology major');
        }elseif ($value==5) {
            return trans('behavioral therapy');
        }elseif ($value==6) {
            return trans('Occupational therapy');
        }elseif ($value==7) {
            return trans('speech therapy');
        }elseif ($value==8) {
            return trans('Physical therapy');
        }elseif ($value==9) {
            return trans('water treatment');
        }elseif ($value==10) {
            return trans('Special Education Clinic');
        }elseif ($value==11) {
            return trans('music therapy');
        }elseif ($value==12) {
            return trans('art therapy');
        }elseif ($value==13) {
            return trans('Therapeutic Kindergarten');
        }
    } 
    
    public function client(){
        return $this->belongsTo(Client::class);
    }
 protected static function boot(){
        parent::boot();
        static::addGlobalScope(new LanguageScope);
    }   
}
