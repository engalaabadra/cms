<?php

namespace Modules\Staff\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rule;
use Modules\Staff\Entities\Staff;

/**
 * Class UpdateStaffRequest.
 */
class UpdateStaffRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * 
     *  UpdateStaffRequest constructor.
     *
     */
    public function __construct(BaseRepository $baseRepo)
    {
        $this->baseRepo = $baseRepo;
    }
    /**
     * Determine if the Staff is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

        //update Staff for only superadministrator  and admins
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
                'title' => ['max:225','required',Rule::unique('staffs')->ignore($this->id)],
                'staff_category_id' => ['numeric','exists:staff_categories,id','required'],
                'job' => ['max:225','required'],
                'description' => ['required'],
                'body' => ['required'],
                            'image'=>['sometimes','mimes:jpeg,bmp,png,gif,svg,pdf'],

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
        throw new AuthorizationException(__('Only the superadministrator and admins can update this Staff'));
    }
    
}
