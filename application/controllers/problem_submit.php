<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Problem_submit extends CI_Controller {
	var $data=NULL;
 
	public function __construct()
  {
    parent::__construct();
    $this->load->helper('date');
  }
  
  public function index($problemId=-1,$loc=0,$loc_id=0){
	  Global $data;
	  if($problemId==-1||!is_numeric($loc_id)||!is_numeric($loc)){
			$this->error->show_error('进入方式错误',array("请不要随意修改URL"),$data);
			return;//防止多次下面分支view	  	
	  }
	  $data['loc']=$loc;
	  $data['loc_id']=$loc_id;
	  GLOBAL $lan;
	  $data['lan'] = $lan;
	  if($data['is_login']){
			$data['problem']=$this->oj_model->get_problem_item($problemId,array('problemId'));
			if(empty($data['problem'])){
				$this->error->show_error('无此题目',array(""),$data);
				return;//防止多次下面分支view				
			}
	  		$data['problemId'] = $problemId;
			$this->load->view('common/header',$data);
			$this->load->view('student/problem_submit_view',$data);
			$this->load->view('common/footer',$data);
		}else{
			$this->error->show_error('尚未登录不能答题',array("先右上角登陆吧"),$data);
			return;//防止多次下面分支view
		}
  }
  
  public function submit($loc=0,$loc_id=0){
	  Global $data;
	  $date_str="%Y-%m-%d %H:%i:%s";
	  $now=strtotime("now");
	  //echo $now;
	  if(!$data['is_login']){
			$this->error->show_error('尚未登录不能答题',array("先右上角登陆吧"),$data);
			return;//防止多次下面分支view
	  }else if(isset($_POST['problemId']) && isset($_POST['code']) && isset($_POST['language'])){//判断用户是否传递了最基本的元素
		$problemId=$_POST['problemId'];
		$programLan=$_POST['language'];
		$code=$_POST['code'];
		$problem_catche = "problem_catche_".$problemId;
		$problem_item=$this->oj_model->get_problem_item($problemId);//按号查相关问题
		
		$code_len = strlen($code);
		
		if($code_len<4){
			//提示代码太短
			$this->error->show_error("代码太短了",array("哎呀，难道是个天才算法么","代码太短了，我无法接受啊"),$data);
			return;
		}
		if($code_len>65536){
			//提示代码太长
			$this->error->show_error("代码太长了",array("源代码长度太大了","代码太长了，我数不过来呀"),$data);
			return;
		}
		
		if(empty($problem_item)){
			//如果用户输入了一个不存在问题跳转到的页面
			$this->error->show_error("提交的问题不存在",array("请确认提交问题的ID"),$data);
			return;
		}
		
		if(($loc == 1) && is_numeric($loc_id)){//若是竞赛
			$this->load->model('contest_model');
			$contestId = $loc_id;
			$privilege=FALSE;
			if(!$this->contest_model->is_contest_problem($contestId,$problemId)){
				//竞赛没有对应的问题
				$this->error->show_error("竞赛没有对应的题目",array("竞赛中找不到你提交的题目呀","是我弄错了，还是你在卖萌"),$data);
				return;
			}
			$data['contest']=$this->oj_model->get_contest_item($contestId,array('private'));//获取题目公开与否
			
			if(!$this->contest_model->is_private($contestId)){
				$privilege=TRUE;
			}
			else {
				Global $pri;
				if($this->contest_model->get_contest_privilege($loc_id,$data['user']['userId'],$pri['submit']))
					$privilege = TRUE;
				else
					$privilege = FALSE;
			}
			if($privilege === TRUE){
				$this->oj_model->add_solution(array('problemId'=>$problemId,'userId'=>$data['user']['userId'],'programLan'=>$programLan,
				'inDate'=>mdate($date_str),'contestId'=>$contestId,'codeLen'=>$code_len),array('code'=>$code));
				if($this->redis->exitsts($problem_catche)){
					$this->redis->del($problem_catche);
				}
			}else{
				$this->error->show_error("没有竞赛权限",array("你没有此次竞赛的权限"),$data);
				return;
			}
			
		}
		else if(($loc == 2) && is_numeric($loc_id)){//若是课程
			//如果是课程的话
			$this->load->model('course_model');
			Global $pri;
			$unitId = $loc_id;
			$courseId = $this->course_model->get_unit_course_id($unitId);
			$this->load->model('course_model');
			Global $pri;
			if($courseId==-1){
				//课程没有对应的问题
				$this->error->show_error("没有课程或者课程单元没有对应的问题",array("课程单元里找不到你要提交的问题ID","是我弄错了，还是你在卖萌"),$data);
				return;
			}
			$privilege = FALSE;
			if(!$this->course_model->is_private($courseId))
				$privilege = TRUE;
			else{
				if($this->course_model->get_course_privilege($courseId,$data['user']['userId'],$pri['submit']))
					$privilege = TRUE;
				else $privilege = FALSE;
			}
			if($privilege === TRUE){
				$this->oj_model->add_solution(array('problemId'=>$problemId,'userId'=>$data['user']['userId'],'programLan'=>$programLan,
				'inDate'=>mdate($date_str),'unitId'=>$unitId,'codeLen'=>$code_len),array('code'=>$code));
				if($this->redis->exitsts($problem_catche)){
					$this->redis->del($problem_catche);
				}
			}else{
				//用户没有权限
				$this->error->show_error("没有课程权限",array("你没有此次竞赛的权限"),$data);
				return;
			}
		}
		else{
			$this->oj_model->add_solution(array('problemId'=>$problemId,'userId'=>$data['user']['userId'],'programLan'=>$programLan,
				'inDate'=>mdate($date_str),'codeLen'=>$code_len),array('code'=>$code));//普通问题
				if($this->redis->exitsts($problem_catche)){
					$this->redis->del($problem_catche);
				}
			}
		redirect(site_url("status"));//跳转到status页面
}else{
	$this->error->show_error('进入方式错误',array("请不要随意修改URL,确保你提交数据"),$data);
	return;//防止多次下面分支view
}
}
}
