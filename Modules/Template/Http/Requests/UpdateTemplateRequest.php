<?php

namespace Modules\Template\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rule;

/**
 * Class UpdateTemplateRequest.
 */
class UpdateTemplateRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * 
     *  UpdateSliderRequest constructor.
     *
     */
    public function __construct(BaseRepository $baseRepo)
    {
        $this->baseRepo = $baseRepo;
    }
    /**
     * Determine if the Slider is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

        //update Slider for only superadministrator  and admins
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
                'name' => ['max:225','required',Rule::unique('templates')->ignore($this->id)],
                'main_value' => ['max:225','required'],
                'value' => ['max:225','required'],
                'main_model' => ['max:225','required'],
                'model' => ['max:225','required'],
                'have_sub' => ['sometimes', 'in:1,0'],
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
        throw new AuthorizationException(__('Only the superadministrator and admins can update this Slider'));
    }
    
}
