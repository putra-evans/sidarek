<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of OTG class
 *
 * @author Yuda Pramana
 */

class DetailRealisasi extends SLP_Controller
{

    private $csrf;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_detail' => 'mdetail'));
        $this->csrf = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );
    }

    public function index()
    {
        $this->breadcrumb->add('Dashboard', site_url('home'));
        $this->breadcrumb->add('Master Subsidi', '#');

        $this->session_info['page_name'] = "Data Master: Ekonomi - Subsidi";
        $this->template->build('form_subsidi/list', $this->session_info);
    }

    public function listview()
    {

        // Get Session
        $session = $this->app_loader->current_account();

        if (!$this->input->is_ajax_request() || empty($session)) {
            exit('No direct script access allowed');
        } else {
            $param = $this->input->post('param', true);
            $resultDT = $this->mdetail->process_datatables($param);
            $resultDT['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($resultDT));
        }
    }


    public function create()
    {

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {

            if ($this->mdetail->validasiDataValue('new') == false) {
                $result = array('status' => 0, 'message' => $this->form_validation->error_array());
            } else {
                $result = $this->mdetail->insert_data();
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
                $data = $this->mdetail->delete_data();
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
            $result = $this->mdetail->update_data();
            $result['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function fetch()
    {
        // Get Data from POST
        $komponen = $this->input->post('id_subsidi_realisasi');

        $table = 'ta_subsidi_detail';

        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('id_subsidi_realisasi', $komponen);
        $query = $this->db->get();
        $rArray = $query->result();

        $final = [];
        foreach ($rArray as $key => $value) {
            $final[$value->bulan] = [
                'realisasi' => $value->realisasi,
                'id_subsidi_detail' => $value->id_subsidi_detail
            ];
        }

        $data =  [
            'success' => true,
            'csrf' => $this->csrf,
            'data' => $final,
        ];

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}
