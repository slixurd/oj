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
		$column_array=array('problemId','title','source','accepted','submit');
		$data['problem_list']=$this->oj_model->get_problem_list($column_array,'problemId',FALSE);
		$this->load->view('problem_list_view',$data);
	}
	
	public function get_problem($id)
	{
		$problem=array(' * ');
		$data['problem']=$this->oj_model->get_problem_item($id,$problem);
		if(! empty($data['problem'])){
			$this->load->view('problem_item_view',$data);
		}
		else{
			$this->index()
			//show_404();
		}
	}
	
}
