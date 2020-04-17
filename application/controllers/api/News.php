<?php

defined('BASEPATH') OR exit('No direct script allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class News extends Rest_Controller {

	public function __construct($config = 'rest')
	{
		parent::__construct();
        $this->load->database();
        $this->load->model("News_model");
    }

    public function index_get(){
        $select = $this->News_model->getNews();
        echo json_encode($select);
    }
    
    public function index_post(){
        $title = $this->post("title");
        $content = $this->post("content");
        $description = $this->post("description");
        $id_user = $this->post("id_user");

        $image =  str_replace('"', '', $_FILES["image"]["name"]);
        $target_dir = "../api_flutter_news/images/"; 
        $target_file = $target_dir . $image;
        
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
            $news = array(
                'image' => $image,
                'title' => $title,
                'content' => $content,
                'description' => $description,
                'date_news' => date('Y-m-d'),
                'id_user' => $id_user
            );

            $insert = $this->News_model->insertNews($news);

            if($insert){
                $response["error"] = false;
                $response["message"] = "Add News Successfully";
                echo json_encode($response);
            }else{
                $response["error"] = true;
                $response["message"] = "Add News not Successfully";
                echo json_encode($response);
            }
        }
    }

    public function edit_post(){
        $title = $this->post("title");
        $content = $this->post("content");
        $description = $this->post("description");
        $id_news = $this->post("id_news");

        $image =  str_replace('"', '', $_FILES["image"]["name"]);
        $target_dir = "../api_flutter_news/images/"; 
        $target_file = $target_dir . $image;
        
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
            $news = array(
                'image' => $image,
                'title' => $title,
                'content' => $content,
                'description' => $description
            );

            $update = $this->News_model->updateNews($id_news,$news);

            if($update){
                $response["error"] = false;
                $response["message"] = "Update News Successfully";
                echo json_encode($response);
            }else{
                $response["error"] = true;
                $response["message"] = "Update News not Successfully";
                echo json_encode($response);
            }
        }
    }

    public function delete_post(){
        $id_news = $this->post("id_news");

        $delete = $this->News_model->deleteNews($id_news);

        if($delete){
            $response["error"] = false;
            $response["message"] = "Delete News Successfully";
            echo json_encode($response);
        }else{
            $response["error"] = true;
            $response["message"] = "Delete News not Successfully";
            echo json_encode($response);
        }
    
    }

}