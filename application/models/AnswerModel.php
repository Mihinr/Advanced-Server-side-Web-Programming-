<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AnswerModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Fetching answers for a specific question
    public function get_answers_by_question_id($question_id) {
        $this->db->select('answers.*, users.username');
        $this->db->from('answers');
        $this->db->join('users', 'users.id = answers.user_id', 'left');
        $this->db->where('answers.question_id', $question_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Inserting a new answer to the database
    public function insertAnswer($data) {
        return $this->db->insert('answers', $data);
    }

    //Fetching answers by user ID for profile page
    public function get_answers_by_user($user_id) {
        $this->db->select('*');
        $this->db->from('answers');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Deleting an answer
    public function deleteAnswer($answer_id) {
        $this->db->where('answer_id', $answer_id);
        $this->db->delete('answers');
    }

    //increment answer votes    
    public function increment_answer_votes($answer_id) {
        $this->db->set('votes', 'votes + 1', FALSE);
        $this->db->where('answer_id', $answer_id);
        $this->db->update('answers');
    }

    // Decrement answer votes
    public function decrement_answer_votes($answer_id) {
        $this->db->set('votes', 'votes - 1', FALSE);
        $this->db->where('answer_id', $answer_id);
        $this->db->update('answers');
    }

    // Accept an answer
     public function acceptAnswer($answer_id, $question_id) {
        $this->db->set('is_accepted', '1');
        $this->db->where('answer_id', $answer_id);
        $this->db->update('answers');

        $this->db->set('is_answered', '1');
        $this->db->where('question_id', $question_id);
        $this->db->update('questions');
       
    }
     // Reject an answer
    public function rejectAnswer($answer_id, $question_id) {
        $this->db->set('is_accepted', '0');
        $this->db->where('answer_id', $answer_id);
        $this->db->update('answers');

        $this->db->set('is_answered', '0');
        $this->db->where('question_id', $question_id);
        $this->db->update('questions');
  
    }

}
