<?php

namespace Modules\Report\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rule;
use Modules\Report\Entities\Report;

/**
 * Class UpdateReportRequest.
 */
class UpdateReportRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * 
     *  UpdateReportRequest constructor.
     *
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
        return true;

        //update Report for only superadministrator  and admins
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
                'title' => ['max:225','required',Rule::unique('reports')->ignore($this->id)],
                'description' => ['required'],
                'thumb'=>['sometimes','mimes:jpeg,bmp,png,gif,svg,pdf'],
                'image'=>['sometimes','mimes:jpeg,bmp,png,gif,svg,pdf'],
                'report_category_id' => ['numeric','exists:report_categories,id','required'],
                'date'=>['date','required'],
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
        throw new AuthorizationException(__('Only the superadministrator and admins can update this Report'));
    }
    
}
