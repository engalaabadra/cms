<?php

namespace Modules\Add\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rule;

/**
 * Class UpdateAddRequest.
 */
class UpdateAddRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * 
     *  UpdateAddRequest constructor.
     *
     */
    public function __construct(BaseRepository $baseRepo)
    {
        $this->baseRepo = $baseRepo;
    }
    /**
     * Determine if the Add is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

        //update Add for only superadministrator  and admins
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
                'title' => ['max:225','required',Rule::unique('adds')->ignore($this->id)],
                'link' => ['required'],
                'type' => ['required', 'in:1,0'],
                                'body' => ['required'],

                'start_date'=>['date','required'],
                'end_date'=>['date','required'],
                'file'=>['required','mimes:jpeg,bmp,png,gif,svg,pdf'],
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
        throw new AuthorizationException(__('Only the superadministrator and admins can update this Add'));
    }
    
}
