<?php

namespace Modules\Program\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rule;
use Modules\Program\Entities\Program;

/**
 * Class UpdateProgramRequest.
 */
class UpdateProgramRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * 
     *  UpdateProgramRequest constructor.
     *
     */
    public function __construct(BaseRepository $baseRepo)
    {
        $this->baseRepo = $baseRepo;
    }
    /**
     * Determine if the Program is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

        //update Program for only superadministrator  and admins
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
                'title' => ['max:225','required',Rule::unique('programs')->ignore($this->id)],
                'program_category_id' => ['numeric','exists:program_categories,id','required'],
            'description' => ['required'],
            'body' => ['required'],
            'meta_description' => ['required'],
            'meta_keywords' => ['required'],
            'image'=>['sometimes','mimes:jpeg,bmp,png,gif,svg,pdf'],
            
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
        throw new AuthorizationException(__('Only the superadministrator and admins can update this Program'));
    }
    
}
