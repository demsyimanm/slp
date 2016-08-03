<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $table = 'sponsor';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
    	'nama', 
    ];
    protected $SoftDelete = true;
    protected $dates = ['deleted_at'];


	public function project()
	{
		return $this->hasMany('App\Project');
	}

}