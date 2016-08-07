<?php
namespace App\Http\Controllers;

use Auth;
use Input;
use Request;
use App\User;
use App\Project;
use App\Sponsor;
use App\Timeline;
use Datetime;
use App\Resource;
use App\History;

class ProjectController extends Controller
{
    public function create()
    {   
        if(Request::isMethod('get'))
        {
            if (Auth::check())
            {	
            	$mentors = Sponsor::get();
                return view('project.create',compact('mentors'));
            }
            return redirect('/');
        }
        else if(Request::isMethod('post'))
        {
            if (Auth::check())
            {
                ini_set("upload_max_filesize","30M");
		    	ini_set("post_max_size","30M");
		    	set_time_limit(3600);

                $data = Input::all();
				if ($_FILES["datafile"]["error"] > 0)
				{
				  echo "Error: " . $_FILES["datafile"]["error"] . "<br />";
				}
				else
				{

                	$insert = Project::insertGetId(array(
						'user_id'				=> Auth::user()->id,
						'namaproject'			=> $data['namaproject'],
						'deskripsi'				=> $data['deskripsi'],
						'alasan'				=> $data['alasan'],
						'intention'				=> $data['intention'],
						'sponsor_id'			=> $data['sponsor_id'],
						'status'				=> '0',
						'mentor'				=> $data['mentor']
					));

					$karya = array_get($data,'datafile');
                    $fileName_karya = 'budget_plan_'.Auth::user()->nip.'_'.(string)$insert.'_'.time().'_'.$karya->getClientOriginalName();
                    $upload_success_1 = $karya->move("budget", $fileName_karya);
                    $update = Project::where('id',$insert)->update(array(
                    	'budgetperkiraan'		=> $fileName_karya
                    ));

                    for ($i=0; $i < 4; $i++) {
                    	$j = $i+1; 
						$tgl = explode(" - ", $data['reservation'.$j]);
						$tglmulai = strtotime($tgl[0]);
						$tglakhir = strtotime($tgl[1]);
						$tglmulai_date = date('Y-m-d',$tglmulai);
						$tglakhir_date = date('Y-m-d',$tglakhir);
						Timeline::insertGetId(array(
                    		'project_id'		=> $insert,
                    		'tanggalmulai'		=> $tglmulai_date,
                    		'tanggalakhir'		=> $tglakhir_date,
                    		'urutan'			=> $j,
                    		'deskripsitimeline'	=> $data['descr'.$j],
                    		'statustimeline'	=> 0,
                    		'percentage'		=> 0
                    	));
                    }

					for ($i = 1; $i <= $data['sumOfGoods']; $i++) {
		                Resource::insertGetId(array(
		                	'project_id'	=> $insert,
		                    'jobspec' 		=> $data['js' . $i],
		                    'jobdesk'       => $data['jd' . $i],
		                ));
		            }
				}
                return redirect('project?status=success');
            }
            return redirect('/');
        }
    }

    public function home()
    {   
        if(Request::isMethod('get'))
        {
            if (Auth::check())
            {	
            	$projects = Project::get();
                return view('project.manage',compact('projects'));
            }
            return redirect('/');
        }
        else if(Request::isMethod('post'))
        {
            
        }
    }

    public function delete($id)
    {	
    	if (Auth::check())
        {
            if (Request::isMethod('get'))
            {
                Project::where('id', $id)->delete();
                return redirect('project?status=delete-success');
            }
        }
        else return redirect('/');
    }

