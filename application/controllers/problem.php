<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Problem extends CI_Controller {

	/**
	 * Index Page for this controller.
	 */
	 
	public function __construct()
  {
    parent::__construct();
    $this->load->model('oj_model');
    $this->load->library('user_help');
  }
  
	public function index($page=1)
	{
		$total=$this->oj_model->get_problem_row();
		if($page>=1 && is_numeric($page) && (($page-1)*10<$total)){
			$column_array=array('problemId','title','source','accepted','submit');
			$data['problem_list']=$this->oj_model->get_problem_list($column_array,'problemId',FALSE,($page-1)*10,10);
			
			if(!$this->user_help->is_session()){
			//用户还没有登录
			for($i=0;$i<count($data['problem_list']);$i++)
			$data['problem_list'][$i]['status']="No";
		}else{
			$user=$this->user_help->get_session();
			$userId=$user['userId'];
			$firstId=$data['problem_list'][0]['problemId'];
			$lastId=$data['problem_list'][count($data['problem_list'])-1]['problemId'];
			$solution_array=array('problemId','userId','result');
			$status=$this->oj_model->get_solution_list_where($solution_array,"result = 1 AND userId = ".$userId." AND 
			(problemId BETWEEN ".$firstId." AND ".$lastId." )");
			
			for($i=0;$i<count($data['problem_list']);$i++){
				for($j=0;$j<count($status);$j++){
				if(($status[$j]['result'] == 1)&&(($status[$j]['problemId'] == $data['problem_list'][$i]['problemId']))){
					$data['problem_list'][$i]['status']="Yes";
					break;
				}
				$data['problem_list'][$i]['status']="No";
			}
			}
		}
		
			$this->load->view('problem_list_view',$data);
		
			$this->load->library('pagination');
			$config['first_link'] = FALSE;
			$config['last_link'] = FALSE;
			$config['uri_segment']=3;
			$config['num_links'] = 7;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = 'http://localhost/scutoj/index.php/problem/index/';
			$config['total_rows'] = $total;
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
