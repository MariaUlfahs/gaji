<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Transaksi extends CI_Controller {
	public function __construct() {
		parent::__construct();
		if ($this->session->userdata('username')==false) {
			redirect('login');
		}
		$this->load->model('model_global');
	}

	public function index() {
		redirect('transaksi/gaji');
	}

	public function gaji() {
		//ambil data karyawan
		$this->db->select('tb_karyawan.nip,nama');
		$this->db->from('tb_karyawan');
		$this->db->join('tb_jabkar','tb_jabkar.nip=tb_karyawan.nip');
		$this->db->order_by('nama','ASC');
		$this->db->order_by('tb_karyawan.nip','ASC');
		$query=$this->db->get();
		$data['karyawan']=$query->result();       //TEKAN NGENE

		//ambil data jenis tambahan
		$this->db->select('id_jenistambahan,jenis_tambahan');
		$this->db->from('tb_jenistambahan');
		$this->db->order_by('jenis_tambahan','ASC');
		$this->db->where('aktif',1);
		$query=$this->db->get();
		$data['jenistambahan']=$query->result();

		//ambil data gapok dari jabatan
/*		$this->db->select('id_jabatan,gapok');
		$this->db->from('tb_jabatan');
		$this->db->order_by('gapok','ASC');
		$this->db->where('aktif',1);
		$query=$this->db->get();
		$data['gapok']=$query->result();         */

		$data['tanggal']=date('d/m/Y');
		$data['title']='Transaksi Penggajian';
		$data['template']='transaksi/form_penggajian';
		$this->load->view('layout/wrapper',$data);
	}

	
	
//PUBLIC FUNCTION SIMPAN
	public function simpan_gaji() {
		$tgl=date('Y-m-d',strtotime($this->input->post('tanggal')));
		$nip=$this->input->post('nip');
		$gapok=$this->input->post('gapok');
		$id_jenistambahan=$this->input->post('id_jenistambahan');
		$nom_tambahan=$this->input->post('nom_tambahan');
		$total_gaji=$this->input->post('total_gaji');
		$id=$this->input->post('id');
		$data=array();
			//tambah data
			//cek kode jika ada yang kembar
			$kunci=array('id_jenistambahan'=>$id_jenistambahan);
			$cek=$this->model_global->cek_data($kunci,'tb_jenistambahan');
			/*if ($cek) {
				echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						NIP sudah diinput sebelumnya.
					</div>';
			} else { */
				//jika tidak ada yang kembar baru tambah data
				$isi=array('tanggal'=>$tgl,'nip'=>$nip,'gapok'=>$gapok,'id_jenistambahan'=>$id_jenistambahan,'nom_tambahan'=>$nom_tambahan,'total_gaji'=>$total_gaji,'aktif'=>1);
				$this->model_global->tambah_data('tb_gajian',$isi);
				echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						Data penggajian berhasil ditambahkan.
					</div>';
			//}
		
	}

//--------------------------------------------------------------------------------------------------------------------------------------------------
//CARI NOMINAL TAMBAHAN
	public function cari_tambahan() {
		$nip=$this->input->post('nip');	
		$id_jenistambahan=$this->input->post('id_jenistambahan');			
		$kunci=array('nip'=>$nip);
		$cek=$this->model_global->ambil_data($kunci,'tb_jabkar');
		if ($cek) {
			$this->db->select('nom_tambahan');
			$this->db->from('tb_tambahan');
			$this->db->where('id_jenistambahan',$id_jenistambahan);
			$this->db->where('kd_jabatan',$cek->kd_jabatan);
			$query=$this->db->get();
			$cek=$query->row();
			echo $cek->nom_tambahan; 
		}		
	}
	
//CARI GAPOK
	public function cari_gapok() {
		$nip=$this->input->post('nip');		
		$kunci=array('nip'=>$nip);
		$cek=$this->model_global->ambil_data($kunci,'tb_jabkar');
		if ($cek) {
			$this->db->select('gapok');
			$this->db->from('tb_jabatan');
			$this->db->where('kd_jabatan',$cek->kd_jabatan);
			$query=$this->db->get();
			$cek=$query->row();
			echo $cek->gapok; 
		}
		
	}
//CARI total_gaji -------------->BELUM SELESE
	public function cari_total() {
		$gapok=$this->input->post('gapok');		
		$kunci=array('gapok'=>$gapok);
		$cek=$this->model_global->ambil_data($kunci,'tb_jabatan');
		if ($cek) {
			$this->db->select('nom_tambahan');
			$this->db->from('tb_jabatan');
			$this->db->where('kd_jabatan',$cek->kd_jabatan);
			$query=$this->db->get();
			$cek=$query->row();
			echo $cek->gapok; 
		}
		
	}

	
	
	
	 
	
//---------------------------------------------------------------------------------------------------------------------------------------------------
	public function penggajian() {
		$data['tanggal']=date('d/m/Y');
		$data['title']='Data Transaksi Penggajian';
		$data['template']='transaksi/view_penggajian';
		$this->load->view('layout/wrapper',$data);
	}

	public function datagaji() {
		$tanggal=date('Y-m-d');
		$req=$_REQUEST;
		$this->db->from('tb_gajian');
		$this->db->join('tb_karyawan','tb_karyawan.nip=tb_gajian.nip');
		$this->db->join('tb_jenistambahan','tb_jenistambahan.id_jenistambahan=tb_gajian.id_jenistambahan');
		$this->db->join('tb_jabkar','tb_jabkar.nip=tb_karyawan.nip');
		$this->db->where('tb_gajian.tanggal',$tanggal);
		//pencarian data
		if ($req['search']['value']) {
			$cari=$req['search']['value'];
			////////////////////////////////////////SAMPAI SINI
			$kunci=array('tb_karyawan.nip'=>$cari,'tb_karyawan.nama'=>$cari,'tb_jabkar.kd_jabatan'=>$cari,'tb_jenistambahan.id_jenistambahan'=>$cari,'tb_gajian.total_gaji'=>$cari);
			$this->db->group_start();
			$this->db->or_like($kunci);
			$this->db->group_end();
		}
		$query=$this->db->get();
		$gapok=$query->num_rows();


		//konversi kolom
		$kolom=array('tb_gajian.tanggal','tb_karyawan.nip','tb_karyawan.nama','gapok','jenis_tambahan','nom_tambahan','total_gaji');
		$this->db->from('tb_gajian');
		$this->db->join('tb_karyawan','tb_karyawan.nip=tb_gajian.nip');
		$this->db->join('tb_jenistambahan','tb_jenistambahan.id_jenistambahan=tb_gajian.id_jenistambahan');
		$this->db->join('tb_jabkar','tb_jabkar.nip=tb_karyawan.nip');
		$this->db->where('tb_gajian.tanggal',$tanggal);
		//pencarian data
		if ($req['search']['value']) {
			$cari=$req['search']['value'];
			$kunci=array('tb_karyawan.nip'=>$cari,'tb_karyawan.nama'=>$cari,'tb_jabkar.kd_jabatan'=>$cari,'tb_jenistambahan.id_jenistambahan'=>$cari,'tb_gajian.total_gaji'=>$cari);
			$this->db->group_start();
			$this->db->or_like($kunci);
			$this->db->group_end();
		}
		//urutan data
		$this->db->order_by($kolom[$req['order'][0]['column']],$req['order'][0]['dir']);
		$this->db->limit($req['length'],$req['start']);
		$query=$this->db->get();
		$qry=$query->result();

		$isinya=array();
		foreach ($qry as $hasil) {
			$datanya=array();
			$datanya[]=date('d/m/Y',strtotime($hasil->tanggal));
			$datanya[]=$hasil->nip;
			
			$datanya[]=$hasil->nama;
			$datanya[]=$hasil->kd_jabatan;
			$datanya[]=number_format($hasil->gapok,0,',','.');
			//$datanya[]=$hasil->gapok;
			$datanya[]=$hasil->jenis_tambahan;
			$datanya[]=number_format($hasil->nom_tambahan,0,',','.');
			$datanya[]=number_format($hasil->total_gaji,0,',','.');
		//	$datanya[]=$hasil->debitur;
			
			$isinya[]=$datanya;
		}
		$result=array('recordsTotal'=>$total,'recordsFiltered'=>$total,'data'=>$isinya);
		echo json_encode($result);
	} 
}