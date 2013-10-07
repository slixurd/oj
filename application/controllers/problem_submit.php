<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Problem_submit extends CI_Controller {
	var $data=NULL;
 
	public function __construct()
  {
    parent::__construct();
    $this->load->model('oj_model');
    $this->load->library('user_help');
    $this->load->helper('url');
    $this->load->helper('date');
    $data['is_login']=FALSE;
		if($this->user_help->is_session()){
			$data['is_login']=TRUE;
			$data['user']=$this->user_help->get_session();
		}
  }
  
  public function index($problemId=10000){
	  if($data['is_login']=TRUE){
			$data['problem']=$this->oj_model->get_problem_item($problemId,array('problemId'));
			$this->load->view('common/header',$data);
			$this->load->view('student/problem_submit_view',$data);
			$this->load->view('common/footer',$data);
		}else{
			redirect(site_url("problem"));//下面可以提示用户登录
		}
  }
  
  public function submit(){
	  $date_str="%Y-%m-%d %H:%i:%s";
	  $now=strtotime("now");
	  if($data['is_login']===FALSE){
		  redirect(site_url("problem"));//下面可以提示用户登录
	  }else if(isset($_POST['problemId']) && isset($_POST['code']) && isset($_POST['language'])){
		  if(isset($_POST['contestId'])&& is_numeric($_POST['contestId'])){
			    $data['privilege']=$this->oj_model->get_contest_privilege($id,$user['userId']);
				if(!empty($data['privilege'])){//用户有权限
					$data['contest_item']=$this->oj_model->get_contest_item($_POST['contestId'],array('statTime','endTime'));
					if($now>=strtotime($data['contest_item']['startTime']) && 
					$now<=strtotime($data['contest_item']['startTime'])){
						$this->oj_model->add_solution(array('problemId'=>$problemId,'userId'=>$data['user']['userId'],'runTime'=>0,
						'contestId'=>$_POST['contestId'],'memory'=>0,'inDate'=>mdate($date_str),'result'=>0,'progranmLan'=>$language),array('code'=>$code));
					}
				}
		  }else if(isset($_POST['unitId'])&& is_numeric($_POST['unitId'])){
			  $data['privilege']=$this->oj_model->get_course_privilege($id,$user['userId']);
				if(!empty($data['privilege'])){//用户有权限
					$data['contest_item']=$this->oj_model->get_course_item($_POST['contestId'],array('statTime','endTime'));
					if($now>=strtotime($data['contest_item']['startTime']) && 
					$now<=strtotime($data['contest_item']['startTime'])){
						$this->oj_model->add_solution(array('problemId'=>$problemId,'userId'=>$data['user']['userId'],'runTime'=>0,
						'unitId'=>$_POST['unitId'],'memory'=>0,'inDate'=>mdate($date_str),'result'=>0,'progranmLan'=>$language),array('code'=>$code));
					}
		  }
	  }else
	  $this->oj_model->add_solution(array('problemId'=>$problemId,'userId'=>$data['user']['userId'],'runTime'=>0,
	   'memory'=>0,'inDate'=>mdate($date_str),'result'=>0,'progranmLan'=>$language),array('code'=>$code));
  }
	$this->load->view('common/header',$data);
	$this->load->view('status_view',$data);
	$this->load->view('common/footer',$data);
}
}
