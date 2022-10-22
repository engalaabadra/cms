<?php

namespace Modules\Audio\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rule;
use Modules\Audio\Entities\Audio;

/**
 * Class UpdateAudioRequest.
 */
class UpdateAudioRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * 
     *  UpdateAudioRequest constructor.
     *
     */
    public function __construct(BaseRepository $baseRepo)
    {
        $this->baseRepo = $baseRepo;
    }
    /**
     * Determine if the Audio is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

        //update Audio for only superadministrator  and admins
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
                'title' => ['max:225','required',Rule::unique('audios')->ignore($this->id)],
                'description' => ['required'],
                'audio_category_id' => ['numeric','exists:audio_categories,id','required'],
                'date'=>['date','required'],
                'thumb'=>['nullable','mimes:jpeg,bmp,png,gif,svg,pdf'],
                'audio'=>['nullable','mimes:jpeg,bmp,png,gif,svg,pdf'],
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
        throw new AuthorizationException(__('Only the superadministrator and admins can update this Audio'));
    }
    
}
