<?php

namespace Modules\News\Http\Requests\Categories;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rule;

/**
 * Class UpdateNewsRequest.
 */
class UpdateNewsRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * 
     *  UpdateArticleRequest constructor.
     *
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

        //update Article for only superadministrator  and admins
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
                'title' => ['max:225','required',Rule::unique('news_categories')->ignore($this->id)],
                'slug' => ['max:225','required',Rule::unique('news_categories')->ignore($this->id)],
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
        throw new AuthorizationException(__('Only the superadministrator and admins can update this Article'));
    }
    
}
