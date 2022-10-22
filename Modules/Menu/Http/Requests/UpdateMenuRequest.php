<?php

namespace Modules\Menu\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rule;
use Modules\Menu\Entities\Menu;

/**
 * Class UpdateMenuRequest.
 */
class UpdateMenuRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * 
     *  UpdateMenuRequest constructor.
     *
     */
    public function __construct(BaseRepository $baseRepo)
    {
        $this->baseRepo = $baseRepo;
    }
    /**
     * Determine if the Menu is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

        //update Menu for only superadministrator  and admins
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
            'name' => ['max:225','required'],
            'slug' => ['max:225','required'],
            'position' => ['max:225','required'],
            'target' => ['numeric','exists:menus,id','nullable'],
            'is_external' => ['sometimes', 'in:1,0'],
            'link_external' => ['sometimes'],
            'order' => ['numeric'],
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
        throw new AuthorizationException(__('Only the superadministrator and admins can update this Menu'));
    }
    
}
