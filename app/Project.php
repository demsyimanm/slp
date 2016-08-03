<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'project';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
    	'user_id',
    	'diskripsi',
    	'alasan',
    	'sponsor_id',
    	'status',
    	'budgetperkiraan',
    	'budgetperusahaan',
    	'mentor'
    		 
    ];
    protected $SoftDelete = true;
    protected $dates = ['deleted_at'];


	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function sponsor()
	{
		return $this->belongsTo('App\Sponsor');
	}

	public function resource()
	{
		return $this->hasMany('App\Resource');
	}

    public function timeline()
    {
        return $this->hasMany('App\Timeline');
    }
}
