<?php

namespace Modules\Client\Http\Controllers\API\Admin\Infos;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Client\Entities\ClientInfo;
use Modules\Client\Entities\Client;
use Modules\Client\Http\Requests\Infos\DeleteClientRequest;
use Modules\Client\Http\Requests\Infos\StoreClientRequest;
use Modules\Client\Http\Requests\Infos\UpdateClientRequest;
use Modules\Client\Repositories\Admin\Infos\ClientRepository;

class ClientController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var ClientRepository
     */
    protected $clientInfoRepo;
    /**
     * @var ClientInfo
     */
    protected $clientInfo;
        /**
     * @var Client
     */
    protected $client;
   

    /**
     * ClientsController constructor.
     *
     * @param ClientRepository $clientInfos
     */
    public function __construct(BaseRepository $baseRepo, ClientInfo $clientInfo, Client $client,ClientRepository $clientInfoRepo)
    {
        $this->middleware(['permission:client_infos_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:client_infos_trash'])->only('trash');
        $this->middleware(['permission:client_infos_restore'])->only('restore');
        $this->middleware(['permission:client_infos_restore-all'])->only('restore-all');
        $this->middleware(['permission:client_infos_show'])->only('show');
        $this->middleware(['permission:client_infos_store'])->only('store');
        $this->middleware(['permission:client_infos_update'])->only('update');
        $this->middleware(['permission:client_infos_destroy'])->only('destroy');
        $this->middleware(['permission:client_infos_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->clientInfo = $clientInfo;
        $this->client = $client;
        $this->clientInfoRepo = $clientInfoRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        // try{
        $clientInfos=$this->clientInfoRepo->all($this->clientInfo);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$clientInfos],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
        public function getAllPaginates(Request $request){
        
         try{
        $clientInfos=$this->clientInfoRepo->getAllPaginates($this->clientInfo,$request);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$clientInfos],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
    public function getAllInfosClientPaginates($clientInfoId){
          try{
        $clientInfos=$this->clientInfoRepo->getAllInfosClientPaginates($this->client,$request,$clientInfoId);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$clientInfos],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $clientInfos=$this->clientInfoRepo->trash($this->clientInfo,$request);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$clientInfos],200);

        
       }catch(\Exception $ex){
           return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

       } 
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientRequest $request,$clientId)
    {
        try{
       $clientInfo= $this->clientInfoRepo->save($request,$this->client,$clientId);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$clientInfo->load('clientCategory')],200);

        
       }catch(\Exception $ex){
           return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

       } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
              try{
        $clientInfo=$this->clientInfoRepo->find($id,$this->clientInfo);
                          if(is_string($clientInfo)){
            return response()->json(['status'=>false,'message'=>$clientInfo],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$clientInfo->load('clientCategory')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

 

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request,$id)
    {
          try{
       $clientInfo= $this->clientInfoRepo->update($request,$id,$this->clientInfo);
                                 if(is_string($clientInfo)){
            return response()->json(['status'=>false,'message'=>$clientInfo],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$clientInfo->load('clientCategory')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

    //methods for restoring
    public function restore($id){
        
          try{
        $clientInfo =  $this->clientInfoRepo->restore($id,$this->clientInfo);
                                  if(is_string($clientInfo)){
            return response()->json(['status'=>false,'message'=>$clientInfo],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$clientInfo->load('clientCategory')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $clientInfos =  $this->clientInfoRepo->restoreAll($this->clientInfo);
                                  if(is_string($clientInfos)){
            return response()->json(['status'=>false,'message'=>$clientInfos],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$clientInfos],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        }
        
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteClientRequest $request,$id)
    {
           try{
       $clientInfo= $this->clientInfoRepo->destroy($id,$this->clientInfo);
                          if(is_string($clientInfo)){
            return response()->json(['status'=>false,'message'=>$clientInfo],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$clientInfo->load('clientCategory')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteClientRequest $request,$id)
    {
          try{
        //to make force destroy for a Client must be this Client  not found in Clients table  , must be found in trash Clients
        $clientInfo=$this->clientInfoRepo->forceDelete($id,$this->clientInfo);
                          if(is_string($clientInfo)){
            return response()->json(['status'=>false,'message'=>$clientInfo],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
