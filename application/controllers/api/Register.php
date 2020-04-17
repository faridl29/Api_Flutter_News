<?php

defined('BASEPATH') OR exit('No direct script allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Register extends Rest_Controller {

	public function __construct($config = 'rest')
	{
		parent::__construct();
        $this->load->database();
        $this->load->model("User_model");
	}

	public function index_post(){
        $username = $this->post('username');
        $email = $this->post('email');
        $password = md5($this->post('password'));

        if($username != '' && $email != '' && $password != ''){
            $cekUser = $this->User_model->cekIfExist($email);

            if(!$cekUser){

                $user = array(
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                    'level' => 1,
                    'register_date' => date('Y-m-d')
                );

                $insert = $this->User_model->saveUser($user);

                if($insert){
                    $response["error"] = FALSE;
                    $response["status"] = 200;
                    $response["message"] = "Register Successfully"; 
                }else{
                    $response["error"] = TRUE;
                    $response["status"] = 502;
                    $response["message"] = "Register not Successfully";
                }

                echo json_encode($response);
            }else{
                $response["error"] = TRUE;
                $response["message"] = "Email sudah terdaftar, gunakan email lain!";
                echo json_encode($response);
            }
        }else{
            $response["error"] = FALSE;
            $response["message"] = "Isi semua kolom!";
            echo json_encode($response);
        }
    }

}