<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Index Page for this controller.
	 */
	  public function __construct()
  {
    parent::__construct();
  }
  
	public function index()
	{
		Global $data;
		if(!$data['is_login']){
			$this->error->show_error("没有权限",array("用户信息页面需要登录","点击右上角登录"),$data);
			return;
		}
		$user = $data['user'];
		$this->load->model('user_model','umodel');
		$u = $this->umodel->get_user_item_id($user['userId']);
		if(empty($u)){
			$this->error->show_error("用户信息错误",array("请重新登陆","点击右上角登录"),$data);
			return;
		}
		$u_static = $this->umodel->get_user_state_item($user['userId']);
		$data['u_plist'] = $this->umodel->get_user_solution_list($user['userId']);
		$data['ce_num']=0;
		$data['ac_num']=$u_static['solved'];
		$data['submit_num']=$u_static['submit'];
		$data['school']=0;
		$data['email']=0;
		$data['plan']='暂无';

		$this->load->view('common/header',$data);
		$this->load->view('student/info');
		$this->load->view('common/footer');
	}
  
  //如果用户已经登录不予注册导入register_noavailable页面
	public function register()
	{
		Global $data;
		$data['page_title']='注册';
		if($data['is_login']){
			$this->error->show_error("已登录不能注册",array("请先退出帐号","点击右上登出"),$data);
			return;
		}else {
			$this->load->view('common/header',$data);
			$this->load->view('register_view',$data);
			$this->load->view('common/footer',$data);
		}
	}
	
