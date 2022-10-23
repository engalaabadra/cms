<?php

namespace Modules\ContactUs\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Access\AuthorizationException;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rules;

/**
 * Class StoreContactUsRequest.
 */
class StoreContactRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * StoreArticleRequest constructor.
     */
    public function __construct(BaseRepository $baseRepo)
    {
        $this->baseRepo = $baseRepo;
    }
    /**
     * Determine if the Article is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        //store Article for only superadministrator , admins 
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
            'name' => ['max:225','required'],
            'region' => ['max:225','required'],
            'phone_no' => ['max:225','required'],
                        'email' => ['max:225','required'],
            'subject' => ['required'],
            'body' => ['required'],
            'region' => ['max:225','required'],

            'is_robot' => ['required','accepted'],
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
        throw new AuthorizationException(__('Only the superadministrator and admins can store this Article'));
    }
}
