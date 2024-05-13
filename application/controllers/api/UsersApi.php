<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
 
use chriskacerguis\RestServer\RestController;

class UsersApi extends RestController {

    function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('session');
    }  
    // User login
    public function login_post() {
        $email = $this->post('email');
        $password = md5($this->post('password'));

        $this->form_validation->set_data(['email' => $email, 'password' => $password]);
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true) {
            $con = [
                'returnType' => 'single',
                'conditions' => [
                    'email' => $email,
                    'password' => $password,
                    'status' => 1
                ]
            ];

            $checkLogin = $this->UserModel->getRows($con);
            if ($checkLogin) {
                $this->session->set_userdata('isUserLoggedIn', TRUE);
                $this->session->set_userdata('userId', $checkLogin['id']);
                $this->session->set_userdata('userName',$checkLogin['username']);

                $this->response([
                    'status' => TRUE,
                    'message' => 'Login successful',
                    'userData' => $checkLogin
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Login failed. Email or password incorrect.'
                ], RestController::HTTP_NOT_FOUND);
            }
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Login failed. Validation errors.',
                'errors' => $this->form_validation->error_array()
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    // User registration
    public function registration_post() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == false) {
            $this->response([
                'status' => FALSE,
                'message' => 'Validation failed.',
                'errors' => $this->form_validation->error_array()
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            $userData = [
                'username' => strip_tags($this->post('username')),
                'email' => strip_tags($this->post('email')),
                'password' => md5($this->post('password'))
            ];

            $insert = $this->UserModel->insert($userData);
            if ($insert) {
                $this->response([
                    'status' => TRUE,
                    'message' => 'User registration successful.'
                ], RestController::HTTP_CREATED);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'User registration failed.'
                ], RestController::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    // Email check
    public function email_check($str) {
        $con = [
            'returnType' => 'count',
            'conditions' => [
                'email' => $str
            ]
        ];

        $checkEmail = $this->UserModel->getRows($con);
        if ($checkEmail > 0) {
            $this->form_validation->set_message('email_check', 'The given email already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
