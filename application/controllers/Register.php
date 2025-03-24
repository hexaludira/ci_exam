<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['datatables', 'form_validation']); // Load Library Ignited-Datatables
		$this->load->model('Master_model', 'master');
		$this->form_validation->set_error_delimiters('', '');
    }

    public function load_jurusan()
	{
		$data = $this->master->getJurusan();
		$this->output_json($data);
	}

    public function kelas_by_jurusan($id)
	{
		$data = $this->master->getKelasByJurusan($id);
		$this->output_json($data);
	}

    public function output_json($data, $encode = true)
	{
		if ($encode) $data = json_encode($data);
		$this->output->set_content_type('application/json')->set_output($data);
	}

	public function validasi_karyawan($method)
	{
		$this->input->post('id_mahasiswa',true);
		$nim 			= $this->input->post('nim', true);
		$email 			= $this->input->post('email', true);
		if ($method == 'add') {
			$u_nim = '|is_unique[mahasiswa.nim]';
			$u_email = '|is_unique[mahasiswa.email]';
		} else {
			$dbdata 	= $this->master->getMahasiswaById($id_mahasiswa);
			$u_nim		= $dbdata->nim === $nim ? "" : "|is_unique[mahasiswa.nim]";
			$u_email	= $dbdata->email === $email ? "" : "|is_unique[mahasiswa.email]";
		}
		$this->form_validation->set_rules('nim', 'NIK', 'required|numeric|trim|min_length[8]|max_length[12]' . $u_nim);
		$this->form_validation->set_rules('nama', 'Name', 'required|trim|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email' . $u_email);
		$this->form_validation->set_rules('jenis_kelamin', 'Gender', 'required');
		$this->form_validation->set_rules('jurusan', 'Dept.', 'required');
		$this->form_validation->set_rules('kelas', 'Class', 'required');

		$this->form_validation->set_message('required', 'Kolom {field} wajib diisi');
	}

	public function create_user($new_id)
	{
		// $id = $this->input->get('id', true);
		$id = $new_id;
		$data = $this->master->getMahasiswaById($id);
		$nama = explode(' ', $data->nama);
		$first_name = $nama[0];
		$last_name = end($nama);

		$username = $data->nim;
		$password = $data->nim;
		$email = $data->email;
		$additional_data = [
			'first_name'	=> $first_name,
			'last_name'		=> $last_name
		];
		$group = array('3'); // Sets user to dosen.

		if ($this->ion_auth->username_check($username)) {
			$data = [
				'status' => false,
				'msg'	 => 'Username not available (already used).'
			];
		} else if ($this->ion_auth->email_check($email)) {
			$data = [
				'status' => false,
				'msg'	 => 'Email is not available (already in use).'
			];
		} else {
			$this->ion_auth->register($username, $password, $email, $additional_data, $group);
			$data = [
				'status'	=> true,
				'msg'	 => 'User created successfully. NIK is used as a password at login.'
			];
		}
		$this->output_json($data);
	}

	public function save()
	{
		$method = $this->input->post('method',true);
		$this->validasi_karyawan($method);

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status'	=> false,
				'errors'	=> [
					'nim' => form_error('nim'),
					'nama' => form_error('nama'),
					'email' => form_error('email'),
					'jenis_kelamin' => form_error('jenis_kelamin'),
					'jurusan' => form_error('jurusan'),
					'kelas' => form_error('kelas'),
				]
			];
			$this->output_json($data);
		} else {
			$input = [
				'nim' 			=> $this->input->post('nim', true),
				'email' 		=> $this->input->post('email', true),
				'nama' 			=> $this->input->post('nama', true),
				'jenis_kelamin' => $this->input->post('jenis_kelamin', true),
				'kelas_id' 		=> $this->input->post('kelas', true),
			];
			if ($method === 'add') {
				$action = $this->master->create('mahasiswa', $input);
				$insert_id = $this->db->insert_id();
				if($insert_id != null){
					$activate_user = $this->create_user($insert_id);
					$this->output_json(['status' => true]);
				}
				
			} else if ($method === 'edit') {
				$id = $this->input->post('id_mahasiswa', true);
				$action = $this->master->update('mahasiswa', $input, 'id_mahasiswa', $id);
			}

			// if ($activate_user) {
			// 	$this->output_json(['status' => true]);
			// } else {
			// 	$this->output_json(['status' => false]);
			// }
			// if ($activate_user) {
			// 	$this->output_json(['status' => true]);
			// } else {
			// 	$this->output_json(['status' => false]);
			// }
		}
	}


	

}




?>