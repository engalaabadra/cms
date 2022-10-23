<?php

namespace Modules\Page\Http\Requests\Banners;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rule;

/**
 * Class UpdatePageRequest.
 */
class UpdatePageRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * 
     *  UpdatePageRequest constructor.
     *
     */
    public function __construct(BaseRepository $baseRepo)
    {
        $this->baseRepo = $baseRepo;
    }
    /**
     * Determine if the Page is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

        //update Page for only superadministrator  and admins
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
                'title' => ['max:225','required',Rule::unique('pages')->ignore($this->id)],
                'page_id' => ['numeric','exists:pages,id','required'],
                'description' => ['required'],
                'images'=>['required'],
                'images.*'=>['sometimes','mimes:jpeg,bmp,png,gif,svg,pdf'],
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
        throw new AuthorizationException(__('Only the superadministrator and admins can update this Page'));
    }
    
}
