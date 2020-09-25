<?php
 class Model_main extends CI_Model {
 	public function __construct() {
	
	}

	public function simpan_data($data,$tabel) {
		$this->db->insert($tabel,$data);
	}

	public function cek_data($kunci,$tabel) {
		$this->db->where($kunci);
		$query=$this->db->get($tabel);
		return $query->row();
	}

	public function update_data($kunci,$tabel,$data) {
		$this->db->where($kunci);
		$this->db->update($tabel,$data);		
	}

	public function ambil_data($kunci,$tabel) {
		$this->db->where($kunci);
		$query=$this->db->get($tabel);
		return $query->result();
	}
}