    public function update($id)
    {   
        if(Request::isMethod('get'))
        {
            if (Auth::check())
            {	
            	$project = Project::find($id);
            	$mentors = Sponsor::get();
            	$times = Timeline::where('project_id',$id)->orderBy('urutan')->get(); 
            	$resources = Resource::where('project_id',$id)->get();
            	$res_sum = Resource::where('project_id',$id)->count();
            	$tgls = array();
            	$desc = array();
            	foreach ($times as $time) {
					$tglmulai_date = date('m/d/Y',strtotime($time->tanggalmulai));
					$tglakhir_date = date('m/d/Y',strtotime($time->tanggalakhir));
					$temp_tgl = $tglmulai_date.' - '.$tglakhir_date;

					array_push($tgls, $temp_tgl);
					array_push($desc, $time->deskripsitimeline);
            	}
                return view('project.update',compact('project','mentors','tgls','resources','desc','res_sum'));
            }
            return redirect('/');
        }

        else if(Request::isMethod('post'))
        {
            if (Auth::check())
            {
                ini_set("upload_max_filesize","30M");
		    	ini_set("post_max_size","30M");
		    	set_time_limit(3600);
		    	$project = Project::find($id);
                $data = Input::all();
                if ($_FILES["datafile"]['name'] != "")
                {

					if ($_FILES["datafile"]["error"] > 0)
					{
					  echo "Error: " . $_FILES["datafile"]["error"] . "<br />";
					}
					else
					{
						$karya = array_get($data,'datafile');
		                $fileName_karya = 'budget_plan_'.Auth::user()->nip.'_'.(string)$id.'_'.time().'_'.$karya->getClientOriginalName();
						if ($project->status != 0)
						{
							if ($project->namaproject != $data['namaproject'])
							{
								History::insertGetId(array(
									'project_id'	=> $id,
									'jenis'			=> 'Project Name',
									'dari'			=> $project->namaproject,
									'perubahan'		=> $data['namaproject']
								));
							}

							if ($project->deskripsi != $data['deskripsi'])
							{
								History::insertGetId(array(
									'project_id'	=> $id,
									'jenis'			=> 'Project Plan',
									'dari'			=> $project->deskripsi,
									'perubahan'		=> $data['deskripsi']
								));
							}

							if ($project->alasan != $data['alasan'])
							{
								History::insertGetId(array(
									'project_id'	=> $id,
									'jenis'			=> 'Project Background',
									'dari'			=> $project->alasan,
									'perubahan'		=> $data['alasan']
								));
							}

							if ($project->intention != $data['intention'])
							{
								History::insertGetId(array(
									'project_id'	=> $id,
									'jenis'			=> 'Strategic Intention',
									'dari'			=> $project->intention,
									'perubahan'		=> $data['intention']
								));
							}

							if ($project->sponsor_id != $data['sponsor_id'])
							{
								History::insertGetId(array(
									'project_id'	=> $id,
									'jenis'			=> 'Sponsor',
									'dari'			=> $project->sponsor_id,
									'perubahan'		=> $data['sponsor_id']
								));
							}

							if ($project->mentor != $data['mentor'])
							{
								History::insertGetId(array(
									'project_id'	=> $id,
									'jenis'			=> 'Mentor',
									'dari'			=> $project->mentor,
									'perubahan'		=> $data['mentor']
								));
							}

		                    History::insertGetId(array(
								'project_id'	=> $id,
								'jenis'			=> 'Budget Plan',
								'dari'			=> $project->budgetperkiraan,
								'perubahan'		=> $fileName_karya
							));

						}

	                	Project::where('id',$id)->update(array(
							'namaproject'			=> $data['namaproject'],
							'deskripsi'				=> $data['deskripsi'],
							'alasan'				=> $data['alasan'],
							'intention'				=> $data['intention'],
							'sponsor_id'			=> $data['sponsor_id'],
							'mentor'				=> $data['mentor']
						));

						$upload_success_1 = $karya->move("budget", $fileName_karya);
	                    $update = Project::where('id',$id)->update(array(
	                    	'budgetperkiraan'		=> $fileName_karya
	                    ));

						for ($i=0; $i < 4; $i++) {
	                    	$j = $i+1; 
							$tgl = explode(" - ", $data['reservation'.$j]);
							$tglmulai = strtotime($tgl[0]);
							$tglakhir = strtotime($tgl[1]);
							$tglmulai_date = date('Y-m-d',$tglmulai);
							$tglakhir_date = date('Y-m-d',$tglakhir);
							$timeline = Timeline::where('project_id',$id)->where('urutan',$j)->first();
							if ($timeline->tanggalmulai != $tglmulai_date)
							{
								History::insertGetId(array(
									'project_id'	=> $id,
									'jenis'			=> 'Start Date at Monitoring '.$j,
									'dari'			=> $timeline->tanggalmulai,
									'perubahan'		=> $tglmulai_date
								));
							}

							if ($timeline->tanggalakhir != $tglakhir_date)
							{
								History::insertGetId(array(
									'project_id'	=> $id,
									'jenis'			=> 'Finish Date at Monitoring '.$j,
									'dari'			=> $timeline->tanggalakhir,
									'perubahan'		=> $tglakhir_date
								));
							}

							if ($timeline->deskripsitimeline != $data['descr'.$j])
							{
								History::insertGetId(array(
									'project_id'	=> $id,
									'jenis'			=> 'What need to be done at Monitoring '.$j,
									'dari'			=> $timeline->deskripsitimeline,
									'perubahan'		=> $data['descr'.$j]
								));
							}

							$del = Timeline::where('project_id',$id)->where('urutan',$j)->delete();

							Timeline::insertGetId(array(
	                    		'project_id'		=> $id,
	                    		'tanggalmulai'		=> $tglmulai_date,
	                    		'tanggalakhir'		=> $tglakhir_date,
	                    		'urutan'			=> $j,
	                    		'deskripsitimeline'	=> $data['descr'.$j],
	                    	));
	                    }

	                    $del = Resource::where('project_id',$id)->delete();
						for ($i = 1; $i <= $data['sumOfGoods']; $i++) {
			                Resource::insertGetId(array(
			                	'project_id'	=> $id,
			                    'jobspec' 		=> $data['js' . $i],
			                    'jobdesk'       => $data['jd' . $i],
			                ));
			            }
					}
	                return redirect('project?status=update-success');
                }
                else
                {
                	if ($project->status != 0)
					{
						if ($project->namaproject != $data['namaproject'])
						{
							History::insertGetId(array(
								'project_id'	=> $id,
								'jenis'			=> 'Project Name',
								'dari'			=> $project->namaproject,
								'perubahan'		=> $data['namaproject']
							));
						}

						if ($project->deskripsi != $data['deskripsi'])
						{
							History::insertGetId(array(
								'project_id'	=> $id,
								'jenis'			=> 'Project Plan',
								'dari'			=> $project->deskripsi,
								'perubahan'		=> $data['deskripsi']
							));
						}

						if ($project->alasan != $data['alasan'])
						{
							History::insertGetId(array(
								'project_id'	=> $id,
								'jenis'			=> 'Project Background',
								'dari'			=> $project->alasan,
								'perubahan'		=> $data['alasan']
							));
						}

						if ($project->intention != $data['intention'])
						{
							History::insertGetId(array(
								'project_id'	=> $id,
								'jenis'			=> 'Strategic Intention',
								'dari'			=> $project->intention,
								'perubahan'		=> $data['intention']
							));
						}

						if ($project->sponsor_id != $data['sponsor_id'])
						{
							History::insertGetId(array(
								'project_id'	=> $id,
								'jenis'			=> 'Sponsor',
								'dari'			=> $project->sponsor_id,
								'perubahan'		=> $data['sponsor_id']
							));
						}

						if ($project->mentor != $data['mentor'])
						{
							History::insertGetId(array(
								'project_id'	=> $id,
								'jenis'			=> 'Mentor',
								'dari'			=> $project->mentor,
								'perubahan'		=> $data['mentor']
							));
						}
					}

                	Project::where('id',$id)->update(array(
						'namaproject'			=> $data['namaproject'],
						'deskripsi'				=> $data['deskripsi'],
						'alasan'				=> $data['alasan'],
						'intention'				=> $data['intention'],
						'sponsor_id'			=> $data['sponsor_id'],
						'mentor'				=> $data['mentor']
					));

					
					//$del = Timeline::where('project_id',$id)->delete();
                    for ($i=0; $i < 4; $i++) {
                    	$j = $i+1; 
						$tgl = explode(" - ", $data['reservation'.$j]);
						$tglmulai = strtotime($tgl[0]);
						$tglakhir = strtotime($tgl[1]);
						$tglmulai_date = date('Y-m-d',$tglmulai);
						$tglakhir_date = date('Y-m-d',$tglakhir);
						$timeline = Timeline::where('project_id',$id)->where('urutan',$j)->first();
						if ($timeline->tanggalmulai != $tglmulai_date)
						{
							History::insertGetId(array(
								'project_id'	=> $id,
								'jenis'			=> 'Start Date at Monitoring '.$j,
								'dari'			=> $timeline->tanggalmulai,
								'perubahan'		=> $tglmulai_date
							));
						}

						if ($timeline->tanggalakhir != $tglakhir_date)
						{
							History::insertGetId(array(
								'project_id'	=> $id,
								'jenis'			=> 'Finish Date at Monitoring '.$j,
								'dari'			=> $timeline->tanggalakhir,
								'perubahan'		=> $tglakhir_date
							));
						}

						if ($timeline->deskripsitimeline != $data['descr'.$j])
						{
							History::insertGetId(array(
								'project_id'	=> $id,
								'jenis'			=> 'What need to be done at Monitoring '.$j,
								'dari'			=> $timeline->deskripsitimeline,
								'perubahan'		=> $data['descr'.$j]
							));
						}
						$del = Timeline::where('project_id',$id)->where('urutan',$j)->delete();

						Timeline::insertGetId(array(
                    		'project_id'		=> $id,
                    		'tanggalmulai'		=> $tglmulai_date,
                    		'tanggalakhir'		=> $tglakhir_date,
                    		'urutan'			=> $j,
                    		'deskripsitimeline'	=> $data['descr'.$j],
                    	));
                    }
                    $del = Resource::where('project_id',$id)->delete();
					for ($i = 1; $i <= $data['sumOfGoods']; $i++) {
		                Resource::insertGetId(array(
		                	'project_id'	=> $id,
		                    'jobspec' 		=> $data['js' . $i],
		                    'jobdesk'       => $data['jd' . $i],
		                ));
		            }
		            return redirect('project?status=update-success');
                }
	        }
            return redirect('/');
        }
    }
}
