<?php

namespace Modules\Gallery\Http\Requests\Albums;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Access\AuthorizationException;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rules;

/**
 * Class StoreGalleryCategoryRequest.
 */
class StoreGalleryRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * StoreGalleryCategoryRequest constructor.
     */
    public function __construct(BaseRepository $baseRepo)
    {
        $this->baseRepo = $baseRepo;
    }
    /**
     * Determine if the GalleryCategory is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        //store GalleryCategory for only superadministrator , admins 
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
            'title' => ['max:225','required',Rule::unique('gallery_albums')],
            'description' => ['required'],
            'gallery_category_id' => ['numeric','exists:gallery_categories,id','required'],
            'date'=>['date','required'],
            'image'=>['nullable','mimes:jpeg,bmp,png,gif,svg,pdf'],
            'order' => ['numeric'],
            'original_status' => ['sometimes', 'in:1,0']

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
        throw new AuthorizationException(__('Only the superadministrator and admins can store this GalleryCategory'));
    }
}
