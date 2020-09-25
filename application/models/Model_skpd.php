<?php
 class Model_skpd extends CI_Model {
 	public function __construct() {
		
	}

	public function kode_pengajuan() {
		$query=$this->db->query("SELECT MAX(RIGHT(kode_lelang,7)) AS kode FROM tb_lelang");
		if ($query->num_rows()) {
			$data=$query->row();
			$no=abs((int)$data->kode)+1;
			if ($no<10) {
				$kode=date('ym')."000000".$no;
			}else if ($no<100) {
				$kode=date('ym')."00000".$no;
			}else if ($no<1000) {
				$kode=date('ym')."0000".$no;
			}else if ($no<10000) {
				$kode=date('ym')."000".$no;
			}else if ($no<100000) {
				$kode=date('ym')."00".$no;
			}else if ($no<100000) {
				$kode=date('ym')."0".$no;
			}else if ($no<1000000) {
				$kode=date('ym').$no;
			} else {
				$kode=date('ym')."0000001";
			}
		} else {
			$kode=date('ym')."0000001";
		}
		return $kode;
	}

	public function daftar_ppk($kunci,$where,$limit,$start) {
		$this->db->or_like($kunci);
		$this->db->where($where);
		$this->db->order_by('nama_ppk','ASC');
		if ($limit!="NA") {
			$this->db->limit($limit,$start);
		}
		$query=$this->db->get('tb_ppk');
		return $query->result();
	}

	public function jumlah_ppk($kunci,$where) {
		$this->db->or_like($kunci);
		$this->db->where($where);
		$query=$this->db->get('tb_ppk');
		return $query->num_rows();
	}

	public function daftar_anggaran($kunci) {
		$this->db->or_like($kunci);
		$query=$this->db->get('tb_jenisanggaran');
		return $query->result();
	}

	public function daftar_kategori() {
		$this->db->order_by('kategori_lelang','ASC');
		$query=$this->db->get('tb_kategorilelang');
		return $query->result();
	}

	public function daftar_metode($where) {
		$this->db->where($where);
		$this->db->order_by('metode_lelang','ASC');
		$query=$this->db->get('tb_metodelelang');
		return $query->result();
	}

	public function daftar_lelang($select,$kunci,$where,$limit,$start) {
		$this->db->select($select);
		$this->db->from('tb_lelang');
		$this->db->join('tb_jenisanggaran','tb_lelang.id_jnsanggaran=tb_jenisanggaran.id_jnsanggaran');
		$this->db->join('tb_metodelelang','tb_lelang.id_metodelelang=tb_metodelelang.id_metodelelang');
		$this->db->join('tb_kategorilelang','tb_metodelelang.id_kategorilelang=tb_kategorilelang.id_kategorilelang');
		$this->db->join('tb_skpd','tb_lelang.kode_skpd=tb_skpd.kode_skpd');
		$this->db->or_like($kunci);
		$this->db->where($where);
		$this->db->order_by('tb_lelang.tanggal','DESC');
		$this->db->limit($limit,$start);
		$query=$this->db->get();
		return $query->result();
	}

	public function jumlah_lelang($select,$kunci,$where) {
		$this->db->select($select);
		$this->db->from('tb_lelang');
		$this->db->join('tb_jenisanggaran','tb_lelang.id_jnsanggaran=tb_jenisanggaran.id_jnsanggaran');
		$this->db->join('tb_metodelelang','tb_lelang.id_metodelelang=tb_metodelelang.id_metodelelang');
		$this->db->join('tb_kategorilelang','tb_metodelelang.id_kategorilelang=tb_kategorilelang.id_kategorilelang');
		$this->db->join('tb_skpd','tb_lelang.kode_skpd=tb_skpd.kode_skpd');
		$this->db->or_like($kunci);
		$this->db->where($where);
		$this->db->order_by('tb_lelang.tanggal','DESC');
		$query=$this->db->get();
		return $query->num_rows();
	}

	public function detail_lelang($select,$kunci) {
		$this->db->select($select);
		$this->db->from('tb_lelang');
		$this->db->join('tb_jenisanggaran','tb_lelang.id_jnsanggaran=tb_jenisanggaran.id_jnsanggaran');
		$this->db->join('tb_skpd','tb_lelang.kode_skpd=tb_skpd.kode_skpd');
		$this->db->join('tb_ppk','tb_lelang.nip_ppk=tb_ppk.nip_ppk');
		$this->db->join('tb_metodelelang','tb_lelang.id_metodelelang=tb_metodelelang.id_metodelelang');
		$this->db->join('tb_kategorilelang','tb_metodelelang.id_kategorilelang=tb_kategorilelang.id_kategorilelang');
		$this->db->where($kunci);
		$query=$this->db->get();
		return $query->row();
	}

	public function daftar_jabatan($kunci,$limit,$start) {
		$this->db->or_like($kunci);
		$this->db->order_by('urutan','ASC');
		$this->db->limit($limit,$start);
		$query=$this->db->get('tb_jabstruktur');
		return $query->result();
	}

	public function detail_pokja($select,$kunci) {
		$this->db->select($select);
		$this->db->from('tb_detailpokja');
		$this->db->join('tb_pokja','tb_detailpokja.nip=tb_pokja.nip');
		$this->db->join('tb_jabstruktur','tb_detailpokja.id_jabstruktur=tb_jabstruktur.id_jabstruktur');
		$this->db->where($kunci);
		$this->db->order_by('nama_pokja','ASC');
		$query=$this->db->get();
		return $query->result();
	}

	public function detail_pokja2($select,$kunci) {
		$this->db->select($select);
		$this->db->from('tb_detailpokja');
		$this->db->join('tb_pokja','tb_detailpokja.nip=tb_pokja.nip');
		$this->db->join('tb_jabstruktur','tb_detailpokja.id_jabstruktur=tb_jabstruktur.id_jabstruktur');
		$this->db->join('tb_skpd','tb_pokja.kode_skpd=tb_skpd.kode_skpd');
		$this->db->where($kunci);
		$this->db->order_by('tb_jabstruktur.urutan','ASC');
		$query=$this->db->get();
		return $query->result();
	}

	public function data_pengaturan() {
		$query=$this->db->get('tb_pengaturan');
		return $query->result();
	}

	//----------------------------------------model global-----------------------------------------------------------
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
	//------------------------------------------------end model global------------------------------------------------------------------------------------
}
?>