<?php

namespace Modules\Newsletter\Http\Controllers\API\User;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Newsletter\Entities\Newsletter;
use Modules\Newsletter\Http\Requests\SendNewsletterRequest;
use Modules\Newsletter\Repositories\User\NewsletterRepository;

class NewsletterController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var NewsletterRepository
     */
    protected $newsletterRepo;
    /**
     * @var Newsletter
     */
    protected $newsletter;
   

    /**
     * NewslettersController constructor.
     *
     * @param NewsletterRepository $newsletters
     */
    public function __construct(BaseRepository $baseRepo, Newsletter $newsletter,NewsletterRepository $newsletterRepo)
    {
        $this->baseRepo = $baseRepo;
        $this->newsletter = $newsletter;
        $this->newsletterRepo = $newsletterRepo;
    }

    public function send(SendNewsletterRequest $request)
    {
        // try{
       $newsletter= $this->newsletterRepo->store($request,$this->newsletter);
                                         if(is_string($newsletter)){
            return response()->json(['status'=>false,'message'=>$newsletter],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$newsletter],200);

        
    //   }catch(\Exception $ex){
    //       return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

    //   } 
    }

  
}
