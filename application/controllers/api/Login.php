<?php

defined('BASEPATH') OR exit('No direct script allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Login extends Rest_Controller {

	public function __construct($config = 'rest')
	{
		parent::__construct();
        $this->load->database();
        $this->load->model("User_model");
	}

	public function index_post(){
        $email = $this->post('email');
        $password = md5($this->post('password'));

        if($email != '' && $password != ''){
            
            $cekUser = $this->User_model->getUserByEmailPassword($email, $password);

            if($cekUser != false){

                $user = array(
                    'error' => false,
                    'id_user' => $cekUser["id_user"],
                    'username' => $cekUser["username"],
                    'email' => $cekUser["email"],
                    'level' => $cekUser["level"],
                    'register_date' => $cekUser["register_date"]
                );
                echo json_encode($user);

            }else{
                $response["error"] = TRUE;
                $response["message"] = "User tidak terdaftar";
                echo json_encode($response);
            }
        }else{
            $response["error"] = TRUE;
            $response["message"] = "Isi semua kolom!";
            echo json_encode($response);
        }
    }

}