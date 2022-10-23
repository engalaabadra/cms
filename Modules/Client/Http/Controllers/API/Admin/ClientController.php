<?php

namespace Modules\Client\Http\Controllers\API\Admin;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Client\Entities\Client;
use Modules\Client\Http\Requests\DeleteClientRequest;
use Modules\Client\Repositories\Admin\ClientRepository;

class ClientController extends Controller
{
      /**
     * @var BaseRepository
     */
    protected $baseRepo;
    /**
     * @var ClientRepository
     */
    protected $clientRepo;
    /**
     * @var Client
     */
    protected $client;
   

    /**
     * ClientsController constructor.
     *
     * @param ClientRepository $clients
     */
    public function __construct(BaseRepository $baseRepo, Client $client,ClientRepository $clientRepo)
    {
        $this->middleware(['permission:clients_read'])->only('index','getAllPaginates');
        $this->middleware(['permission:clients_trash'])->only('trash');
        $this->middleware(['permission:clients_restore'])->only('restore');
        $this->middleware(['permission:clients_restore-all'])->only('restore-all');
        $this->middleware(['permission:clients_show'])->only('show');
        $this->middleware(['permission:clients_store'])->only('store');
        $this->middleware(['permission:clients_update'])->only('update');
        $this->middleware(['permission:clients_destroy'])->only('destroy');
        $this->middleware(['permission:clients_destroy-force'])->only('destroy-force');
        $this->baseRepo = $baseRepo;
        $this->client = $client;
        $this->clientRepo = $clientRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang=null){
        // try{
        $clients=$this->clientRepo->all($this->client,$lang);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$clients],200);

        
        // }catch(\Exception $ex){
        //     return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        // } 
    }
        public function getAllPaginates(Request $request){
        
         try{
        $clients=$this->clientRepo->getAllPaginates($this->client,$request);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$clients],200);

               
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
       



    // methods for trash
    public function trash(Request $request){
  try{
        $clients=$this->clientRepo->trash($this->client,$request);
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$clients],200);

        
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
        $client=$this->clientRepo->find($id,$this->client);
                          if(is_string($client)){
            return response()->json(['status'=>false,'message'=>$client],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$client->load('clientCategory')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }

 


    //methods for restoring
    public function restore($id){
        
          try{
        $client =  $this->clientRepo->restore($id,$this->client);
                                  if(is_string($client)){
            return response()->json(['status'=>false,'message'=>$client],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$client->load('clientCategory')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 

    }
    public function restoreAll(){
          try{
        $clients =  $this->clientRepo->restoreAll($this->client);
                                  if(is_string($clients)){
            return response()->json(['status'=>false,'message'=>$clients],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$clients],200);

        
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
       $client= $this->clientRepo->destroy($id,$this->client);
                          if(is_string($client)){
            return response()->json(['status'=>false,'message'=>$client],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success'],'data'=>$client->load('clientCategory')],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
       
    }
    public function forceDelete(DeleteClientRequest $request,$id)
    {
          try{
        //to make force destroy for a Client must be this Client  not found in Clients table  , must be found in trash Clients
        $client=$this->clientRepo->forceDelete($id,$this->client);
                          if(is_string($client)){
            return response()->json(['status'=>false,'message'=>$client],404);
        }
          return response()->json(['status'=>true,'message'=>$this->baseRepo->globalVars()['success']],200);

        
        }catch(\Exception $ex){
            return response()->json(['status'=>false,'message'=>$this->baseRepo->globalVars()['error']],500);

        } 
    }
    
}
