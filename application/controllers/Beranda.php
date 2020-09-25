<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Beranda extends CI_Controller {
	public function __construct() {
		parent::__construct();
		if ($this->session->userdata('username')==false) {
			redirect('login');
		}
		$this->load->model('model_global');
	}

	public function index() {
		$data['title']="Halaman Depan";
		$data['template']="beranda/view_beranda";
		$this->load->view('layout/wrapper',$data);
	}

	public function password() {
		if ($this->input->post('ganti')) {
			$pass1=md5($this->input->post('pass1'));
			$pass2=md5($this->input->post('pass2'));
			$pass3=md5($this->input->post('pass3'));
			$user=$this->session->userdata('username');
			$kunci=array('password'=>$pass1,'user'=>$user);
			if ($pass2==$pass3) {
				$cek=$this->model_admin->cek_data($kunci,'tb_spv');
				if ($cek) {
					$isi=array('password'=>$pass2);
					$simpan=$this->model_admin->update_data($kunci,'tb_spv',$isi);
					$data['peringatan']="<div class=\"alert alert-success alert-dismissible fade in\" role=\"alert\">
	      									<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button>
	      									Password berhasil diubah.
	    								</div>";	
				} else {
					$data['peringatan']="<div class=\"alert alert-danger alert-dismissible fade in\" role=\"alert\">
	      									<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button>
	      									Password lama masih salah!
	    								</div>";
				}
			} else {
				$data['peringatan']="<div class=\"alert alert-danger alert-dismissible fade in\" role=\"alert\">
										<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button>
										Password baru masih belum cocok!
									</div>";
			}
		}
		$data['title']="Ubah Password";
		$data['template']="beranda/ubah_password";
		$this->load->view('layout/wrapper',$data);
	}
}