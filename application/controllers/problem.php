<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Problem extends CI_Controller {

	 
	public function __construct()
  {
    parent::__construct();
  }

/**
 * 这里的表单直接用的post传递过来就可以了
 * s_title,s_id
 */
  
	public function index($page=1)
	{
		Global $data;
		//s_type=0,1,2分别表示不开启搜索,按id，title搜索
		$this->load->helper('form');
		$this->load->library('form_validation');
		$total=0;
		$by_id=FALSE;//是否按照id来查找
		$by_title=FALSE;//是佛按照title来查找，这里可以扩展成混合查找
		
		$data['page_title']='题目列表';

		if(isset($_POST['s_id'])){
			//判断是否是id搜索
			$s_id=$_POST['s_id'];
			$by_id=TRUE;
			$total=$this->oj_model->get_row("problem","problemId","defunct =0 AND problemId = ".$this->db->escape($s_id)." ");
		}else if(isset($_POST['s_title'])){
			//title搜索
			$s_title=$_POST['s_title'];
			$by_title=TRUE;
			$total=$this->oj_model->get_row("problem","problemId","defunct =0 AND title LIKE ".$this->db->escape("%".$s_title."%")." ");
		}else{
			$problem_count_catche = "problem_count_catche";
			if($this->redis->exitsts($problem_count_catche)){
				$total = $this->redis->get($problem_count_catche);
			}else{
				$total=$this->oj_model->get_row();//直接获取行数
				$this->redis->set($problem_count_catche,$total);
		}
		}
		
		
		if($total==0){
			$data['problem_list']=array();
			$data['is_empty']=TRUE;//搜索结果为空
		}
		if(isset($_POST['s_id']) || isset($_POST['s_title'])){
				$limit_from=0;
				$limit_row=$total;
				$is_search=TRUE;
			}else{
				$is_search=FALSE;
				$limit_from=($page-1)*10;
				$limit_row=10;
			}//判断是否是搜索模式是的话下面就不分页
		if($page>=1 && is_numeric($page) && (($page-1)*10<=$total)){
			$column_array=array('problemId','title','source','accepted','submit');
			if($by_id===TRUE){
				$data['problem_list']=$this->oj_model->get_problem_list_where($column_array,'problemId',FALSE,
				"defunct =0 AND problemId = ".$this->db->escape($s_id)." ",$limit_from,$limit_row);
			}else if($by_title===TRUE){
				$data['problem_list']=$this->oj_model->get_problem_list_where($column_array,'problemId',FALSE,
				"defunct =0 AND title LIKE ".$this->db->escape("%".$s_title."%")." ",$limit_from,$limit_row);
			}else{
				$problem_page_catche =  "problem_page_catche";
				if($this->redis->hexitsts($problem_page_catche,$page)){
					$data['problem_list'] = unserialize($this->redis->hget($problem_page_catche,$page));
				}else{
					$data['problem_list']=$this->oj_model->get_problem_list($column_array,'problemId',FALSE,$limit_from,$limit_row);
					$this->redis->hset($problem_page_catche,$page,serialize($data['problem_list']));
			}
			}
			
			if(!$data['is_login']){
			//用户还没有登录status全部设置为no
			for($i=0;$i<count($data['problem_list']);$i++)
			$data['problem_list'][$i]['status']="No";
		}else if(!empty($data['problem_list'][0])){
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
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url("problem/index");
			$config['total_rows'] = $total;
			if($is_search==TRUE){
				$config['per_page'] =$total;
			}else
			$config['per_page'] =10;
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
		Global $data;
		if(isset($_GET['contest_id'])){
			$data['contestId'] = $_GET['contest_id'];
		}else if(isset($_GET['unit_id'])){
			$data['unit_id']=$_GET['unit_id'];
		}
		$problem=array(' * ');
		$data['problem']=$this->oj_model->get_problem_item($id,$problem);
		$problem_catche = "problem_catche_".$id;
		if($this->redis->exitsts($problem_catche)){
			$data['problem'] = unserialize($this->redis->get($problem_catche));
		}else{
			$data['problem']=$this->oj_model->get_problem_item($id,$problem);
			if(! empty($data['problem'])){
				$this->redis->set($problem_catche,serialize($data['problem']));
			}
		}
		if(! empty($data['problem'])){
			$this->load->view('common/header',$data);
			$this->load->view('problem_item_view',$data);
			$this->load->view('common/footer',$data);
		}
		else{
			$this->error->show_error("没有找到此问题",array("悲剧了，没有找到对应的问题呀"),$data);
		}
	}
	
}
