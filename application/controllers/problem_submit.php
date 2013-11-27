<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Problem_submit extends CI_Controller {
	var $data=NULL;
 
	public function __construct()
  {
    parent::__construct();
    $this->load->helper('date');
  }
  
  public function index($problemId=10000){
	  Global $data;
	  if($data['is_login']){
			$data['problem']=$this->oj_model->get_problem_item($problemId,array('problemId'));
			$this->load->view('common/header',$data);
			$this->load->view('student/problem_submit_view',$data);
			$this->load->view('common/footer',$data);
		}else{
			$this->error->show_error('尚未登录不能答题',array("先右上角登陆吧","test","测试"),$data);
			return;//防止多次下面分支view
		}
  }
  
  public function submit(){
	  Global $data;
	  $date_str="%Y-%m-%d %H:%i:%s";
	  $now=strtotime("now");
	  if(!$data['is_login']){
			$this->error->show_error('尚未登录不能答题',array("先右上角登陆吧","test","测试"),$dta);
			return;//防止多次下面分支view
	  }else if(isset($_POST['problemId']) && isset($_POST['code']) && isset($_POST['language']) && is_numeric($problemId)){//判断用户是否传递了最基本的元素
		$problemId=$_POST['problemId'];
		$programLan=$_POST['language'];
		$code=$_POST['code'];
		$problem_catche = "problem_catche_".$problemId;
		$problem_item=$this->oj_model->get_problem_item($problemId);//按号查相关问题
		
		if($code_len<4){
			//提示代码太短
			$this->error->show_error("代码太短了",array("哎呀，难道是个天才算法么","代码太短了，我无法接受啊"));
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
		
		if(isset($_POST['contest_id']) && is_numeric($_POST['contest_id'])){//若是竞赛
			$contestId = $_POST['contest_id'];
			$contestId = $_POST['contest_id'];
			$privilege=FALSE;
			$contest_problem = $this->oj_model->get_item_where("contest_problem" , array("contestId,problemId"), " contestId = ".$this->db->escape($contestId)." AND 
			problemId = ".$this->oj_model->escape($problemId)." ");
			if(empty($contest_problem)){
				//竞赛没有对应的问题
				$this->error->show_error("竞赛没有对应的题目",array("竞赛中找不到你提交的题目呀","是我弄错了，还是你在卖萌"),$data);
				return;
			}
			
			$data['contest']=$this->oj_model->get_contest_item($contestId,array('private'));//获取题目公开与否
			
			if($date['contest']['private']==0)
			$privilege=TRUE;
			else {
				$contest_privilege = $this->oj_model->get_item_where("contest_privilege",array("contestId","userId","priType"),"contestId","userId = ".$this->db->escape($userId)." 
			AND contestId = ".$this->db->escape($contestId)." AND defunct = 0");
				if(empty($contest_privilege)){	
					$privilege = FALSE;
				}else $privilege = TRUE;
			}
			if($privilege === TRUE){
				$this->oj_model->add_solution(array('problemId'=>$problemId,'userId'=>$data['user']['userId'],'programLan'=>$programLan,
				'inDate'=>mdate($now),'contestId'=>$contestId,'codeLenth'=>$code_len));
				if($this->redis->exitsts($problem_catche)){
					$this->redis->del($problem_catche);
				}
			}else{
				$this->error->show_error("没有竞赛权限",array("你没有此次竞赛的权限"),$data);
				return;
			}
			
		}
		else if(isset($_POST['course_id']) && is_numeric($_POST['course_id']) 
		&& isset($_POST['unit_id']) && is_numeric($_POST['unit_id'])){//若是课程
			//如果是课程的话
			$unitId = $_POST['unit_id'];
			$courseId = $_POST['course_id'];
			$unit_problem = $this->oj_model->get_item_where("unit_problem" , array("unitId","problemId"), " unitId = ".$this->db->escape($unitId)." AND 
			problemId = ".$this->oj_model->escape($problemId)." ");
			if(empty($unit_problem)){
				//课程没有对应的问题
				$this->error->show_error("课程单元没有对应的问题",array("课程单元里找不到你要提交的问题ID","是我弄错了，还是你在卖萌"),$data);
				return;
			}
			$data['course']=$this->oj_model->get_course_item($unitId,array('private'));
			$privilege = FALSE;
			if($data['course']['private'] == 0)
			$privilege = TRUE;
			else{
				$course_privilege = $this->oj_model->get_item_where("course_privilege","courseId" , array("courseId","userId","priType"),"userId = ".$this->db->escape($userId)." 
				AND courseId = ".$this->db->escape($courseId)." AND defunct = 0");
				if(empty($course_privilege)){
					$privilege = FALSE;
				}else $privilege = TRUE;
			}
			if($privilege === TRUE){
				$this->oj_model->add_solution(array('problemId'=>$problemId,'userId'=>$data['user']['userId'],'programLan'=>$programLan,
				'inDate'=>mdate($now),'unitd'=>$unitId,'codeLenth'=>$code_len));
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
				'inDate'=>mdate($now),'codeLenth'=>$code_len));//普通问题
				if($this->redis->exitsts($problem_catche)){
					$this->redis->del($problem_catche);
				}
			}
		redirect(site_url("status"));//跳转到status页面
}
}
}
