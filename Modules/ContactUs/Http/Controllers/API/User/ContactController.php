<?php

namespace Modules\ContactUs\Http\Controllers\API\User;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ContactUs\Entities\ContactUs;
use Modules\ContactUs\Http\Requests\SendContactRequest;
use Modules\ContactUs\Repositories\User\ContactRepository;

class ContactController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var ContactRepository
     */
    protected $contactUsRepo;
    /**
     * @var Contact
     */
    protected $contactUs;
   

    /**
     * ContactsController constructor.
     *
     * @param ContactRepository $contactUss
     */
    public function __construct(BaseRepository $baseRepo, ContactUs $contactUs,ContactRepository $contactUsRepo)
    {
        $this->baseRepo = $baseRepo;
        $this->contactUs = $contactUs;
        $this->contactUsRepo = $contactUsRepo;
    }

    public function send(SendContactRequest $request)
    {
        // try{
       $contactUs= $this->contactUsRepo->store($request,$this->contactUs);
                                         if(is_string($contactUs)){
            return response()->json(['status'=>false,'message'=>$contactUs],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$contactUs],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }

  
}
