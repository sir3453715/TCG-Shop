<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActionLog extends Model
{
    use HasFactory;
    protected $table = 'action_log';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','action_table','action_id','change_column','action'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function create_log( $model=null , $action='修改' ){
        if($action == '修改'){
            $new_array=$model->getDirty();
            $change_array = array();
            foreach ($new_array as $key=>$value){
                $change_array[]='修改 '.$key.' 從 "'.$model->getOriginal($key).'" 改為 "'.$value.'"';
            }
            $change_column = json_encode($change_array);
        }else{
            $modelArray = $model->toArray();
            if (isset($modelArray['roles'])&&is_array($modelArray['roles'])){
                $roles = $modelArray['roles'][0]['display_name'];
                unset($modelArray['roles']);
                $modelArray['roles'] = $roles;
            }
            $change_column = json_encode($modelArray);
        }
        if($change_column != '[]'){
            $data=[
                'user_id'=>Auth::id(),
                'action_table'=>class_basename($model),
                'action_id'=>$model->id,
                'change_column'=>$change_column,
                'action'=>$action,
            ];

            ActionLog::create($data);
        }
    }

}
