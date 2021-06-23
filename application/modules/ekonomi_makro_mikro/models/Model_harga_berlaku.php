<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_harga_berlaku extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{

		$this->form_validation->set_rules('id_lapusaha', 'Lapangan Usaha', 'required');
		$this->form_validation->set_rules('triwulan', 'Triwulan', 'required');
		$this->form_validation->set_rules('tahun', 'Tahun', 'required');
		$this->form_validation->set_rules('harga_berlaku', 'Harga Berlaku', 'required');


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
				'index' 					=> $index,
				'id_pdrb' 					=> $r['id_pdrb'],
				'id_lapangan_usaha' 		=> $r['id_lapangan_usaha'],
				'triwulan' 					=> $r['triwulan'],
				'lapangan_usaha' 			=> $r['lapangan_usaha'],
				'jenis_pdrb' 			    => $r['jenis_pdrb'],
				'tahun_pdrb' 				=> $r['tahun_pdrb'],
				'harga_pdrb' 				=> $r['harga_pdrb'],
				'action' 					=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_pdrb']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_pdrb']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ta_csr'),
			"recordsFiltered" => $this->db->count_all_results('ta_csr'),
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
							a.id_pdrb,
							b.id_lapangan_usaha,
							b.lapangan_usaha,
							a.triwulan,
							a.jenis_pdrb,
							a.tahun_pdrb,
							a.harga_pdrb,
		');
		$this->db->from('ta_pdrb a');
		$this->db->join('ma_lapangan_usaha b', 'b.id_lapangan_usaha = a.id_lapangan_usaha', 'left');
		$this->db->where('a.jenis_pdrb', 'harga berlaku');

		if (isset($post['id_lapusaha_filter']) and $post['id_lapusaha_filter'] != '') {
			$this->db->where('b.id_lapangan_usaha', $post['id_lapusaha_filter']);
		}

		if (isset($post['tahun_filter']) and $post['tahun_filter'] != '') {
			$this->db->where('a.tahun_pdrb', $post['tahun_filter']);
		}

		$column_search = array('a.tahun_pdrb', 'b.lapangan_usaha');

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

	public function getDataList($lapangan, $tahun)
	{
		$this->db->select('
							a.id_pdrb,
							b.id_lapangan_usaha,
							b.lapangan_usaha,
							a.triwulan,
							a.jenis_pdrb,
							a.tahun_pdrb,
							a.harga_pdrb,
		');
		$this->db->from('ta_pdrb a');
		$this->db->join('ma_lapangan_usaha b', 'b.id_lapangan_usaha = a.id_lapangan_usaha', 'left');
		$this->db->where('a.jenis_pdrb', 'harga berlaku');

		if ($lapangan != '')
			$this->db->where('b.id_lapangan_usaha', $lapangan);

		if ($tahun != '')
			$this->db->where('a.tahun_pdrb', $tahun);

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
				'id_lapangan_usaha'				=> $this->input->post('id_lapusaha'),
				'triwulan'						=> $this->input->post('triwulan'),
				'tahun_pdrb'					=> $this->input->post('tahun'),
				'jenis_pdrb'					=> $this->input->post('jenis_pdrb'),
				'harga_pdrb'					=> $this->input->post('harga_berlaku'),

			);

			$this->db->insert('ta_pdrb', $data);

			$result['success'] = 'YEAH';
			$result['status'] = true;
			$result['message'] = 'Data Harga Berlaku Berhasil Disimpan';
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

			$id_pdrb = $this->input->post('id_pdrb');
			$this->db->from('ta_pdrb');
			$passed   = $this->db->where('id_pdrb', $id_pdrb);

			if ($passed) {

				$data = array(
					'id_lapangan_usaha'				=> $this->input->post('id_lapusaha'),
					'triwulan'						=> $this->input->post('triwulan'),
					'tahun_pdrb'					=> $this->input->post('tahun'),
					'harga_pdrb'					=> $this->input->post('harga_berlaku'),
				);

				$this->db->update('ta_pdrb', $data);

				$result['success'] = 'YEAH';
				$result['status'] = true;
				$result['message'] = 'Data Harga Berlaku Berhasil Diubah';
			}
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function delete_data()
	{
		$id_pdrb     = $this->encryption->decrypt($this->input->post('id_pdrb', true));

		/*query delete*/
		$this->db->where('id_pdrb', $id_pdrb);
		$this->db->delete('ta_pdrb');

		return array('message' => 'SUCCESS');
	}
}
