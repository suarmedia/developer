<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_category_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'name' => $this->input->post('name', true)
        );
        return $data;
    }

    //add category
    public function add()
    {
        $data = $this->input_values();
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('gallery_categories', $data);
    }

    //get all gallery categories
    public function get_all_categories()
    {
        $query = $this->db->get('gallery_categories');
        return $query->result();
    }

    //get gallery categories
    public function get_categories()
    {
        $this->db->where('gallery_categories.lang_id', $this->selected_lang->id);
        $query = $this->db->get('gallery_categories');
        return $query->result();
    }

    //get gallery categories by lang
    public function get_categories_by_lang($lang_id)
    {
        $this->db->where('gallery_categories.lang_id', $lang_id);
        $query = $this->db->get('gallery_categories');
        return $query->result();
    }

    //get category count
    public function get_category_count()
    {
        $this->db->where('gallery_categories.lang_id', $this->selected_lang->id);
        $query = $this->db->get('gallery_categories');
        return $query->num_rows();
    }

    //get category
    public function get_category($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('gallery_categories');
        return $query->row();
    }

    //update category
    public function update($id)
    {
        $data = $this->input_values();

        $this->db->where('id', $id);
        return $this->db->update('gallery_categories', $data);
    }

    //delete category
    public function delete($id)
    {
        $category = $this->get_category($id);

        if (!empty($category)) {
            $this->db->where('id', $id);
            return $this->db->delete('gallery_categories');
        } else {
            return false;
        }

    }


}