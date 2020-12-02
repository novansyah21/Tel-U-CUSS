<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Fakultas_model extends CI_Model
{

    // public function daftar_jurusan()
    // {
    //     $query = "SELECT * FROM jurusan";
    //     $sql = $this->db->query($query);
    //     return $sql->result_array();
    // }

    public function daftar_jurusan()
    {
        $query = "SELECT 
                    fakultas.id_fakultas,
                    fakultas.kode_fakultas,
                    fakultas.nama_fakultas,
                    jurusan.id_jurusan,
                    jurusan.kode_jurusan,
                    jurusan.nama_jurusan,
                    angkatan.id_angkatan,
                    angkatan.angkatan,
                    jurusan.id_fakultas
                    FROM fakultas
                    JOIN jurusan ON
                        jurusan.id_fakultas = fakultas.id_fakultas
                    JOIN angkatan ON
                        jurusan.id_angkatan = angkatan.id_angkatan ";
        $sql = $this->db->query($query);
        return $sql->result_array();
    }

    public function daftar_angkatan()
    {
        $query = "SELECT * FROM angkatan ";
        $sql = $this->db->query($query);
        return $sql->result_array();
    }

    public function daftar_fakultas()
    {
        $query = "SELECT * FROM fakultas";
        $sql = $this->db->query($query);
        // print_r($sql);
        return $sql->result_array();
    }

    public function jurusanByID($id_jurusan)
    {
        $query = "SELECT 
                    fakultas.id_fakultas,
                    fakultas.kode_fakultas,
                    fakultas.nama_fakultas,
                    jurusan.id_jurusan,
                    jurusan.kode_jurusan,
                    jurusan.nama_jurusan,
                    angkatan.id_angkatan,
                    angkatan.angkatan,
                    jurusan.id_fakultas as fakultas_id
                    FROM jurusan
                    JOIN fakultas ON
                        fakultas.id_fakultas = jurusan.id_fakultas
                    JOIN angkatan ON 
                        angkatan.id_angkatan = jurusan.id_angkatan
                    WHERE jurusan.id_jurusan =" . $id_jurusan;

        $sql = $this->db->query($query);

        return $sql->row_array();
    }

    public function angkatanByID($id_jurusan)
    {
        $query = "SELECT 
                    fakultas.id_fakultas,
                    fakultas.kode_fakultas,
                    fakultas.nama_fakultas,
                    jurusan.id_jurusan,
                    jurusan.kode_jurusan,
                    jurusan.nama_jurusan,
                    jurusan.angkatan,
                    jurusan.id_fakultas as fakultas_id
                    FROM jurusan
                    JOIN fakultas ON
                        fakultas.id_fakultas = jurusan.id_fakultas
                    WHERE jurusan.id_jurusan =" . $id_jurusan;

        $sql = $this->db->query($query);

        return $sql->row_array();
    }

    public function daftar_kelas($id_jurusan)
    {
        $query = "SELECT * FROM kelas WHERE id_jurusan = " . $id_jurusan;
        $sql = $this->db->query($query);
        return $sql->result_array();
    }


    public function daftar_gedung()
    {
        $query = "SELECT * FROM gedung";
        $sql = $this->db->query($query);
        return $sql->result_array();
    }


    public function tambahJurusan($post)
    {
        $id_fakultas    = $this->db->escape($_POST['id_fakultas']);
        $nama_jurusan   = $this->db->escape($_POST['nama_jurusan']);
        $kode_jurusan   = $this->db->escape($_POST['kode_jurusan']);
        $angkatan       = $this->db->escape($_POST['angkatan']);
        $query2 = "INSERT INTO angkatan (
            angkatan
        ) SELECT * FROM (SELECT $angkatan) t
        WHERE NOT EXISTS (SELECT angkatan FROM angkatan WHERE angkatan = $angkatan) ";
        $sql2 = $this->db->query($query2);
        
        $query3 = "SELECT * FROM angkatan WHERE angkatan = $angkatan";
        $sql3 = $this->db->query($query3);
        $hasilquery = $sql3->result_array(); 
        $id_angkatan = $hasilquery[0]['id_angkatan'];
        $query = "INSERT INTO jurusan (
                    id_fakultas,
                    nama_jurusan,
                    kode_jurusan,
                    id_angkatan
                )
                VALUES
                    (
                    $id_fakultas,
                    $nama_jurusan,
                    $kode_jurusan,
                    $id_angkatan
                    )";
        $sql = $this->db->query($query);
    }
    

    public function tambahFakultas($post)
    {
        $id_gedung      = $this->db->escape($_POST['id_gedung']);
        $nama_fakultas  = $this->db->escape($_POST['nama_fakultas']);
        $kode_fakultas  = $this->db->escape($_POST['kode_fakultas']);
        $query = "INSERT INTO fakultas (
                    id_gedung,
                    nama_fakultas,
                    kode_fakultas
                )
                VALUES
                    (
                    $id_gedung,
                    $nama_fakultas,
                    $kode_fakultas
                    )";
        $sql = $this->db->query($query);
    }

    public function tambahGedung($post)
    {
        $nama_gedung   = $this->db->escape($_POST['nama_gedung']);
        $query = "INSERT INTO gedung (
                    nama_gedung
                )
                VALUES
                    (
                    $nama_gedung
                    )";
        $sql = $this->db->query($query);
    }

    public function hapus_jurusan($id_jurusan)
    {
        $this->db->delete('jurusan', ['id_jurusan' => $id_jurusan]);
    }

    function select()
    {
        $this->db->order_by('id_kelas', 'DESC');
        $query = $this->db->get('kelas');
        return $query;
    }

    function insert($data)
    {
        $this->db->insert_batch('kelas', $data);
    }

    public function jurusanByFakultasId($id_fakultas){
        return $this->db->select('*')->where('id_fakultas', $id_fakultas)->join('angkatan','angkatan.id_angkatan = jurusan.id_angkatan')->get('jurusan')->result_array();
        // SELECT * FROM FAKULTAS WHERE id_fakultas = $id_fakultas
    }
}
