<?php
 class Model_global extends CI_Model {
 	public function __construct() {
		
	}
	public function jumlah_data($kunci,$tabel) {
		$this->db->where($kunci);
		$query=$this->db->get($tabel);
		return $query->num_rows();
	}

	public function cek_data($kunci,$tabel) {
		$this->db->where($kunci);
		$query=$this->db->get($tabel);
		return $query->num_rows();
	}

	public function ambil_data($kunci,$tabel) {
		$this->db->where($kunci);
		$query=$this->db->get($tabel);
		return $query->row();
	}

	public function ambil_data_banyak($kunci,$tabel) {
		$this->db->where($kunci);
		$query=$this->db->get($tabel);
		return $query->result();
	}

	public function tambah_data($tabel,$data) {
		$this->db->insert($tabel,$data);		
	}

	public function update_data($kunci,$tabel,$data) {
		$this->db->where($kunci);
		$this->db->update($tabel,$data);		
	}

	public function hapus_data($kunci,$tabel) {
		$this->db->where($kunci);
		$this->db->delete($tabel);
	}
}
?>