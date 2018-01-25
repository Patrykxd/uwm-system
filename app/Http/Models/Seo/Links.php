<?php

namespace App\Http\Models\Seo;

use Illuminate\Database\Eloquent\Model;

class Links extends Model {

    protected $fillable = [
        'links_id', 'projects_id',
        'anchor', 'url', 'refersto',
        'server_response', 'nofollow',
        'status', 'robot'
    ];
    protected $table = 'links';
    protected $primaryKey = 'links_id';

    public function projects() {
        return $this->hasMany(
                'App\Http\Models\Seo\Projects',
                'id', 'projects_id');
    }

}
