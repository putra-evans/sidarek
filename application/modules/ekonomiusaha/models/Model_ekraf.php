<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_ekraf extends CI_Model
{
    protected $_publishDate = "";
    public function __construct()
    {
        parent::__construct();
    }

    public function validasiDataValue($role)
    {

        $this->form_validation->set_rules('id_regency', 'Nama Perusahaan', 'required');


        validation_message_setting();
        if ($this->form_validation->run() == FALSE)
            return false;
        else
            return true;
    }

    public function process_datatables($param)
    {

        $draw = intval($this->input->get("draw"));

        $dataProduk = $this->_get_datatables($param);

        $data = [];
        $index = 1;
        foreach ($dataProduk as $r) {
            $data[] = array(
                'index'                       => $index,
                'id_ekraf'                    => $r['id_ekraf'],
                'usaha_owner'                 => $r['usaha_owner'],
                'usaha_nama'                  => $r['usaha_nama'],
                'id_jenis_ekraf'              => $r['id_jenis_ekraf'],
                'alamat_jalan'                => $r['alamat_jalan'],
                'alamat_nomor'                => $r['alamat_nomor'],
                'alamat_rt_rw'                => $r['alamat_rt_rw'],
                'id_regency'                  => $r['id_regency'],
                'id_district'                 => $r['id_district'],
                'id_village'                  => $r['id_village'],
                'kode_pos'                    => $r['kode_pos'],
                'no_hp'                       => $r['no_hp'],
                'usaha_umur'                  => $r['usaha_umur'],
                'regency_name'                => $r['regency_name'],
                'district_name'               => $r['district_name'],
                'village_name'                => $r['village_name'],
                'jenis_ekraf'                 => $r['jenis_ekraf'],
                'action'                      => '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_ekraf']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_ekraf']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

            );
            $index++;
        }

        $result = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->db->count_all_results('ma_ekraf'),
            "recordsFiltered" => $this->db->count_all_results('ma_ekraf'),
            "data" => $data
        );

        return $result;
    }

    public function _get_datatables($param)
    {

        $post = array();
        if (is_array($param)) {
            foreach ($param as $v) {
                $post[$v['name']] = $v['value'];
            }
        }

        // Query Filter
        $this->db->select('
							ekraf.id_ekraf,					
							ekraf.usaha_owner,
							ekraf.usaha_nama,
							ekraf.no_hp,
							ekraf.id_jenis_ekraf,
							ekraf.alamat_jalan,
							ekraf.alamat_nomor,
							ekraf.alamat_rt_rw,
							ekraf.id_regency,
							ekraf.id_district,
							ekraf.id_village,
							ekraf.kode_pos,
							ekraf.usaha_umur,
							regency.name as "regency_name",
							district.name as "district_name",
                            village.name as "village_name",
                            jenis.nama as "jenis_ekraf"
		');
        $this->db->from('ma_ekraf ekraf');
        $this->db->join('wa_regency regency', 'regency.id = ekraf.id_regency', 'left');
        $this->db->join('wa_district district', 'district.id = ekraf.id_district', 'left');
        $this->db->join('wa_village village', 'village.id = ekraf.id_village', 'left');
        $this->db->join('ref_jenis_ekraf jenis', 'jenis.id_jenis_ekraf = ekraf.id_jenis_ekraf', 'left');


        if (isset($post['id_regency_filter']) and $post['id_regency_filter'] != '') {
            $this->db->where('ekraf.id_regency', $post['id_regency_filter']);
        }

        if (isset($post['jenis_ekraf']) and $post['jenis_ekraf'] != '') {
            $this->db->where('ekraf.id_jenis_ekraf', $post['jenis_ekraf']);
        }

        $column_search = array('regency.name');

        $i = 0;

        foreach ($column_search as $item) { // loop column
            if (isset($_POST['search']['value'])) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($column_search) - 1 == $i) { //last loop
                    $this->db->group_end();
                } //close bracket
            }
            $i++;
        }
        // End of Query Filter

        // Dont know
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getDataListekrafReport($jenis, $kabkota)
    {
        $this->db->select('
                            ekraf.id_ekraf,					
                            ekraf.usaha_owner,
                            ekraf.usaha_nama,
                            ekraf.no_hp,
                            ekraf.id_jenis_ekraf,
                            ekraf.alamat_jalan,
                            ekraf.alamat_nomor,
                            ekraf.alamat_rt_rw,
                            ekraf.id_regency,
                            ekraf.id_district,
                            ekraf.id_village,
                            ekraf.kode_pos,
                            ekraf.usaha_umur,
                            regency.name as "regency_name",
                            district.name as "district_name",
                            village.name as "village_name",
                            jenis.nama as "jenis_ekraf"
');
        $this->db->from('ma_ekraf ekraf');
        $this->db->join('wa_regency regency', 'regency.id = ekraf.id_regency', 'left');
        $this->db->join('wa_district district', 'district.id = ekraf.id_district', 'left');
        $this->db->join('wa_village village', 'village.id = ekraf.id_village', 'left');
        $this->db->join('ref_jenis_ekraf jenis', 'jenis.id_jenis_ekraf = ekraf.id_jenis_ekraf', 'left');

        if ($kabkota != '')
            $this->db->where('ekraf.id_regency', $kabkota);
        if ($jenis != '')
            $this->db->where('ekraf.id_jenis_ekraf', $jenis);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_data()
    {
        $result = [
            'status' => false,
            'success' => 'NOPE',
            'message' => null,
            'info' => null
        ];

        try {

            $data = array(
                'usaha_owner'            => $this->input->post('usaha_owner'),
                'usaha_nama'            => $this->input->post('usaha_nama'),
                'id_jenis_ekraf'        => $this->input->post('id_jenis_ekraf'),
                'no_hp'                   => $this->input->post('no_hp'),
                'alamat_jalan'            => $this->input->post('alamat_jalan'),
                'alamat_nomor'            => $this->input->post('alamat_nomor'),
                'alamat_rt_rw'            => $this->input->post('alamat_rt_rw'),
                'id_regency'            => $this->input->post('id_regency'),
                'id_district'            => $this->input->post('id_district'),
                'id_village'            => $this->input->post('id_village'),
                'kode_pos'                => $this->input->post('kode_pos'),
                'usaha_umur'            => $this->input->post('usaha_umur'),
            );

            $this->db->insert('ma_ekraf', $data);

            $result['success'] = 'YEAH';
            $result['status'] = true;
            $result['message'] = 'Data Subsidi Berhasil Disimpan';
        } catch (\Exception $e) {
            $result['info'] = $e->getMessage();
        }

        return $result;
    }

    public function update_data()
    {

        $result = [
            'status' => false,
            'success' => 'NOPE',
            'message' => null,
            'info' => null
        ];

        try {

            $idPass = $this->input->post('id_ekraf');
            $passed   = $this->db->where('id_ekraf', $idPass);

            if ($passed) {

                $data = array(
                    'usaha_owner'            => $this->input->post('usaha_owner'),
                    'usaha_nama'            => $this->input->post('usaha_nama'),
                    'no_hp'            => $this->input->post('no_hp'),
                    'id_jenis_ekraf'        => $this->input->post('id_jenis_ekraf'),
                    'alamat_jalan'            => $this->input->post('alamat_jalan'),
                    'alamat_nomor'            => $this->input->post('alamat_nomor'),
                    'alamat_rt_rw'            => $this->input->post('alamat_rt_rw'),
                    'id_regency'            => $this->input->post('id_regency'),
                    'id_district'            => $this->input->post('id_district'),
                    'id_village'            => $this->input->post('id_village'),
                    'kode_pos'                => $this->input->post('kode_pos'),
                    'usaha_umur'            => $this->input->post('usaha_umur'),
                );

                $this->db->update('ma_ekraf', $data);

                $result['success'] = 'YEAH';
                $result['status'] = true;
                $result['message'] = 'Data Perusahaan Berhasil Diubah';
            }
        } catch (\Exception $e) {
            $result['info'] = $e->getMessage();
        }

        return $result;
    }

    public function delete_data()
    {
        $itemID     = $this->encryption->decrypt($this->input->post('id_ekraf', true));

        /*query delete*/
        $this->db->where('id_ekraf', $itemID);
        $this->db->delete('ma_ekraf');

        return array('message' => 'SUCCESS');
    }

    public function getDataDistrictByRegency($id)
    {
        $this->db->where('regency_id', $id);
        $this->db->order_by('id ASC');
        $query = $this->db->get('wa_district');
        return $query->result_array();
    }

    public function getDataVillageByDistrict($id)
    {
        $this->db->where('district_id', $id);
        $this->db->order_by('id ASC');
        $query = $this->db->get('wa_village');
        return $query->result_array();
    }
}
