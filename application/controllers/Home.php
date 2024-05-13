<?php
class Home extends CI_Controller{

    // Method to display the home page
    public function index(){        

        $this->load->model('QuestionModel');

        // Fetching all the questions from the database
        $data['questions'] = $this->QuestionModel->getAllQuestions();

        $this->load->view('templates/header');
        $this->load->view('homePage', $data);
        $this->load->view('templates/footer');

    }
}