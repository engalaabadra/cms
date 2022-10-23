<?php

namespace Modules\Form\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Access\AuthorizationException;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rules;

/**
 * Class SendFormRequest.
 */
class SendFormRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * SendFormRequest constructor.
     */
    public function __construct(BaseRepository $baseRepo)
    {
        $this->baseRepo = $baseRepo;
    }
    /**
     * Determine if the Category is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
                return true;

        //store Category for only superadministrator , admins 
        $authorizeRes= $this->baseRepo->authorizeSuperAndAdmin();
        if($authorizeRes==true){
                return true;
            
        }else{
            return $this->failedAuthorization();
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'transfer_date' => ['required','date'],
            'name_doctor' => ['required','max:255'],
            'specialization' => ['required','max:255'],
            'phone_no_doctor' => ['required','max:255'],
            'institution_made_transfer' => ['required','max:255'],
            'phone_no_institution' => ['required','max:255'],
            'name_patient' => ['required','max:255'],
            'birth_date' => ['required','date'],
            'sex' => ['required','max:255'],
            'name_parent' => ['required','max:255'],
            'phone_no_patient' => ['required','max:255'],
            'reason_conversion' => ['required','max:255'],
            'symptoms_seen' => ['required','max:255'],
            'presumed_diagnosis' => ['required','max:255'],
            'health_problems' => ['sometimes','in:1,0'],
            'patient_taking_medication' => ['sometimes','in:1,0'],
            'suggested_services' => ['sometimes','in:1,2,3,4,5,6,7,8,9,10,11,12,13'],
            'signature' => ['required','max:255'],
            'date' => ['required','date'],
            'status' => ['sometimes', 'in:1,0'],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [

        ];
    }
        /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException(__('Only the superadministrator and admins can update this category'));
    }
}
