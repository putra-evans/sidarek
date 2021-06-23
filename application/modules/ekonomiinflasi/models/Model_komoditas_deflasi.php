<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_komoditas_deflasi extends CI_Model
{
    protected $_publishDate = "";
    public function __construct()
    {
        parent::__construct();
    }

    public function validasiDataValue($role)
    {
        // $this->form_validation->set_rules('penyumbang_inflasi', 'Kosong', 'required');
        $this->form_validation->set_rules('komoditas', 'Komoditas Penyumbang', 'required');
        $this->form_validation->set_rules('inflasi', 'Inflasi', 'required');
        $this->form_validation->set_rules('andil', 'Andil', 'required');
        $this->form_validation->set_rules('monday_date', 'Bulan', 'required');

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
        $index = $_POST['start'] + 1;
        foreach ($dataProduk as $r) {
            $data[] = array(
                'index'                     => $index,
                'id_kom_inflasi'            => $r['id_kom_inflasi'],
                'id_jenis_komoditas'        => $r['id_jenis_komoditas'],
                'id_komoditas_penyumbang'   => $r['id_komoditas_penyumbang'],
                'inflasi_deflasi'           => $r['inflasi_deflasi'],
                'andil'                     => $r['andil'],
                'bulan'                     => $r['bulan'],
                'tipe'                      => $r['tipe'],
                'nama_komoditas_penyumbang' => $r['nama_komoditas_penyumbang'],
                'jenis_komoditas'           => $r['jenis_komoditas'],
                'action'                    => '<button type="button" class="btn btn-xs btn-primary btnEdit" data-id="' . $this->encryption->encrypt($r['id_kom_inflasi']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
                                            <button type="button" class="btn btn-xs btn-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_kom_inflasi']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'
            );
            $index++;
        }

        $result = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->db->count_all_results('ta_inflasi'),
            "recordsFiltered" => $this->db->count_all_results('ta_inflasi'),
            "data" => $data,
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

        $this->db->select('
                            a.id_kom_inflasi, 
                            a.inflasi_deflasi,
                            a.andil,
                            a.bulan,
                            a.tipe,
                            b.nama_komoditas_penyumbang,
                            b.id_komoditas_penyumbang,
                            c.jenis_komoditas,
                            c.id_jenis_komoditas,
        ');
        $this->db->from('ta_komoditas_penyumbang a');
        $this->db->join('ref_komoditas_penyumbang b',   'a.id_komoditas_penyumbang = b.id_komoditas_penyumbang', 'left');
        $this->db->join('ref_jenis_komoditas_penyumbang c', 'b.id_jenis_komoditas = c.id_jenis_komoditas', 'left');
        $this->db->where('a.tipe', 'deflasi');

        if (isset($post['jenis_komoditas']) and $post['jenis_komoditas'] != '') {
            $this->db->where('c.id_jenis_komoditas', $post['jenis_komoditas']);
        }
        if (isset($post['monday_date']) and $post['monday_date'] != '') {
            $this->db->where('a.bulan', $post['monday_date']);
        }

        $column_search = array('c.jenis_komoditas', 'b.nama_komoditas_penyumbang');

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

        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function ListKomdeflasiReport($jenis, $bulan)
    {
        $this->db->select('
                            a.id_kom_inflasi, 
                            a.inflasi_deflasi,
                            a.andil,
                            a.bulan,
                            a.tipe,
                            b.nama_komoditas_penyumbang,
                            b.id_komoditas_penyumbang,
                            c.jenis_komoditas,
                            c.id_jenis_komoditas,
');
        $this->db->from('ta_komoditas_penyumbang a');
        $this->db->join('ref_komoditas_penyumbang b',   'a.id_komoditas_penyumbang = b.id_komoditas_penyumbang', 'left');
        $this->db->join('ref_jenis_komoditas_penyumbang c', 'b.id_jenis_komoditas = c.id_jenis_komoditas', 'left');
        $this->db->where('a.tipe', 'deflasi');

        if ($jenis != '')
            $this->db->where('c.id_jenis_komoditas', $jenis);
        if ($bulan != '')
            $this->db->where('a.bulan', $bulan);

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
                'id_komoditas_penyumbang'     => $this->input->post('komoditas'),
                'inflasi_deflasi'             => $this->input->post('inflasi'),
                'andil'                       => $this->input->post('andil'),
                'bulan'                       => $this->input->post('monday_date'),
                'tipe'                        => 'deflasi',
            );

            $this->db->insert('ta_komoditas_penyumbang', $data);

            $result['success'] = 'YEAH';
            $result['status'] = true;
            $result['message'] = 'Data Berhasil Disimpan';
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


            $id = $this->input->post('id_kom_inflasi');
            $this->db->from('ta_komoditas_penyumbang', $id);
            $passed   = $this->db->where('id_kom_inflasi', $id);

            if ($passed) {

                $data = array(
                    'id_komoditas_penyumbang'   => $this->input->post('komoditas'),
                    'inflasi_deflasi'           => $this->input->post('inflasi'),
                    'andil'                     => $this->input->post('andil'),
                    'bulan'                     => $this->input->post('monday_date'),
                );

                $this->db->update('ta_komoditas_penyumbang', $data);

                $result['success'] = 'YEAH';
                $result['status'] = true;
                $result['message'] = 'Data Komoditas Inflasi Berhasil Disimpan';
            }
        } catch (\Exception $e) {
            $result['info'] = $e->getMessage();
        }

        return $result;
    }

    public function delete_data()
    {
        $id_kom_inflasi     = $this->encryption->decrypt($this->input->post('id_kom_inflasi', true));

        /*query delete*/
        $this->db->where('id_kom_inflasi', $id_kom_inflasi);
        $this->db->delete('ta_komoditas_penyumbang');
        return array('message' => 'SUCCESS');
    }

    public function input_data()
    {
        $pk = $this->input->post('pk');


        if (isset($pk['idinflasidetail'])) {
            $this->db->where('id_inflasi_detail', $pk['idinflasidetail']);
            $data = array('persen_inflasi' => $this->input->post('value'));
            $this->db->update('ta_inflasi_detail', $data);
        } else {
            $data = array(
                'id_inflasi'                => $pk['idinflasi'],
                'bulan_inflasi'             => $pk['bulan'],
                'persen_inflasi'            => $this->input->post('value')
            );

            $this->db->insert('ta_inflasi_detail', $data);
        }

        return array('message' => 'SUCCESS');
    }
}
