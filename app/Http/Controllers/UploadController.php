<?php

namespace App\Http\Controllers;

use Auth;
use Input;
use Request;
use App\User;
use File;
use DB;
use Excel;
use App\MonthlyClosing;
use App\NewHire;
use App\Test;
use App\TestNewHire;
use App\RefreshmentNewHire;
use App\NotPassed;
use App\NotPassedNewHire;
use App\Refreshment;
use App\MainData;
use App\TrainingUjian;
use App\TrainingRefreshment;
use DateTime;
use Carbon\Carbon;
//use App\TargetRefreshment;
use App\TargetUjian;

class UploadController extends Controller
{
    public function monthlyClosing()
    {   
        if(Request::isMethod('get'))
        {
        	if (Auth::check())
            {
        		return view('upload.monthlyClosing');
        	}
            return redirect('login');
        }
        else
        {
        	if (Auth::check())
            {
	        	ini_set("upload_max_filesize","300M");
		    	ini_set("post_max_size","300M");
		    	set_time_limit(108000);
				
		    	$input = Input::all();

				if ($_FILES["monthlyClosing"]["error"] > 0)
				{
				  echo "Error: " . $_FILES["monthlyClosing"]["error"] . "<br />";
				}
				else
				{

					$monthlyClosing = array_get($input,'monthlyClosing');
		            $fileName_monthlyClosing = $monthlyClosing->getClientOriginalName();
		            $upload_success = $monthlyClosing->move("upload", $fileName_monthlyClosing);
		            //echo $fileName_monthlyClosing;
		            $data = Excel::load('upload/'.$fileName_monthlyClosing, function($reader){
		            	$temp = $reader->toObject();
		            	$temp->each(function($data) {

		            		$cek_nh = NewHire::where('id',$data->nip)->count();
		            		if ($cek_nh > 0)
		            		{
		            			$datas = NewHire::find($data->nip);
		            			MainData::insertGetId(array(
		            				'monthlyClosing_id'		=> $data->nip,
		            				'name'					=> $datas->name,
		            				'passed'				=> $datas->passed,
		            				'passedDate'			=> $datas->passedDate,
		            				'SCRTU'					=> 'new',
		            				'BSMRID'				=> $datas->BSMRID,
		            				'LSPPID'				=> $datas->LSPPID,
		            				'lastRefreshment'		=> $datas->lastRefreshment,
		            				'users_id'				=> Auth::user()->name
		            			));
		            			NewHire::where('id', $data->nip)->delete();
		            		}
		            		
	            			$cek = MonthlyClosing::where('id',$data->nip)->count();
		            		if($cek > 0)
		            		{
		            			MonthlyClosing::where('id',$data->nip)->update(array(
									'grade'				=> $data->grade,
									'directorate'		=> $data->directorate,
									'subdirectorate'	=> $data->sub_directorate,
									'group'				=> $data->group,
									'division'			=> $data->division,
									'department'		=> $data->department,
									'job'				=> $data->job,
									'costCenter'		=> $data->cost_center,
									'location'			=> $data->location,
									'orgName'			=> $data->org_name,
									'maritalStatus'		=> $data->marital_status,
									'status'			=> $data->status,
									'religion'			=> $data->religion,
									'branchInitial'		=> $data->branch_initial,
									'locGroup'			=> $data->loc_group,
									'payrollName'		=> $data->payroll_name,
									'email'				=> $data->email_address,
									'users_id'			=> Auth::user()->name
			                    ));	
		            		}
		            		else
		            		{
		            			MonthlyClosing::insertGetId(array(
			                        'id'				=> $data->nip,
									'name'				=> $data->emp_name,
									'grade'				=> $data->grade,
									'directorate'		=> $data->directorate,
									'subdirectorate'	=> $data->sub_directorate,
									'group'				=> $data->group,
									'division'			=> $data->division,
									'department'		=> $data->department,
									'job'				=> $data->job,
									'costCenter'		=> $data->cost_center,
									'location'			=> $data->location,
									'orgName'			=> $data->org_name,
									'dateOfBirth'		=> $data->date_of_birth->toDateString(),
									'hireDate'			=> $data->hire_date->toDateString(),
									'gender'			=> $data->gender,
									'maritalStatus'		=> $data->marital_status,
									'status'			=> $data->status,
									'religion'			=> $data->religion,
									'branchInitial'		=> $data->branch_initial,
									'locGroup'			=> $data->loc_group,
									'payrollName'		=> $data->payroll_name,
									'email'				=> $data->email_address,
									'users_id'			=> Auth::user()->name
			                    ));	
		            		}
		            		
						});
						DB::commit();
						//dd($temp[0]->nip);

		            });
					return redirect('upload/monthlyClosing?status=success');
				}
            	return redirect('login');
			}
        }
    }

    public function termination()
    {   
        if(Request::isMethod('get'))
        {
        	if (Auth::check())
            {
        		return view('upload.termination');
        	}
            return redirect('login');
        }
        else
        {
        	if (Auth::check())
            {
	        	ini_set("upload_max_filesize","300M");
		    	ini_set("post_max_size","300M");
		    	set_time_limit(108000);
				
		    	$input = Input::all();

				if ($_FILES["termination"]["error"] > 0)
				{
				  echo "Error: " . $_FILES["termination"]["error"] . "<br />";
				}
				else
				{

					$termination = array_get($input,'termination');
		            $fileName_termination = $termination->getClientOriginalName();
		            $upload_success = $termination->move("upload", $fileName_termination);
		            //echo $fileName_monthlyClosing;
		            $data = Excel::load('upload/'.$fileName_termination, function($reader){
		            	$temp = $reader->toObject();
		            	$temp->each(function($data) {
					    	MonthlyClosing::insertGetId(array(
		                        'id'				=> $data->nip,
								'name'				=> $data->emp_name,
								'grade'				=> $data->grade,
								'period'			=> $data->period,
								'terminationDate'	=> $data->termination_date->toDateString(),
								'directorate'		=> $data->directorate,
								'subdirectorate'	=> $data->sub_directorate,
								'group'				=> $data->group,
								'division'			=> $data->division,
								'department'		=> $data->department,
								'job'				=> $data->job,
								'costCenter'		=> $data->cost_center,
								'location'			=> $data->location,
								'orgName'			=> $data->org_name,
								'dateOfBirth'		=> $data->date_of_birth->toDateString(),
								'hireDate'			=> $data->hire_date->toDateString(),
								'gender'			=> $data->gender,
								'maritalStatus'		=> $data->marital_status,
								'status'			=> $data->status,
								'religion'			=> $data->religion,
								'branchInitial'		=> $data->branch_initial,
								'locGroup'			=> $data->loc_group,
								'payrollName'		=> $data->payroll_name,
								'email'				=> $data->email_address,
								'users_id'			=> Auth::user()->name
		                    ));

						});
						DB::commit();
						//dd($temp[0]->nip);

		            });
					return redirect('upload/termination?status=success');
				}
            	return redirect('login');
			}
        }
    }

    /*public function newHire()
    {   
        if(Request::isMethod('get'))
        {
        	if (Auth::check())
            {
        		return view('upload.newHire');
        	}
            return redirect('login');
        }
        else
        {
        	if (Auth::check())
            {
	        	ini_set("upload_max_filesize","300M");
		    	ini_set("post_max_size","300M");
		    	set_time_limit(108000);
				
		    	$input = Input::all();

				if ($_FILES["newHire"]["error"] > 0){
				  echo "Error: " . $_FILES["newHire"]["error"] . "<br />";
				}
				else
				{

					$newHire = array_get($input,'newHire');
		            $fileName_newHire = $newHire->getClientOriginalName();
		            $upload_success = $newHire->move("upload", $fileName_newHire);
		            //echo $fileName_monthlyClosing;
		            $data = Excel::load('upload/'.$fileName_newHire, function($reader){
		            	$temp = $reader->toObject();
		            	$temp->each(function($data) {

		            		$cek = NewHire::where('id',$data->nip)->count();
		            		if ($cek > 0)
		            		{
		            			NewHire::where('id',$data->nip)->update(array(
									'name'				=> $data->emp_name,
									'grade'				=> $data->grade,
									'period'			=> $data->period,
									'hireDate'			=> $data->hire_date->toDateString(),
									'directorate'		=> $data->directorate,
									'subdirectorate'	=> $data->sub_directorate,
									'group'				=> $data->group,
									'division'			=> $data->division,
									'department'		=> $data->department,
									'job'				=> $data->job,
									'rcCode'			=> $data->rc_code,
									'location'			=> $data->location,
									'orgName'			=> $data->org_name,
									'dateOfBirth'		=> $data->date_of_birth->toDateString(),
									'gender'			=> $data->gender,
									'maritalStatus'		=> $data->marital_status,
									'statusNewHire'		=> $data->status,
									'religion'			=> $data->religion,
									'locGroup'			=> $data->loc_group,
									'payrollName'		=> $data->payroll_name,
									'email'				=> $data->email_address,
									'remarkNewHire'		=> $data->remarks,
									'users_id'			=> Auth::user()->name
			                    ));
		            		}
		            		else
		            		{
		            			NewHire::insertGetId(array(
			                        'id'				=> $data->nip,
									'name'				=> $data->emp_name,
									'grade'				=> $data->grade,
									'period'			=> $data->period,
									'hireDate'			=> $data->hire_date->toDateString(),
									'directorate'		=> $data->directorate,
									'subdirectorate'	=> $data->sub_directorate,
									'group'				=> $data->group,
									'division'			=> $data->division,
									'department'		=> $data->department,
									'job'				=> $data->job,
									'rcCode'			=> $data->rc_code,
									'location'			=> $data->location,
									'orgName'			=> $data->org_name,
									'dateOfBirth'		=> $data->date_of_birth->toDateString(),
									'gender'			=> $data->gender,
									'maritalStatus'		=> $data->marital_status,
									'statusNewHire'		=> $data->status,
									'religion'			=> $data->religion,
									'locGroup'			=> $data->loc_group,
									'payrollName'		=> $data->payroll_name,
									'email'				=> $data->email_address,
									'remarkNewHire'		=> $data->remarks,
									'users_id'			=> Auth::user()->name
			                    ));
		            		}
					    	

						});
						DB::commit();
						//dd($temp[0]->nip);

		            });
					return redirect('upload/newHire?status=success');
				}
            	return redirect('login');
			}
        }
    }
*/
    public function ujian()
    {   
        if(Request::isMethod('get'))
        {
        	if (Auth::check())
            {
        		return view('upload.ujian');
        	}
            return redirect('login');
        }
        else
        {
        	if (Auth::check())
            {
	        	ini_set("upload_max_filesize","300M");
		    	ini_set("post_max_size","300M");
		    	set_time_limit(108000);
				
		    	$input = Input::all();

				if ($_FILES["ujian"]["error"] > 0){
				  echo "Error: " . $_FILES["ujian"]["error"] . "<br />";
				}
				else{

					$ujian = array_get($input,'ujian');
		            $fileName_ujian = $ujian->getClientOriginalName();
		            $upload_success = $ujian->move("upload", $fileName_ujian);
		            //echo $fileName_monthlyClosing;
		            $data = Excel::load('upload/'.$fileName_ujian, function($reader){
		            	$temp = $reader->toObject();
		            	$temp->each(function($data) {
		            		if($data->hasil[0] == 'K')
		            		{
		            			Test::where('nip',$data->nip)->where('level',$data->level)->update(array(
									'lembaga'			=> $data->nia,
									'tgl'				=> $data->tgl_ujian,
									'users_id'			=> Auth::user()->name
			                    ));
		            		}
		            		else
		            		{
		            			NotPassed::insertGetId(array(
			                        'nip'				=> $data->nip,
									'name'				=> $data->emp_name,
									'level'				=> $data->level,
									'tgl'				=> $data->tgl_ujian,
									'result'			=> $data->hasil,
									'users_id'			=> Auth::user()->name
			                    ));
		            		}
					    	
						});
						DB::commit();
						//dd($temp[0]->nip);

		            });
					return redirect('upload/ujian?status=success');
				}
            	return redirect('login');
			}
        }
    }

