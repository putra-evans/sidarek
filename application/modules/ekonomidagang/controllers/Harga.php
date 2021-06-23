<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of OTG class
 *
 * @author Yuda Pramana
 */

class Harga extends SLP_Controller
{

    private $csrf;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_harga' => 'mharga'));
        $this->csrf = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );
    }

    public function index()
    {

        $this->breadcrumb->add('Dashboard', site_url('home'));
        $this->breadcrumb->add('Harga Bahan Pokok per Minggu', '#');

        $this->session_info['page_name'] = "Harga Bahan Pokok per Minggu";
        $this->session_info['komoditas'] = $this->getKomoditas();
        $this->session_info['kategori']  = json_encode($this->getKategoriKomoditas());
        $this->session_info['jenis']     = json_encode($this->getJenisKomoditas());
        $minggutahunes = array_combine(range(1,52), range(1,52));
        $this->session_info['minggu_tahunes']  = array("" => "Pilih Minggu") + $minggutahunes;
        $this->session_info['master']  = json_encode($this->getMasterBahanPokok());

        $this->session_info['minggu_tahun_filter']  = date('W')+0;
        $this->session_info['tahun_filter']  = date("Y");
        
        $this->template->build('form_harga/list', $this->session_info);
    }

    public function getMasterBahanPokok(){
        
        $this->db->select('
                            jenis.id_komoditas_jenis,
                            jenis.id_komoditas,
                            jenis.id_komoditas_kategori,
                            jenis.nama as "jenis_nama",
                            jenis.satuan as "jenis_satuan",
                            komoditas.nama as "komoditas_nama",
                            kategori.nama as "kategori_nama",
        ');

        $this->db->from('ma_komoditas_jenis     jenis');
        $this->db->join('ref_komoditas 		    komoditas', 'komoditas.id_komoditas = jenis.id_komoditas', 'left');
		$this->db->join('ma_komoditas_kategori 	kategori', 'kategori.id_komoditas_kategori = jenis.id_komoditas_kategori', 'left');
        
        $query = $this->db->get();
		return $query->result_array();
    }

    public function getKomoditas()
    {

        $query = $this->db->get("ref_komoditas");
        $data = [];
        $data[''] = '-- Pilih Komoditas --';
        foreach ($query->result() as $key => $value) {
            $data[$value->id_komoditas] = $value->nama;
        }

        return $data;
    }

    public function getKategoriKomoditas()
    {

        $query = $this->db->get("ma_komoditas_kategori");
        $data = [];
        $data[''] = '-- Pilih Kategori --';
        foreach ($query->result() as $key => $value) {
            $data[$value->id_komoditas_kategori] = [
                'id_komoditas' => $value->id_komoditas,
                'nama' => $value->nama,
            ];
        }

        return $data;
    }

    public function getJenisKomoditas()
    {

        $query = $this->db->get("ma_komoditas_jenis");
        $data = [];
        $data[''] = '-- Pilih Jenis --';
        foreach ($query->result() as $key => $value) {
            $data[$value->id_komoditas_jenis] = [
                'id_komoditas_kategori' => $value->id_komoditas_kategori,
                'id_komoditas' => $value->id_komoditas,
                'nama' => $value->nama,
                'satuan' => $value->satuan,
            ];
        }

        return $data;
    }

    public function listview()
    {

        // Get Session
        $session = $this->app_loader->current_account();

        if (!$this->input->is_ajax_request() || empty($session)) {
            exit('No direct script access allowed');
        } else {
            $param = $this->input->post('param', true);
            $resultDT = $this->mharga->process_datatables($param);
            $resultDT['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($resultDT));
        }
    }


    public function create()
    {

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {

            if ($this->mharga->validasiDataValue('new') == false) {
                $result = array('status' => 0, 'message' => $this->form_validation->error_array());
            } else {
                $result = $this->mharga->insert_data();
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
                $data = $this->mharga->delete_data();
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
            $result = $this->mharga->update_data();
            $result['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }


    public function input()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {

            $result = $this->mharga->input_data();
            $result['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }
}
