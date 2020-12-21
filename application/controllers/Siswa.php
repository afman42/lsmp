<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if ($_SESSION['login'] != TRUE) {
   			echo "<script type='text/javascript'>alert('Harap Login Terlebih dahulu');window.location.href='".site_url('utama/login')."'</script>";
		}
		$this->load->model('Siswa_model');
	}

    public function index()
	{
		$data['header'] = 'E-elearning - Siswa';
		$user = $this->db->get_where('user',['level' => $this->session->userdata('level')])->row();
        $data['jadwal'] = $this->Siswa_model->jadwal_siswa($user->is_siswa)->result();
        $data['jumlah_tugas'] = $this->Siswa_model->hitung_tugas($user->is_siswa)->result();
		$this->load->view('template/header',$data);
		$this->load->view('siswa/index',$data);
		$this->load->view('template/footer');
    }
    
    public function tugas()
    {
        $data['header'] = 'E-elearning - Siswa Tugas';
		$user = $this->db->get_where('user',['level' => $this->session->userdata('level')])->row();
        $data['ujian'] = $this->Siswa_model->ujian_siswa($user->is_siswa)->result();
		$this->load->view('template/header',$data);
		$this->load->view('siswa/ujian',$data);
		$this->load->view('template/footer');
    }

    public function kerjakan($id)
    {
    	$data['header'] = 'E-elearning - Kerjakan Tugas';
        $data['kerjakan'] = $this->Siswa_model->kerjakan_ujian($id)->row(1);
		$this->load->view('template/header',$data);
		$this->load->view('siswa/kerjakan',$data);
		$this->load->view('template/footer');
    }

    public function kerjakan_soal()
    {
		$this->load->view('siswa/soal');
    }

    public function nilai()
    {
		$user = $this->db->get_where('user',['level' => $this->session->userdata('level')])->row();

    	if (empty($_SESSION['email']) AND empty($_SESSION['level']) AND $_SESSION['login']==TRUE){
   			 echo "<script type='text/javascript'>alert('Harap Login Terlebih dahulu');window.location.href='".site_url('utama/login')."'</script>";
		 
		}else{
		
		$soal = $this->db->query("SELECT * FROM quiz_pilganda where topik_tugas_id='$_POST[id_topik]'");
		$pilganda = $soal->num_rows();
		$soal_esay = $this->db->query("SELECT * FROM quiz_essay WHERE topik_tugas_id='$_POST[id_topik]'");
		$esay = $soal_esay->num_rows();
		//jika ada pilihan ganda dan ada esay
		if (!empty($pilganda) AND !empty($esay)){

		//jika ada inputan soal pilganda
		if(!empty($_POST['soal_pilganda'])){
		    $benar = 0;
		    $salah = 0;
		    foreach($_POST['soal_pilganda'] as $key => $value){
		    $cek = $this->db->query("SELECT * FROM quiz_pilganda WHERE id=$key");
		    // while($c = mysqli_fetch_array($cek)){
		 	foreach ($cek->result_array() as $c) {
		        $jawaban = $c['kunci'];
		    }
		    if($value==$jawaban){
		        $benar++;
		    }else{
		        $salah++;
		    }
		}

		$jumlah = $_POST['jumlahsoalpilganda'];
		$tidakjawab = $jumlah - $benar - $salah;
		$persen = $benar / $jumlah;
		$hasil = $persen * 100;

		$this->db->query("INSERT INTO nilai (topik_tugas_id, siswa_id, benar, salah, tidak_dikerjakan,persentase)
		                           VALUES ('$_POST[id_topik]','$user->is_siswa','$benar','$salah','$tidakjawab','$hasil')");

		}
		elseif (empty($_POST['soal_pilganda'])){
		    $jumlah = $_POST['jumlahsoalpilganda'];
		    $this->db->query("INSERT INTO nilai (topik_tugas_id, siswa_id, benar, salah, tidak_dikerjakan,persentase)
		                           VALUES ('$_POST[id_topik]','$user->is_siswa','0','0','$jumlah','0')");
		}

		//jika ada inputan soal esay
		if(!empty($_POST['soal_esay'])){
		    foreach($_POST['soal_esay'] as $key2 => $value){
		    $jawaban = $value;
		    $cek = $this->db->query("SELECT * FROM quiz_essay WHERE id=$key2");
		    foreach ($cek->result_array() as $data) {
		    // while($data = mysqli_fetch_array($cek)){
		        $this->db->query("INSERT INTO jawaban_essay(topik_tugas_id,id_quiz_essay,siswa_id,jawaban)
		                                 VALUES('$_POST[id_topik]','$data[id]','$user->is_siswa','$jawaban')");

		    }
		    
		    }

		}
		elseif (empty($_POST['soal_esay'])){
		    $this->db->query("INSERT INTO jawaban_essay(topik_tugas_id,id_quiz_essay,siswa_id,jawaban)
		                                 VALUES('$_POST[id_topik]','$data[id]','$user->is_siswa','')");
		}
			redirect(site_url('siswa/tugas'));
		}

		//jika soal hanya esay
		if (empty($pilganda) AND !empty($esay)){
		    //jika ada inputan soal esay
		if(!empty($_POST['soal_esay'])){
		    foreach($_POST['soal_esay'] as $key2 => $value){
		    $jawaban = $value;
		    $cek = $this->db->query("SELECT * FROM quiz_essay WHERE id=$key2");
		    foreach ($cek->result_array() as $data) {
		    
		        $this->db->query("INSERT INTO jawaban_essay(topik_tugas_id,id_quiz_essay,siswa_id,jawaban)
		                                 VALUES('$_POST[id_topik]','$data[id]','$user->is_siswa','$jawaban')");

		    }

		    }

		}
		elseif (empty($_POST['soal_esay'])){
		    $this->db->query("INSERT INTO jawaban_essay(topik_tugas_id,id_quiz_essay,siswa_id,jawaban)
		                                 VALUES('$_POST[id_topik]','$data[id]','$user->is_siswa','')");
		}
			redirect(site_url('siswa/tugas'));
		}

		//jika soal hanya pilihan ganda
		if (!empty($pilganda) AND empty($esay)){
		    //jika ada inputan soal pilganda
		if(!empty($_POST['soal_pilganda'])){
		    $benar = 0;
		    $salah = 0;
		    foreach($_POST['soal_pilganda'] as $key => $value){
		    $cek = $this->db->query("SELECT * FROM quiz_pilganda WHERE id=$key");
		    // while($c = mysqli_fetch_array($cek)){
		    foreach ($cek->result_array() as $c) {
		        $jawaban = $c['kunci'];
		    }
		    if($value==$jawaban){
		        $benar++;
		    }else{
		        $salah++;
		    }
		}

		$jumlah = $_POST['jumlahsoalpilganda'];
		$tidakjawab = $jumlah - $benar - $salah;
		$persen = $benar / $jumlah;
		$hasil = $persen * 100;

		$this->db->query("INSERT INTO nilai (topik_tugas_id, siswa_id, benar, salah, tidak_dikerjakan,persentase)
		                           VALUES ('$_POST[id_topik]','$user->is_siswa','$benar','$salah','$tidakjawab','$hasil')");

		}elseif (empty($_POST['soal_pilganda'])){
		    $jumlah = $_POST['jumlahsoalpilganda'];
		    $this->db->query("INSERT INTO nilai (topik_tugas_id, siswa_id, benar, salah, tidak_dikerjakan,persentase)
		                           VALUES ('$_POST[id_topik]','$user->is_siswa','0','0','$jumlah','0')");
		}
				redirect(site_url('siswa/tugas'));
		}

		}
    }
}