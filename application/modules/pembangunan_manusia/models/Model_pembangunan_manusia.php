<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_pembangunan_manusia extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{

		$this->form_validation->set_rules('komponen', 'Komponen', 'required');
		$this->form_validation->set_rules('monday_date', 'Tahun', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required');


		validation_message_setting();
		if ($this->form_validation->run() == FALSE)
			return false;
		else
			return true;
	}

	public function process_datatables($param)
	{

		$draw = intval($this->input->get("draw"));

		$dataCIF = $this->_get_datatables($param);

		// var_dump($data);
		// exit;

		$data = [];
		$index = 1;
		foreach ($dataCIF as $r) {
			$komponen = $r['komponen'];
			if ($komponen == 'Pengeluaran per Kapita') {
				$status = "Rp.000";
			} else {
				$status = "Tahun";
			}
			$data[] = array(
				'index' 						=> $index,
				'id_pembangunan' 				=> $r['id_pembangunan'],
				'komponen' 						=> $r['komponen'],
				'status' 						=> $status,
				'tahun' 						=> $r['tahun'],
				'jumlah' 						=> $r['jumlah'],
				'action' 					=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_pembangunan']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_pembangunan']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ta_transportasi'),
			"recordsFiltered" => $this->db->count_all_results('ta_transportasi'),
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
							a.id_pembangunan,
							a.komponen,
							a.tahun,
							a.jumlah
		');
		$this->db->from('ta_pembangunan_manusia a');
		if (isset($post['monday_date']) and $post['monday_date'] != '') {
			$this->db->where('a.tahun', $post['monday_date']);
		}
		$column_search = array('a.komponen');

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
				'komponen'		=> $this->input->post('komponen'),
				'tahun'			=> $this->input->post('monday_date'),
				'jumlah'		=> $this->input->post('jumlah')

			);

			$this->db->insert('ta_pembangunan_manusia', $data);

			$result['success'] = 'YEAH';
			$result['status'] = true;
			$result['message'] = 'Data Pembangunan Manusia Berhasil Disimpan';
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

			$id_pembangunan = $this->input->post('id_pembangunan');
			$this->db->from('ta_pembangunan_manusia');
			$passed   = $this->db->where('id_pembangunan', $id_pembangunan);

			if ($passed) {

				$data = array(
					'komponen'		=> $this->input->post('komponen'),
					'tahun'			=> $this->input->post('monday_date'),
					'jumlah'		=> $this->input->post('jumlah')
				);

				$this->db->update('ta_pembangunan_manusia', $data);

				$result['success'] = 'YEAH';
				$result['status'] = true;
				$result['message'] = 'Data Pembangunan Manusia Berhasil Diubah';
			}
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function delete_data()
	{
		$id_pembangunan  = $this->encryption->decrypt($this->input->post('id_pembangunan', true));

		/*query delete*/
		$this->db->where('id_pembangunan', $id_pembangunan);
		$this->db->delete('ta_pembangunan_manusia');

		return array('message' => 'SUCCESS');
	}

	public function getDataList($tahun)
	{
		$this->db->select('
							a.id_pembangunan,
							a.komponen,
							a.tahun,
							a.jumlah
		');
		$this->db->from('ta_pembangunan_manusia a');

		if ($tahun != '')
			$this->db->where('a.tahun', $tahun);

		$query = $this->db->get();
		return $query->result_array();
	}
}
