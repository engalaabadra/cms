<?php

namespace Modules\Add\Http\Controllers\API\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\BaseRepository;

use Modules\Add\Repositories\User\AddRepository;
use Modules\Add\Entities\Add;
class AddController extends Controller
{
     /**
     * @var AddRepository
     */
    protected $addRepo;
        /**
     * @var Add
     */
    protected $add;
   

    /**
     * AddsController constructor.
     *
     * @param AddRepository $add
     */
    public function __construct(BaseRepository $baseRepo, Add $add,AddRepository $addRepo)
    {

        $this->baseRepo = $baseRepo;
        $this->add = $add;
        $this->addRepo = $addRepo;
    }
 public function index($lang=null){
        $adds=$this->addRepo->all($this->add,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$adds],200);

    } 
}
