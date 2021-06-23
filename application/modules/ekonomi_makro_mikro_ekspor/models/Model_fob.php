<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_fob extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{

		$this->form_validation->set_rules('id_sektor', 'Sektor', 'required');
		$this->form_validation->set_rules('monday_date', 'Bulan/Tahun', 'required');
		$this->form_validation->set_rules('nilaifob', 'Nilai FOB', 'required');


		validation_message_setting();
		if ($this->form_validation->run() == FALSE)
			return false;
		else
			return true;
	}

	public function process_datatables($param)
	{

		$draw = intval($this->input->get("draw"));

		$dataFob = $this->_get_datatables($param);

		// var_dump($data);
		// exit;

		$data = [];
		$index = 1;
		foreach ($dataFob as $r) {
			$data[] = array(
				'index' 					=> $index,
				'id_ekspor' 				=> $r['id_ekspor'],
				'id_sektor_ekspor' 			=> $r['id_sektor_ekspor'],
				'sektor_ekspor' 			=> $r['sektor_ekspor'],
				'bulan_ekspor' 				=> $r['bulan_ekspor'],
				'nilai_fob' 				=> $r['nilai_fob'],
				'action' 					=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_ekspor']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_ekspor']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ta_ekspor'),
			"recordsFiltered" => $this->db->count_all_results('ta_ekspor'),
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
							a.id_ekspor,
							b.id_sektor_ekspor,
							b.sektor_ekspor,
							a.bulan_ekspor,
							a.nilai_fob,
		');
		$this->db->from('ta_ekspor a');
		$this->db->join('ma_sektor_ekspor b', 'b.id_sektor_ekspor = a.id_sektor_ekspor', 'inner');

		if (isset($post['sektor']) and $post['sektor'] != '') {
			$this->db->where('b.id_sektor_ekspor', $post['sektor']);
		}

		if (isset($post['monday_date1']) and $post['monday_date1'] != '') {
			$this->db->where('a.bulan_ekspor', $post['monday_date1']);
		}

		$column_search = array('a.bulan_ekspor', 'b.sektor_ekspor');

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

	public function getDataList($sektor, $tahun)
	{
		$this->db->select('
							a.id_ekspor,
							b.id_sektor_ekspor,
							b.sektor_ekspor,
							a.bulan_ekspor,
							a.nilai_fob,
		');
		$this->db->from('ta_ekspor a');
		$this->db->join('ma_sektor_ekspor b', 'b.id_sektor_ekspor = a.id_sektor_ekspor', 'inner');

		if ($sektor != '')
			$this->db->where('b.id_sektor_ekspor', $sektor);

		if ($tahun != '')
			$this->db->where('a.bulan_ekspor', $tahun);

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
				'id_sektor_ekspor'			=> $this->input->post('id_sektor'),
				'bulan_ekspor'				=> $this->input->post('monday_date'),
				'nilai_fob'					=> $this->input->post('nilaifob'),

			);

			$this->db->insert('ta_ekspor', $data);

			$result['success'] = 'YEAH';
			$result['status'] = true;
			$result['message'] = 'Data Nilai FOB Berhasil Disimpan';
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

			$id_ekspor = $this->input->post('id_ekspor');
			$this->db->from('ta_ekspor');
			$passed   = $this->db->where('id_ekspor', $id_ekspor);

			if ($passed) {

				$data = array(
					'id_sektor_ekspor'			=> $this->input->post('id_sektor'),
					'bulan_ekspor'				=> $this->input->post('monday_date'),
					'nilai_fob'					=> $this->input->post('nilaifob'),
				);

				$this->db->update('ta_ekspor', $data);

				$result['success'] = 'YEAH';
				$result['status'] = true;
				$result['message'] = 'Data FOB Ekspor Berhasil Diubah';
			}
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function delete_data()
	{
		$id_ekspor     = $this->encryption->decrypt($this->input->post('id_ekspor', true));

		/*query delete*/
		$this->db->where('id_ekspor', $id_ekspor);
		$this->db->delete('ta_ekspor');

		return array('message' => 'SUCCESS');
	}
}
