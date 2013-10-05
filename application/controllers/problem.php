<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Problem extends CI_Controller {

	 
	public function __construct()
  {
    parent::__construct();
    $this->load->model('oj_model');
    $this->load->library('user_help');
  }

/**
 * 这里的表单直接用的post传递过来就可以了
 * s_title,s_id
 */
  
	public function index($page=1)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$total=0;
		$by_id=FALSE;//是否按照id来查找
		$by_title=FALSE;//是佛按照title来查找，这里可以扩展成混合查找
		
		$data['is_login']=FALSE;
		if($this->user_help->is_session()){
			$data['is_login']=TRUE;
			$data['user']=$this->user_help->get_session();
		}//这里用来表示用户是否登录传递到view页面
		
		if(isset($_POST['s_id'])){
			//判断是否是id搜索
			$by_id=TRUE;
			$total=$this->oj_model->get_row("problem","problemId","defunct =0 AND problemId = ".$this->db->escape($_POST['s_id'])." ");
		}else if(isset($_POST['s_title'])){
			//title搜索
			$by_title=TRUE;
			$total=$this->oj_model->get_row("problem","problemId","defunct =0 AND title LIKE ".$this->db->escape("%".$_POST['s_title']."%")." ");
		}else
		$total=$this->oj_model->get_row();//直接获取行数
		if($total==0){
			//问题集合为空或者搜索结果为空
		}
		if($page>=1 && is_numeric($page) && (($page-1)*10<$total)){
			$column_array=array('problemId','title','source','accepted','submit');
			if($by_id===TRUE){
				$data['problem_list']=$this->oj_model->get_problem_list_where($column_array,'problemId',FALSE,
				"defunct =0 AND problemId = ".$this->db->escape($_POST['s_id'])." ",($page-1)*10,10);
			}else if($by_title===TRUE){
				$data['problem_list']=$this->oj_model->get_problem_list_where($column_array,'problemId',FALSE,
				"defunct =0 AND title LIKE ".$this->db->escape("%".$_POST['s_title']."%")." ",($page-1)*10,10);
			}else
			$data['problem_list']=$this->oj_model->get_problem_list($column_array,'problemId',FALSE,($page-1)*10,10);
			
			if(!$data['is_login']){
			//用户还没有登录status全部设置为no
			for($i=0;$i<count($data['problem_list']);$i++)
			$data['problem_list'][$i]['status']="No";
		}else{
			//用户已经登录获取本页每个问题的status
			$user=$this->user_help->get_session();
			$userId=$user['userId'];
			$firstId=$data['problem_list'][0]['problemId'];
			$lastId=$data['problem_list'][count($data['problem_list'])-1]['problemId'];
			$solution_array=array('problemId','userId','result');
			$status=$this->oj_model->get_solution_list_where($solution_array,"result = 1 AND userId = ".$userId." AND 
			(problemId BETWEEN ".$firstId." AND ".$lastId." )");
			
			for($i=0;$i<count($data['problem_list']);$i++){
				if(count($status)===0)
				$data['problem_list'][$i]['status']="No";
				for($j=0;$j<count($status);$j++){
				if(($status[$j]['result'] == 1)&&(($status[$j]['problemId'] == $data['problem_list'][$i]['problemId']))){
					$data['problem_list'][$i]['status']="Yes";
					break;
				}
				$data['problem_list'][$i]['status']="No";
			}
			}
		}
		
			$this->load->library('pagination');
			$config['first_link'] = TRUE;
			$config['last_link'] = TRUE;
			$config['uri_segment']=3;
			$config['num_links'] = 7;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = 'http://localhost/scutoj/index.php/problem/index/';
			$config['total_rows'] = $total;
			$config['per_page'] = 10;

			$config['first_link'] = '首页';
			$config['last_link'] = '末页';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a>';
			$config['cur_tag_close'] = '</a></li>';		
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';			
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';	
			$this->pagination->initialize($config);


			$data['pagination_block'] = $this->pagination->create_links();

			$this->load->view('common/header',$data);
			$this->load->view('problem_list_view',$data);
			$this->load->view('common/footer',$data);
		}
		else{
			show_404();
		}
		
	}
	
	public function get_problem($id)
	{
		$data['is_login']=FALSE;
		if($this->user_help->is_session()){
			$data['is_login']=TRUE;
		}//这里用来表示用户是否登录传递到view页面
		$problem=array(' * ');
		$data['problem']=$this->oj_model->get_problem_item($id,$problem);
		if(! empty($data['problem'])){
			$this->load->view('problem_item_view',$data);
		}
		else{
			//这里是用来表示用户传递错误参数或者问题为空时的页面
			$this->index();
			//show_404();
		}
	}
	
}