    public function refreshment()
    {   
        if(Request::isMethod('get'))
        {
        	if (Auth::check())
            {
        		return view('upload.refreshment');
        	}
            return redirect('login');
        }
        else
        {
        	if (Auth::check())
            {
	        	ini_set("upload_max_filesize","300M");
		    	ini_set("post_max_size","300M");
		    	set_time_limit(108000);
				
		    	$input = Input::all();

				if ($_FILES["refreshment"]["error"] > 0){
				  echo "Error: " . $_FILES["refreshment"]["error"] . "<br />";
				}
				else{

					$refreshment = array_get($input,'refreshment');
		            $fileName_refreshment = $refreshment->getClientOriginalName();
		            $upload_success = $refreshment->move("upload", $fileName_refreshment);
		            //echo $fileName_monthlyClosing;
		            $data = Excel::load('upload/'.$fileName_refreshment, function($reader){
		            	$temp = $reader->toObject();
		            	$temp->each(function($data) {
		            		if(!empty($data->tanggal))
		            		{
		            			$cek = Refreshment::where('nip',$data->nip)->where('level',$data->level)->where('tgl',$data->tanggal)->count();
		            			if($cek > 0)
		            			{
			            			Refreshment::where('nip',$data->nip)->where('level',$data->level)->where('tgl',$data->tanggal)->update(array(
										'BSMRID'			=> $data->id_bsmr,
										'LSPPID'			=> $data->id_lspp,
										'status'			=> $data->status,
										'penyelenggara'		=> $data->penyelenggara,
										'materipembicara'	=> $data->materipembicara,
										'keterangan'		=> $data->keterangan,
										'users_id'			=> Auth::user()->name
				                    ));
				                }
				                else
				                {
				                	$ke = Refreshment::select('ke')->where('nip',$data->nip)->where('level',$data->level)
				                			->where('ke', DB::raw("(select max(`ke`) from refreshment where nip='".$data->nip."' and tgl != '0000-00-00')"))
				                			->first();

				                	if(is_null($ke))
				                	{
				                		Refreshment::insertGetId(array(
					                        'nip'				=> $data->nip,
											'name'				=> $data->emp_name,
											'level'				=> $data->level,
											'ke'				=> 1,
											'tgl'				=> $data->tanggal,
											'BSMRID'			=> $data->id_bsmr,
											'LSPPID'			=> $data->id_lspp,
											'status'			=> $data->status,
											'penyelenggara'		=> $data->penyelenggara,
											'materipembicara'	=> $data->materipembicara,
											'keterangan'		=> $data->keterangan,
											'users_id'			=> Auth::user()->name
					                    ));
				                	}

				                	else if ($ke->ke < 5)
				                	{
				                		Refreshment::where('nip',$data->nip)->where('level',$data->level)->where('ke',$ke->ke+1)->update(array(
											'tgl'				=> $data->tanggal,
											'BSMRID'			=> $data->id_bsmr,
											'LSPPID'			=> $data->id_lspp,
											'status'			=> $data->status,
											'penyelenggara'		=> $data->penyelenggara,
											'materipembicara'	=> $data->materipembicara,
											'keterangan'		=> $data->keterangan,
											'users_id'			=> Auth::user()->name
					                    ));
				                	}
				                	
				                	else if ($ke->ke >= 5)
				                	{
				                		Refreshment::where('nip',$data->nip)->where('level',$data->level)->where('tgl', DB::raw("(select min(`tgl`) from refreshment where nip='".$data->nip."' and level=".$data->level.")"))->update(array(
					                        'nip'				=> $data->nip,
											'name'				=> $data->emp_name,
											'level'				=> $data->level,
											'ke'				=> $ke->ke+1,
											'tgl'				=> $data->tanggal,
											'BSMRID'			=> $data->id_bsmr,
											'LSPPID'			=> $data->id_lspp,
											'status'			=> $data->status,
											'penyelenggara'		=> $data->penyelenggara,
											'materipembicara'	=> $data->materipembicara,
											'keterangan'		=> $data->keterangan,
											'users_id'			=> Auth::user()->name
					                    ));
				                	}
			                		$ujian = MainData::select('passedDate','passed')->where('monthlyClosing_id',$data->nip)->first();
			                		$dateUjian = DateTime::createFromFormat("Y-m-d", $ujian->passedDate->toDateString());	
	 								$day = $dateUjian->format("d");
	 								$mon = $dateUjian->format("m");
	 								$dateRef = DateTime::createFromFormat("Y-m-d", $data->tanggal->toDateString());

	 								if ($ujian->passed == 3 or $ujian->passed == 4 or $ujian->passed == 5 ) $jatuhTempo = 2;
		            				else if ($ujian->passed == 0 or $ujian->passed == 1 or $ujian->passed == 2) $jatuhTempo = 4;
	 								if ($dateRef >= $dateUjian)
	 								{
	 									$year = $dateRef->format("Y") + $jatuhTempo;
	 								}
	 								else if ($dateRef < $dateUjian)
	 								{
	 									$year = $dateUjian->format("Y") + $jatuhTempo;
	 								}
	 								
	 								$plan = $year.'-'.$mon.'-'.$day;
	 								MainData::where('monthlyClosing_id',$data->nip)->update(array(
										'nextRefreshment'		=> $plan,
										'users_id'			=> Auth::user()->name
				                    ));

				                    /*TargetRefreshment::where('nip',$data->nip)->where('tgl',NULL)->update(array(
				                    	'nextRefreshment'	=> $plan,
				                    ));*/
				                }
		            		}
		            		/*else
		            		{
		            			Refreshment::insertGetId(array(
									'BSMRID'			=> $data->id_bsmr,
									'LSPPID'			=> $data->id_lspp,
									'level'				=> $data->level,
									'status'			=> $data->status,
									'penyelenggara'		=> $data->penyelenggara,
									'keterangan'		=> $data->keterangan
			                    ));
		            		}*/
					    	

						});
						DB::commit();

		            });
					return redirect('upload/refreshment?status=success');
				}
            	return redirect('login');
			}
        }
    }

