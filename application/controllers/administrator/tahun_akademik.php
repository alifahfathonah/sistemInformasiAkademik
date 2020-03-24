<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tahun_akademik extends CI_Controller {

	public function index()
	{
        // Memanggil data di dalam database melalui Model
        $data['tahun_akademik'] = $this->tahunakademik_model->tampil_data('tahun_akademik')->result();

		$this->load->view('templates_administrator/header');
        $this->load->view('templates_administrator/sidebar');
        $this->load->view('administrator/tahun_akademik', $data);
        $this->load->view('templates_administrator/footer');
    }


    public function tambah_tahun_akademik()
    {
        $data['tahun_akademik'] = $this->tahunakademik_model->tampil_data('tahun_akademik')->result();

        $this->load->view('templates_administrator/header');
        $this->load->view('templates_administrator/sidebar');
        $this->load->view('administrator/tahun_akademik_form', $data);
        $this->load->view('templates_administrator/footer');
    }



    public function tambah_tahun_akademik_aksi()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) 
        {
            // Jika gagal kembali ke Function tambah prodi
            $this->tambah_tahun_akademik();
        } 
        else 
        {
            // Jika benar, data masuk ke database
                $tahun_akademik     = $this->input->post('tahun_akademik');
                $semester           = $this->input->post('semester');
                $status             = $this->input->post('status');

            $data = [
                'tahun_akademik' => $tahun_akademik,
                'semester'       => $semester,
                'status'         => $status
            ];
                $this->tahunakademik_model->insert_data($data, 'tahun_akademik');
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Tahun Akademik berhasil di tambahkan </div>');
                redirect('administrator/tahun_akademik');
        }
    }


    public function _rules()
    {
        $this->form_validation->set_rules('tahun_akademik','tahun_akademik','required',[
            'required' => 'Tahun Akademik Wajib di isi'
        ]);
        $this->form_validation->set_rules('semester','semester','required',[
            'required' => 'Semester Wajib di isi atau di pilih'
        ]);
        $this->form_validation->set_rules('status','status','required',[
            'required' => 'Status Wajib di isi atau di pilih'
        ]);
    }


    public function update($id) 
    {
        $where = ['id_thn_akademik' => $id];
        $data['tahun_akademik'] = $this->tahunakademik_model->edit_data($where, 'tahun_akademik')->result();

        $this->load->view('templates_administrator/header');
        $this->load->view('templates_administrator/sidebar');
        $this->load->view('administrator/tahun_akademik_update', $data);
        $this->load->view('templates_administrator/footer');
    }


    public function update_aksi()
    {
        $id                 = $this->input->post('id_thn_akademik');
        $tahun_akademik     = $this->input->post('tahun_akademik');
        $semester           = $this->input->post('semester');
        $status             = $this->input->post('status');

        $data = [
            'tahun_akademik'    => $tahun_akademik,
            'semester'          => $semester,
            'status'            => $status
        ];

        $where = ['id_thn_akademik' => $id];

        $this->tahunakademik_model->update_data($where, $data, 'tahun_akademik');
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data berhasil Tahun Akademik di update</div>');
        redirect('administrator/tahun_akademik');
    }



    public function delete($id)
    {
        $where = ['id_thn_akademik' => $id];
        
        $this->tahunakademik_model->hapus_data($where, 'tahun_akademik');
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Data Tahun Akademik berhasil di hapus</div>');
        redirect('administrator/tahun_akademik');
    }



}