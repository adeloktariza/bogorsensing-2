<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('model_user');
 
	}

	public function index() {
		$this->load->view('view_login_user');
	}

	public function cek_login() {
		$data = array('username' => $this->input->post('username', TRUE),
					  'password' => md5($this->input->post('password', TRUE)));

		$hasil = $this->model_user->cek_user($data);

		if ($hasil->num_rows() == 1) 
		{
			foreach ($hasil->result() as $sess) {
				
				$sess_data['id_user'] = $sess->id_user;
				$sess_data['username'] = $sess->username;
				$sess_data['level'] = $sess->level;
				$this->session->set_userdata($sess_data);

				// echo $sess_data['username'];


			}
			
			if ($this->session->userdata('level') == 2) {
				redirect('user/userController');
			}
			elseif ($this->session->userdata('level') == 1) {
				redirect('home');
			}
			elseif ($this->session->userdata('level') == 0) {
				redirect('home');
			}		
		}
		else {
			echo "Gagal Masuk !!!";
		}
	}

}

?>