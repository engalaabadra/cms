<?php

namespace Modules\Auth\Http\Requests\User;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rule;
use Modules\Profile\Entities\Profile;
use Illuminate\Validation\Rules;
use App\Models\User;

/**
 * Class UpdateUserRequest.
 */
class UpdateUserRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * 
     *  UpdateUserRequest constructor.
     *
     */
    public function __construct(BaseRepository $baseRepo)
    {
        $this->baseRepo = $baseRepo;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
 //update user for only superadministrator  and prevent update on superadmin
        $authorizeRes= $this->baseRepo->authorize();
        if($authorizeRes==true){
            if($this->id==="1"){
                return $this->failedAuthorization();
            }else{
            //this user superadmin   
                return true;
            }
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
                        'first_name' => ['required','string','max:255',Rule::unique('users')->ignore($this->id)],
            'last_name' => ['required','string','max:255'],
            'email' => ['required','max:225',Rule::unique('users')],
            'password'=>['required', Rules\Password::defaults()],
            'status' => ['sometimes', 'in:1,0'],
            'roles' => ['sometimes'],
            'roles.*'=>['exists:roles,id']
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'roles.*.exists' => trans('One or more roles were not found or are not allowed to be associated with this user type.'),

        
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
        throw new AuthorizationException(__('Only the superadministrator can update this user.'));
    }
}
