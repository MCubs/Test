<?php

class testController extends Controller{
	    public function __construct(){

        parent::__construct();
        include MODEL_PATH .'/testModel.php';
        $this->model = new testModel;			

    }

    public function indexAction(){
    	$data['EducationList'] = $this->model-> getEducationList();
    	$data['CityList'] = $this->model->getCityList();
    	$data['UserList'] = $this->model->getUserList();
        $this->view->generate('test.php', 'template_test.php', $data);		
    }
	

}

?>