<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of OTG class
 *
 * @author Yuda Pramana
 */

class Peragaankabkota extends SLP_Controller
{

    private $csrf;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_kabkota' => 'mkabkota'));
        $this->csrf = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );
    }

    public function index()
    {

        $this->breadcrumb->add('Dashboard', site_url('home'));
        $this->breadcrumb->add('Rincian Koperasi per Kab / Kota', '#');

        $this->session_info['page_name'] = "Rincian Peragaan Koperasi per Kab / Kota";
        $this->session_info['regency'] = $this->getRegency();

        $this->template->build('form_kabkota/list', $this->session_info);
    }

    public function getRegency()
    {
        $this->db->where('province_id', 13);

        $query = $this->db->get("wa_regency");
        $data = [];
        $data[''] = '-- Semua Kab / Kota --';
        foreach ($query->result() as $key => $value) {
            $data[$value->id] = $value->name;
        }

        return $data;
    }

    public function listview()
    {
        $tahun         = urldecode($this->uri->segment(4, 0));
        $tahun = $tahun != 0 ? $tahun : null;

        // Get Session
        $session = $this->app_loader->current_account();

        if (!$this->input->is_ajax_request() || empty($session)) {
            exit('No direct script access allowed');
        } else {
            $param = $this->input->post('param', true);
            $resultDT = $this->mkabkota->process_datatables($param, $tahun);
            $resultDT['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($resultDT));
        }
    }


    public function create()
    {

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {

            if ($this->mkabkota->validasiDataValue('new') == false) {
                $result = array('status' => 0, 'message' => $this->form_validation->error_array());
            } else {
                $result = $this->mkabkota->insert_data();
            }

            $result['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function delete()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session   = $this->app_loader->current_account();
            $produkId     = $this->encryption->decrypt($this->input->post('produkId', true));
            if (!empty($session)) {
                $data = $this->mkabkota->delete_data();
                if ($data['message'] == 'SUCCESS') {
                    $result = array('status' => 1, 'message' => 'Data kebijakan berhasil dihapus...', 'csrf' => $this->csrf);
                } else {
                    $result = array('status' => 0, 'message' => 'Proses delete data kebijakan gagal, silahkan periksa kembali data yang akan dihapus...', 'csrf' => $this->csrf);
                }
            } else {
                $result = array('status' => 0, 'message' => 'Proses delete data gagal...', 'csrf' => $this->csrf);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function update()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $result = $this->mkabkota->update_data();
            $result['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function tahun()
    {
        $tahun         = urldecode($this->uri->segment(4, 0));

        $data     = urldecode($this->uri->segment(5, 0));

        if (!isset($tahun)) {
            redirect('ekonomikoperasi/peragaankabkota');
        } else {
            if ($data == 0) {
                $this->generateForm($tahun);
            } else {
                $this->listview($tahun);
            }
        }
    }

    private function generateForm($tahun)
    {
        $this->breadcrumb->add('Dashboard', site_url('home'));
        $this->breadcrumb->add('Rincian Koperasi per Kab-Kota', site_url('ekonomikoperasi/peragaankabkota'));
        $this->breadcrumb->add('Tahun ' . $tahun, '#');

        $this->session_info['page_name'] = "Rincian Peragaan Koperasi per Kab / Kota";
        $this->session_info['regency'] = $this->getRegency();
        $this->session_info['tahun'] = $tahun;

        $this->template->build('form_kabkota/list', $this->session_info);
    }
}
