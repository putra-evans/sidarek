<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_wisman extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{

		$this->form_validation->set_rules('id_bangsa', 'Kebangsaan', 'required');
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
				'id_wisman' 					=> $r['id_wisman'],
				'id_bangsa' 				=> $r['id_bangsa'],
				'nama_bangsa' 			=> $r['nama_bangsa'],
				'bulan' 				=> $r['bulan_pariwisata'],
				'jumlah' 				=> $r['jumlah'],
				'action' 					=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_wisman']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_wisman']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

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
							a.id_wisman,
							b.id_bangsa,
							b.nama_bangsa,
							a.bulan_pariwisata,
							a.jumlah,
		');
		$this->db->from('ta_wisman a');
		$this->db->join('ma_pariwisata_bangsa b', 'b.id_bangsa = a.id_bangsa', 'inner');

		if (isset($post['bangsa']) and $post['bangsa'] != '') {
			$this->db->where('b.id_bangsa', $post['bangsa']);
		}

		if (isset($post['monday_date']) and $post['monday_date'] != '') {
			$this->db->where('a.bulan_pariwisata', $post['monday_date']);
		}

		$column_search = array('a.bulan_pariwisata', 'b.nama_bangsa');

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

	public function getDataList($bangsa, $tahun)
	{
		$this->db->select('
		a.id_wisman,
		b.id_bangsa,
		b.nama_bangsa,
		a.bulan_pariwisata,
		a.jumlah
			');
		$this->db->from('ta_wisman a');
		$this->db->join('ma_pariwisata_bangsa b', 'b.id_bangsa = a.id_bangsa', 'inner');

		if ($bangsa != '')
			$this->db->where('b.id_bangsa', $bangsa);

		if ($tahun != '')
			$this->db->where('a.bulan_pariwisata', $tahun);

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
				'id_bangsa'				=> $this->input->post('id_bangsa'),
				'bulan_pariwisata'		=> $this->input->post('monday_date'),
				'jumlah'				=> $this->input->post('jumlah'),

			);

			$this->db->insert('ta_wisman', $data);

			$result['success'] = 'YEAH';
			$result['status'] = true;
			$result['message'] = 'Data Wisatawan Mancanegara Berhasil Disimpan';
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

			$id_wisman = $this->input->post('id_wisman');
			$this->db->from('ta_wisman');
			$passed   = $this->db->where('id_wisman', $id_wisman);

			if ($passed) {

				$data = array(
					'id_bangsa'				=> $this->input->post('id_bangsa'),
					'bulan_pariwisata'				=> $this->input->post('monday_date'),
					'jumlah'					=> $this->input->post('jumlah'),
				);

				$this->db->update('ta_wisman', $data);

				$result['success'] = 'YEAH';
				$result['status'] = true;
				$result['message'] = 'Data Pariwisara Wisman Berhasil Diubah';
			}
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function delete_data()
	{
		$id_wisman     = $this->encryption->decrypt($this->input->post('id_wisman', true));

		/*query delete*/
		$this->db->where('id_wisman', $id_wisman);
		$this->db->delete('ta_wisman');

		return array('message' => 'SUCCESS');
	}
}
