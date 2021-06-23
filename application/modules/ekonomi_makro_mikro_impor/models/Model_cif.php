<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_cif extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{

		$this->form_validation->set_rules('id_golongan', 'Golongan Barang', 'required');
		$this->form_validation->set_rules('monday_date', 'Bulan/Tahun', 'required');
		$this->form_validation->set_rules('nilaicif', 'Nilai CIF', 'required');


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
				'id_impor' 					=> $r['id_impor'],
				'id_golongan' 				=> $r['id_golongan'],
				'nama_golongan' 			=> $r['nama_golongan'],
				'bulan_impor' 				=> $r['bulan_impor'],
				'nilai_cif' 				=> $r['nilai_cif'],
				'action' 					=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_impor']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_impor']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ta_impor'),
			"recordsFiltered" => $this->db->count_all_results('ta_impor'),
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
							a.id_impor,
							b.id_golongan,
							b.nama_golongan,
							a.bulan_impor,
							a.nilai_cif,
		');
		$this->db->from('ta_impor a');
		$this->db->join('ma_golongan_impor b', 'b.id_golongan = a.id_golongan', 'inner');

		if (isset($post['golongan']) and $post['golongan'] != '') {
			$this->db->where('b.id_golongan', $post['golongan']);
		}

		if (isset($post['monday_date']) and $post['monday_date'] != '') {
			$this->db->where('a.bulan_impor', $post['monday_date']);
		}

		$column_search = array('a.bulan_impor', 'b.nama_golongan');

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

	public function getDataList($golongan, $tahun)
	{
		$this->db->select('
							a.id_impor,
							b.id_golongan,
							b.nama_golongan,
							a.bulan_impor,
							a.nilai_cif,
		');
		$this->db->from('ta_impor a');
		$this->db->join('ma_golongan_impor b', 'b.id_golongan = a.id_golongan', 'inner');

		if ($golongan != '')
			$this->db->where('b.id_golongan', $golongan);

		if ($tahun != '')
			$this->db->where('a.bulan_impor', $tahun);

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
				'id_golongan'			=> $this->input->post('id_golongan'),
				'bulan_impor'			=> $this->input->post('monday_date'),
				'nilai_cif'				=> $this->input->post('nilaicif'),

			);

			$this->db->insert('ta_impor', $data);

			$result['success'] = 'YEAH';
			$result['status'] = true;
			$result['message'] = 'Data Nilai CIF Berhasil Disimpan';
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

			$id_impor = $this->input->post('id_impor');
			$this->db->from('ta_impor');
			$passed   = $this->db->where('id_impor', $id_impor);

			if ($passed) {

				$data = array(
					'id_golongan'				=> $this->input->post('id_golongan'),
					'bulan_impor'				=> $this->input->post('monday_date'),
					'nilai_cif'					=> $this->input->post('nilaicif'),
				);

				$this->db->update('ta_impor', $data);

				$result['success'] = 'YEAH';
				$result['status'] = true;
				$result['message'] = 'Data CIF Impor Berhasil Diubah';
			}
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function delete_data()
	{
		$id_impor     = $this->encryption->decrypt($this->input->post('id_impor', true));

		/*query delete*/
		$this->db->where('id_impor', $id_impor);
		$this->db->delete('ta_impor');

		return array('message' => 'SUCCESS');
	}
}
