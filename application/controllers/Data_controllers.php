<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Data_controllers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("fakultas_model");
        $this->load->model("ruangan_model");
        $this->load->model('waktu_model');
        $this->load->model('kelas_model');
    }

    public function dosen()
    {
        $this->load->model("dosen_model");
        $data['list_dosen'] = $this->dosen_model->daftar_dosen();
        $data['list_dosenbaru'] = $this->dosen_model->daftar_dosenbaru();
        $this->load->view("data/dosen_view", $data);
    }

    public function fakultas()
    {
        $this->load->model("fakultas_model");
        $data['list_jurusan'] = $this->fakultas_model->daftar_jurusan();
        $data['list_fakultas'] = $this->fakultas_model->daftar_fakultas();
        $data['list_gedung'] = $this->fakultas_model->daftar_gedung();
        // $data['list_jurusan'] = $this->fakultas_model->hapus_jurusan($id_jurusan);
        $this->load->view("data/fakultas_view", $data);
        if (isset($_POST['tambahJurusan'])) {
            $this->fakultas_model->tambahJurusan($_POST);
            redirect("Data_controllers/fakultas");
        } else if (isset($_POST['tambahFakultas'])) {
            $this->fakultas_model->tambahFakultas($_POST);
            redirect("Data_controllers/fakultas");
        } else if (isset($_POST['tambahGedung'])) {
            $this->fakultas_model->tambahGedung($_POST);
            redirect("Data_controllers/fakultas");
        }
    }

    public function tambahFakultas()
    {
        if (isset($_POST['tambahFakultas'])) {
            $this->fakultas_model->tambahFakultas($_POST);
        }
    }

    public function ruangan()
    {
        $this->load->model("ruangan_model");
        $data['list_ruangan'] = $this->ruangan_model->daftar_ruangan();
        $data['list_fakultas'] = $this->fakultas_model->daftar_fakultas();
        $data['list_gedung'] = $this->fakultas_model->daftar_gedung();
        // $data['list_ruangan'] = $this->ruangan_model->hapus_ruangan($id_ruangan);
        $this->load->view("data/ruangan_view", $data);
        if (isset($_POST['tambahRuangan'])) {
            $this->ruangan_model->tambahRuangan($_POST);
            redirect("Data_controllers/ruangan");
        }
    }

    public function tambahRuangan()
    {
        if (isset($_POST['tambahRuangan'])) {
            $this->ruangan_model->tambahRuangan($_POST);
        }
    }

    public function waktu()
    {
        $this->load->model("waktu_model");
        $data['list_jam'] = $this->waktu_model->daftar_jam();

        $this->load->view("data/waktu_view", $data);
        if (isset($_POST['tambahWaktu'])) {
            $this->waktu_model->tambahWaktu($_POST);
            redirect("Data_controllers/waktu");
        }
    }

    public function tambahWaktu()
    {
        if (isset($_POST['tambahWaktu'])) {
            $this->waktu_model->tambahWaktu($_POST);
        }
    }

    public function kelas()
    {
        $this->load->model("kelas_model");
        $data['list_kelas'] = $this->kelas_model->daftar_kelas();
        $data['list_ruangan'] = $this->ruangan_model->daftar_ruangan();
        $data['list_fakultas'] = $this->fakultas_model->daftar_fakultas();
        $data['list_gedung'] = $this->fakultas_model->daftar_gedung();

        $this->load->view("data/kelas_view", $data);
        if (isset($_POST['tambahKelas'])) {
            $this->kelas_model->tambahRuangan($_POST);
            redirect("Data_controllers/kelas");
        }
    }

    public function tambahKelas()
    {
        if (isset($_POST['tambahKelas'])) {
            $this->kelas_model->tambahKelas($_POST);
        }
    }
}
