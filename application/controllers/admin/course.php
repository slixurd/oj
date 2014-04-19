<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course extends CI_Controller {

     
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index($page = 1){
        Global $data;
        if(!$data['is_login']){
            $this->error->show_error("对不起，请先登录",array("你还没有登录，请先登录！"),$data);
            return;
        }
        $data['page_title']='课程';
        $this->load->model("user_model");
        $this->load->model("back/course_edit","course_edit");
        //$type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
        //$type = $type['type'];
        //if($type != "admin"){
        //  $this->error->show_error("对不起，问题编辑需要管理员权限",array("需要更改问题，请联系管理员"),$data);
        //  return;
        //}
        $total = $this->course_edit->get_course_count();
        $data['course_list'] = $this->course_edit->get_course_list(($page-1)*10,10);
        //var_dump($data['course_list']);
        
        
        $this->load->library('pagination');
        $config['first_link'] = TRUE;
        $config['last_link'] = TRUE;
        $config['use_page_numbers'] = TRUE;
        $config['base_url'] = site_url("admin/course/index");
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
        $this->load->view("admin/course_list",$data);
        $this->load->view("common/admin_footer",$data);
    }
    
    public function del($cid = NULL){
        Global $data;
        if($cid === NULL||!is_numeric($cid)){
            $result = array('status' => false , 'reason' => '错误的课程编号');
            echo json_encode($result);
            return;
        }
        if(!$data['is_login']){
            $result = array('status' => false , 'reason' => '未登录');
            echo json_encode($result);
            return;
        }
        $this->load->model("user_model");
        $this->load->model("back/course_edit","course_edit");
        $type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
        $type = $type['type'];
        // if($type != "admin"){
        //     $this->error->show_error("对不起，问题编辑需要管理员权限",array("需要更改问题，请联系管理员"),$data);
        //     return;
        // }
        
        $this->course_edit->del_course($cid);
        //这里需要增加状态判断，如果删除失败返回false，否则为true
        $result = array('status' => true);
        echo json_encode($result);
    }

    public function unit_list($cid = 0){
        Global $data;
        if(!$data['is_login']){
            $this->error->show_error("对不起，请先登录",array("你还没有登录，请先登录！"),$data);
            return;
        }
        $data['page_title']='课程';
        $this->load->model("user_model");
        $this->load->model("back/course_edit","course_edit");
        $type = $this->user_model->get_user_item_id($data['user']['userId'],array('type'));
        $type = $type['type'];
        // if($type != "admin"){
        //     $this->error->show_error("对不起，问题编辑需要管理员权限",array("需要更改问题，请联系管理员"),$data);
        //     return;
        // }

        $problem_list = $this->course_edit->get_course_unit_list($cid);
        
        $data['plist'] = $problem_list;
        var_dump($problem_list);
        $this->load->view("common/admin_header",$data);
        $this->load->view("admin/unit_list",$data);
        $this->load->view("common/admin_footer",$data);        

    }
    

        

}
