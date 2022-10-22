<?php

namespace Modules\Project\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rule;
use Modules\Project\Entities\Project;

/**
 * Class UpdateProjectRequest.
 */
class UpdateProjectRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * 
     *  UpdateProjectRequest constructor.
     *
     */
    public function __construct(BaseRepository $baseRepo)
    {
        $this->baseRepo = $baseRepo;
    }
    /**
     * Determine if the Project is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

        //update Project for only superadministrator  and admins
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
                'title' => ['max:225','required',Rule::unique('projects')->ignore($this->id)],
                'project_category_id' => ['numeric','exists:project_categories,id','required'],
                'description' => ['max:225','required'],
            'body' => ['max:225','required'],
            'meta_description' => ['max:225','required'],
            'meta_keywords ' => ['max:225','required'],
            'image'=>['sometimes','mimes:jpeg,bmp,png,gif,svg,pdf'],
            'logo'=>['sometimes','mimes:jpeg,bmp,png,gif,svg,pdf'],
            'link' => ['max:225','required'],
            
                'date'=>['date','required'],
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
        throw new AuthorizationException(__('Only the superadministrator and admins can update this Project'));
    }
    
}
