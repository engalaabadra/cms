<?php

namespace Modules\Form\Http\Controllers\API\User;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Form\Entities\Form;
use Modules\Form\Http\Requests\SendFormRequest;
use Modules\Form\Repositories\User\FormRepository;

class FormController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var FormRepository
     */
    protected $formRepo;
    /**
     * @var Form
     */
    protected $form;
   

    /**
     * FormsController constructor.
     *
     * @param FormRepository $forms
     */
    public function __construct(BaseRepository $baseRepo, Form $form,FormRepository $formRepo)
    {
        $this->baseRepo = $baseRepo;
        $this->form = $form;
        $this->formRepo = $formRepo;
    }

    public function send(SendFormRequest $request)
    {
        // try{
       $form= $this->formRepo->store($request,$this->form);
                                         if(is_string($form)){
            return response()->json(['status'=>false,'message'=>$form],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$form],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }

  
}
