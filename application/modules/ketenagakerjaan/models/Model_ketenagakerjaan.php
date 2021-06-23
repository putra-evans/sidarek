<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_ketenagakerjaan extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{

		$this->form_validation->set_rules('stt', 'Status Ketenagakerjaan', 'required');
		$this->form_validation->set_rules('monday_date', 'Bulan/Tahun', 'required');
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
			$data[] = array(
				'index' 					=> $index,
				'id_kerja' 					=> $r['id_kerja'],
				'id_status' 				=> $r['id_status'],
				'nama_status' 				=> $r['nama_status'],
				'bulan_kerja' 				=> $r['bulan_kerja'],
				'jumlah_kerja' 				=> $r['jumlah_kerja'],
				'action' 					=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_kerja']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_kerja']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ta_wisman'),
			"recordsFiltered" => $this->db->count_all_results('ta_wisman'),
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
							a.id_kerja,
							b.id_status,
							b.nama_status,
							a.bulan_kerja,
							a.jumlah_kerja,
		');
		$this->db->from('ta_ketenagakerjaan a');
		$this->db->join('ma_sttketenagakerjaan b', 'b.id_status = a.id_status', 'inner');

		if (isset($post['status']) and $post['status'] != '') {
			$this->db->where('b.id_status', $post['status']);
		}

		if (isset($post['monday_date']) and $post['monday_date'] != '') {
			$this->db->where('a.bulan_kerja', $post['monday_date']);
		}
		$column_search = array('a.bulan_kerja', 'b.nama_status');

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

	public function getDataList($status, $tahun)
	{
		$this->db->select('
							a.id_kerja,
							b.id_status,
							b.nama_status,
							a.bulan_kerja,
							a.jumlah_kerja,
		');
		$this->db->from('ta_ketenagakerjaan a');
		$this->db->join('ma_sttketenagakerjaan b', 'b.id_status = a.id_status', 'inner');

		if ($status != '')
			$this->db->where('b.id_status', $status);

		if ($tahun != '')
			$this->db->where('a.bulan_kerja', $tahun);

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
				'id_status'			=> $this->input->post('stt'),
				'bulan_kerja'		=> $this->input->post('monday_date'),
				'jumlah_kerja'		=> $this->input->post('jumlah'),

			);

			$this->db->insert('ta_ketenagakerjaan', $data);

			$result['success'] = 'YEAH';
			$result['status'] = true;
			$result['message'] = 'Data Ketenagakerjaan Berhasil Disimpan';
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

			$id_kerja = $this->input->post('id_kerja');
			$this->db->from('ta_ketenagakerjaan');
			$passed   = $this->db->where('id_kerja', $id_kerja);

			if ($passed) {

				$data = array(
					'id_status'			=> $this->input->post('stt'),
					'bulan_kerja'		=> $this->input->post('monday_date'),
					'jumlah_kerja'		=> $this->input->post('jumlah'),
				);

				$this->db->update('ta_ketenagakerjaan', $data);

				$result['success'] = 'YEAH';
				$result['status'] = true;
				$result['message'] = 'Data Ketenagakerjaan Berhasil Diubah';
			}
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function delete_data()
	{
		$id_kerja     = $this->encryption->decrypt($this->input->post('id_kerja', true));

		/*query delete*/
		$this->db->where('id_kerja', $id_kerja);
		$this->db->delete('ta_ketenagakerjaan');

		return array('message' => 'SUCCESS');
	}
}