    public function databesar()
    {   
        if(Request::isMethod('get'))
        {
        	if (Auth::check())
            {
        		return view('upload.databesar');
        	}
            return redirect('login');
        }
        else
        {
        	if (Auth::check())
            {
	        	ini_set("upload_max_filesize","300M");
		    	ini_set("post_max_size","300M");
		    	set_time_limit(108000);
				
		    	$input = Input::all();

				if ($_FILES["databesar"]["error"] > 0){
				  echo "Error: " . $_FILES["databesar"]["error"] . "<br />";
				}
				else{


					$databesar = array_get($input,'databesar');
		            $fileName_databesar = $databesar->getClientOriginalName();
		            $upload_success = $databesar->move("upload", $fileName_databesar);
		            //echo $fileName_monthlyClosing;

		            $data = Excel::load('upload/'.$fileName_databesar, function($reader){
		            	$temp = $reader->get();

		            	$temp->each(function($data) {
		            		$cek = MainData::where('monthlyClosing_id',$data->nip)->count();
		            		if($cek > 0)
		            		{

		            			/*LEVEL BY REGULATION*/
		            			if($data->scrtu == 'Commisioner') $lvlbByReg = 1;
		            			else if($data->scrtu == 'Pres Comm') $lvlbByReg = 1;
		            			else if($data->scrtu == 'Indp Comm') $lvlbByReg = 2;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D0') $lvlbByReg = 5;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D1') $lvlbByReg = 4;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D2') $lvlbByReg = 3;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D3') $lvlbByReg = 2;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D4') $lvlbByReg = 1;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D5') $lvlbByReg = 0;
		            			else if($data->scrtu == 'SRTU' and $data->position_in_so == 'D0') $lvlbByReg = 4;
		            			else if($data->scrtu == 'SRTU' and $data->position_in_so == 'D1') $lvlbByReg = 1;
		            			else $lvlbByReg = 0;

		            			//RMCP Level
		            			$temp_tgl_lv = array();
		            			$temp_passed = 0;
		            			$init = DateTime::createFromFormat('Y-m-d', '1900-1-1');
		            			$temp_passed_date =  $init;

		            			if ($data->lv_1 != '0')
		            			{
		            				$temp_passed = 1;
		            				if ($data->lv_1 == 'P')
		            				{
		            					$temp_tgl_lv_1 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_1 != 'P' and $data->lv_1 != '0')
		            				{
		            					$temp_tgl_lv_1 =  DateTime::createFromFormat('Y-m-d', $data->lv_1->toDateString());
		            					$temp_passed_date = $temp_tgl_lv_1;
		            				}
		            				
		            			}
		            			else if ($data->lv_1 == '0')
		            			{
		            				$temp_tgl_lv_1 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_1);


		            			if ($data->lv_2 != '0')
		            			{
		            				$temp_passed = 2;
		            				if ($data->lv_2 == 'P')
		            				{
		            					$temp_tgl_lv_2 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_2 != 'P' and $data->lv_2 != '0')
		            				{
		            					$temp_tgl_lv_2 =  DateTime::createFromFormat('Y-m-d', $data->lv_2->toDateString());;
		            					$temp_passed_date = $temp_tgl_lv_2;
		            				}
		            				
		            			}
		            			else if ($data->lv_2 == '0')
		            			{
		            				$temp_tgl_lv_2 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_2);


		            			if ($data->lv_3 != '0')
		            			{
		            				$temp_passed = 3;
		            				if ($data->lv_3 == 'P')
		            				{
		            					$temp_tgl_lv_3 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_3 != 'P' and $data->lv_3 != '0')
		            				{
		            					$temp_tgl_lv_3 =  DateTime::createFromFormat('Y-m-d', $data->lv_3->toDateString());;
		            					$temp_passed_date = $temp_tgl_lv_3;
		            				}
		            				
		            			}
		            			else if ($data->lv_3 == '0')
		            			{
		            				$temp_tgl_lv_3 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_3);


		            			if ($data->lv_4 != '0')
		            			{
		            				$temp_passed = 4;
		            				if ($data->lv_4 == 'P')
		            				{
		            					$temp_tgl_lv_4 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_4 != 'P' and $data->lv_4 != '0')
		            				{
		            					$temp_tgl_lv_4 =  DateTime::createFromFormat('Y-m-d', $data->lv_4->toDateString());;
		            					$temp_passed_date = $temp_tgl_lv_4;
		            				}
		            				
		            			}
		            			else if ($data->lv_4 == '0')
		            			{
		            				$temp_tgl_lv_4 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_4);



		            			if ($data->lv_5 != '0')
		            			{
		            				$temp_passed = 5;
		            				if ($data->lv_5 == 'P')
		            				{
		            					$temp_tgl_lv_5 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_5 != 'P' and $data->lv_5 != '0')
		            				{
		            					$temp_tgl_lv_5 = DateTime::createFromFormat('Y-m-d', $data->lv_5->toDateString());;
		            					$temp_passed_date = $temp_tgl_lv_5;
		            				}
		            				
		            			}
		            			else if ($data->lv_5 == '0')
		            			{
		            				$temp_tgl_lv_5 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_5);

		            			// Cek Ujian
		            			$cek_ujian = Test::where('nip',$data->nip)->count();
		            			if($cek_ujian > 0)
		            			{
		            				for ($i=0;$i<5;$i++)
			            			{
			            				Test::where('nip',$data->nip)->where('level',$i+1)->update(array(
											'tgl'				=> $temp_tgl_lv[$i],
											'users_id'			=> Auth::user()->name
					                    ));

			            			}
		            			}
		            			else
		            			{
		            				for ($i=0;$i<5;$i++)
			            			{
			            				Test::insertGetId(array(
					                        'nip'				=> $data->nip,
											'name'				=> $data->emp_name,
											'level'				=> $i+1,
											'tgl'				=> $temp_tgl_lv[$i],
											'users_id'			=> Auth::user()->name
					                    ));

			            			}
		            			}
		            			

if ($temp_passed == 0 and $lvlbByReg == 0) $remark = "Not Required";
		            			else if ($temp_passed >= $lvlbByReg) $remark = "Certified";
		            			else if ($temp_passed < $lvlbByReg) $remark = "Uncertified";

		            			else $remark = '';

		            			//Refreshment
		            			$temp_tgl_ref_ke = array();
		            			$init = Carbon::createFromDate(1900, 0, 0, 'Asia/Jakarta');
		            			$temp_last_ref_date =  $init;

		            			if ($data->ke_1 != '0')
		            			{
		            				$temp_tgl_ke_1 = $data->ke_1;
		            				$temp_last_ref_date = $temp_tgl_ke_1;
		            			}
		            			else if ($data->ke_1 == '0')
		            			{
		            				$temp_tgl_ke_1 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_1);


		            			if ($data->ke_2 != '0')
		            			{
		            				$temp_tgl_ke_2 = $data->ke_2;
		            				$temp_last_ref_date = $temp_tgl_ke_2;
		            			}
		            			else if ($data->ke_2 == '0')
		            			{
		            				$temp_tgl_ke_2 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_2);


		            			if ($data->ke_3 != '0')
		            			{
		            				$temp_tgl_ke_3 = $data->ke_3;
		            				$temp_last_ref_date = $temp_tgl_ke_3;
		            			}
		            			else if ($data->ke_3 == '0')
		            			{
		            				$temp_tgl_ke_3 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_3);


		            			if ($data->ke_4 != '0')
		            			{
		            				$temp_tgl_ke_4 = $data->ke_4;
		            				$temp_last_ref_date = $temp_tgl_ke_4;
		            			}
		            			else if ($data->ke_4 == '0')
		            			{
		            				$temp_tgl_ke_4 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_4);


		            			if ($data->ke_5 != '0')
		            			{
		            				$temp_tgl_ke_5 = $data->ke_5;
		            				$temp_last_ref_date = $temp_tgl_ke_5;
		            			}
		            			else if ($data->ke_5 == '0')
		            			{
		            				$temp_tgl_ke_5 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_5);


		            			//JATUH TEMPO
		            			if ($temp_passed == 3 or $temp_passed == 4 or $temp_passed == 5 ) $jatuhTempo = 2;
		            			else if ($temp_passed == 0 or $temp_passed == 1 or $temp_passed == 2) $jatuhTempo = 4;

		            			//PLAN
		            			if ($remark == "Uncertified") 
	            				{
	            					$plan = 'Not Yet';
	            					$cek_target = TargetUjian::where('nip',$data->nip)->count();
	            					$emp = MonthlyClosing::find($data->nip);  
	            					if ($cek_target > 0)
	            					{
	            						TargetUjian::where('nip',$data->nip)->update(array(
	            							'name'				=> $data->emp_name,
	            							'directorate'		=> $emp->directorate,
	            							'SCRTU'				=> $data->scrtu,
	            							'SOposition'		=> $data->position_in_so,
	            							'levelByRegulation' => $lvlbByReg,
	            							'passed'			=> $temp_passed,
	            							'status'			=> 'Uncertified',
	            							'users_id'			=> Auth::user()->name
	            						));	
	            					}
	            					else
	            					{
	            						$date = date("Y-m-d");
						                $month = date("m");
						                $year = date("Y");
						                if ($month == 1 or $month == 3 or $month == 5 or $month == 7 or $month == 8 or $month == 10 or $month == 12) $day = 31;
						                else if ($month == 2)
						                {
						                	if ($year%4 == 0) $day=29;
						                	else $day = 28;
						                }
						                else $day = 30;
						                $full = $year.'-'.$month.'-'.$day;
						                $full_date = DateTime::createFromFormat("Y-m-d", $full);
	            						TargetUjian::insertGetId(array(
	            							'nip'				=> $data->nip,
	            							'name'				=> $data->emp_name,
	            							'directorate'		=> $emp->directorate,
	            							'outstanding'		=> $full_date,
	            							'SCRTU'				=> $data->scrtu,
	            							'SOposition'		=> $data->position_in_so,
	            							'levelByRegulation' => $lvlbByReg,
	            							'passed'			=> $temp_passed,
	            							'status'			=> $remark,
	            							'users_id'			=> Auth::user()->name
	            						));	
	            						
	            					}
	            				}
		            			else
		            			{

		            				$cek_target = TargetUjian::where('nip',$data->nip)->count();
	            					$emp = MonthlyClosing::find($data->nip);  
	            					if ($cek_target > 0 and $remark == 'Certified')
	            					{
	            						TargetUjian::where('nip',$data->nip)->update(array(
	            							'name'				=> $data->emp_name,
	            							'directorate'		=> $emp->directorate,
	            							'SCRTU'				=> $data->scrtu,
	            							'SOposition'		=> $data->position_in_so,
	            							'levelByRegulation' => $lvlbByReg,
	            							'passed'			=> $temp_passed,
	            							'status'			=> 'Certified',
	            							'users_id'			=> Auth::user()->name
	            						));	
	            					}

		            				$dateUjian = $temp_passed_date;	
	 								$day = $dateUjian->format("d");
	 								$mon = $dateUjian->format("m");
	 								$dateRef = DateTime::createFromFormat("Y-m-d", $temp_last_ref_date->toDateString());

	 								if ($dateRef >= $dateUjian)
	 								{
	 									$year = $dateRef->format("Y") + $jatuhTempo;
	 								}
	 								else if ($dateRef < $dateUjian)
	 								{
	 									$year = $dateUjian->format("Y") + $jatuhTempo;
	 								}
	 								

	 								$plan = $year.'-'.$mon.'-'.$day;
		            			}
		            			

		            			MainData::where('monthlyClosing_id',$data->nip)->update(array(
			                        'name'				=> $data->emp_name,
									'emailDS'			=> $data->email_ds,
									'SOupdate'			=> $data->so_update,
									'infoByEmail'		=> $data->info_by_email,
									'categorySRTU'		=> $data->category_srtu,
									'SCRTU'				=> $data->scrtu,
									'SOposition'		=> $data->position_in_so,
									'levelByRegulation'	=> $lvlbByReg,
									'passed'			=> $temp_passed,
									'remark'			=> $remark,
									'passedDate'		=> $temp_passed_date,
									'BSMRID'			=> $data->bsmr_id,
									'LSPPID'			=> $data->lspp_id,
									'lastRefreshment'	=> $temp_last_ref_date,
									'jatuhTempo'		=> $jatuhTempo,
									'nextRefreshment'	=> $plan,
									'lastLocation'		=> $data->location_last_refreshment,
									'users_id'			=> Auth::user()->name
			                    ));

		            			/*$cek_target_ref = TargetRefreshment::where('nip',$data->nip)->where('tgl',NULL)->count();
		            			if ($cek_target_ref > 0)
		            			{
		            				TargetRefreshment::where('nip',$data->nip)->where('tgl',NULL)->update(array(
		            					'tglKelulusan'		=> $temp_passed_date,
		            					'lastRefreshment'	=> $temp_last_ref_date,
				                    	'nextRefreshment'	=> $plan,
				                    	'level'				=> $temp_passed
		            				));
		            			}
		            			else
		            			{
		            				$emp = MonthlyClosing::find($data->nip);
		            				TargetRefreshment::insertGetId(array(
				                    	'nip'				=> $data->nip,
				                    	'name'				=> $data->emp_name,
				                    	'directorate'		=> $emp->directorate,
				                    	'tglKelulusan'		=> $temp_passed_date,
				                    	'lastRefreshment'	=> $temp_last_ref_date,
				                    	'nextRefreshment'	=> $plan,
				                    	'level'				=> $temp_passed
				                    ));
		            			}*/
			                    

			                    //Cek refreshment
		            			$cek_refreshment = Refreshment::where('nip',$data->nip)->count();
		            			if($cek_refreshment > 0)
		            			{
		            				for ($i=0;$i<5;$i++)
			            			{
			            				Refreshment::where('nip',$data->nip)->where('level',$temp_passed)->where('ke',$i+1)->update(array(
											'tgl'				=> $temp_tgl_ref_ke[$i],
											'users_id'			=> Auth::user()->name
					                    ));

			            			}
		            			}
		            			else
		            			{
		            				for ($i=0;$i<5;$i++)
			            			{
			            				Refreshment::insertGetId(array(
					                        'nip'				=> $data->nip,
											'name'				=> $data->emp_name,
											'level'				=> $temp_passed,
											'ke'				=> $i+1,
											'tgl'				=> $temp_tgl_ref_ke[$i],
											'users_id'			=> Auth::user()->name
					                    ));

			            			}
		            			}
		            		}
		            		else
		            		{

		            			/*LEVEL BY REGULATION*/
		            			if($data->scrtu == 'Commisioner') $lvlbByReg = 1;
		            			else if($data->scrtu == 'Pres Comm') $lvlbByReg = 1;
		            			else if($data->scrtu == 'Indp Comm') $lvlbByReg = 2;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D0') $lvlbByReg = 5;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D1') $lvlbByReg = 4;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D2') $lvlbByReg = 3;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D3') $lvlbByReg = 2;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D4') $lvlbByReg = 1;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D5') $lvlbByReg = 0;
		            			else if($data->scrtu == 'SRTU' and $data->position_in_so == 'D0') $lvlbByReg = 4;
		            			else if($data->scrtu == 'SRTU' and $data->position_in_so == 'D1') $lvlbByReg = 1;
		            			else $lvlbByReg = 0;

		            			/*PASSED*/
		            			//diganti $data->nip
		            			/*$pass = Test::where('nip','CN023729')->where('level', DB::raw("(select max(`level`) from test where nip='CN023729')"))->first();
		            			$passed = $pass->level;
		            			
		            			//REMARK
		            			if ($passed >= $lvlbByReg) $remark = "Certified";
		            			else if ($passed < $lvlbByReg) $remark = "Uncertified";
		            			//PASSED DATE
		            			$passDate = $pass->tgl;

		            			//BSMR
		            			$bsmr = $pass->BSMRID;

		            			//LSPP
		            			$lspp = $pass->LSPPID;

		            			//REFRESHMENT
		            			//LAST REF
		            			//diganti $data->nip
		            			$lastRef =  Refreshment::where('nip','CN002896')->where('level', DB::raw("(select max(`level`) from refreshment where nip='CN002896')"))->first();;
		            			//dd($lastRef);
		            			$tglLastRef = $lastRef->tgl;

		            			//JATUH TEMPO
		            			if ($lastRef->level == 3 or $lastRef->level == 4 or $lastRef->level == 5 ) $jatuhTempo = 2;
		            			else if ($lastRef->level == 0 or $lastRef->level == 1 or $lastRef->level == 2) $jatuhTempo = 4;

		            			//PLAN
		            			if ($remark == "Uncertified") $plan = 'Not Yet';
		            			else
		            			{
		            				$dateUjian = DateTime::createFromFormat("Y-m-d", $passDate);
	 								$day = $dateUjian->format("d");
	 								$mon = $dateUjian->format("m");

	 								$dateRef = DateTime::createFromFormat("Y-m-d", $tglLastRef);
	 								$year = $dateRef->format("Y") + $jatuhTempo;

	 								$plan = $year.'-'.$mon.'-'.$day;
		            			}*/

		            			//dd($plan);

		            			//RMCP Level
		            			$temp_tgl_lv = array();
		            			$temp_passed = 0;
		            			$init = DateTime::createFromFormat('Y-m-d', '1900-1-1');
		            			$temp_passed_date =  $init;

		            			if ($data->lv_1 != '0')
		            			{
		            				$temp_passed = 1;
		            				if ($data->lv_1 == 'P')
		            				{
		            					$temp_tgl_lv_1 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_1 != 'P' and $data->lv_1 != '0')
		            				{
		            					$temp_tgl_lv_1 = DateTime::createFromFormat('Y-m-d', $data->lv_1->toDateString());
		            					$temp_passed_date = $temp_tgl_lv_1;
		            				}
		            			}
		            			else if ($data->lv_1 == '0')
		            			{
		            				$temp_tgl_lv_1 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_1);


		            			if ($data->lv_2 != '0')
		            			{
		            				$temp_passed = 2;
		            				if ($data->lv_2 == 'P')
		            				{
		            					$temp_tgl_lv_2 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_2 != 'P' and $data->lv_2 != '0')
		            				{
		            					$temp_tgl_lv_2 =  DateTime::createFromFormat('Y-m-d', $data->lv_2->toDateString());
		            					$temp_passed_date = $temp_tgl_lv_2;
		            				}
		            				
		            			}
		            			else if ($data->lv_2 == '0')
		            			{
		            				$temp_tgl_lv_2 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_2);


		            			if ($data->lv_3 != '0')
		            			{
		            				$temp_passed = 3;
		            				if ($data->lv_3 == 'P')
		            				{
		            					$temp_tgl_lv_3 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_3 != 'P' and $data->lv_3 != '0')
		            				{
		            					$temp_tgl_lv_3 =  DateTime::createFromFormat('Y-m-d', $data->lv_3->toDateString());
		            					$temp_passed_date = $temp_tgl_lv_3;
		            				}
		            				
		            			}
		            			else if ($data->lv_3 == '0')
		            			{
		            				$temp_tgl_lv_3 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_3);


		            			if ($data->lv_4 != '0')
		            			{
		            				$temp_passed = 4;
		            				if ($data->lv_4 == 'P')
		            				{
		            					$temp_tgl_lv_4 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_4 != 'P' and $data->lv_4 != '0')
		            				{
		            					$temp_tgl_lv_4 =  DateTime::createFromFormat('Y-m-d', $data->lv_4->toDateString());
		            					$temp_passed_date = $temp_tgl_lv_4;
		            				}
		            				
		            			}
		            			else if ($data->lv_4 == '0')
		            			{
		            				$temp_tgl_lv_4 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_4);



		            			if ($data->lv_5 != '0')
		            			{
		            				$temp_passed = 5;
		            				if ($data->lv_5 == 'P')
		            				{
		            					$temp_tgl_lv_5 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_5 != 'P' and $data->lv_5 != '0')
		            				{
		            					$temp_tgl_lv_5 =  DateTime::createFromFormat('Y-m-d', $data->lv_5->toDateString());
		            					$temp_passed_date = $temp_tgl_lv_5;
		            				}
		            				
		            			}
		            			else if ($data->lv_5 == '0')
		            			{
		            				$temp_tgl_lv_5 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_5);

		            			// Cek Ujian
		            			$cek_ujian = Test::where('nip',$data->nip)->count();
		            			if($cek_ujian > 0)
		            			{
		            				for ($i=0;$i<5;$i++)
			            			{
			            				Test::where('nip',$data->nip)->where('level',$i+1)->update(array(
											'tgl'				=> $temp_tgl_lv[$i],
											'users_id'			=> Auth::user()->name
					                    ));

			            			}
		            			}
		            			else
		            			{
		            				for ($i=0;$i<5;$i++)
			            			{
			            				Test::insertGetId(array(
					                        'nip'				=> $data->nip,
											'name'				=> $data->emp_name,
											'level'				=> $i+1,
											'tgl'				=> $temp_tgl_lv[$i],
											'users_id'			=> Auth::user()->name
					                    ));

			            			}
		            			}
		            			
if ($temp_passed == 0 and $lvlbByReg == 0) $remark = "Not Required";
		            			else if ($temp_passed >= $lvlbByReg) $remark = "Certified";
		            			else if ($temp_passed < $lvlbByReg) $remark = "Uncertified";
		            			else $remark = '';

		            			//Refreshment
		            			$temp_tgl_ref_ke = array();
		            			$init = Carbon::createFromDate(1900, 0, 0, 'Asia/Jakarta');
		            			$temp_last_ref_date =  $init;

		            			if ($data->ke_1 != '0')
		            			{
		            				$temp_tgl_ke_1 = $data->ke_1;
		            				$temp_last_ref_date = $temp_tgl_ke_1;
		            			}
		            			else if ($data->ke_1 == '0')
		            			{
		            				$temp_tgl_ke_1 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_1);


		            			if ($data->ke_2 != '0')
		            			{
		            				$temp_tgl_ke_2 = $data->ke_2;
		            				$temp_last_ref_date = $temp_tgl_ke_2;
		            			}
		            			else if ($data->ke_2 == '0')
		            			{
		            				$temp_tgl_ke_2 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_2);


		            			if ($data->ke_3 != '0')
		            			{
		            				$temp_tgl_ke_3 = $data->ke_3;
		            				$temp_last_ref_date = $temp_tgl_ke_3;
		            			}
		            			else if ($data->ke_3 == '0')
		            			{
		            				$temp_tgl_ke_3 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_3);


		            			if ($data->ke_4 != '0')
		            			{
		            				$temp_tgl_ke_4 = $data->ke_4;
		            				$temp_last_ref_date = $temp_tgl_ke_4;
		            			}
		            			else if ($data->ke_4 == '0')
		            			{
		            				$temp_tgl_ke_4 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_4);


		            			if ($data->ke_5 != '0')
		            			{
		            				$temp_tgl_ke_5 = $data->ke_5;
		            				$temp_last_ref_date = $temp_tgl_ke_5;
		            			}
		            			else if ($data->ke_5 == '0')
		            			{
		            				$temp_tgl_ke_5 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_5);


		            			//JATUH TEMPO
		            			if ($temp_passed == 3 or $temp_passed == 4 or $temp_passed == 5 ) $jatuhTempo = 2;
		            			else if ($temp_passed == 0 or $temp_passed == 1 or $temp_passed == 2) $jatuhTempo = 4;

		            			//PLAN
		            			if ($remark == "Uncertified") 
	            				{

	            					$plan = 'Not Yet';
	            					$cek_target = TargetUjian::where('nip',$data->nip)->count();
	            					$emp = MonthlyClosing::find($data->nip);  
	            					if ($cek_target > 0)
	            					{
	            						TargetUjian::where('nip',$data->nip)->update(array(
	            							'name'				=> $data->emp_name,
	            							'directorate'		=> $emp->directorate,
	            							'SCRTU'				=> $data->scrtu,
	            							'SOposition'		=> $data->position_in_so,
	            							'levelByRegulation' => $lvlbByReg,
	            							'passed'			=> $temp_passed,
	            							'status'			=> 'Uncertified',
	            							'users_id'			=> Auth::user()->name
	            						));	
	            					}
	            					else
	            					{
	            						$date = date("Y-m-d");
						                $month = date("m");
						                $year = date("Y");
						                if ($month == 1 or $month == 3 or $month == 5 or $month == 7 or $month == 8 or $month == 10 or $month == 12) $day = 31;
						                else if ($month == 2)
						                {
						                	if ($year%4 == 0) $day=29;
						                	else $day = 28;
						                }
						                else $day = 30;
						                $full = $year.'-'.$month.'-'.$day;
						                $full_date = DateTime::createFromFormat("Y-m-d", $full);
	            						TargetUjian::insertGetId(array(
	            							'nip'				=> $data->nip,
	            							'name'				=> $data->emp_name,
	            							'directorate'		=> $emp->directorate,
	            							'outstanding'		=> $full_date,
	            							'SCRTU'				=> $data->scrtu,
	            							'SOposition'		=> $data->position_in_so,
	            							'levelByRegulation' => $lvlbByReg,
	            							'passed'			=> $temp_passed,
	            							'status'			=> 'Uncertified',
	            							'users_id'			=> Auth::user()->name
	            						));	
	            						
	            					}
	            				}
		            			else
		            			{

		            				$cek_target = TargetUjian::where('nip',$data->nip)->count();
	            					$emp = MonthlyClosing::find($data->nip);  
	            					if ($cek_target > 0)
	            					{
	            						TargetUjian::where('nip',$data->nip)->update(array(
	            							'name'				=> $data->emp_name,
	            							'directorate'		=> $emp->directorate,
	            							'SCRTU'				=> $data->scrtu,
	            							'SOposition'		=> $data->position_in_so,
	            							'levelByRegulation' => $lvlbByReg,
	            							'passed'			=> $temp_passed,
	            							'status'			=> 'Certified',
	            							'users_id'			=> Auth::user()->name
	            						));	
	            					}

		            				$dateUjian = $temp_passed_date;	
	 								$day = $dateUjian->format("d");
	 								$mon = $dateUjian->format("m");
	 								$dateRef = DateTime::createFromFormat("Y-m-d", $temp_last_ref_date->toDateString());

	 								if ($dateRef >= $dateUjian)
	 								{
	 									$year = $dateRef->format("Y") + $jatuhTempo;
	 								}
	 								else if ($dateRef < $dateUjian)
	 								{
	 									$year = $dateUjian->format("Y") + $jatuhTempo;
	 								}
	 								

	 								$plan = $year.'-'.$mon.'-'.$day;
		            			}
		            			


		            			MainData::insertGetId(array(
			                        'monthlyClosing_id'	=> $data->nip,
			                        'name'				=> $data->emp_name,
									'emailDS'			=> $data->email_ds,
									'SOupdate'			=> $data->so_update,
									'infoByEmail'		=> $data->info_by_email,
									'categorySRTU'		=> $data->category_srtu,
									'SCRTU'				=> $data->scrtu,
									'SOposition'		=> $data->position_in_so,
									'levelByRegulation'	=> $lvlbByReg,
									'passed'			=> $temp_passed,
									'remark'			=> $remark,
									'passedDate'		=> $temp_passed_date,
									'BSMRID'			=> $data->bsmr_id,
									'LSPPID'			=> $data->lspp_id,
									'lastRefreshment'	=> $temp_last_ref_date,
									'jatuhTempo'		=> $jatuhTempo,
									'nextRefreshment'	=> $plan,
									'lastLocation'		=> $data->location_last_refreshment,
									'users_id'			=> Auth::user()->name
			                    ));

		            			/*$cek_target_ref = TargetRefreshment::where('nip',$data->nip)->where('tgl',NULL)->count();
		            			if ($cek_target_ref > 0)
		            			{
		            				TargetRefreshment::where('nip',$data->nip)->where('tgl',NULL)->update(array(
		            					'tglKelulusan'		=> $temp_passed_date,
		            					'lastRefreshment'	=> $temp_last_ref_date,
				                    	'nextRefreshment'	=> $plan,
				                    	'level'				=> $temp_passed
		            				));
		            			}
		            			else
		            			{
		            				TargetRefreshment::insertGetId(array(
				                    	'nip'				=> $data->nip,
				                    	'name'				=> $data->emp_name,
				                    	'directorate'		=> $emp->directorate,
				                    	'tglKelulusan'		=> $temp_passed_date,
				                    	'lastRefreshment'	=> $temp_last_ref_date,
				                    	'nextRefreshment'	=> $plan,
				                    	'level'				=> $temp_passed
				                    ));
		            			}*/
			                    


			                    //Cek refreshment
		            			$cek_refreshment = Refreshment::where('nip',$data->nip)->count();
		            			if($cek_refreshment > 0)
		            			{
		            				for ($i=0;$i<5;$i++)
			            			{
			            				Refreshment::where('nip',$data->nip)->where('level',$temp_passed)->where('ke',$i+1)->update(array(
											'tgl'				=> $temp_tgl_ref_ke[$i],
											'users_id'			=> Auth::user()->name
					                    ));

			            			}
		            			}
		            			else
		            			{
		            				for ($i=0;$i<5;$i++)
			            			{
			            				Refreshment::insertGetId(array(
					                        'nip'				=> $data->nip,
											'name'				=> $data->emp_name,
											'level'				=> $temp_passed,
											'ke'				=> $i+1,
											'tgl'				=> $temp_tgl_ref_ke[$i],
											'users_id'			=> Auth::user()->name
					                    ));

			            			}
		            			}
		            		}
					    	
						});
						DB::commit();
						//dd($temp[0]->nip);

		            });
					return redirect('upload/maindata?status=success');
				}
            	return redirect('login');
			}
        }
    }

    public function hrbp()
    {   
        if(Request::isMethod('get'))
        {
        	if (Auth::check())
            {
        		return view('upload.hrbp');
        	}
            return redirect('login');
        }
        else
        {
        	if (Auth::check())
            {
	        	ini_set("upload_max_filesize","300M");
		    	ini_set("post_max_size","300M");
		    	set_time_limit(108000);
				
		    	$input = Input::all();

				if ($_FILES["hrbp"]["error"] > 0){
				  echo "Error: " . $_FILES["hrbp"]["error"] . "<br />";
				}
				else{

					$hrbp = array_get($input,'hrbp');
		            $fileName_hrbp = $hrbp->getClientOriginalName();
		            $upload_success = $hrbp->move("upload", $fileName_hrbp);
		            //echo $fileName_monthlyClosing;
		            $data = Excel::load('upload/'.$fileName_hrbp, function($reader){
		            	$temp = $reader->get();
		            	
		            	
		            	//$reader->dd();
		            	$temp->each(function($data) {	
		            		if(!is_null($data->if_any_revision) and !is_null($data->nip))
		            		{

		            			$emp = MainData::where('monthlyClosing_id',$data->nip)->first();

		            			if($data->scrtu == 'Commisioner') $lvlbByReg = 1;
		            			else if($data->scrtu == 'Pres Comm') $lvlbByReg = 1;
		            			else if($data->scrtu == 'Indp Comm') $lvlbByReg = 2;
		            			else if($data->scrtu == 'CRTU' and $data->if_any_revision == 'D0') $lvlbByReg = 5;
		            			else if($data->scrtu == 'CRTU' and $data->if_any_revision == 'D1') $lvlbByReg = 4;
		            			else if($data->scrtu == 'CRTU' and $data->if_any_revision == 'D2') $lvlbByReg = 3;
		            			else if($data->scrtu == 'CRTU' and $data->if_any_revision == 'D3') $lvlbByReg = 2;
		            			else if($data->scrtu == 'CRTU' and $data->if_any_revision == 'D4') $lvlbByReg = 1;
		            			else if($data->scrtu == 'CRTU' and $data->if_any_revision == 'D5') $lvlbByReg = 0;
		            			else if($data->scrtu == 'SRTU' and $data->if_any_revision == 'D0') $lvlbByReg = 4;
		            			else if($data->scrtu == 'SRTU' and $data->if_any_revision == 'D1') $lvlbByReg = 1;
		            			else $lvlbByReg = 0;


		            			if ($emp->passed >= $lvlbByReg) $remark = "Certified";
		            			else if ($emp->passed < $lvlbByReg) $remark = "Uncertified";
		            			else $remark = '';

		            			if ($emp->passed == 3 or $emp->passed == 4 or $emp->passed == 5 ) $jatuhTempo = 2;
		            			else if ($emp->passed == 0 or $emp->passed == 1 or $emp->passed == 2) $jatuhTempo = 4;

								if ($remark == "Uncertified") 
	            				{

	            					$plan = 'Not Yet';
	            					$cek_target = TargetUjian::where('nip',$data->nip)->count();
	            					$emp2 = MonthlyClosing::find($data->nip);  
	            					if ($cek_target > 0)
	            					{
	            						TargetUjian::where('nip',$data->nip)->update(array(
	            							'name'				=> $data->emp_name,
	            							'directorate'		=> $emp2->directorate,
	            							'SCRTU'				=> $data->scrtu,
	            							'SOposition'		=> $data->if_any_revision,
	            							'levelByRegulation' => $lvlbByReg,
	            							'passed'			=> $emp->passed,
	            							'status'			=> 'Uncertified',
	            							'users_id'			=> Auth::user()->name
	            						));	
	            					}
	            					else
	            					{
	            						$date = date("Y-m-d");
						                $month = date("m");
						                $year = date("Y");
						                if ($month == 1 or $month == 3 or $month == 5 or $month == 7 or $month == 8 or $month == 10 or $month == 12) $day = 31;
						                else if ($month == 2)
						                {
						                	if ($year%4 == 0) $day=29;
						                	else $day = 28;
						                }
						                else $day = 30;
						                $full = $year.'-'.$month.'-'.$day;
						                $full_date = DateTime::createFromFormat("Y-m-d", $full);
	            						TargetUjian::insertGetId(array(
	            							'nip'				=> $data->nip,
	            							'name'				=> $data->emp_name,
	            							'directorate'		=> $emp2->directorate,
	            							'SCRTU'				=> $data->scrtu,
	            							'outstanding'		=> $full_date,
	            							'SOposition'		=> $data->if_any_revision,
	            							'levelByRegulation' => $lvlbByReg,
	            							'passed'			=> $emp->passed,
	            							'status'			=> 'Uncertified',
	            							'users_id'			=> Auth::user()->name
	            						));	
	            						
	            					}
	            				}
		            			else
		            			{

		            				$cek_target = TargetUjian::where('nip',$data->nip)->count();
	            					$emp2 = MonthlyClosing::find($data->nip);  
	            					if ($cek_target > 0 and $remark == 'Certified')
	            					{
	            						TargetUjian::where('nip',$data->nip)->update(array(
	            							'name'				=> $data->emp_name,
	            							'directorate'		=> $emp2->directorate,
	            							'SCRTU'				=> $data->scrtu,
	            							'SOposition'		=> $data->if_any_revision,
	            							'levelByRegulation' => $lvlbByReg,
	            							'passed'			=> $emp->passed,
	            							'status'			=> 'Certified',
	            							'users_id'			=> Auth::user()->name
	            						));	
	            					}

		            				$dateUjian = DateTime::createFromFormat("Y-m-d", $emp->passedDate);
	 								$day = $dateUjian->format("d");
	 								$mon = $dateUjian->format("m");
	 								$dateRef = DateTime::createFromFormat("Y-m-d", $emp->lastRefreshment);

	 								if ($dateRef >= $dateUjian)
	 								{
	 									$year = $dateRef->format("Y") + $jatuhTempo;
	 								}
	 								else if ($dateRef < $dateUjian)
	 								{
	 									$year = $dateUjian->format("Y") + $jatuhTempo;
	 								}
	 								

	 								$plan = $year.'-'.$mon.'-'.$day;
		            			}
		            			MainData::where('monthlyClosing_id',$data->nip)->update(array(
		            				'SCRTU'				=> $data->scrtu,
									'SOposition'		=> $data->if_any_revision,
									'levelByRegulation'	=> $lvlbByReg,
									'remark'			=> $remark,
									'nextRefreshment'	=> $plan,
									'infoByEmail'		=> $data->info_by_email,
									'SOupdate'			=> $data->so_update,
									'users_id'			=> Auth::user()->name
			                    ));

			                    /*TargetRefreshment::where('nip',$data->nip)->where('tgl',NULL)->update(array(
			                    	'nextRefreshment'	=> $plan,
			                    ));*/
		            		}
						});
						DB::commit();
						//dd($temp[0]->nip);

		            });
					return redirect('upload/hrbp?status=success');
				}
            	return redirect('login');
			}
        }
    }

    public function trainingUjian()
    {   
        if(Request::isMethod('get'))
        {
        	if (Auth::check())
            {
        		return view('upload.trainingUjian');
        	}
            return redirect('login');
        }
        else
        {
        	if (Auth::check())
            {
	        	ini_set("upload_max_filesize","300M");
		    	ini_set("post_max_size","300M");
		    	set_time_limit(108000);
				
		    	$input = Input::all();

				if ($_FILES["trainingUjian"]["error"] > 0){
				  echo "Error: " . $_FILES["trainingUjian"]["error"] . "<br />";
				}
				else{

					$trainingUjian = array_get($input,'trainingUjian');
		            $fileName_trainingUjian = $trainingUjian->getClientOriginalName();
		            $upload_success = $trainingUjian->move("upload", $fileName_trainingUjian);
		            //echo $fileName_monthlyClosing;
		            $data = Excel::load('upload/'.$fileName_trainingUjian, function($reader){
		            	$temp = $reader->get();
		            	$temp->each(function($data) {	
	            			TrainingUjian::insertGetId(array(
	            				'nip'				=> $data->nip,
								'name'				=> $data->emp_name,
								'directorate'		=> $data->directorate,
								'level'				=> $data->level,
								'tglStart'			=> $data->start_training,
								'tglEnd'			=> $data->end_training,
								'pengajar'			=> $data->pengajar,
								'location'			=> $data->location,
								'users_id'			=> Auth::user()->name
		                    ));
						});
						DB::commit();
						//dd($temp[0]->nip);

		            });
					return redirect('upload/training/ujian?status=success');
				}
            	return redirect('login');
			}
        }
    }

    public function trainingRefreshment()
    {   
        if(Request::isMethod('get'))
        {
        	if (Auth::check())
            {
        		return view('upload.trainingRefreshment');
        	}
            return redirect('login');
        }
        else
        {
        	if (Auth::check())
            {
	        	ini_set("upload_max_filesize","300M");
		    	ini_set("post_max_size","300M");
		    	set_time_limit(108000);
				
		    	$input = Input::all();

				if ($_FILES["trainingRefreshment"]["error"] > 0){
				  echo "Error: " . $_FILES["trainingRefreshment"]["error"] . "<br />";
				}
				else{

					$trainingRefreshment = array_get($input,'trainingRefreshment');
		            $fileName_trainingRefreshment = $trainingRefreshment->getClientOriginalName();
		            $upload_success = $trainingRefreshment->move("upload", $fileName_trainingRefreshment);
		            //echo $fileName_monthlyClosing;
		            $data = Excel::load('upload/'.$fileName_trainingRefreshment, function($reader){
		            	$temp = $reader->get();
		            	$temp->each(function($data) {	
	            			TrainingRefreshment::insertGetId(array(
	            				'nip'				=> $data->nip,
								'name'				=> $data->emp_name,
								'directorate'		=> $data->directorate,
								'level'				=> $data->level,
								'nextRefreshment'	=> $data->plan_next_refreshment,
								'tglStart'			=> $data->start_training,
								'tglEnd'			=> $data->end_training,
								'pengajar'			=> $data->pengajar,
								'location'			=> $data->location,
								'users_id'			=> Auth::user()->name
		                    ));
						});
						DB::commit();
						//dd($temp[0]->nip);

		            });
					return redirect('upload/training/refreshment?status=success');
				}
            	return redirect('login');
			}
        }
    }

    public function databesarNewHire()
    {   
        if(Request::isMethod('get'))
        {
        	if (Auth::check())
            {
        		return view('upload.databesarNewHire');
        	}
            return redirect('login');
        }
        else
        {
        	if (Auth::check())
            {
	        	ini_set("upload_max_filesize","300M");
		    	ini_set("post_max_size","300M");
		    	set_time_limit(108000);
				
		    	$input = Input::all();

				if ($_FILES["databesar"]["error"] > 0){
				  echo "Error: " . $_FILES["databesar"]["error"] . "<br />";
				}
				else{


					$databesar = array_get($input,'databesar');
		            $fileName_databesar = $databesar->getClientOriginalName();
		            $upload_success = $databesar->move("upload", $fileName_databesar);
		            //echo $fileName_monthlyClosing;

		            $data = Excel::load('upload/'.$fileName_databesar, function($reader){
		            	$temp = $reader->get();

		            	$temp->each(function($data) {
		            		$cek = NewHire::where('id',$data->nip)->count();
		            		if($cek > 0)
		            		{
		            			/*LEVEL BY REGULATION*/
		            			/*if($data->scrtu == 'Commisioner') $lvlbByReg = 1;
		            			else if($data->scrtu == 'Pres Comm') $lvlbByReg = 1;
		            			else if($data->scrtu == 'Indp Comm') $lvlbByReg = 2;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D0') $lvlbByReg = 5;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D1') $lvlbByReg = 4;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D2') $lvlbByReg = 3;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D3') $lvlbByReg = 2;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D4') $lvlbByReg = 1;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D5') $lvlbByReg = 0;
		            			else if($data->scrtu == 'SRTU' and $data->position_in_so == 'D0') $lvlbByReg = 4;
		            			else if($data->scrtu == 'SRTU' and $data->position_in_so == 'D1') $lvlbByReg = 1;
		            			else $lvlbByReg = 0;*/

		            			//RMCP Level
		            			$temp_tgl_lv = array();
		            			$temp_passed = 0;
		            			$init = DateTime::createFromFormat('Y-m-d', '1900-1-1');
		            			$temp_passed_date =  $init;

		            			if ($data->lv_1 != '0')
		            			{
		            				$temp_passed = 1;
		            				if ($data->lv_1 == 'P')
		            				{
		            					$temp_tgl_lv_1 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_1 != 'P' and $data->lv_1 != '0')
		            				{
		            					$temp_tgl_lv_1 =  DateTime::createFromFormat('Y-m-d', $data->lv_1->toDateString());
		            					$temp_passed_date = $temp_tgl_lv_1;
		            				}
		            				
		            			}
		            			else if ($data->lv_1 == '0')
		            			{
		            				$temp_tgl_lv_1 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_1);


		            			if ($data->lv_2 != '0')
		            			{
		            				$temp_passed = 2;
		            				if ($data->lv_2 == 'P')
		            				{
		            					$temp_tgl_lv_2 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_2 != 'P' and $data->lv_2 != '0')
		            				{
		            					$temp_tgl_lv_2 =  DateTime::createFromFormat('Y-m-d', $data->lv_2->toDateString());;
		            					$temp_passed_date = $temp_tgl_lv_2;
		            				}
		            				
		            			}
		            			else if ($data->lv_2 == '0')
		            			{
		            				$temp_tgl_lv_2 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_2);


		            			if ($data->lv_3 != '0')
		            			{
		            				$temp_passed = 3;
		            				if ($data->lv_3 == 'P')
		            				{
		            					$temp_tgl_lv_3 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_3 != 'P' and $data->lv_3 != '0')
		            				{
		            					$temp_tgl_lv_3 =  DateTime::createFromFormat('Y-m-d', $data->lv_3->toDateString());;
		            					$temp_passed_date = $temp_tgl_lv_3;
		            				}
		            				
		            			}
		            			else if ($data->lv_3 == '0')
		            			{
		            				$temp_tgl_lv_3 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_3);


		            			if ($data->lv_4 != '0')
		            			{
		            				$temp_passed = 4;
		            				if ($data->lv_4 == 'P')
		            				{
		            					$temp_tgl_lv_4 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_4 != 'P' and $data->lv_4 != '0')
		            				{
		            					$temp_tgl_lv_4 =  DateTime::createFromFormat('Y-m-d', $data->lv_4->toDateString());;
		            					$temp_passed_date = $temp_tgl_lv_4;
		            				}
		            				
		            			}
		            			else if ($data->lv_4 == '0')
		            			{
		            				$temp_tgl_lv_4 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_4);



		            			if ($data->lv_5 != '0')
		            			{
		            				$temp_passed = 5;
		            				if ($data->lv_5 == 'P')
		            				{
		            					$temp_tgl_lv_5 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_5 != 'P' and $data->lv_5 != '0')
		            				{
		            					$temp_tgl_lv_5 = DateTime::createFromFormat('Y-m-d', $data->lv_5->toDateString());;
		            					$temp_passed_date = $temp_tgl_lv_5;
		            				}
		            				
		            			}
		            			else if ($data->lv_5 == '0')
		            			{
		            				$temp_tgl_lv_5 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_5);

		            			// Cek Ujian
		            			$cek_ujian = Test::where('nip',$data->nip)->count();
		            			if($cek_ujian > 0)
		            			{
		            				for ($i=0;$i<5;$i++)
			            			{
			            				Test::where('nip',$data->nip)->where('level',$i+1)->update(array(
											'tgl'				=> $temp_tgl_lv[$i],
											'users_id'			=> Auth::user()->name
					                    ));

			            			}
		            			}
		            			else
		            			{
		            				for ($i=0;$i<5;$i++)
			            			{
			            				Test::insertGetId(array(
					                        'nip'				=> $data->nip,
											'name'				=> $data->emp_name,
											'level'				=> $i+1,
											'tgl'				=> $temp_tgl_lv[$i],
											'users_id'			=> Auth::user()->name
					                    ));

			            			}
		            			}
		            			

		            			/*if ($temp_passed >= $lvlbByReg) $remark = "Certified";
		            			else if ($temp_passed < $lvlbByReg) $remark = "Uncertified";
		            			else $remark = '';*/

		            			//Refreshment
		            			$temp_tgl_ref_ke = array();
		            			$init = Carbon::createFromDate(1900, 0, 0, 'Asia/Jakarta');
		            			$temp_last_ref_date =  $init;

		            			if ($data->ke_1 != '0')
		            			{
		            				$temp_tgl_ke_1 = $data->ke_1;
		            				$temp_last_ref_date = $temp_tgl_ke_1;
		            			}
		            			else if ($data->ke_1 == '0')
		            			{
		            				$temp_tgl_ke_1 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_1);


		            			if ($data->ke_2 != '0')
		            			{
		            				$temp_tgl_ke_2 = $data->ke_2;
		            				$temp_last_ref_date = $temp_tgl_ke_2;
		            			}
		            			else if ($data->ke_2 == '0')
		            			{
		            				$temp_tgl_ke_2 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_2);


		            			if ($data->ke_3 != '0')
		            			{
		            				$temp_tgl_ke_3 = $data->ke_3;
		            				$temp_last_ref_date = $temp_tgl_ke_3;
		            			}
		            			else if ($data->ke_3 == '0')
		            			{
		            				$temp_tgl_ke_3 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_3);


		            			if ($data->ke_4 != '0')
		            			{
		            				$temp_tgl_ke_4 = $data->ke_4;
		            				$temp_last_ref_date = $temp_tgl_ke_4;
		            			}
		            			else if ($data->ke_4 == '0')
		            			{
		            				$temp_tgl_ke_4 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_4);


		            			if ($data->ke_5 != '0')
		            			{
		            				$temp_tgl_ke_5 = $data->ke_5;
		            				$temp_last_ref_date = $temp_tgl_ke_5;
		            			}
		            			else if ($data->ke_5 == '0')
		            			{
		            				$temp_tgl_ke_5 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_5);


		            			//JATUH TEMPO
		            			/*if ($temp_passed == 3 or $temp_passed == 4 or $temp_passed == 5 ) $jatuhTempo = 2;
		            			else if ($temp_passed == 0 or $temp_passed == 1 or $temp_passed == 2) $jatuhTempo = 4;*/

		            			//PLAN
		            			/*if ($remark == "Uncertified") $plan = 'Not Yet';
		            			else
		            			{

		            				$dateUjian = $temp_passed_date;	
	 								$day = $dateUjian->format("d");
	 								$mon = $dateUjian->format("m");
	 								$dateRef = DateTime::createFromFormat("Y-m-d", $temp_last_ref_date->toDateString());

	 								if ($dateRef >= $dateUjian)
	 								{
	 									$year = $dateRef->format("Y") + $jatuhTempo;
	 								}
	 								else if ($dateRef < $dateUjian)
	 								{
	 									$year = $dateUjian->format("Y") + $jatuhTempo;
	 								}
	 								

	 								$plan = $year.'-'.$mon.'-'.$day;
		            			}*/
		            			

		            			NewHire::where('id',$data->nip)->update(array(
			                        'name'				=> $data->emp_name,
									//'emailDS'			=> $data->email_ds,
									//'SOupdate'			=> $data->so_update,
									//'infoByEmail'		=> $data->info_by_email,
									//'categorySRTU'		=> $data->category_srtu,
									//'SCRTU'				=> $data->scrtu,
									//'SOposition'		=> $data->position_in_so,
									//'levelByRegulation'	=> $lvlbByReg,
									'grade'				=> $data->grade,
									'directorate'		=> $data->directorate,
									'subdirectorate'	=> $data->subdirectorate,
									'group'				=> $data->group,
									'division'			=> $data->division,
									'department'		=> $data->department,
									'passed'			=> $temp_passed,
									//'remarkMainData'	=> $remark,
									'passedDate'		=> $temp_passed_date,
									'BSMRID'			=> $data->bsmr_id,
									'LSPPID'			=> $data->lspp_id,
									'lastRefreshment'	=> $temp_last_ref_date,
									'users_id'			=> Auth::user()->name
									//'jatuhTempo'		=> $jatuhTempo,
									//'nextRefreshment'	=> $plan
									//'lastLocation'		=> $data->location_last_refreshment
			                    ));

			                    //Cek refreshment
		            			$cek_refreshment = Refreshment::where('nip',$data->nip)->count();
		            			if($cek_refreshment > 0)
		            			{
		            				for ($i=0;$i<5;$i++)
			            			{
			            				Refreshment::where('nip',$data->nip)->where('level',$temp_passed)->where('ke',$i+1)->update(array(
											'tgl'				=> $temp_tgl_ref_ke[$i],
											'users_id'			=> Auth::user()->name
					                    ));

			            			}
		            			}
		            			else
		            			{
		            				for ($i=0;$i<5;$i++)
			            			{
			            				Refreshment::insertGetId(array(
					                        'nip'				=> $data->nip,
											'name'				=> $data->emp_name,
											'level'				=> $temp_passed,
											'ke'				=> $i+1,
											'tgl'				=> $temp_tgl_ref_ke[$i],
											'users_id'			=> Auth::user()->name
					                    ));

			            			}
		            			}
		            		}
		            		else
		            		{

		            			/*LEVEL BY REGULATION*/
		            			/*if($data->scrtu == 'Commisioner') $lvlbByReg = 1;
		            			else if($data->scrtu == 'Pres Comm') $lvlbByReg = 1;
		            			else if($data->scrtu == 'Indp Comm') $lvlbByReg = 2;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D0') $lvlbByReg = 5;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D1') $lvlbByReg = 4;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D2') $lvlbByReg = 3;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D3') $lvlbByReg = 2;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D4') $lvlbByReg = 1;
		            			else if($data->scrtu == 'CRTU' and $data->position_in_so == 'D5') $lvlbByReg = 0;
		            			else if($data->scrtu == 'SRTU' and $data->position_in_so == 'D0') $lvlbByReg = 4;
		            			else if($data->scrtu == 'SRTU' and $data->position_in_so == 'D1') $lvlbByReg = 1;
		            			else $lvlbByReg = 0;*/

		            			//RMCP Level
		            			$temp_tgl_lv = array();
		            			$temp_passed = 0;
		            			$init = DateTime::createFromFormat('Y-m-d', '1900-1-1');
		            			$temp_passed_date =  $init;

		            			if ($data->lv_1 != '0')
		            			{
		            				$temp_passed = 1;
		            				if ($data->lv_1 == 'P')
		            				{
		            					$temp_tgl_lv_1 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_1 != 'P' and $data->lv_1 != '0')
		            				{
		            					$temp_tgl_lv_1 =  DateTime::createFromFormat('Y-m-d', $data->lv_1->toDateString());
		            					$temp_passed_date = $temp_tgl_lv_1;
		            				}
		            				
		            			}
		            			else if ($data->lv_1 == '0')
		            			{
		            				$temp_tgl_lv_1 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_1);


		            			if ($data->lv_2 != '0')
		            			{
		            				$temp_passed = 2;
		            				if ($data->lv_2 == 'P')
		            				{
		            					$temp_tgl_lv_2 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_2 != 'P' and $data->lv_2 != '0')
		            				{
		            					$temp_tgl_lv_2 =  DateTime::createFromFormat('Y-m-d', $data->lv_2->toDateString());;
		            					$temp_passed_date = $temp_tgl_lv_2;
		            				}
		            				
		            			}
		            			else if ($data->lv_2 == '0')
		            			{
		            				$temp_tgl_lv_2 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_2);


		            			if ($data->lv_3 != '0')
		            			{
		            				$temp_passed = 3;
		            				if ($data->lv_3 == 'P')
		            				{
		            					$temp_tgl_lv_3 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_3 != 'P' and $data->lv_3 != '0')
		            				{
		            					$temp_tgl_lv_3 =  DateTime::createFromFormat('Y-m-d', $data->lv_3->toDateString());;
		            					$temp_passed_date = $temp_tgl_lv_3;
		            				}
		            				
		            			}
		            			else if ($data->lv_3 == '0')
		            			{
		            				$temp_tgl_lv_3 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_3);


		            			if ($data->lv_4 != '0')
		            			{
		            				$temp_passed = 4;
		            				if ($data->lv_4 == 'P')
		            				{
		            					$temp_tgl_lv_4 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_4 != 'P' and $data->lv_4 != '0')
		            				{
		            					$temp_tgl_lv_4 =  DateTime::createFromFormat('Y-m-d', $data->lv_4->toDateString());;
		            					$temp_passed_date = $temp_tgl_lv_4;
		            				}
		            				
		            			}
		            			else if ($data->lv_4 == '0')
		            			{
		            				$temp_tgl_lv_4 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_4);



		            			if ($data->lv_5 != '0')
		            			{
		            				$temp_passed = 5;
		            				if ($data->lv_5 == 'P')
		            				{
		            					$temp_tgl_lv_5 = DateTime::createFromFormat('Y-m-d', '1900-1-2');
		            				}
		            				else if ($data->lv_5 != 'P' and $data->lv_5 != '0')
		            				{
		            					$temp_tgl_lv_5 = DateTime::createFromFormat('Y-m-d', $data->lv_5->toDateString());;
		            					$temp_passed_date = $temp_tgl_lv_5;
		            				}
		            				
		            			}
		            			else if ($data->lv_5 == '0')
		            			{
		            				$temp_tgl_lv_5 = '';
		            			}
		            			array_push($temp_tgl_lv,$temp_tgl_lv_5);

		            			// Cek Ujian
		            			$cek_ujian = Test::where('nip',$data->nip)->count();
		            			if($cek_ujian > 0)
		            			{
		            				for ($i=0;$i<5;$i++)
			            			{
			            				Test::where('nip',$data->nip)->where('level',$i+1)->update(array(
											'tgl'				=> $temp_tgl_lv[$i],
											'users_id'			=> Auth::user()->name
					                    ));

			            			}
		            			}
		            			else
		            			{
		            				for ($i=0;$i<5;$i++)
			            			{
			            				Test::insertGetId(array(
					                        'nip'				=> $data->nip,
											'name'				=> $data->emp_name,
											'level'				=> $i+1,
											'tgl'				=> $temp_tgl_lv[$i],
											'users_id'			=> Auth::user()->name
					                    ));

			            			}
		            			}
		            			

		            			/*if ($temp_passed >= $lvlbByReg) $remark = "Certified";
		            			else if ($temp_passed < $lvlbByReg) $remark = "Uncertified";
		            			else $remark = '';*/

		            			//Refreshment
		            			$temp_tgl_ref_ke = array();
		            			$init = Carbon::createFromDate(1900, 0, 0, 'Asia/Jakarta');
		            			$temp_last_ref_date =  $init;

		            			if ($data->ke_1 != '0')
		            			{
		            				$temp_tgl_ke_1 = $data->ke_1;
		            				$temp_last_ref_date = $temp_tgl_ke_1;
		            			}
		            			else if ($data->ke_1 == '0')
		            			{
		            				$temp_tgl_ke_1 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_1);


		            			if ($data->ke_2 != '0')
		            			{
		            				$temp_tgl_ke_2 = $data->ke_2;
		            				$temp_last_ref_date = $temp_tgl_ke_2;
		            			}
		            			else if ($data->ke_2 == '0')
		            			{
		            				$temp_tgl_ke_2 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_2);


		            			if ($data->ke_3 != '0')
		            			{
		            				$temp_tgl_ke_3 = $data->ke_3;
		            				$temp_last_ref_date = $temp_tgl_ke_3;
		            			}
		            			else if ($data->ke_3 == '0')
		            			{
		            				$temp_tgl_ke_3 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_3);


		            			if ($data->ke_4 != '0')
		            			{
		            				$temp_tgl_ke_4 = $data->ke_4;
		            				$temp_last_ref_date = $temp_tgl_ke_4;
		            			}
		            			else if ($data->ke_4 == '0')
		            			{
		            				$temp_tgl_ke_4 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_4);


		            			if ($data->ke_5 != '0')
		            			{
		            				$temp_tgl_ke_5 = $data->ke_5;
		            				$temp_last_ref_date = $temp_tgl_ke_5;
		            			}
		            			else if ($data->ke_5 == '0')
		            			{
		            				$temp_tgl_ke_5 = '';
		            			}
		            			array_push($temp_tgl_ref_ke,$temp_tgl_ke_5);


		            			//JATUH TEMPO
		            			/*if ($temp_passed == 3 or $temp_passed == 4 or $temp_passed == 5 ) $jatuhTempo = 2;
		            			else if ($temp_passed == 0 or $temp_passed == 1 or $temp_passed == 2) $jatuhTempo = 4;*/

		            			//PLAN
		            			/*if ($remark == "Uncertified") $plan = 'Not Yet';
		            			else
		            			{
		            				$dateUjian = $temp_passed_date;	
	 								$day = $dateUjian->format("d");
	 								$mon = $dateUjian->format("m");
	 								$dateRef = DateTime::createFromFormat("Y-m-d", $temp_last_ref_date->toDateString());

	 								if ($dateRef >= $dateUjian)
	 								{
	 									$year = $dateRef->format("Y") + $jatuhTempo;
	 								}
	 								else if ($dateRef < $dateUjian)
	 								{
	 									$year = $dateUjian->format("Y") + $jatuhTempo;
	 								}
	 								

	 								$plan = $year.'-'.$mon.'-'.$day;
		            			}*/
		            			

		            			NewHire::insertGetId(array(
			                        'id'				=> $data->nip,
			                        'name'				=> $data->emp_name,
									//'emailDS'			=> $data->email_ds,
									//'SOupdate'			=> $data->so_update,
									//'infoByEmail'		=> $data->info_by_email,
									//'categorySRTU'		=> $data->category_srtu,
									//'SCRTU'				=> $data->scrtu,
									//'SOposition'		=> $data->position_in_so,
									//'levelByRegulation'	=> $lvlbByReg,
									'grade'				=> $data->grade,
									'directorate'		=> $data->directorate,
									'subdirectorate'	=> $data->subdirectorate,
									'group'				=> $data->group,
									'division'			=> $data->division,
									'department'		=> $data->department,
									'passed'			=> $temp_passed,
									//'remarkMainData'	=> $remark,
									'passedDate'		=> $temp_passed_date,
									'BSMRID'			=> $data->bsmr_id,
									'LSPPID'			=> $data->lspp_id,
									'lastRefreshment'	=> $temp_last_ref_date,
									'users_id'			=> Auth::user()->name
									//'jatuhTempo'		=> $jatuhTempo,
									//'nextRefreshment'	=> $plan
									//'lastLocation'		=> $data->location_last_refreshment
			                    ));

			                    //Cek refreshment
		            			$cek_refreshment = Refreshment::where('nip',$data->nip)->count();
		            			if($cek_refreshment > 0)
		            			{
		            				for ($i=0;$i<5;$i++)
			            			{
			            				Refreshment::where('nip',$data->nip)->where('level',$temp_passed)->where('ke',$i+1)->update(array(
											'tgl'				=> $temp_tgl_ref_ke[$i],
											'users_id'			=> Auth::user()->name
					                    ));

			            			}
		            			}
		            			else
		            			{
		            				for ($i=0;$i<5;$i++)
			            			{
			            				Refreshment::insertGetId(array(
					                        'nip'				=> $data->nip,
											'name'				=> $data->emp_name,
											'level'				=> $temp_passed,
											'ke'				=> $i+1,
											'tgl'				=> $temp_tgl_ref_ke[$i],
											'users_id'			=> Auth::user()->name
					                    ));

			            			}
		            			}
		            		}
					    	
						});
						DB::commit();
						//dd($temp[0]->nip);

		            });
					return redirect('upload/maindata/newhire?status=success');
				}
            	return redirect('login');
			}
        }
    }

    public function ujianNewHIre()
    {   
        if(Request::isMethod('get'))
        {
        	if (Auth::check())
            {
        		return view('upload.ujianNewHIre');
        	}
            return redirect('login');
        }
        else
        {
        	if (Auth::check())
            {
	        	ini_set("upload_max_filesize","300M");
		    	ini_set("post_max_size","300M");
		    	set_time_limit(108000);
				
		    	$input = Input::all();

				if ($_FILES["ujian"]["error"] > 0){
				  echo "Error: " . $_FILES["ujian"]["error"] . "<br />";
				}
				else{

					$ujian = array_get($input,'ujian');
		            $fileName_ujian = $ujian->getClientOriginalName();
		            $upload_success = $ujian->move("upload", $fileName_ujian);
		            //echo $fileName_monthlyClosing;
		            $data = Excel::load('upload/'.$fileName_ujian, function($reader){
		            	$temp = $reader->toObject();
		            	$temp->each(function($data) {
		            		if($data->hasil[0] == 'K')
		            		{
		            			Test::where('nip',$data->nip)->where('level',$data->level)->update(array(
									'lembaga'			=> $data->nia,
									'tgl'				=> $data->tgl_ujian,
									'users_id'			=> Auth::user()->name
			                    ));
		            		}
		            		else
		            		{
		            			NotPassed::insertGetId(array(
			                        'nip'				=> $data->nip,
									'name'				=> $data->emp_name,
									'level'				=> $data->level,
									'tgl'				=> $data->tgl_ujian,
									'result'			=> $data->hasil,
									'users_id'			=> Auth::user()->name
			                    ));
		            		}
					    	
						});
						DB::commit();
						//dd($temp[0]->nip);

		            });
					return redirect('upload/ujian/newhire?status=success');
				}
            	return redirect('login');
			}
        }
    }

    public function refreshmentNewHire()
    {   
        if(Request::isMethod('get'))
        {
        	if (Auth::check())
            {
        		return view('upload.refreshmentNewHire');
        	}
            return redirect('login');
        }
        else
        {
        	if (Auth::check())
            {
	        	ini_set("upload_max_filesize","300M");
		    	ini_set("post_max_size","300M");
		    	set_time_limit(108000);
				
		    	$input = Input::all();

				if ($_FILES["refreshment"]["error"] > 0){
				  echo "Error: " . $_FILES["refreshment"]["error"] . "<br />";
				}
				else{

					$refreshment = array_get($input,'refreshment');
		            $fileName_refreshment = $refreshment->getClientOriginalName();
		            $upload_success = $refreshment->move("upload", $fileName_refreshment);
		            //echo $fileName_monthlyClosing;
		            $data = Excel::load('upload/'.$fileName_refreshment, function($reader){
		            	$temp = $reader->toObject();
		            	$temp->each(function($data) {
		            		if(!empty($data->tanggal))
		            		{
		            			$cek = Refreshment::where('nip',$data->nip)->where('level',$data->level)->where('tgl',$data->tanggal)->count();
		            			if($cek > 0)
		            			{
			            			Refreshment::where('nip',$data->nip)->where('level',$data->level)->where('tgl',$data->tanggal)->update(array(
										'BSMRID'			=> $data->id_bsmr,
										'LSPPID'			=> $data->id_lspp,
										'status'			=> $data->status,
										'penyelenggara'		=> $data->penyelenggara,
										'materipembicara'	=> $data->materipembicara,
										'keterangan'		=> $data->keterangan,
										'users_id'			=> Auth::user()->name
				                    ));
				                }
				                else
				                {
				                	$ke = Refreshment::select('ke')->where('nip',$data->nip)->where('level',$data->level)
				                			->where('ke', DB::raw("(select max(`ke`) from refreshmentnewhire where nip='".$data->nip."' and tgl != '0000-00-00')"))
				                			->first();

				                	if(is_null($ke))
				                	{
				                		Refreshment::insertGetId(array(
					                        'nip'				=> $data->nip,
											'name'				=> $data->emp_name,
											'level'				=> $data->level,
											'ke'				=> 1,
											'tgl'				=> $data->tanggal,
											'BSMRID'			=> $data->id_bsmr,
											'LSPPID'			=> $data->id_lspp,
											'status'			=> $data->status,
											'penyelenggara'		=> $data->penyelenggara,
											'materipembicara'	=> $data->materipembicara,
											'keterangan'		=> $data->keterangan,
											'users_id'			=> Auth::user()->name
					                    ));
				                	}

				                	else if ($ke->ke < 5)
				                	{
				                		Refreshment::where('nip',$data->nip)->where('level',$data->level)->where('ke',$ke->ke+1)->update(array(
											'tgl'				=> $data->tanggal,
											'BSMRID'			=> $data->id_bsmr,
											'LSPPID'			=> $data->id_lspp,
											'status'			=> $data->status,
											'penyelenggara'		=> $data->penyelenggara,
											'materipembicara'	=> $data->materipembicara,
											'keterangan'		=> $data->keterangan,
											'users_id'			=> Auth::user()->name
					                    ));
				                	}
				                	
				                	else if ($ke->ke >= 5)
				                	{
				                		Refreshment::where('nip',$data->nip)->where('level',$data->level)->where('tgl', DB::raw("(select min(`tgl`) from refreshment where nip='".$data->nip."' and level=".$data->level.")"))->update(array(
											'ke'				=> $ke->ke+1,
											'tgl'				=> $data->tanggal,
											'BSMRID'			=> $data->id_bsmr,
											'LSPPID'			=> $data->id_lspp,
											'status'			=> $data->status,
											'penyelenggara'		=> $data->penyelenggara,
											'materipembicara'	=> $data->materipembicara,
											'keterangan'		=> $data->keterangan,
											'users_id'			=> Auth::user()->name
					                    ));
				                	}
			                		
				                }
		            		}
		            		/*else
		            		{
		            			Refreshment::insertGetId(array(
									'BSMRID'			=> $data->id_bsmr,
									'LSPPID'			=> $data->id_lspp,
									'level'				=> $data->level,
									'status'			=> $data->status,
									'penyelenggara'		=> $data->penyelenggara,
									'keterangan'		=> $data->keterangan
			                    ));
		            		}*/
					    	

						});
						DB::commit();

		            });
					return redirect('upload/refreshment/newhire?status=success');
				}
            	return redirect('login');
			}
        }
    }

}
