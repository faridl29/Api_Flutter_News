<?php

defined('BASEPATH') OR exit('No direct script allowed');

class User_model extends CI_Model {
    public function __construct()
	{
		parent::__construct();
		$this->load->database();
    }
    
    public function cekIfExist($email){
        $this->db->where('email', $email);
        $user = $this->db->get('user')->num_rows();
        if($user > 0 ){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function saveUser($user = array()){
        $insert = $this->db->insert('user', $user);
        return $insert;
    }

    public function getUserByEmailPassword($email, $password) {
 
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $query = $this->db->get('user');
 
        if ($query) {
            $user = $query->row_array();
            return $user;

        } else {
            return NULL;
        }
    }
}