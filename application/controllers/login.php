<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 */
	  public function __construct()
  {
    parent::__construct();
    $this->load->model('oj_model');
  }
  
	public function index(){
		$this->output->enable_profiler(TRUE);
		$this->load->library('user_help');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username');
		$this->form_validation->set_rules('pa');
		
		if($this->form_validation->run()===TRUE){
			if($this->user_help->is_session()){
				//已经登陆了
				$this->load->helper('form');
				$this->load->view('login_view');
			}else{
				$info=$this->input->post('username',TRUE);
				$pass=$this->input->post('pa',TRUE);
				$userdata=NULL;
			if(($userdata=$this->user_help->set_session($info,$pass))!=FALSE){
					$data['userdata']=$userdata;
					$this->load->view('user_info_view',$data);
				}else{
					$this->load->helper('form');
					$this->load->view('login_view');
				}
			}
		}
			
	}
	
	public function show(){
		$this->load->helper('form');
		$this->load->view('login_view');
	}
	
}