/**
 * 注册提交地址以post的方式注册,检查邮箱格式，用户名长度4-15数字字母,邮箱长度6-50,密码长度6-20数字字母否则不通过审核
 */
 
	
	public function register_submit()
	{
		Global $data;
		$this->load->helper('date');
		$date_str="%Y-%m-%d %H:%i:%s";
		$this->load->library('encrypt');
		
		$this->form_validation->set_rules('username');
		$this->form_validation->set_rules('pa');
		$this->form_validation->set_rules('paconf');
		$this->form_validation->set_rules('email');
		$salt=$this->user_help->salt(25,35);
		$data['result']=0;//data['result']：0/注册成功，1/用户注册格式不能通过审核，2/注册成功但不能正常登录请自行登录，3/用户邮箱或者用户名已经存在
		//4/表单不能正常提交通过验证或者用户密码确认不符合
		if($data['is_login']){
			$this->error->show_error("已登录不能注册",array("请先退出帐号","点击右上角注册"),$data);
		}
		else if($this->form_validation->run() === TRUE && $this->input->post('pa',TRUE) == $this->input->post('paconf',TRUE)){
			$user=array(
				'name'=>$this->input->post('username',TRUE),
				'password'=>$this->input->post('pa',TRUE),
				'email'=>$this->input->post('email',TRUE),
				'defunct'=>0
			);
			$user['password']=$this->encrypt->sha1($salt.$user['password']);
			$user['salt']=$salt;
			$user['regTime']=mdate($date_str);
			$u_name=$this->oj_model->unique_user($user['name']);
			$u_email=$this->oj_model->unique_email($user['email']);
			if($u_email==0 && $u_name==0){//如果检测密码用户名邮箱不成功的话将不会直接定向到失败页面而是echo相应的数组
				$name_rt=$this->user_help->check_name($user['name']);
				$email_rt=$this->user_help->check_email_preg($user['email']);
				$pass_rt=$this->user_help->check_pass($this->input->post('pa',TRUE));
				if($name_rt['name_preg'] == 0 || $name_rt['name_len']<4 || $name_rt['name_len']>15 ||
				  $pass_rt['pass_preg']==0 || $pass_rt['pass_len']<6  ||
				strlen($user['email'])<6  || $pass_rt['pass_len']>20 ||
				  $email_rt ==0  || strlen($user['email'])>50){//用户注册信息不能通过审核
					$data['result']=1;//注册信息格式不能通过审核
					$this->error->show_error("注册信息有错误",array("传递过来的用户信息不能通过审核","请重新注册"),$data);
					return;
				}
				else
					$this->oj_model->add_user($user);

				if(($data['user']=$this->user_help->set_session($user['name'],$this->input->post('pa',TRUE)))!=FALSE){
					$data['is_login']=TRUE;
					$data['user'] = $this->user_help->get_session();
					$this->load->view('common/header',$data);
					$this->load->view('register_success_view',$data);
					$this->load->view('common/footer',$data);
				}else{
					$data['result']=2;//注册成功但不能正常创建seseeion并且登录
					$this->error->show_error("注册成功",array("你已经注册成功了，无法自动登录","请重新登录"),$data);
					return;
				}
			}else{
				$data['result']=3;//用户名或者邮箱已经存在
				$this->error->show_error("用户名或者邮箱已经存在",array("请用别的用户名或者邮箱注册"),$data);
				return;
			}
			
		}
		else{
			$data['result']=4;//表单不能提交或者密码确认不符合
			$this->error->show_error("注册信息提交失败",array("请确认密码符合后重新注册"),$data);
			return;
		}
	}

	public function check_unique_email(){
		$email_to_check = $this->input->post('email',TRUE);
		$unique = array('email' => $this->oj_model->unique_email($email_to_check) ); 
		echo json_encode($unique);
	}

	public function check_unique_username(){
		$name_to_check = $this->input->post('username',TRUE);
		$unique = array('username' => $this->oj_model->unique_user($name_to_check) ); 
		echo json_encode($unique);
	}
	
	public function modify(){
		Global $data;
		if(!$data['is_login']){
			$this->error->show_error("没有权限",array("用户信息页面需要登录","点击右上角登录"),$data);
			return;
		}
		$user = $data['user'];
		$this->load->model('user_model','umodel');
		$u = $this->umodel->get_user_item_id($user['userId']);
		if(empty($u)){
			$this->error->show_error("用户信息错误",array("请重新登陆","点击右上角登录"),$data);
			return;
		}

		$this->load->view('common/header',$data);
		$this->load->view('modify');
		$this->load->view('common/footer');		
	}


	public function modify_result(){
		Global $data;
		if(!$data['is_login']){
			$this->error->show_error("没有权限",array("用户信息页面需要登录","点击右上角登录"),$data);
			return;
		}
		$user = $data['user'];
		$this->load->model('user_model','umodel');
		if(($this->input->post('pa')!=$this->input->post('paconf'))||$this->input->post('origin')===FALSE){
			$this->error->show_error("用户信息错误",array("请重新填写"),$data);
			return;
		}

		$vpass = $this->umodel->check_pass($this->input->post('pa',TRUE));
		$valid = $this->umodel->check_user_password_id($user['userId'],$this->input->post('origin',TRUE));
		if($valid === FALSE ||$vpass['pass_preg'] == 0){
			$this->error->show_error("用户密码错误或新密码不符合要求",array("请重新填写"),$data);
			return;			
		}

		if($this->umodel->update_user_password($user['userId'],$this->input->post('pa',TRUE),$this->input->post('origin',TRUE)) == FALSE){
			$this->error->show_error("用户密码错误或新密码不符合要求",array("请重新填写"),$data);
			return;					
		}

		$this->logout();
		$this->load->view('common/header',$data);
		$this->load->view('modify_result');
		$this->load->view('common/footer');		
	}

	public function logout()
	{
		$this->session->sess_destroy();
	}

	public function history(){
		Global $data;
		if(!$data['is_login']){
			$this->error->show_error("没有权限",array("用户信息页面需要登录","点击右上角登录"),$data);
			return;
		}
		$user = $data['user'];

		$this->load->model('user_model','umodel');
		$data['log_list'] = $this->umodel->get_login_log_list($user['name'],$user['email']);
		$this->load->view('common/header',$data);
		$this->load->view('student/history');
		$this->load->view('common/footer');		
	}

	public function reset(){
		Global $data;
		$data['page_title'] = "找回密码";
		if($data['is_login']){
			$this->error->show_error("已经登陆",array("都登陆还忘记密码么?"),$data);
			return;
		}
		$this->load->view('common/header',$data);
		$this->load->view('student/reset');
		$this->load->view('common/footer');				
	}

	public function reset_result(){
		Global $data;
		if($data['is_login']){
			$this->error->show_error("已经登陆",array("都登陆还忘记密码么?"),$data);
			return;
		}
		if ($this->input->post("name") == FALSE || $this->input->post("email") == FALSE ||$this->input->post("pass") == FALSE ) {
			$this->error->show_error("数据不全",array("返回重新填写再提交"),$data);
			return;
		}
		$name = $this->input->post("name",TRUE);
		$email = $this->input->post("email",TRUE);
		$pass = $this->input->post("pass",TRUE);
		$this->load->model('user_model','umodel');

		$is_right = $this->umodel->check_email($name,$email);
		if($is_right === FALSE){
			$this->error->show_error("用户名和邮箱不匹配",array("返回重新填写再提交"),$data);
			return;
		}

		$vpass = $this->umodel->check_pass($pass);
		if($vpass['pass_preg'] == 0){
			$this->error->show_error("新密码不符合要求",array("请重新填写"),$data);
			return;			
		}

		$this->umodel->force_cpass($name,$pass);

		$this->load->view('common/header',$data);
		$this->load->view('student/reset_success');
		$this->load->view('common/footer');				
	}

}
