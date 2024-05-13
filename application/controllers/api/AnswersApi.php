<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Including the required libraries
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
 
// Extending the RestController
use chriskacerguis\RestServer\RestController;

class AnswersApi extends RestController {

    // loading the models and library
    public function __construct() {
        parent::__construct();
        $this->load->model('AnswerModel');
        $this->load->helper('url');
        $this->load->library('session');
    }

    // Post Answer
    public function post_answer_post() {
        $userId = $this->session->userdata('userId');
        if (!$userId) {
            $this->response(['status' => 'error', 'message' => 'User not logged in'], RestController::HTTP_UNAUTHORIZED);
            return;
        }

        $answer_data = [
            'body' => $this->post('body'),
            'question_id' => $this->post('question_id'),
            'user_id' => $userId,
            'answered_date' => date('Y-m-d H:i:s')
        ];

        if ($this->AnswerModel->insertAnswer($answer_data)) {
            $this->response(['status' => 'success', 'message' => "Successfully Posted"], RestController::HTTP_CREATED);
        } else {
            $this->response(['status' => 'success', 'message' => 'Server error'], RestController::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Vote Answers
    public function vote_answer_post($answer_id, $type) {
        if (!$this->session->userdata('isUserLoggedIn')) {
            $this->response(['status' => 'error', 'message' => 'User not logged in'], RestController::HTTP_UNAUTHORIZED);
            return;
        }

        if ($type === 'up') {
            $this->AnswerModel->increment_answer_votes($answer_id);
        } elseif ($type === 'down') {
            $this->AnswerModel->decrement_answer_votes($answer_id);
        }

        $this->response(['status' => 'success', 'message' => 'Vote updated'], RestController::HTTP_OK);
    }

      

    // Accept Answer
    public function accept_answer_post($answer_id, $question_id) {
        $this->AnswerModel->acceptAnswer($answer_id, $question_id); 
        $this->response(['status' => 'success', 'message' => 'Answer accepted successfully'], RestController::HTTP_OK);
         
    }


    // Reject Answer
    public function reject_answer_post($answer_id, $question_id) {
        $this->AnswerModel->rejectAnswer($answer_id, $question_id);
        $this->response(['status' => 'success', 'message' => 'Answer rejected successfully'], RestController::HTTP_OK);
        
    }

}






