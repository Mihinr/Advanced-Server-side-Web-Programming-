<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller { 
    
     // Method to load user profile page
    public function profile()
    {
        $this->load->view('templates/header');
        $this->load->view('profilePage');
        $this->load->view('templates/footer');
    }

    // Method to load login page
    public function loadLogin()
    {
        // Loading the login view
        $this->load->view('templates/header');
        $this->load->view('auth/loginPage');
        $this->load->view('templates/footer');
    }

    public function loadRegister()
    {
        // Loading the signup view
        $this->load->view('templates/header');
        $this->load->view('auth/signupPage');
        $this->load->view('templates/footer');
    }

    // Method to logout user  
    public function logout(){ 

        $this->session->unset_userdata('isUserLoggedIn'); 
        $this->session->unset_userdata('userId'); 
        $this->session->unset_userdata('userName'); 

         // Destroying session
        $this->session->sess_destroy();

        // Redirecting to login page after logout        
        $this->load->view('templates/header');
        $this->load->view('auth/loginPage');
        $this->load->view('templates/footer');
    } 
}
