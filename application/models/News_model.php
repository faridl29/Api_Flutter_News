<?php

defined('BASEPATH') OR exit('No direct script allowed');

class News_model extends CI_Model {
    public function __construct()
	{
		parent::__construct();
		$this->load->database();
    }
    
    public function insertNews($news = array()){
        $insert = $this->db->insert("news", $news);
        return $insert;
    }

    public function getNews(){
        $this->db->select('news.*, user.username');
        $this->db->join('user', 'user.id_user = news.id_user');
        $get = $this->db->get('news')->result();

        return $get;
    }

    public function updateNews($id_news, $news = array()){
        $this->db->where('id_news', $id_news);
        $update = $this->db->update('news', $news);
        return $update;
    }

    public function deleteNews($id_news){
        $this->db->where('id_news', $id_news);
        $delete = $this->db->delete('news');
        return $delete;
    }
}