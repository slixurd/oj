<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rank extends CI_Controller {

     
    public function __construct()
    {
        parent::__construct();
        $this->load->model("rank_model","rank");
    }
    
    public function index($page = 1){
		Global $data;
		$data['page_title']='排名';
		
		if(intval($page) <= 0){
			$this->error->show_error("对不起，地址错误",array("页面编号错误"),$data);
            return; 
		}
		
		$total = $this->rank->get_count_user();
		$data['rank_list'] = $this->rank->rank_list(($page-1)*10,10);
		
		//echo var_dump($data);
		
		$this->load->library('pagination');
        $config['first_link'] = TRUE;
        $config['last_link'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $config['base_url'] = site_url("admin/contest/index");
        $config['total_rows'] = $total;
        $config['per_page'] =10;
        $config['first_link'] = '首页';
        $config['last_link'] = '末页';
        $config['num_tag_open'] = '<li>';
        //// important!由于地址过长所以必须有修改segment,否则无法定位
        $config['uri_segment'] = 4;         
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
        $this->load->view("common/admin_header",$data);
        //$this->load->view("admin/rank_list",$data);
        $this->load->view("common/admin_footer",$data);
	}
	
	public function contest_rank_list($cid = 0){
		Global $data;
		
		$cid = intval($cid);
		$rank_list = $this->rank->contest_rank($cid);
		if($rank_list == false){
			$this->error->show_error("对不起， 竞赛未开始",array("竞赛还没有开始哦"),$data);
            return; 
		}
		
		foreach($rank_list  as $rank)
			echo "<BR>".var_dump($rank)."<BR>";
		
		$this->load->view("common/admin_header",$data);
        //$this->load->view("admin/contest_rank_list",$data);
        $this->load->view("common/admin_footer",$data);
	}
	
	public function unit_rank_list($uid){
		Global $data;
		
		$cid = intval($cid);
		$rank_list = $this->rank->unit_rank($uid);
		if($rank_list == false){
			$this->error->show_error("对不起， 竞赛未开始",array("竞赛状态错误"),$data);
            return; 
		}
		
		echo var_dump($rank_list);
		
		$this->load->view("common/admin_header",$data);
        //$this->load->view("admin/unit_rank_list",$data);
        $this->load->view("common/admin_footer",$data);
	}
	
	
	
}
