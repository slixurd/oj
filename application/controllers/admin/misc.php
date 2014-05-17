<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Misc extends CI_Controller {

     
    public function __construct()
    {
        parent::__construct();
        $this->load->model("user_model");
        $this->load->model("back/contest_edit","contest_edit");
        $this->load->model("user_model","user_model");
    }

    public function index(){

    }

    public function force_cpass(){
        Global $data;
        if(!$data['is_login']){
            $this->error->show_error("对不起，请先登录",array("你还没有登录，请先登录！"),$data);
            return;
        }


        $this->load->view("common/admin_header",$data);
        $this->load->view("admin/cpass",$data);
        $this->load->view("common/admin_footer",$data);     
    }

    public function put_cpass(){
         Global $data;
        if(!$data['is_login']){
            $result = array('status' => false,'result' => '没有权限' );
            echo json_encode($result);
            return;
        }
        //权限检查
        

        $uname = $this->input->post("user",true);
        $upass = "12345678";
        $this->user_model->force_cpass($uname,$upass);

        $result = array('status' => true );
        echo json_encode($result);
    }

    public function pri(){
        Global $data;
        if(!$data['is_login']){
            $this->error->show_error("对不起，请先登录",array("你还没有登录，请先登录！"),$data);
            return;
        }

        $list = $this->user_model->get_type_list();
        $data['plist'] = $list;
        $this->load->view("common/admin_header",$data);
        $this->load->view("admin/pri",$data);
        $this->load->view("common/admin_footer",$data);             
    }

}