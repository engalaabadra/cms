<?php

namespace Modules\Report\Http\Requests\Categories;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\BaseRepository;
use Illuminate\Validation\Rule;
use Modules\Report\Entities\Report;
use Modules\Report\Entities\ReportCategory;

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
                'slug' => ['max:225','required',Rule::unique('report_categories')->ignore($this->id)],
                'title' => ['max:225','required',Rule::unique('report_categories')->ignore($this->id)],
    
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
