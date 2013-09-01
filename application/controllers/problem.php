<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Problem extends CI_Controller {

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
		$data['problem']=$this->oj_model->get_problem_list(TRUE,array('title','output'),"title = 'titletest'");
		$this->load->view('problem_list_view',$data);
	}
}