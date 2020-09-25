public function simpan_gaji() {
		$tanggal=$this->input->post('tanggal');
		//$tgl=date('Y-m-d',strtotime($this->input->post('tanggal')));
		$nip=$this->input->post('nip');
		$jenistambahan=$this->input->post('jenistambahan');	
		$nom_tambahan=$this->input->post('nom_tambahan');
		$gapok=$this->input->post('gapok');
		$total=$this->input->post('total');
	/*  $kd_jabatan=$this->input->post('kd_jabatan');
		$gapok=$this->input->post('gapok');
		$id_jenistambahan=$this->input->post('id_jenistambahan');
		$nom_tambahan=$this->input->post('nom_tambahan');
		$keterangan=$this->input->post('keterangan');        */
	//	$total=$gapok+$nom_tambahan;
		//cari kelas siswa dulu
		$kunci=array('nip'=>$nip);
		$cek=$this->model_global->ambil_data($kunci,'tb_jabkar');                       //tadi tb_jabkar
		if ($cek) {
			$jabatan=$cek->kd_jabatan;
		} else {
			echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					karyawan belum ditentukan jabatannya!
				</div>';
				die();
		}
		
		//konvert tanggal dulu
		$tgl=str_replace('/','-',$tanggal);
		$tgl=date('Y-m-d',strtotime($tgl));
						
		//cari jenis pembayaran dulu 
		$kunci=array('id_jenistambahan'=>$jenistambahan);
		$cek=$this->model_global->ambil_data($kunci,'tb_jenistambahan'); 
		if ($cek) {
			$isi=array('tanggal'=>$tgl,'nip'=>$nip,'kd_karyawan'=>$karyawan,'id_jenistambahan'=>$jenistambahan,'nom_tambahan'=>$nom_tambahan,'gapok'=>$gapok,'total'=>$total);
			$this->model_global->tambah_data('tb_gajian',$isi);
			echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					Data Tambahan berhasil disimpan.
				</div>';
		} else {
			echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					Jenis Tambahan tidak ditemukan!
				</div>';
		}
	} 