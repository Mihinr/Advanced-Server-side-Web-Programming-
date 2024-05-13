<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Load necessary models, helper, and library
        $this->load->model('QuestionModel');
        $this->load->model('AnswerModel');
        $this->load->model('UserModel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
    }

    // Method to display user profile
    public function index() {
        // Fetch the current logged-in user
        $user_id = $this->session->userdata('userId');

        if (!$user_id) {
            redirect('users/loadLogin');
            return;
        }

         // Fetch the user's data
        $data['user'] = $this->UserModel->get_user_by_id($user_id);

     
        $data['questions'] = $this->QuestionModel->get_questions_by_user($user_id);
        $data['answers'] = $this->AnswerModel->get_answers_by_user($user_id);

        $this->load->view('templates/header');
        $this->load->view('profile', $data);
        $this->load->view('templates/footer');
    }

    // Method to delete a question
    public function delete_question($question_id) {
        $this->QuestionModel->delete_question($question_id);
        echo json_encode(['status' => 'success']);
    }
    
    // Respond with success status
    public function deleteAnswer($answer_id) {
        $this->AnswerModel->deleteAnswer($answer_id);
        echo json_encode(['status' => 'success']);
    }
}
?>
