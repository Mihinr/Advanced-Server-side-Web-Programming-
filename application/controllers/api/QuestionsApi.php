<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
use chriskacerguis\RestServer\RestController;

class QuestionsApi extends RestController {

    public function __construct() {
        parent::__construct();
        $this->load->model('QuestionModel');
        $this->load->helper('url');
        $this->load->library('session');
    }

    // POST: Create a new question
    public function create_post() {
        if (!$this->session->userdata('userId')) {
            $this->response([
                'success' => false,
                'message' => 'User not logged in'
            ], RestController::HTTP_UNAUTHORIZED);
            return;
        }

        $title = $this->post('title');
        $body = $this->post('body');
        $tags = $this->post('tags');
        $imagePath = $this->handle_image_upload();

        if ($imagePath === false) {
            return; // handle_image_upload already sent the response
        }

        $questionData = [
            'title' => $title,
            'body' => $body,
            'tags' => $tags,
            'votes' => 0,
            'views' => 0,
            'is_answered' => FALSE,
            'posted_date' => date('Y-m-d H:i:s'),
            'image_path' => $imagePath,
            'user_id' => $this->session->userdata('userId')
        ];

        if ($this->QuestionModel->insert_question($questionData)) {
            $this->response([
                'success' => true,
                'message' => 'Question created successfully'
            ], RestController::HTTP_CREATED);
        } else {
            $this->response([
                'success' => false,
                'message' => 'Failed to create question'
            ], RestController::HTTP_INTERNAL_ERROR);
        }
    }

    private function handle_image_upload() {
        if (!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                return 'uploads/' . $uploadData['file_name'];
            } else {
                $this->response([
                    'success' => false,
                    'message' => 'Image upload failed',
                    'error' => $this->upload->display_errors()
                ], RestController::HTTP_BAD_REQUEST);
                return false;
            }
        }
        return ''; // No image provided
    }

    // GET: Fetch filtered questions based on filter
    public function questions_get() {
        $filter = $this->get('filter');

        switch ($filter) {
            case 'top':
                $questions = $this->QuestionModel->get_top_questions();
                break;
            case 'latest':
                $questions = $this->QuestionModel->get_latest_questions();
                break;
            case 'unanswered':
                $questions = $this->QuestionModel->get_unanswered_questions();
                break;
            default:
                $questions = $this->QuestionModel->get_questions();
                break;
        }

        $this->response($questions, RestController::HTTP_OK);
    }

    // PUT: Update the vote for a question
    public function vote_questions_put($question_id) {
        if (!$this->session->userdata('isUserLoggedIn')) {
            $this->response([
                'status' => 'error',
                'message' => 'User not logged in'
            ], RestController::HTTP_UNAUTHORIZED);
            return;
        }

        $type = $this->put('type');
        if ($type == 'up') {
            $this->QuestionModel->increment_question_votes($question_id);
        } elseif ($type == 'down') {
            $this->QuestionModel->decrement_question_votes($question_id);
        }

        $this->response([
            'status' => 'success',
            'message' => 'Vote updated'
        ], RestController::HTTP_OK);
    }
}
?>
