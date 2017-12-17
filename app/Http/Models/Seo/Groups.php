<?php

namespace App\Http\Models\Seo;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model {

    protected $fillable = ['id', 'name_grups'];
   
    protected $table = 'groups';
    protected $primaryKey = 'id';

    public function projects(){
         return $this->nahMany('App\Http\Models\Sep\Projects','groups_id');
    }
    
}
