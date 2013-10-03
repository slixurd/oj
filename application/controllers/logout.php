<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	/**
	 * Index Page for this controller.
	 */
	  public function __construct()
  {
    parent::__construct();
  }
  
	public function index(){
		$this->load->library('user_help');
		if(!$this->user_help->is_session()){
			//用户还没有登录
			$this->load->view('login_view');
		}else{
			//销毁session
			$this->load->library('session');
			//$this->load->model('oj_model');
			//$this->oj_model->unset_session($this->session->userdata('session_id'));
			$this->session->sess_destroy();
		}
			
	}
}
