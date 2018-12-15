<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletter_model extends CI_Model
{

    //add to newsletter
    public function add_to_newsletter($email)
    {
        $data = array(
            'email' => $email
        );
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->db->insert('newsletters', $data);
    }

    //delete from newsletter
    public function delete_from_newsletter($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('newsletters');
    }

    //get subscribers
    public function get_subscribers()
    {
        $query = $this->db->get('newsletters');
        return $query->result();
    }

    //get newsletter
    public function get_newsletter($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('newsletters');
        return $query->row();
    }

    //get newsletter by id
    public function get_newsletter_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('newsletters');
        return $query->row();
    }

    //unsubscribe email
    public function unsubscribe_email($email)
    {
        $this->db->where('email', $email);
        $this->db->delete('newsletters');
    }

}