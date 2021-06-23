<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_bangsa extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{

		$this->form_validation->set_rules('nama', 'Nama Kebangsaan', 'required');


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
				'id_bangsa'			=> $r['id_bangsa'],
				'nama_bangsa' 		=> $r['nama_bangsa'],
				'action' 			=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_bangsa']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_bangsa']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ma_pariwisata_bangsa'),
			"recordsFiltered" => $this->db->count_all_results('ma_pariwisata_bangsa'),
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
							a.id_bangsa,					
							a.nama_bangsa
		');
		$this->db->from('ma_pariwisata_bangsa a');

		// if (isset($post['nama']) and $post['nama'] != '') {
		// 	$this->db->where('a.nama_golongan', $post['nama']);
		// }

		$column_search = array('a.nama_bangsa');

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
				'nama_bangsa'		=> $this->input->post('nama'),
			);

			$this->db->insert('ma_pariwisata_bangsa', $data);

			$result['success'] = 'YEAH';
			$result['status'] = true;
			$result['message'] = 'Data Kebangsaan Berhasil Disimpan';
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

			$id_bangsa 	= $this->input->post('id_bangsa');
			$bangsa   	= $this->db->where('id_bangsa', $id_bangsa);

			if ($bangsa) {

				$data = array(
					'nama_bangsa'	=> $this->input->post('nama'),
				);

				$this->db->update('ma_pariwisata_bangsa', $data);

				$result['success'] = 'YEAH';
				$result['status'] = true;
				$result['message'] = 'Data Kebangsaan Pariwisata Berhasil Diubah';
			}
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function delete_data()
	{
		$id_bangsa     = $this->encryption->decrypt($this->input->post('id_bangsa', true));

		/*query delete*/
		$this->db->where('id_bangsa', $id_bangsa);
		$this->db->delete('ma_pariwisata_bangsa');

		return array('message' => 'SUCCESS');
	}
}
