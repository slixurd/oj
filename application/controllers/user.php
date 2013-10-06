<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Index Page for this controller.
	 */
	  public function __construct()
  {
    parent::__construct();
    $this->load->model('oj_model');
  }
  
	public function index()
	{
		//这里暂时用用户页面代替
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->view('register_view');
	}
	
	public function register()
	{
		$this->load->library('user_help');
		$this->load->helper('date');
		$date_str="%Y-%m-%d %H:%i:%s";
		$this->load->library('encrypt');
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username');
		$this->form_validation->set_rules('pa');
		$this->form_validation->set_rules('email');
		$salt=$this->user_help->salt(25,35);
		if($this->form_validation->run() === TRUE ){
			$user=array(
				'name'=>$this->input->post('username',TRUE),
				'password'=>$this->input->post('pa',TRUE),
				'email'=>$this->input->post('email',TRUE),
				'defunct'=>0
			);
			$user['password']=$this->encrypt->sha1($salt.$user['password']);
			$user['salt']=$salt;
			$user['regTime']=mdate($date_str);
			$this->oj_model->add_user($user);
			$this->load->view('register_success_view');
		}
		else{
			$this->load->view('register_view');
		}
	}
	
}
