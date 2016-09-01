<?php
set_time_limit(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Jakarta");
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('parser');
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$sesi = $this->session->all_userdata();
		if(isset($sesi['KEYTOKEN'])){
			redirect('/beranda','refresh');
		}else{
			$this->load->view('welcome');
		}
	}

	public function login()
	{
		if(empty($this->input->post('email')) || empty($this->input->post('password')))
		{
			$this->session->set_flashdata('alertTitle', 'Login Gagal.');
			$this->session->set_flashdata('alertType', 'danger');
			$this->session->set_flashdata('alert', 'Masukkan Belum Lengkap.');
			redirect('/');
		}

		else
		{
			$url = "https://www.lapor.go.id/index.php/api/lapor/verify";
			$tokendefault = "f8244f657702a1d9d3cdd7d43aa60bf8";
//			echo "Loggin In";
			$variable = "email=".$this->input->post('email')."&password=".$this->input->post('password');

			$out = $this->postCurl($url,$tokendefault,$variable);
	//		var_dump($out); return;
			if(isset($out["verify"])&&$out['verify']==1){ 
				$url = 'https://www.lapor.go.id/index.php/api/lapor/userprofile?id='.$out['user_id'];
				$profil = $this->getCurl($url,$out['KeyToken']);
				$profil = json_decode($profil);
				$loggedin = array(
					'firstname' => $out['firstname'],
					'level' => $out['level_id'],
					'lastname' => $out['lastname'],
					'user_id' => $out['user_id'],
					'KEYTOKEN' => $out['KeyToken'],
					'img' => $profil->hash_photo
					);
				$this->session->set_userdata($loggedin);
				redirect('/beranda', 'refresh');
			}
			else{
				if(isset($out["http_code"])&&$out["http_code"]==0){
					//echo "TEST";
					//echo $_POST['email'];
					$this->session->set_flashdata('alertTitle', 'Login Gagal.');
					$this->session->set_flashdata('alertType', 'danger');
					$this->session->set_flashdata('alert', 'Tidak Ada Koneksi Internet.');
				}else if($out["verify"]==0&&(isset($out["error"]["login"]) || isset($out['error']['password']) )){
					$this->session->set_flashdata('alertTitle', 'Login Gagal.');
					$this->session->set_flashdata('alertType', 'danger');
					$this->session->set_flashdata('alert', 'Masukkan Anda Salah.');
				}
				redirect('/');
			}
		}		
	}

	public function ceksesi(){
		$sesi = $this->session->all_userdata();
		print_r($sesi);
	}

	public function register($user)
	{	
		$sesi = $this->session->all_userdata();
		if(isset($sesi['KEYTOKEN'])){
			redirect('/beranda','refresh');
		}else{
			if($user=="pelapor"){
				$this->load->view('register');
			}else{
				$split = explode("&", $user);
				$failmsg = array(
					"email" => $split[0],
					"firstname" => $split[1],
					"lastname" => $split[2],
					"phone" => $split[3]
					);
				//print_r($split);
				$this->load->view('register',$failmsg);
			}
		}
		
	}

	public function sendregister()
	{

		$tokendefault = "f8244f657702a1d9d3cdd7d43aa60bf8";
		$this->load->view('register');
		$url = "https://www.lapor.go.id/index.php/api/lapor/register";
		if($this->input->post('password')!=($this->input->post('confirmpass'))){
			$this->session->set_flashdata('alertTitle', 'Register Gagal.');
			$this->session->set_flashdata('alertType', 'danger');
			$this->session->set_flashdata('alert', 'Password dan Confirm Password Tidak Sama.');
			$var = $this->input->post('email')."&".$this->input->post('firstname')."&".$this->input->post('lastname')."&".$this->input->post('phone');
			redirect('./daftar/'.$var);
		}
		$variable = "source=LaporLite&email=".$this->input->post('email')."&password=".$this->input->post('password')."&firstname=".$this->input->post('firstname')."&lastname=".$this->input->post('lastname')."&phone=".$this->input->post('phone');
		$result = $this->postCurl($url,$tokendefault,$variable);
		if($result['registration']==1){
			$this->session->set_flashdata('alertTitle', 'Registrasi Berhasil.');
			$this->session->set_flashdata('alertType', 'success');
			$this->session->set_flashdata('alert', $result['msg']);
			redirect('/');
		}else{
			print_r($result);
		}
	}

	public function ingatpasswordload()
	{
		$this->load->view('lupa_password');
	}

	public function ingatpassword()
	{
		$url = "https://www.lapor.go.id/index.php/api/lapor/forgot_password";
		$tokendefault = "f8244f657702a1d9d3cdd7d43aa60bf8";
		
		$variable = "email=".$this->input->post('email');
		$result = $this->postCurl($url,$tokendefault,$variable);
		
		//echo $variable;
		//print_r($result);

		if ($result['status']==1) {
			$this->session->set_flashdata('alertTitle', 'Berhasil.');
			$this->session->set_flashdata('alertType', 'success');
			$this->session->set_flashdata('alert', 'Mohon ikuti petunjuk instruksi selanjutnya yang telah kami kirimkan melalui email Anda.');
			redirect('./lupapasswordload');
		}else{
			$this->session->set_flashdata('alertTitle', 'Gagal.');
			$this->session->set_flashdata('alertType', 'danger');
			$this->session->set_flashdata('alert', $result['errors']);
		}		
	}

	public function logout($condition)
	{
		//echo $condition;

		$this->session->unset_userdata('firstname');
		$this->session->unset_userdata('lastname');
		$this->session->unset_userdata('KEYTOKEN');
		$this->session->unset_userdata('user_id');
		if($condition == 1){

			$this->session->set_flashdata('alertTitle', 'Logout');
			$this->session->set_flashdata('alertType', 'danger');
			$this->session->set_flashdata('alert', 'Berhasil.');

		} else if($condition == 2){
			
			$this->session->set_flashdata('alertTitle', 'TOKEN EXPIRED');
			$this->session->set_flashdata('alertType', 'danger');
			$this->session->set_flashdata('alert', 'Silahkan Login Kembali.');

		}	
		redirect('/');
	}

	function postCurl($url,$token,$variable){
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL,$url);
		//echo $url;
		if($token != null){
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'KEYTOKEN: '.$token
				)); 
		}
		//echo $token;
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$variable);
		//echo $variable;

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$out = curl_exec($ch);
		$info = curl_getinfo($ch);
		if($out === false)
		{
			//print_r($info);
			echo 'Curl error: ' . curl_error($ch);
			curl_close($ch);

			return $info;

		}else{

			$out = json_decode($out,true);

			curl_close ($ch);
			return $out;

		}
	}


	function getCurl($url,$token){
        // Get cURL resource
		$curl = curl_init();
        // Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
			CURLOPT_HTTPHEADER => array('KEYTOKEN: '.$token)
			));		
        // Send the request & save response to $resp
		$resp = curl_exec($curl);

		$info = curl_getinfo($curl);
    //print_r($info);
		if($resp === false){
			echo 'Curl error: ' . curl_error($curl);
			curl_close($curl);
			print_r($info);

			return $info;
		}else{
        // Close request to clear up some resources
			curl_close($curl);

			return $resp;
		}
	}
}
