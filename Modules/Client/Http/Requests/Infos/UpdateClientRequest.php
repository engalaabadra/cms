<?php

namespace Modules\Client\Http\Requests\Infos;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rule;

/**
 * Class UpdateClientRequest.
 */
class UpdateClientRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * 
     *  UpdateClientRequest constructor.
     *
     */
    public function __construct(BaseRepository $baseRepo)
    {
        $this->baseRepo = $baseRepo;
    }
    /**
     * Determine if the Client is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

        //update Client for only superadministrator  and admins
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
            'description' => ['max:225','required'],
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
        throw new AuthorizationException(__('Only the superadministrator and admins can update this Client'));
    }
    
}
