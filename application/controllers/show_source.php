<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Show_source extends CI_Controller {
 
	public function __construct()
  {
    parent::__construct();
  }
  
  public function index($solutionId=0){
	  Global $data;
	  $data['page_title']='查看源码';
	  if(!$data['is_login']){
		  $this->error->show_error("你还没有登录",array("此竞赛需要权限，请先登录","点击右上角登录"),$data);
		  return;
	  }
	  $data['source']=array();
	  if(is_numeric($solutionId)){
		$data['source'] = $this->oj_model->get_item_where("solution",array('solutionId','problemId','result',' programLan'),
		"userId = ".$data['user']['userId']." AND solutionId = ".$solutionId."");
		$data['source']['code'] = $this->oj_model->get_item_where("solution_code",array('code'),"solutionId = ".$solutionId."");
		if(empty($data['source']) || empty($data['source']['code'])){
			$this->error->show_error("没有相关源码",array("没有相关的源代码","请确认源码是否存在","可能你没有源码权限"),$data);
			return;
		}
	}
	$this->load->view('common/header',$data);
	$this->load->view('show_source_view',$data);
	$this->load->view('common/footer',$data);
	
  }
}
