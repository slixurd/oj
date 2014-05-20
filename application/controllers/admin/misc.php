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

    public function update_type(){
        Global $data;
        if(!$data['is_login']){
            echo json_encode(array('status'=>false,'reason'=>'not login'));
            return;
        }
        $name = $this->input->post("username",true);
        $pri_submit = $this->input->post("type",true); 
        if(($pri = get_pri_type($pri_submit)) == false){
            $result = array('status'=>false,'reason'=>"unknown type");
            echo json_encode($result);
            return;
        }
        $this->load->model("back/user_edit","user_edit");
        $uid = $this->user_edit->get_id_by_name($name);

        //权限优先级判定.低优先级不能设置高优先级权限. admin > teacher > assitant > student
        //admin可以设置所有权限级.teacher只能设置assistant,assitant不能设置
        $user_pri = $this->user_edit->get_user_type($data['user']['userId']);
        $user_pri = $user_pri['type'];
        $user_pri = get_pri_key($user_pri);
        if($user_pri !== false && ($user_pri == 0 || $user_pri < $pri_submit)){
            if( $uid != false && $this->user_edit->update_user_type($uid,$pri) != false ){
                $result = array('status'=>true);
                echo json_encode($result);
                return;           
            }
        }
        $result = array('status'=>false,'reason'=>"用户名不存在或者越权修改权限.");
        echo json_encode($result);
        return;
    }
    public function update_pri(){
        Global $data;
        if(!$data['is_login']){
            echo json_encode(array('status'=>false,'reason'=>'not login'));
            return;
        }
        $username = $this->input->post("userid",true);
        $type = $this->input->post("type",true) == "0" ? "course":"contest";
        $commonId = intval($this->input->post("cid",true));

        $this->load->model("back/user_edit","user_edit");
        $userId = $this->user_edit->get_id_by_name($username);
        $check = $this->user_edit->add_pri($data['user']['userId'],$userId,$type,$commonId);
        if ($check === false) {
            echo json_encode(array('status'=>false,'reason'=>'没有修改的权限,请与更高级的管理员或者老师联系'));
            return;
        }
        echo json_encode(array('status'=>true));
    }

}