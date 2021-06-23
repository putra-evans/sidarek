<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_sektor extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{
		$this->form_validation->set_rules('nama_sektor', 'Nama Sektor', 'required');

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
				'index' 			=> $index,
				'id_sektor' 		=> $r['id_sektor'],
				'sektor' 		    => $r['sektor'],
				'action' 			=> '<button type="button" class="btn btn-xs btn-orange btnEdit" data-id="' . $this->encryption->encrypt($r['id_sektor']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
                                            <button type="button" class="btn btn-xs btn-success btnLook" data-id="' . $this->encryption->encrypt($r['id_sektor']) . '" title="Look Commodity">Lihat Komoditi </button>'
            );
            
            // <button type="button" class="btn btn-xs btn-primary btnView" data-id="' . $this->encryption->encrypt($r['id_sektor']) . '" title="View data"><i class="fa fa-search"></i> </button>
            // <button type="button" class="btn btn-xs btn-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_sektor']) . '" title="Delete data"><i class="fa fa-times"></i> </button>
			$index++;
        }
        
        $sektor = $this->db->get('ma_sektor');
		// Generate Select Options
        $options = '<option value="">-- Semua Komoditi --</option>';
		foreach ($sektor->result() as $key => $value) {
            $options .= "<option value=".$value->id_sektor.">".$value->nama."</option>";
        }

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ma_sektor'),
			"recordsFiltered" => $this->db->count_all_results('ma_sektor'),
            "data" => $data,
            "sektoroptions" => $options,
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
                            sektor.id_sektor, 
                            sektor.nama AS sektor');
		$this->db->from('ma_sektor sektor');

		if (isset($post['id_sektor']) and $post['id_sektor'] != '') {
			$this->db->where('sektor.id_sektor', $post['id_sektor']);
		}

		$column_search = array('sektor.nama');

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

	public function insert_data_sektor()
	{
		$result = [
			'status' => false,
			'success' => 'NOPE',
			'message' => null,
			'info' => null
		];

		try {

			$data = array(
				'nama'			=> $this->input->post('nama_sektor'),
			);

			$this->db->insert('ma_sektor', $data);

			$result['success'] = 'YEAH';
			$result['status'] = true;
			$result['message'] = 'Data Sektor Berhasil Disimpan';
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function update_data_sektor()
	{

		$result = [
			'status' => false,
			'success' => 'NOPE',
			'message' => null,
			'info' => null
		];

		try {
            
            $idSektor = $this->input->post('id_sektor');
			$produk   = $this->db->where('id_sektor', $idSektor);

			if ($produk) {

				$data = array(
                    'nama'			=> $this->input->post('nama_sektor'),
				);

				$this->db->update('ma_sektor', $data);

				$result['success'] = 'YEAH';
				$result['status'] = true;
				$result['message'] = 'Data Sektor Berhasil Disimpan';
			}
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function delete_data_sektor()
	{
		$idSektor     = $this->encryption->decrypt($this->input->post('idSektor', true));

		/*query delete*/
		$this->db->where('id_sektor', $idSektor);
		$this->db->delete('ma_sektor');

		return array('message' => 'SUCCESS');
	}

	
}
