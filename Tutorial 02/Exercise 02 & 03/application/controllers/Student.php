<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load the URL helper
        $this->load->helper('url');
    }

    public function index() {
        // Data to be passed to the view
        $data = array(
            'student_name' => 'Jane Santiago',
            'course' => 'Software Engineering',
            'image_url' => base_url('assets/images/jane.png') // Replace with an actual image URL
        );

        // Load the view and pass data
        $this->load->view('student_details', $data);
    }
}
?>
