<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = 'resource';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
    	'jobspec',
    	'cv',
    	'jobdesk',
    	'nama',
    	'nohp',   
    	'project_id' 		 
    ];
    protected $SoftDelete = true;
    protected $dates = ['deleted_at'];


	public function project()
	{
		return $this->belongsTo('App\Project');
	}
}
