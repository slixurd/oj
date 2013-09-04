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
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username');
		$this->form_validation->set_rules('pa');
		$this->form_validation->set_rules('email');
		if($this->form_validation->run() === TRUE ){
			$user=array(
				'name'=>$this->input->post('username'),
				'password'=>$this->input->post('pa'),
				'email'=>$this->input->post('email'),
				'defunct'=>0
			);
			$this->oj_model->add_user($user);
			$this->load->view('register_success_view');
		}
		else{
			$this->load->view('register_view');
		}
	}
	
}
