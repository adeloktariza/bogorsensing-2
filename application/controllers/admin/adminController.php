<?php

class AdminController extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if ($this->session->userdata('username') == "") {
			redirect('login');
		}
		$this->load->helper('text');
		$this->load->model('model_register');
		$this->load->model('model_admin');
	}

	public function index() {
		$data['username'] = $this->session->userdata('username');
		$this->load->view('view_admin', $data);
	}

	public function page_register_admin() {
		$data['username'] = $this->session->userdata('username');
		$data['id_user'] = $this->session->userdata('id_user');

		$id = $this->session->userdata('id_user');

		$data['data_admin'] = $this->model_admin->get_admin($id);


		$this->load->view('view_admin_register', $data);
	}

	public function page_register_instansi() {
		$data['username'] = $this->session->userdata('username');
		$data['id_user'] = $this->session->userdata('id_user');

		$id = $this->session->userdata('id_user');

		$data['data_dinas'] = $this->model_admin->get_dinas();

		$this->load->view('view_instansi_register', $data);
	}

	public function page_kategori() 
    {
    	$data['username'] = $this->session->userdata('username');

    	$data['data_instansi'] = $this->model_admin->get_instansi();

    	$data['data_kategori'] = $this->model_admin->get_kategori();


        $this->load->view('view_admin_kategori',$data);
    }

	public function register_admin() {
		$data = array('username' => $this->input->post('addUsername', TRUE),
					  'password' => md5($this->input->post('addPassword', TRUE)),
					  'level'    => 0 
					 );


		$hasil = $this->model_register->add_user($data);


		$data2= array(
					  'nama' => $this->input->post('addName', TRUE),
					  'email' => $this->input->post('addEmail', TRUE),
					  'no_telpon' => $this->input->post('addNumber', TRUE),
					  'alamat' => $this->input->post('addAddress', TRUE),
					  'id_user' => $hasil
					 );

		$hasil2 = $this->model_register->add_admin($data2);

		redirect('admin/adminController/page_register_admin');

	}

	public function register_instansi() {
		$data = array('username' => $this->input->post('addUsername', TRUE),
					  'password' => md5($this->input->post('addPassword', TRUE)),
					  'level'    => 1 
					 );


		$hasil = $this->model_register->add_user($data);


		$data2= array(
					  'nama' => $this->input->post('addName', TRUE),
					  'email' => $this->input->post('addEmail', TRUE),
					  'no_telpon' => $this->input->post('addNumber', TRUE),
					  'alamat' => $this->input->post('addAddress', TRUE),
					  'id_user' => $hasil
					 );

		$hasil2 = $this->model_register->add_instansi($data2);

		redirect('admin/AdminController/page_register');

	}

	public function add_kategori() {
		$data = array('nama_kategori' => $this->input->post('addName', TRUE),
					  'id_instansi'   => $this->input->post('addKategori', TRUE)
					 );

		$hasil = $this->model_admin->add_kategori($data);

		redirect('admin/AdminController/page_kategori');

	}

	public function update_kategori() {

		$id= $this->uri->segment(4);
		
		$data = array('nama_kategori' => $this->input->post('addName', TRUE),
					  'id_instansi'   => $this->input->post('addKategori', TRUE)
					 );

		$hasil = $this->model_admin->update_kategori($data,$id);

		redirect('admin/AdminController/page_kategori');

	}

	public function delete_kategori() {

		$data= $this->uri->segment(4);
		
		$del = $this->model_admin->delete_kategori($data);

		redirect('admin/adminController/page_kategori');

	}

}
?>