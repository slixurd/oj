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
			$this->load->view('login_view');
		}else{
			$this->session->sess_destroy();
			redirect(site_url("problem/index"));
		}
			
	}
}
