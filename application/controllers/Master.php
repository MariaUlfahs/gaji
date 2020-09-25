<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Master extends CI_Controller {
	public function __construct() {
		parent::__construct();
		if ($this->session->userdata('username')==false) {
			redirect('login');
		}
		$this->load->model('model_global');
	}

	public function index() {
		redirect('master/jenistambahan');
	}

	public function jenistambahan() {
		$data['title']='Jenis Tambahan';
		$data['template']='master/view_jenistambahan';
		$this->load->view('layout/wrapper',$data);
	}

	public function datajenistambahan() {
		$req=$_REQUEST;
		$this->db->from('tb_jenistambahan');
		$this->db->where('aktif',1);
		//pencarian data
		if ($req['search']['value']) {
			$cari=$req['search']['value'];
			$kunci=array('jenis_tambahan'=>$cari);
			$this->db->group_start();
			$this->db->or_like($kunci);
			$this->db->group_end();
		}
		$query=$this->db->get();
		$total=$query->num_rows();


		//konversi kolom
		$kolom=array('jenis_tambahan','','');
		$this->db->from('tb_jenistambahan');
		$this->db->where('aktif',1);
		//pencarian data
		if ($req['search']['value']) {
			$cari=$req['search']['value'];
			$kunci=array('jenis_tambahan'=>$cari);
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
			$datanya[]=$hasil->jenis_tambahan;
			$datanya[]='<a href="'.base_url('master/form_jenistambahan/?id='.$hasil->id_jenistambahan).'" class="btn btn-info btn-xs" title="Edit"><i class="fa fa-edit icon-white"></i></a>';
			$datanya[]='<button title="Hapus" onclick="konfirhapus(this.value)" class="btn btn-danger btn-xs" value="'.$hasil->id_jenistambahan.'"><i class="fa fa-trash-o"></i></button>';
			$isinya[]=$datanya;
		}
		$result=array('recordsTotal'=>$total,'recordsFiltered'=>$total,'data'=>$isinya);
		echo json_encode($result);
	}

	public function form_jenistambahan() {
		$id=$this->input->get('id');
		$kunci=array('id_jenistambahan'=>$id);
		$cek=$this->model_global->ambil_data($kunci,'tb_jenistambahan');
		if ($cek) {
			$data['id_jenistambahan']=$cek->id_jenistambahan;
			$data['jenistambahan']=$cek->jenis_tambahan;
			//ambil data tarif
			$databiaya=$this->model_global->ambil_data_banyak($kunci,'tb_tambahan');
			$arrtambahan=array();
			foreach ($arrtambahan as $hasil) {
				$arrtambahan[$hasil->kd_jabatan]=$hasil->nom_tambahan;
			}
			$data['arrtambahan']=$arrtambahan;
		}
		//ambil data jabatan
		
		$this->db->from('tb_jabatan');
		$this->db->where('aktif',1);
		$this->db->order_by('nama_jabatan','ASC');
		$this->db->order_by('gapok','ASC');
		$query=$this->db->get();
		$data['datajabatan']=$query->result();
		$data['title']='Jenis Tambahan';
		$data['template']='master/form_jenistambahan';
		$this->load->view('layout/wrapper',$data);
	}

	public function simpan_jenistambahan() {
		$jenistambahan=$this->input->post('jenistambahan');
		$id=$this->input->post('id');
		if ($id) {
			//edit data
			$kunci=array('id_jenistambahan'=>$id);
			$isi=array('jenis_tambahan'=>$jenistambahan,'aktif'=>1);
			$this->model_global->update_data($kunci,'tb_jenistambahan',$isi);
			foreach ($this->input->post() as $key => $value) {
				if ($key=='jenistambahan') {
					continue;
				}
				if ($key=='id') {
					continue;
				}
				$kunci=array('id_jenistambahan'=>$id,'kd_jabatan'=>$key);
				$cek=$this->model_global->cek_data($kunci,'tb_tambahan');
				if ($cek) {
					$isi=array('nom_tambahan'=>$value);
					$this->model_global->update_data($kunci,'tb_tambahan',$isi);
				} else {
					$isi=array('id_jenistambahan'=>$id,'kd_jabatan'=>$key,'nom_tambahan'=>$value);
					$this->model_global->tambah_data('tb_tambahan',$isi);
				}
			}
			echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					Data jenis Tambahan berhasil diubah.
				</div>';
		} else {
			//tambah data
			//cek kode jika ada yang kembar
			$kunci=array('jenis_tambahan'=>$jenistambahan,'aktif'=>1);
			$cek=$this->model_global->cek_data($kunci,'tb_jenistambahan');
			if ($cek) {
				echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						Data jenis bayar sudah diinput sebelumnya.
					</div>';
			} else {
				//jika tidak ada yang kembar baru tambah data
				$isi=array('jenis_tambahan'=>$jenistambahan,'aktif'=>1);
				$this->model_global->tambah_data('tb_jenistambahan',$isi);
				$id=$this->db->insert_id();
				foreach ($this->input->post() as $key => $value) {
					if ($key=='jenistambahan') {
						continue;
					}
					if ($key=='id') {
						continue;
					}
					$isi=array('id_jenistambahan'=>$id,'kd_jabatan'=>$key,'nom_tambahan'=>$value);
					$this->model_global->tambah_data('tb_tambahan',$isi);
				}
				echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						Data jenis tambahan berhasil ditambahkan.
					</div>';
			}
		}
	}

	function hapus_jenistambahan() {
		$id=$this->input->post('id');
		if ($id) {
			$kunci=array('id_jenistambahan'=>$id);
			$isi=array('aktif'=>0);
			$this->model_global->update_data($kunci,'tb_jenistambahan',$isi);
			echo '<div class="alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					Data Jenis Tambahan berhasil dihapus.
				</div>';
		}
	}
//--------------------------------------------------------------------------------------------------------------------------------------
/*	public function debitur() {
		$data['title']='Debitur Pembayaran';
		$data['template']='master/view_debitur';
		$this->load->view('layout/wrapper',$data);
	}

	public function datadebitur() {
		$req=$_REQUEST;
		$this->db->from('tb_debitur');
		$this->db->where('aktif',1);
		//pencarian data
		if ($req['search']['value']) {
			$cari=$req['search']['value'];
			$kunci=array('debitur'=>$cari);
			$this->db->group_start();
			$this->db->or_like($kunci);
			$this->db->group_end();
		}
		$query=$this->db->get();
		$total=$query->num_rows();


		//konversi kolom
		$kolom=array('debitur','','');
		$this->db->from('tb_debitur');
		$this->db->where('aktif',1);
		//pencarian data
		if ($req['search']['value']) {
			$cari=$req['search']['value'];
			$kunci=array('debitur'=>$cari);
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
			$datanya[]=$hasil->debitur;
			$datanya[]='<a href="javascript:void(0)" class="btn btn-info btn-xs" title="Edit" data-toggle="modal" data-target="#modalutama" onclick="tampilform(\''.$hasil->debitur.'\')"><i class="fa fa-edit icon-white"></i></a>';
			$datanya[]='<button title="Hapus" onclick="konfirhapus(this.value)" class="btn btn-danger btn-xs" value="'.$hasil->debitur.'"><i class="fa fa-trash-o"></i></button>';
			$isinya[]=$datanya;
		}
		$result=array('recordsTotal'=>$total,'recordsFiltered'=>$total,'data'=>$isinya);
		echo json_encode($result);
	}

	public function form_debitur() {
		$id=$this->input->post('id');
		$kunci=array('debitur'=>$id);
		$cek=$this->model_global->ambil_data($kunci,'tb_debitur');
		if ($cek) {
			$data['debitur']=$cek->debitur;
		}
		$data['title']='Debitur';
		$this->load->view('master/form_debitur',$data);
	}

	public function simpan_debitur() {
		$debitur=$this->input->post('debitur');
		$id=$this->input->post('id');
		$data=array();
		if ($id) {
			//edit data
			$kunci=array('debitur'=>$id);
			$isi=array('debitur'=>$debitur,'aktif'=>1);
			$this->model_global->update_data($kunci,'tb_debitur',$isi);
			echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					Data debitur berhasil diubah.
				</div>';
		} else {
			//tambah data
			//cek kode jika ada yang kembar
			$kunci=array('debitur'=>$debitur,'aktif'=>1);
			$cek=$this->model_global->cek_data($kunci,'tb_debitur');
			if ($cek) {
				echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						Nama debitur sudah diinput sebelumnya.
					</div>';
			} else {
				//jika tidak ada yang kembar baru tambah data
				$isi=array('debitur'=>$debitur,'aktif'=>1);
				$this->db->replace('tb_debitur',$isi);
				echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						Data debitur berhasil ditambahkan.
					</div>';
			}
		}
	}

	function hapus_debitur() {
		$id=$this->input->post('id');
		if ($id) {
			$kunci=array('debitur'=>$id);
			$isi=array('aktif'=>0);
			$this->model_global->update_data($kunci,'tb_debitur',$isi);
			echo '<div class="alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					Data debitur dihapus.
				</div>';
		}
	}
	*/
	//-------------JABATAN----------------------------

	public function jabatan() {
		$data['title']='Data Jabatan';
		$data['template']='master/view_jabatan';
		$this->load->view('layout/wrapper',$data);
	}

	public function datajabatan() {
		$req=$_REQUEST;
		$this->db->from('tb_jabatan');
		$this->db->where('aktif',1);
		//pencarian data
		if ($req['search']['value']) {
			$cari=$req['search']['value'];
			$kunci=array('kd_jabatan'=>$cari,'nama_jabatan'=>$cari,'gapok'=>$cari);
			$this->db->group_start();
			$this->db->or_like($kunci);
			$this->db->group_end();
		}
		$query=$this->db->get();
		$total=$query->num_rows();


		//konversi kolom
		$kolom=array('kd_jabatan','nama_jabatan','gapok','','');
		$this->db->from('tb_jabatan');
		$this->db->where('aktif',1);
		//pencarian data
		if ($req['search']['value']) {
			$cari=$req['search']['value'];
			$kunci=array('kd_jabatan'=>$cari,'nama_jabatan'=>$cari,'gapok'=>$cari,);
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
			$datanya[]=$hasil->kd_jabatan;
			$datanya[]=$hasil->nama_jabatan;
			
			$datanya[]=$hasil->gapok;
			
			$datanya[]='<a href="javascript:void(0)" class="btn btn-info btn-xs" title="Edit" data-toggle="modal" data-target="#modalutama" onclick="tampilform(\''.$hasil->kd_jabatan.'\')"><i class="fa fa-edit icon-white"></i></a>';
			$datanya[]='<button title="Hapus" onclick="konfirhapus(this.value)" class="btn btn-danger btn-xs" value="'.$hasil->kd_jabatan.'"><i class="fa fa-trash-o"></i></button>';
			$isinya[]=$datanya;
		}
		$result=array('recordsTotal'=>$total,'recordsFiltered'=>$total,'data'=>$isinya);
		echo json_encode($result);
	}

	public function form_jabatan() {
		$id=$this->input->post('id');
		$kunci=array('kd_jabatan'=>$id);
		$cek=$this->model_global->ambil_data($kunci,'tb_jabatan');
		if ($cek) {
			$data['kd_jabatan']=$cek->kd_jabatan;
			$data['nama_jabatan']=$cek->nama_jabatan;
			
			$data['gapok']=$cek->gapok;
			
		}
		$data['title']='Data Jabatan';
		$this->load->view('master/form_jabatan',$data);
	}

	public function simpan_jabatan() {
		$kd_jabatan=$this->input->post('kd_jabatan');
		$nama_jabatan=$this->input->post('nama_jabatan');
		
		$gapok=$this->input->post('gapok');
		$gaji_lembur=$this->input->post('gaji_lembur');
		$id=$this->input->post('id');
		$data=array();
		if ($id) {
			//edit data
			$kunci=array('kd_jabatan'=>$id);
			$isi=array('kd_jabatan'=>$kd_jabatan,'nama_jabatan'=>$nama_jabatan,'gapok'=>$gapok,'aktif'=>1);
			$this->model_global->update_data($kunci,'tb_jabatan',$isi);
			echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					Data Jabatan berhasil diubah.
				</div>';
		} else {
			//tambah data
			//cek kode jika ada yang kembar
			$kunci=array('kd_jabatan'=>$kd_jabatan,'aktif'=>1);
			$cek=$this->model_global->cek_data($kunci,'tb_jabatan');
			if ($cek) {
				echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						Kode Jabatan sudah ada!
					</div>';
			} else {
				//jika tidak ada yang kembar baru tambah data
				$isi=array('kd_jabatan'=>$kd_jabatan,'nama_jabatan'=>$nama_jabatan,'gapok'=>$gapok,'aktif'=>1);
				$this->db->replace('tb_jabatan',$isi);
				echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						Data Jabatan berhasil ditambahkan.
					</div>';
			}
		}
	}

	function hapus_jabatan() {
		$id=$this->input->post('id');
		if ($id) {
			$kunci=array('kd_jabatan'=>$id);
			$isi=array('aktif'=>0);
			$this->model_global->update_data($kunci,'tb_jabatan',$isi);
			echo '<div class="alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					Data Jabatan berhasil dihapus.
				</div>';
		}
	}
// ----------------------------------------DATA KARYAWAN-------------------------------------------
	public function karyawan() {
		$data['title']='Data Karyawan';
		$data['template']='master/view_karyawan';
		$this->load->view('layout/wrapper',$data);
	}

	public function datakaryawan() {
		$req=$_REQUEST;
		$this->db->from('tb_karyawan');
		$this->db->where('aktif',1);
		//pencarian data
		if ($req['search']['value']) {
			$cari=$req['search']['value'];
			$kunci=array('nip'=>$cari,'nama'=>$cari,'jekel'=>$cari,'telepon'=>$cari,'alamat'=>$cari);
			$this->db->group_start();
			$this->db->or_like($kunci);
			$this->db->group_end();
		}
		$query=$this->db->get();
		$total=$query->num_rows();


		//konversi kolom
		$kolom=array('nip','nama','jekel','telepon','alamat','','');
		$this->db->from('tb_karyawan');
		$this->db->where('aktif',1);
		//pencarian data
		if ($req['search']['value']) {
			$cari=$req['search']['value'];
			$kunci=array('nip'=>$cari,'nama'=>$cari,'jekel'=>$cari,'telepon'=>$cari,'alamat'=>$cari);
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
			$datanya[]=$hasil->nip;
			$datanya[]=$hasil->nama;
			$datanya[]=$hasil->jekel;
			$datanya[]=$hasil->telepon;
			$datanya[]=$hasil->alamat;
			$datanya[]='<a href="javascript:void(0)" class="btn btn-info btn-xs" title="Edit" data-toggle="modal" data-target="#modalutama" onclick="tampilform(\''.$hasil->nip.'\')"><i class="fa fa-edit icon-white"></i></a>';
			$datanya[]='<button title="Hapus" onclick="konfirhapus(this.value)" class="btn btn-danger btn-xs" value="'.$hasil->nip.'"><i class="fa fa-trash-o"></i></button>';
			$isinya[]=$datanya;
		}
		$result=array('recordsTotal'=>$total,'recordsFiltered'=>$total,'data'=>$isinya);
		echo json_encode($result);
	}

	public function form_karyawan() {
		$id=$this->input->post('id');
		$kunci=array('nip'=>$id);
		$cek=$this->model_global->ambil_data($kunci,'tb_karyawan');
		if ($cek) {
			$data['nip']=$cek->nip;
			$data['nama']=$cek->nama;
			$data['jekel']=$cek->jekel;
			$data['telepon']=$cek->telepon;
			$data['alamat']=$cek->alamat;
			
		}
		$data['title']='Data Karyawan';
		$this->load->view('master/form_karyawan',$data);
	}

	public function simpan_karyawan() {
		$nip=$this->input->post('nip');
		$nama=$this->input->post('nama');
		$jekel=$this->input->post('jekel');
		$telepon=$this->input->post('telepon');
		$alamat=$this->input->post('alamat');
		$id=$this->input->post('id');
		$data=array();
		if ($id) {
			//edit data
			$kunci=array('nip'=>$id);
			$isi=array('nip'=>$nip,'nama'=>$nama,'jekel'=>$jekel,'telepon'=>$telepon,'alamat'=>$alamat,'aktif'=>1);
			$this->model_global->update_data($kunci,'tb_karyawan',$isi);
			echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					Data karyawan berhasil diubah.
				</div>';
		} else {
			//tambah data
			//cek kode jika ada yang kembar
			$kunci=array('nip'=>$nip);
			$cek=$this->model_global->cek_data($kunci,'tb_karyawan');
			if ($cek) {
				echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						NIP sudah diinput sebelumnya.
					</div>';
			} else {
				//jika tidak ada yang kembar baru tambah data
				$isi=array('nip'=>$nip,'nama'=>$nama,'jekel'=>$jekel,'telepon'=>$telepon,'alamat'=>$alamat,'aktif'=>1);
				$this->model_global->tambah_data('tb_karyawan',$isi);
				echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						Data Karyawan berhasil ditambahkan.
					</div>';
			}
		}
	}

	function hapus_karyawan() {
		$id=$this->input->post('id');
		if ($id) {
			$kunci=array('nip'=>$id);
			$isi=array('aktif'=>0);
			$this->model_global->update_data($kunci,'tb_karyawan',$isi);
			echo '<div class="alert alert-warning alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					Data Karyawan berhasil dihapus.
				</div>';
		}
	}
//-------------------------------------BAGI JABATAN----------------------------------------------------------------------
	function bagijabatan() {
		$this->db->from('tb_jabatan');
		$this->db->order_by('nama_jabatan','ASC');
		$this->db->order_by('gapok','ASC');
		$query=$this->db->get();
		$data['datajabatan']=$query->result();
		$data['title']='Pembagian Jabatan Karyawan';
		$data['template']='master/view_bagijabatan';
		$this->load->view('layout/wrapper',$data);
	}

	function databagijabatan() {
		$jabatan=$this->input->get('jabatan');
		//ambil master jabatan dulu
		$this->db->from('tb_jabatan');
		$this->db->where('aktif',1);
		$this->db->order_by('nama_jabatan','ASC');
		$this->db->order_by('gapok','ASC');
		$query=$this->db->get();
		$datajabatan=$query->result();

		$req=$_REQUEST;
		$this->db->select('tb_karyawan.nip,nama,jekel,tb_jabkar.kd_jabatan');
		$this->db->from('tb_karyawan');
		$this->db->join('tb_jabkar','tb_jabkar.nip=tb_karyawan.nip','LEFT');
		if ($jabatan) {
			$this->db->where('tb_jabkar.kd_jabatan',$jabatan);
		}
		$this->db->where('tb_karyawan.aktif',1);
		//pencarian data
		if ($req['search']['value']) {
			$cari=$req['search']['value'];
			$kunci=array('tb_karyawan.nip'=>$cari,'nama'=>$cari,'jekel'=>$cari);
			$this->db->group_start();
			$this->db->or_like($kunci);
			$this->db->group_end();
		}
		$query=$this->db->get();
		$total=$query->num_rows();


		//konversi kolom
		$kolom=array('tb_karyawan.nip','nama','jekel','');
		$this->db->select('tb_karyawan.nip,nama,jekel,tb_jabkar.kd_jabatan');
		$this->db->from('tb_karyawan');
		$this->db->join('tb_jabkar','tb_jabkar.nip=tb_karyawan.nip','LEFT');
		if ($jabatan) {
			$this->db->where('tb_jabkar.kd_jabatan',$jabatan);
		}
		$this->db->where('tb_karyawan.aktif',1);
		//pencarian data
		if ($req['search']['value']) {
			$cari=$req['search']['value'];
			$kunci=array('tb_karyawan.nip'=>$cari,'nama'=>$cari,'jekel'=>$cari);
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
			$op='<option value="">-- pilih jabatan --</option>';
			foreach ($datajabatan as $hasil2) {
				if (@$hasil->kd_jabatan==$hasil2->kd_jabatan) {
					$selected='selected';
				} else {
					$selected='';
				}
				$op.='<option value="'.$hasil2->kd_jabatan.'" '.$selected.'>'.$hasil2->kd_jabatan.'</option>';
			}
			$datanya=array();
			$datanya[]=$hasil->nip;
			
			$datanya[]=$hasil->nama;
			$datanya[]=$hasil->jekel;
			$datanya[]='<select class="form-control" name="kdjabatan[]" id="kdjabatan[]" onchange="simpanjabatan(\''.$hasil->nip.'\',this.value)">'.$op.'</select>';
			$isinya[]=$datanya;
		}
		$result=array('recordsTotal'=>$total,'recordsFiltered'=>$total,'data'=>$isinya);
		echo json_encode($result);
	}

	public function simpan_bagijabatan() {
		$nip=$this->input->post('nip');
		$jabatan=$this->input->post('jabatan');
		if ($jabatan) {
			//cek data
			$kunci=array('nip'=>$nip);
			$cek=$this->model_global->cek_data($kunci,'tb_jabkar');
			if ($cek) {
				$isi=array('kd_jabatan'=>$jabatan,'nip'=>$nip);
				$this->model_global->update_data($kunci,'tb_jabkar',$isi);
			} else {
				$isi=array('kd_jabatan'=>$jabatan,'nip'=>$nip);
				$this->model_global->tambah_data('tb_jabkar',$isi);
			}
		} else {
			$kunci=array('nip'=>$nip);
			$this->model_global->hapus_data($kunci,'tb_jabkar');
		}
	}
	
}