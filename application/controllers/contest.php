<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contest extends CI_Controller {

	 
	public function __construct()
  {
    parent::__construct();
  }

	public function index($s_type=0,$s_content=NULL,$page=1){
		Global $data;
		$by_id=FALSE;//是否按照id来查找
		$by_title=FALSE;//是佛按照title来查找，这里可以扩展成混合查找

		$data['page_title']='竞赛列表';

		if(isset($_POST['s_id'])){
			//判断是否是id搜索
			$s_id=$_POST['s_id'];
			$by_id=TRUE;
			$total=$this->oj_model->get_row("contest","contestId","defunct =0 AND contestId = ".$this->db->escape($s_id)." ");
		}else if(isset($_POST['s_title'])){
			//title搜索
			$s_title=$_POST['s_title'];
			$by_title=TRUE;
			$total=$this->oj_model->get_row("contest","contestId","defunct =0 AND title LIKE ".$this->db->escape("%".$s_title."%")." ");
		}else
		$total=$this->oj_model->get_row("contest","contestId","defunct = 0");//contest总行数
		if($total==0){
			$data['is_empty']=TRUE;
			$data['contest_list']=array();
		}
		if(is_numeric($page) && $page>=1 && (($page-1)*10<=$total)){
			$column_array=array('contestId','title','startTime','endTime','defunct','private');
			if($by_id===TRUE){
				$data['contest_list']=$this->oj_model->get_contest_list_where($column_array,'contestId',FALSE,
				"defunct =0 AND contestId = ".$this->db->escape($s_id)." ",($page-1)*10,10);
			}else if($by_title===TRUE){
				$data['contest_list']=$this->oj_model->get_contest_list_where($column_array,'contestId',FALSE,
				"defunct =0 AND title LIKE ".$this->db->escape("%".$s_title."%")." ",($page-1)*10,10);
			}else
			$data['contest_list']=$this->oj_model->get_contest_list_where($column_array,
			"contestId",TRUE,"defunct = 0",($page-1)*10,10);
			
			$this->load->library('pagination');
			$config['first_link'] = TRUE;
			$config['last_link'] = TRUE;
			$config['uri_segment']=3;
			$config['num_links'] = 7;
			$config['use_page_numbers'] = TRUE;
			$config['base_url'] = site_url("contest/index");
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
			$this->load->view('contest_list_view',$data);
			$this->load->view('common/footer',$data);
		}else{
			$this->index();//页面没找到
			//show(404);
		}
		
	}
	
	public function get_contest($id){
		if(!is_numeric($id)){
			show_404();//用户可能进行非法操作
			exit();
		}
		$data['permission']="no";
		$data['is_login']=FALSE;
		$user=$data['user'];
		$data['contest_item']=$this->oj_model->get_contest_item($id);
		$data['contest_problem_list']=$this->oj_model->get_contest_problem_list($id);
		if(empty($data['contest_item'])){
			show_404();//没有索取的竞赛
		}else{
			if($data['contest_item']['private']==0){
				$data['permission']="yes";
			}	
			else if($data['is_login']===FALSE){//用户没有登录
				$data['permission']="no";
			}else{//用户登录
				$data['permission']="no";
				$data['problem_privilege']=$this->oj_model->get_contest_privilege($id,$user['userId']);
				if(!empty($data['problem_privilege'])){//用户有权限
					$data['permission']="yes";
				}
			}
			$this->load->view('common/header',$data);
			$this->load->view('contest_item_view',$data);
			$this->load->view('common/footer',$data);
		}
	}
}
