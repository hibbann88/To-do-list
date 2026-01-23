<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todo extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Memuat Model, Helper, dan Library
        $this->load->model('list_model');
        $this->load->model('task_model');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    // Tampil semua Daftar (READ List)
    public function index()
    {
        $data['lists'] = $this->list_model->get_all_lists();
        $this->load->view('list/index', $data);
    }

    // Buat Daftar (CREATE List)
    public function create_list()
    {
        $this->form_validation->set_rules('title', 'Judul Daftar', 'required|max_length[255]');

        if ($this->form_validation->run() === FALSE) {
            $this->index(); // Tampilkan error di halaman utama
        } else {
            $data = array(
                'title' => $this->input->post('title')
            );
            $this->list_model->create_list($data);
            redirect('todo');
        }
    }

    // Tampil Detail Task dalam Daftar (READ Task)
    public function view_tasks($list_id)
    {
        $data['list'] = $this->list_model->get_list_by_id($list_id);
        
        if (!$data['list']) {
            show_404();
            return; // Hentikan eksekusi jika List tidak ditemukan
        }

        // PERBAIKAN: Mengganti $data['task'] menjadi $data['tasks'] (plural)
        $data['tasks'] = $this->task_model->get_tasks_by_list($list_id); 
        
        $this->load->view('task/view', $data);
    }

    // Tambah Task baru (CREATE Task)
    public function add_task($list_id)
    {
        $this->form_validation->set_rules('description', 'Deskripsi', 'required');
        $this->form_validation->set_rules('target_date', 'Tanggal Target', 'required');

        if ($this->form_validation->run() === FALSE) {
            // Jika validasi gagal, panggil ulang view_tasks untuk menampilkan error validasi
            $this->view_tasks($list_id);
        } else {
            $data = array(
                'list_id'       => $list_id,
                'description'   => $this->input->post('description'),
                'status'        => 'pending',
                'created_date'  => date('Y-m-d'),
                'target_date'   => $this->input->post('target_date')
            );

            $this->task_model->create_task($data);
            redirect('todo/view_tasks/' . $list_id);
        }
    }

    // Ubah Status Task (UPDATE Task - Quick Update)
    public function update_status($list_id, $task_id, $new_status)
    {
        // Pastikan status yang dikirim valid
        if (in_array($new_status, ['pending', 'in_progress', 'completed'])) {
             $this->task_model->update_task_status($task_id, $new_status);
        }
        redirect('todo/view_tasks/' . $list_id);
    }
    
    // Tampil Form Edit Task (READ Task for Update)
    public function edit_task_form($list_id, $task_id)
    {
        $data['task'] = $this->task_model->get_task_by_id($task_id);
        $data['list_id'] = $list_id;

        if (!$data['task']) {
            show_404();
            return;
        }
        $this->load->view('task/edit', $data); // Pastikan view/task/edit.php ada
    }

    // Simpan Perubahan Task (UPDATE Task - Full Edit)
    public function update_task($list_id, $task_id)
    {
        $this->form_validation->set_rules('description', 'Deskripsi', 'required');
        $this->form_validation->set_rules('target_date', 'Tanggal Target', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() === FALSE) {
            // Jika validasi gagal, tampilkan kembali form edit
            $this->edit_task_form($list_id, $task_id);
        } else {
            $data = array(
                'description'   => $this->input->post('description'),
                'target_date'   => $this->input->post('target_date'),
                'status'        => $this->input->post('status')
            );

            $this->task_model->update_task($task_id, $data);
            redirect('todo/view_tasks/' . $list_id);
        }
    }

    // Hapus Task (DELETE Task)
    public function delete_task($list_id, $task_id)
    {
        $this->task_model->delete_task($task_id);
        redirect('todo/view_tasks/' . $list_id);
    }
}