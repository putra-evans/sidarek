<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of OTG class
 *
 * @author Yuda Pramana
 */

class Komoditas_penyumbang extends SLP_Controller
{

    private $csrf;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Model_komoditas_penyumbang' => 'mkp'));
        $this->csrf = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );
    }

    public function index()
    {

        $this->breadcrumb->add('Dashboard', site_url('home'));
        $this->breadcrumb->add('Data Komoditas Penyumbang', '#');
        $this->session_info['page_name'] = "Data Komoditas Penyumbang";
        $this->session_info['jenis_komoditas'] = $this->mkp->getListJenis();
        $this->template->build('form_komoditas_penyumbang/list', $this->session_info);
    }

    public function listview()
    {

        // Get Session
        $session = $this->app_loader->current_account();

        if (!$this->input->is_ajax_request() || empty($session)) {
            exit('No direct script access allowed');
        } else {
            $param = $this->input->post('param', true);
            $resultDT = $this->mkp->process_datatables($param);
            $resultDT['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($resultDT));
        }
    }


    public function create()
    {

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {

            if ($this->mkp->validasiDataValue('new') == false) {
                $result = array('status' => 0, 'message' => $this->form_validation->error_array());
            } else {
                $result = $this->mkp->insert_data();
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
            $id_komoditas_penyumbang     = $this->encryption->decrypt($this->input->post('id_komoditas_penyumbang', true));
            if (!empty($session)) {
                $data = $this->mkp->delete_data();
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
            $result = $this->mkp->update_data();
            $result['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }


    public function fetch()
    {
        // Get Data from POST
        $komponen = $this->input->post('id_inflasi');

        $table = 'ta_inflasi_detail';

        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('id_inflasi', $komponen);
        $query = $this->db->get();
        $rArray = $query->result();

        $final = [];
        foreach ($rArray as $key => $value) {
            $final[$value->bulan_inflasi] = [
                'bulan_inflasi' => $value->bulan_inflasi,
                'persen_inflasi' => $value->persen_inflasi,
                'id_inflasi' => $value->id_inflasi,
                'id_inflasi_detail' => $value->id_inflasi_detail ? $value->id_inflasi_detail : null,
            ];
        }

        $data =  [
            'success' => true,
            'csrf' => $this->csrf,
            'data' => $final,
        ];

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function input()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {

            $result = $this->minflasi->input_data();
            $result['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function import_from_excel()
    {
        require_once APPPATH . 'third_party/php_excel/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
        // load excel
        // var_dump($_FILES);
        // exit;

        $file = $_FILES['excel_file']['tmp_name'];
        $load = PHPExcel_IOFactory::load($file);
        $sheets = $load->getActiveSheet()->toArray(null, true, true, true);
        $column =


            $tahun_inflasi = null;
        $id_tipe_inflasi = null;
        foreach ($sheets as $key => $sheet) {

            if ($key == 2) {
                // Get tahun_inflasi dan tipe
                $tahun_inflasi = $sheet['A'];
                $tipe = $sheet['B'];

                // Get Tipe from Database
                $resulttipe = $this->db->get_where('ref_tipe_inflasi', array('nama' => $tipe))->row();
                $id_tipe_inflasi = $resulttipe->id_tipe_inflasi;
            } elseif ($key > 3) {
                $daerah = $sheet['A'];
                $result_daerah = $this->db->get_where('ref_daerah_inflasi', array('nama' => $daerah))->row();

                if (!$result_daerah) {
                    break;
                }

                $id_daerah_inflasi = $result_daerah->id_daerah_inflasi;

                $condition = [
                    'tahun_inflasi'     => $tahun_inflasi,
                    'id_tipe_inflasi'      => $id_tipe_inflasi,
                    'id_daerah_inflasi'      => $id_daerah_inflasi
                ];

                $resultinflasi = $this->db->get_where('ta_inflasi', $condition)->row();
                if ($resultinflasi) {
                    $id_inflasi = $resultinflasi->id_inflasi;
                } else {
                    $resultinflasi = $this->db->insert('ta_inflasi', $condition);
                    $id_inflasi = $this->db->insert_id();
                }

                $months = range('B', 'M');
                $rinciandata = [];
                foreach ($months as $akey => $month) {

                    $array = array('id_inflasi' => $id_inflasi, 'bulan_inflasi' => $akey + 1);
                    $this->db->from('ta_inflasi_detail');
                    $this->db->where($array);
                    $inf = $this->db->get()->row();

                    if ($inf) {
                        $this->db->where($array);
                        $this->db->update('ta_inflasi_detail', ['persen_inflasi' => str_replace(',', '.', $sheet[$month])]);
                    } else {
                        $this->db->insert('ta_inflasi_detail', [
                            'id_inflasi' => $id_inflasi,
                            'bulan_inflasi' => $akey + 1,
                            'persen_inflasi' => str_replace(',', '.', $sheet[$month])
                        ]);
                    }
                }
            }
        }

        $data =  [
            'success' => true,
            'csrf' => $this->csrf,
        ];

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
}
