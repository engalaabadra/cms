<?php

namespace Modules\Video\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Access\AuthorizationException;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rules;

/**
 * Class StoreVideoRequest.
 */
class StoreVideoRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * StoreReportRequest constructor.
     */
    public function __construct(BaseRepository $baseRepo)
    {
        $this->baseRepo = $baseRepo;
    }
    /**
     * Determine if the Report is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       // return true;
        //store Report for only superadministrator , admins 
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
            'title' => ['max:225','required',Rule::unique('videos')],
            'description' => ['required'],
            'video_link' => ['max:225','required'],
            'thumb'=>['sometimes','mimes:jpeg,bmp,png,gif,svg,pdf'],
            'video_category_id' => ['numeric','exists:video_categories,id','required'],
            'is_featured' => ['sometimes', 'in:1,0'],
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
        throw new AuthorizationException(__('Only the superadministrator and admins can store this Report'));
    }
}
