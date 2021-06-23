<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_sektor extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{

		$this->form_validation->set_rules('id_sektor_ekonomi', 'Nama Perusahaan', 'required');


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
				'id_kredit_persektor'	 		=> $r['id_kredit_persektor'],
				'id_sektor_ekonomi' 			=> $r['id_sektor_ekonomi'],
				'tahun' 						=> $r['tahun'],
				'akad' 							=> $r['akad'],
				'outstanding' 					=> $r['outstanding'],
				'debitur' 						=> $r['debitur'],
				'rerata' 						=> $r['rerata'],
				'sektor_name' 					=> $r['sektor_name'],
				'action' 						=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_kredit_persektor']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_kredit_persektor']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ta_kredit_persektor'),
			"recordsFiltered" => $this->db->count_all_results('ta_kredit_persektor'),
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
							kredit.id_kredit_persektor,					
							kredit.id_sektor_ekonomi,
							kredit.tahun,
							kredit.akad,
							kredit.outstanding,
							kredit.debitur,
							kredit.rerata,
							sektor.nama as "sektor_name"
		');
		$this->db->from('ta_kredit_persektor kredit');
		$this->db->join('ref_sektor_ekonomi sektor', 'sektor.id_sektor_ekonomi = kredit.id_sektor_ekonomi', 'left');


		if (isset($post['id_sektor_ekonomi_filter']) and $post['id_sektor_ekonomi_filter'] != '') {
			$this->db->where('kredit.id_sektor_ekonomi', $post['id_sektor_ekonomi_filter']);
		}

		if (isset($post['tahun_filter']) and $post['tahun_filter'] != '') {
			$this->db->where('kredit.tahun', $post['tahun_filter']);
		}

		$column_search = array('kredit.id_sektor_ekonomi');

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

	public function getDataListkreditsektorReport($tahun, $sektor)
	{
		$this->db->select('
							kredit.id_kredit_persektor,					
							kredit.id_sektor_ekonomi,
							kredit.tahun,
							kredit.akad,
							kredit.outstanding,
							kredit.debitur,
							kredit.rerata,
							sektor.nama as "sektor_name"
					');
		$this->db->from('ta_kredit_persektor kredit');
		$this->db->join('ref_sektor_ekonomi sektor', 'sektor.id_sektor_ekonomi = kredit.id_sektor_ekonomi', 'left');

		if ($sektor != '')
			$this->db->where('kredit.id_sektor_ekonomi', $sektor);
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
				'id_kredit_persektor'		=> $this->input->post('id_kredit_persektor'),
				'id_sektor_ekonomi'			=> $this->input->post('id_sektor_ekonomi'),
				'tahun'						=> $this->input->post('tahun'),
				'akad'						=> $this->input->post('akad'),
				'outstanding'				=> $this->input->post('outstanding'),
				'debitur'					=> $this->input->post('debitur'),
				'rerata'					=> $this->input->post('rerata'),
			);

			$this->db->insert('ta_kredit_persektor', $data);

			$result['success'] = 'YEAH';
			$result['status'] = true;
			$result['message'] = 'Data Subsidi Berhasil Disimpan';
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

			$idPass 	= $this->input->post('id_kredit_persektor');
			$passed 	= $this->db->where('id_kredit_persektor', $idPass);

			if ($passed) {

				$data = array(
					'id_kredit_persektor'		=> $this->input->post('id_kredit_persektor'),
					'id_sektor_ekonomi'			=> $this->input->post('id_sektor_ekonomi'),
					'tahun'						=> $this->input->post('tahun'),
					'akad'						=> $this->input->post('akad'),
					'outstanding'				=> $this->input->post('outstanding'),
					'debitur'					=> $this->input->post('debitur'),
					'rerata'					=> $this->input->post('rerata'),
				);

				$this->db->update('ta_kredit_persektor', $data);

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
		$itemID     = $this->encryption->decrypt($this->input->post('id_kredit_persektor', true));

		/*query delete*/
		$this->db->where('id_kredit_persektor', $itemID);
		$this->db->delete('ta_kredit_persektor');

		return array('message' => 'SUCCESS');
	}
}