<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('model_global');
	}

	public function index() {
		$user=$this->input->post('user');
		$pass=md5($this->input->post('pass'));
		if ($this->input->post('user')) {
			//cari di tabel admin dulu
			$kunci=array('username'=>$user,'password'=>$pass);
			$cek=$this->model_global->ambil_data($kunci,'tb_admin');
			if ($cek) {
				$this->session->set_userdata('username',$cek->username);
				$this->session->set_userdata('nama',$cek->nama);
				redirect('beranda');
			} else {
				$data['peringatan']='<script> alert ("Username dan password masih salah!") </script>';
			}
		}
		$data['title']="Login";
		$this->load->view('view_login',$data);
	}

	public function out() {
		$array=array('username','akses');
		$this->session->unset_userdata($array);
		redirect('login');
	}
}