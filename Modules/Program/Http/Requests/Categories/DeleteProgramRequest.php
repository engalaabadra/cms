<?php

namespace Modules\Program\Http\Requests\Categories;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\BaseRepository;


/**
 * Class DeleteProgramRequest.
 */
class DeleteProgramRequest extends FormRequest
{
    /**
     * @var BaseRepository
    */
    protected $baseRepo;
    /**
     * DeleteProgramRequest constructor.
     *
     */
    public function __construct(BaseRepository $baseRepo)
    {
        $this->baseRepo = $baseRepo;
    }
    /**
     * Determine if the Program is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

      //delete Program for only superadministrator  and admins
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
        throw new AuthorizationException(__('Only the superadministrator and admins can update this Program'));
    }
}
