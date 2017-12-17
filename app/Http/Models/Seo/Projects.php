<?php

namespace App\Http\Models\Seo;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model {

    protected $fillable = ['id','refers_projects_id','id_user', 'groups_id', 'project_name','project_domain'];
   
    protected $table = 'projects';
    protected $primaryKey = 'id';
    
    public function groups(){
         return $this->belongsTo('App\Http\Models\Seo\Groups','groups_id','groups_id');
    }
    public function links(){
         return $this->hasMany('App\Http\Models\Seo\Links','projects_id');
    }
    
}
