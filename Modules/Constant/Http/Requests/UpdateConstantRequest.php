<?php

namespace Modules\Constant\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rule;
use Modules\Constant\Entities\Constant;

/**
 * Class UpdateConstantRequest.
 */
class UpdateConstantRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * 
     *  UpdateConstantRequest constructor.
     *
     */
    public function __construct(BaseRepository $baseRepo)
    {
        $this->baseRepo = $baseRepo;
    }
    /**
     * Determine if the Constant is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

        //update Constant for only superadministrator  and admins
        $authorizeRes= $this->baseRepo->authorize();
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
                'title' => ['max:225','required',Rule::unique('constants')->ignore($this->id)],
                'value' => ['max:225','required'],
                'slug' => ['max:225','required'],
            'order' => ['numeric'],
                'status' => ['sometimes', 'in:1,0']
    
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
        throw new AuthorizationException(__('Only the superadministrator and admins can update this Constant'));
    }
    
}
