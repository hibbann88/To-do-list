<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class List_model extends CI_Model {

    public function get_all_lists()
    {
        return $this->db->get('lists')->result();
    }

    public function get_list_by_id($id)
    {
        return $this->db->get_where('lists', array('id' => $id))->row();
    }

    public function create_list($data)
    {
        return $this->db->insert('lists', $data);
    }
}