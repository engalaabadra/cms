<?php
    use Modules\Activity\Entities\Activity;
    function activity($model,$action){
        $user=auth()->guard('api')->user();
        $nameClassModel=class_basename(get_class($model));
        Activity::insert(['user_id'=>$user->id,'name'=>$user->first_name." ".$action." ".$nameClassModel,'created_at'=>now()]);
    }