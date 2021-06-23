<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_umkmb extends CI_Model
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
				'id_umkmb'	 					=> $r['id_umkmb'],
				'id_regency' 					=> $r['id_regency'],
				'tahun' 						=> $r['tahun'],
				'umk' 							=> $r['umk'],
				'umb' 							=> $r['umb'],
				'total_umkmb' 					=> $r['total_umkmb'],
				'tk_umk' 						=> $r['tk_umk'],
				'tk_umb' 						=> $r['tk_umb'],
				'total_tk' 						=> $r['total_tk'],
				'regency_name' 					=> $r['regency_name'],
				'action' 						=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_umkmb']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_umkmb']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ta_umkmb'),
			"recordsFiltered" => $this->db->count_all_results('ta_umkmb'),
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
							umkmb.id_umkmb,					
							umkmb.id_regency,
							umkmb.tahun,
							umkmb.umk,
							umkmb.umb,
							umkmb.total_umkmb,
							umkmb.tk_umk,
							umkmb.tk_umb,
							umkmb.total_tk,
							regency.name as "regency_name"
		');
		$this->db->from('ta_umkmb umkmb');
		$this->db->join('wa_regency regency', 'regency.id = umkmb.id_regency', 'left');


		if (isset($post['id_regency_filter']) and $post['id_regency_filter'] != '') {
			$this->db->where('umkmb.id_regency', $post['id_regency_filter']);
		}

		if (isset($post['tahun_filter']) and $post['tahun_filter'] != '') {
			$this->db->where('umkmb.tahun', $post['tahun_filter']);
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

	public function getDataListumkmbReport($tahun, $kabkota)
	{
		$this->db->select('
							umkmb.id_umkmb,					
							umkmb.id_regency,
							umkmb.tahun,
							umkmb.umk,
							umkmb.umb,
							umkmb.total_umkmb,
							umkmb.tk_umk,
							umkmb.tk_umb,
							umkmb.total_tk,
							regency.name as "regency_name"
					');
		$this->db->from('ta_umkmb umkmb');
		$this->db->join('wa_regency regency', 'regency.id = umkmb.id_regency', 'left');

		if ($kabkota != '')
			$this->db->where('umkmb.id_regency', $kabkota);
		if ($tahun != '')
			$this->db->where('umkmb.tahun', $tahun);

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

			$totalumkmb = $this->input->post('umk') + $this->input->post('umb');
			$total_tk = $this->input->post('tk_umk') + $this->input->post('tk_umb');
			$data = array(
				'id_regency'				=> $this->input->post('id_regency'),
				'tahun'						=> $this->input->post('tahun'),
				'umk'						=> $this->input->post('umk'),
				'umb'						=> $this->input->post('umb'),
				'total_umkmb'				=> $totalumkmb,
				'tk_umk'					=> $this->input->post('tk_umk'),
				'tk_umb'					=> $this->input->post('tk_umb'),
				'total_tk'					=> $total_tk
			);

			$this->db->insert('ta_umkmb', $data);

			$result['success'] = 'YEAH';
			$result['status'] = true;
			$result['message'] = 'Data UMKMB Berhasil Disimpan';
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

			$idPass = $this->input->post('id_umkmb');
			$passed   = $this->db->where('id_umkmb', $idPass);

			if ($passed) {

				$totalumkmb = $this->input->post('umk') + $this->input->post('umb');
				$total_tk = $this->input->post('tk_umk') + $this->input->post('tk_umb');

				$data = array(
					'id_regency'				=> $this->input->post('id_regency'),
					'tahun'						=> $this->input->post('tahun'),
					'umk'						=> $this->input->post('umk'),
					'umb'						=> $this->input->post('umb'),
					'total_umkmb'				=> $totalumkmb,
					'tk_umk'					=> $this->input->post('tk_umk'),
					'tk_umb'					=> $this->input->post('tk_umb'),
					'total_tk'					=> $total_tk
				);

				$this->db->update('ta_umkmb', $data);

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
		$itemID     = $this->encryption->decrypt($this->input->post('id_umkmb', true));

		/*query delete*/
		$this->db->where('id_umkmb', $itemID);
		$this->db->delete('ta_umkmb');

		return array('message' => 'SUCCESS');
	}
}
