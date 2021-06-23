<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of OTG class
 *
 * @author Yuda Pramana
 */

class Sektor extends SLP_Controller
{

    private $csrf;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_sektor' => 'ms'));
        $this->load->model(array('model_komoditi' => 'mk'));
        $this->csrf = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );
    }

    public function index()
    {
        $this->breadcrumb->add('Dashboard', site_url('home'));
        $this->breadcrumb->add('Master Sektor dan Komoditi', '#');

        $this->session_info['page_name'] = "Master Sektor dan Komoditi";
        $this->template->build('form_sektor/list', $this->session_info);
    }

    public function listview()
    {
        // Get Session
        $session = $this->app_loader->current_account();

        if (!$this->input->is_ajax_request() || empty($session)) {
            exit('No direct script access allowed');
        } else {
            $param = $this->input->post('param', true);
            $resultDT = $this->ms->process_datatables($param);
            $resultDT['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($resultDT));
        }
    }


    public function create()
    {

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {

            if ($this->ms->validasiDataValue('new') == false) {
                $result = array('status' => 0, 'message' => $this->form_validation->error_array());
            } else {
                $result = $this->ms->insert_data_sektor();
            }

            $result['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
       
    }

    public function delete(){

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session   = $this->app_loader->current_account();
            $produkId     = $this->encryption->decrypt($this->input->post('produkId', true));
            if (!empty($session)) {
                $data = $this->ms->delete_data_produksi();
                if ($data['message'] == 'SUCCESS') {
                    $result = array('status' => 1, 'message' => 'Data produksi SDA berhasil dihapus...', 'csrf' => $this->csrf);
                } else {
                    $result = array('status' => 0, 'message' => 'Proses delete data gagal, silahkan periksa kembali data yang akan dihapus...', 'csrf' => $this->csrf);
                }
            } else {
                $result = array('status' => 0, 'message' => 'Proses delete data gagal...', 'csrf' => $this->csrf);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function update() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $result = $this->ms->update_data_sektor();
            $result['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function fetch() {

        // Get Session
        $session = $this->app_loader->current_account();

        if (!$this->input->is_ajax_request() || empty($session)) {
            exit('No direct script access allowed');
        } else {
            $param = $this->input->post('param', true);
            $idsektor = $this->input->post('idsektor', true);
            $resultDT = $this->mk->process_datatables($param, $idsektor);
            $resultDT['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($resultDT));
        }

    }
}
