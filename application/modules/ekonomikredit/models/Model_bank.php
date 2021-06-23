<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_bank extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{

		$this->form_validation->set_rules('id_perbankan', 'Nama Perusahaan', 'required');


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
				'id_kredit_perbankan'	 		=> $r['id_kredit_perbankan'],
				'id_perbankan' 					=> $r['id_perbankan'],
				'tahun' 						=> $r['tahun'],
				'akad' 							=> $r['akad'],
				'outstanding' 					=> $r['outstanding'],
				'debitur' 						=> $r['debitur'],
				'rerata' 						=> $r['rerata'],
				'bank_name' 					=> $r['bank_name'],
				'action' 						=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_kredit_perbankan']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_kredit_perbankan']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ta_kredit_perbankan'),
			"recordsFiltered" => $this->db->count_all_results('ta_kredit_perbankan'),
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
							kredit.id_kredit_perbankan,					
							kredit.id_perbankan,
							kredit.tahun,
							kredit.akad,
							kredit.outstanding,
							kredit.debitur,
							kredit.rerata,
							bank.nama as "bank_name"
		');
		$this->db->from('ta_kredit_perbankan kredit');
		$this->db->join('ref_perbankan bank', 'bank.id_perbankan = kredit.id_perbankan', 'left');


		if (isset($post['id_perbankan_filter']) and $post['id_perbankan_filter'] != '') {
			$this->db->where('kredit.id_perbankan', $post['id_perbankan_filter']);
		}

		if (isset($post['tahun_filter']) and $post['tahun_filter'] != '') {
			$this->db->where('kredit.tahun', $post['tahun_filter']);
		}

		$column_search = array('bank.nama');

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

	public function getDataListkreditbankReport($tahun, $bank)
	{
		$this->db->select('
							kredit.id_kredit_perbankan,					
							kredit.id_perbankan,
							kredit.tahun,
							kredit.akad,
							kredit.outstanding,
							kredit.debitur,
							kredit.rerata,
							bank.nama as "bank_name"
					');
		$this->db->from('ta_kredit_perbankan kredit');
		$this->db->join('ref_perbankan bank', 'bank.id_perbankan = kredit.id_perbankan', 'left');

		if ($bank != '')
			$this->db->where('kredit.id_perbankan', $bank);
		if ($tahun != '')
			$this->db->where('kredit.tahun', $tahun);

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
				'id_kredit_perbankan'		=> $this->input->post('id_kredit_perbankan'),
				'id_perbankan'				=> $this->input->post('id_perbankan'),
				'tahun'						=> $this->input->post('tahun'),
				'akad'						=> $this->input->post('akad'),
				'outstanding'				=> $this->input->post('outstanding'),
				'debitur'					=> $this->input->post('debitur'),
				'rerata'					=> $this->input->post('rerata'),
			);

			$this->db->insert('ta_kredit_perbankan', $data);

			$result['success'] = 'YEAH';
			$result['status'] = true;
			$result['message'] = 'Data Kredit per Bank Berhasil Disimpan';
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

			$idPass = $this->input->post('id_kredit_perbankan');
			$passed   = $this->db->where('id_kredit_perbankan', $idPass);

			if ($passed) {

				$data = array(
					'id_kredit_perbankan'		=> $this->input->post('id_kredit_perbankan'),
					'id_perbankan'				=> $this->input->post('id_perbankan'),
					'tahun'						=> $this->input->post('tahun'),
					'akad'						=> $this->input->post('akad'),
					'outstanding'				=> $this->input->post('outstanding'),
					'debitur'					=> $this->input->post('debitur'),
					'rerata'					=> $this->input->post('rerata'),
				);

				$this->db->update('ta_kredit_perbankan', $data);

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
		$itemID     = $this->encryption->decrypt($this->input->post('id_kredit_perbankan', true));

		/*query delete*/
		$this->db->where('id_kredit_perbankan', $itemID);
		$this->db->delete('ta_kredit_perbankan');

		return array('message' => 'SUCCESS');
	}
}
