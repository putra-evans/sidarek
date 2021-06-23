<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_lapanganusaha extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{

		$this->form_validation->set_rules('nama', 'Lapangan Usaha', 'required');


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
				'index' 			=> $index,
				'id_lapangan_usaha'	=> $r['id_lapangan_usaha'],
				'lapangan_usaha' 	=> $r['lapangan_usaha'],
				'action' 			=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_lapangan_usaha']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_lapangan_usaha']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ref_perusahaan'),
			"recordsFiltered" => $this->db->count_all_results('ref_perusahaan'),
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
							per.id_lapangan_usaha,					
							per.lapangan_usaha
		');
		$this->db->from('ma_lapangan_usaha per');

		if (isset($post['nama']) and $post['nama'] != '') {
			$this->db->where('per.lapangan_usaha', $post['nama']);
		}

		$column_search = array('per.lapangan_usaha');

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
				'lapangan_usaha'		=> $this->input->post('nama'),
			);

			$this->db->insert('ma_lapangan_usaha', $data);

			$result['success'] = 'YEAH';
			$result['status'] = true;
			$result['message'] = 'Data Lapangan Usaha Berhasil Disimpan';
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

			$id_lapangan_usaha 	= $this->input->post('id_lapangan_usaha');
			$perusahaan   		= $this->db->where('id_lapangan_usaha', $id_lapangan_usaha);

			if ($perusahaan) {

				$data = array(
					'lapangan_usaha'	=> $this->input->post('nama'),
				);

				$this->db->update('ma_lapangan_usaha', $data);

				$result['success'] = 'YEAH';
				$result['status'] = true;
				$result['message'] = 'Data Lapangan Usaha Berhasil Diubah';
			}
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function delete_data()
	{
		$itemID     = $this->encryption->decrypt($this->input->post('id_lapangan_usaha', true));

		/*query delete*/
		$this->db->where('id_lapangan_usaha', $itemID);
		$this->db->delete('ma_lapangan_usaha');

		return array('message' => 'SUCCESS');
	}
}
