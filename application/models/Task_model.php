<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task_model extends CI_Model {

    // Mengambil SEMUA tugas untuk list tertentu
    public function get_tasks_by_list($list_id)
    {
        // PERBAIKAN: Harus mengambil data dari tabel 'tasks'
        $this->db->order_by('target_date', 'ASC');
        return $this->db->get_where('tasks', array('list_id' => $list_id))->result();
        // Harusnya menggunakan ->result() untuk array of objects
    }

    // Mengambil SATU tugas berdasarkan ID (Digunakan untuk Edit)
    public function get_task_by_id($id)
    {
        return $this->db->get_where('tasks', array('id' => $id))->row();
        // Menggunakan ->row() untuk satu object
    }
    
    // Membuat Tugas Baru
    public function create_task($data)
    {
        return $this->db->insert('tasks', $data);
    }

    // Mengubah data Task (Full Update)
    public function update_task($task_id, $data)
    {
        $this->db->where('id', $task_id);
        return $this->db->update('tasks', $data);
    }

    // Mengubah Status Task (Quick Update)
    public function update_task_status($task_id, $new_status)
    {
        $this->db->where('id', $task_id);
        return $this->db->update('tasks', array('status' => $new_status));
    }

    // Menghapus Task
    public function delete_task($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tasks');
    }
}