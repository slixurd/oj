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
  
	public function index($page=1)
	{
		$data['row']=$this->oj_model->get_problem_row();
		if($page>=1 && is_numeric($page) && (($page-1)*10<$data['row']['row'])){
			$column_array=array('problemId','title','source','accepted','submit');
			$data['problem_list']=$this->oj_model->get_problem_list($column_array,'problemId',FALSE,($page-1)*10,10);
			$this->load->view('problem_list_view',$data);
		
			$this->load->library('pagination');
			$config['first_link'] = FALSE;
			$config['last_link'] = FALSE;
			$config['uri_segment']=3;
			$config['num_links'] = 7;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = 'http://localhost/scutoj/index.php/problem/index/';
			$config['total_rows'] = $data['row']['row'];
			$config['per_page'] = 10;
			$this->pagination->initialize($config);
			echo $this->pagination->create_links();
		}
		else{
			show_404();
		}
		
	}
	
	public function get_problem($id)
	{
		$problem=array(' * ');
		$data['problem']=$this->oj_model->get_problem_item($id,$problem);
		if(! empty($data['problem'])){
			$this->load->view('problem_item_view',$data);
		}
		else{
			$this->index();
			//show_404();
		}
	}
	
}
