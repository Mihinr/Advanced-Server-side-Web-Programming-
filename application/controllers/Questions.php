<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questions extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('QuestionModel');
        $this->load->helper(array('form', 'url'));
    }

    public function create()
    {
        $this->load->view('templates/header');
        $this->load->view('postQuestion');
        $this->load->view('templates/footer');
    }


    // Question details
    public function question_details($question_id) {
        $this->QuestionModel->increment_views($question_id);
      
        $this->load->model('AnswerModel');
        
     
        $data['question'] = $this->QuestionModel->get_question_by_id($question_id);
        
        $data['answers'] = $this->AnswerModel->get_answers_by_question_id($question_id);
        
      
        $this->load->view('templates/header');
        $this->load->view('questionDetails', $data); 
        $this->load->view('templates/footer');
    }

    // search questions
    public function searchQuestions() {
     
        $search_term = $this->input->get('search', TRUE);
        $data['searchedFor'] = $search_term;

    
        $data['results'] = $this->QuestionModel->search_questions($search_term);


        $this->load->view('templates/header');        
        $this->load->view('searchResults', $data);
        $this->load->view('templates/footer');
    }
}
    
