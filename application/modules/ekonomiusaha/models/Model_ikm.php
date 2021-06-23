<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_ikm extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{

		$this->form_validation->set_rules('id_regency', 'Nama Perusahaan', 'required');


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
				'index' 						=> $index,
				'id_ikm'	 					=> $r['id_ikm'],
				'id_regency' 					=> $r['id_regency'],
				'tahun' 						=> $r['tahun'],
				'unit' 							=> $r['unit'],
				'tk' 							=> $r['tk'],
				'investasi' 					=> $r['investasi'],
				'produksi' 						=> $r['produksi'],
				'bahan_baku' 					=> $r['bahan_baku'],
				'regency_name' 					=> $r['regency_name'],
				'action' 						=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_ikm']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_ikm']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ta_ikm'),
			"recordsFiltered" => $this->db->count_all_results('ta_ikm'),
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
							ikm.id_ikm,					
							ikm.id_regency,
							ikm.tahun,
							ikm.unit,
							ikm.tk,
							ikm.investasi,
							ikm.produksi,
							ikm.bahan_baku,
							regency.name as "regency_name"
		');
		$this->db->from('ta_ikm ikm');
		$this->db->join('wa_regency regency', 'regency.id = ikm.id_regency', 'left');


		if (isset($post['id_regency_filter']) and $post['id_regency_filter'] != '') {
			$this->db->where('ikm.id_regency', $post['id_regency_filter']);
		}

		if (isset($post['tahun_filter']) and $post['tahun_filter'] != '') {
			$this->db->where('ikm.tahun', $post['tahun_filter']);
		}

		$column_search = array('regency.name');

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

	public function getDataListikmReport($tahun, $kabkota)
	{
		$this->db->select('
							ikm.id_ikm,					
							ikm.id_regency,
							ikm.tahun,
							ikm.unit,
							ikm.tk,
							ikm.investasi,
							ikm.produksi,
							ikm.bahan_baku,
							regency.name as "regency_name"
');
		$this->db->from('ta_ikm ikm');
		$this->db->join('wa_regency regency', 'regency.id = ikm.id_regency', 'left');

		if ($kabkota != '')
			$this->db->where('ikm.id_regency', $kabkota);
		if ($tahun != '')
			$this->db->where('ikm.tahun', $tahun);

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
				'id_regency'				=> $this->input->post('id_regency'),
				'tahun'						=> $this->input->post('tahun'),
				'unit'						=> $this->input->post('unit'),
				'tk'						=> $this->input->post('tk'),
				'investasi'					=> $this->input->post('investasi'),
				'produksi'					=> $this->input->post('produksi'),
				'bahan_baku'				=> $this->input->post('bahan_baku'),
			);

			$this->db->insert('ta_ikm', $data);

			$result['success'] = 'YEAH';
			$result['status'] = true;
			$result['message'] = 'Data IKM Berhasil Disimpan';
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

			$idPass = $this->input->post('id_ikm');
			$passed   = $this->db->where('id_ikm', $idPass);

			if ($passed) {

				$data = array(
					'id_regency'				=> $this->input->post('id_regency'),
					'tahun'						=> $this->input->post('tahun'),
					'unit'						=> $this->input->post('unit'),
					'tk'						=> $this->input->post('tk'),
					'investasi'					=> $this->input->post('investasi'),
					'produksi'					=> $this->input->post('produksi'),
					'bahan_baku'				=> $this->input->post('bahan_baku'),
				);

				$this->db->update('ta_ikm', $data);

				$result['success'] = 'YEAH';
				$result['status'] = true;
				$result['message'] = 'Data Perusahaan Berhasil Diubah';
			}
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function delete_data()
	{
		$itemID     = $this->encryption->decrypt($this->input->post('id_ikm', true));

		/*query delete*/
		$this->db->where('id_ikm', $itemID);
		$this->db->delete('ta_ikm');

		return array('message' => 'SUCCESS');
	}
}
