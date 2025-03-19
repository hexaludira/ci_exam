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
}




?>