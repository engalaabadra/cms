<?php

namespace Modules\Gallery\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rule;
use Modules\Gallery\Entities\Gallery;

/**
 * Class UpdateGalleryRequest.
 */
class UpdateGalleryRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * 
     *  UpdateGalleryRequest constructor.
     *
     */
    public function __construct(BaseRepository $baseRepo)
    {
        $this->baseRepo = $baseRepo;
    }
    /**
     * Determine if the Gallery is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

        //update Gallery for only superadministrator  and admins
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
        // $Gallerys= Gallery::where('id',$this->id)->first();
        // if($Gallerys!==null){
            return [
                'title' => ['max:225','required',Rule::unique('Gallerys')->ignore($this->id)],
                'Gallery_category_id' => ['numeric','exists:Gallery_categories,id','required'],
                'date'=>['date','required'],
            'order' => ['numeric'],
                'status' => ['sometimes', 'in:1,0']
    
            ];
        // }else{
        //     return [

        //     ];
        // }

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
        throw new AuthorizationException(__('Only the superadministrator and admins can update this Gallery'));
    }
    
}
