<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    protected $table = 'timeline';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
    	'project_id',
    	'tanggalmulai',
    	'tanggalakhir',
        'urutan',
    	'deskripsitimeline',
    	'submittimeline',
    	'statustimeline',		 
    ];
    protected $SoftDelete = true;
    protected $dates = ['deleted_at'];


	public function project()
	{
		return $this->belongsTo('App\Project');
	}
}
