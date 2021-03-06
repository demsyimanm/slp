<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [ 
    	'project_id', 
        'jenis',
        'dari',
    	'perubahan'
    ];
    protected $SoftDelete = true;
    protected $dates = ['deleted_at'];

    public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function project()
	{
		return $this->belongsTo('App\Project');
	}

}
