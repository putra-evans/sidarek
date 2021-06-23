<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_kemiskinan extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{
		$this->form_validation->set_rules('daerah', 'Daerah', 'required');
		$this->form_validation->set_rules('monday_date', 'Bulan/Tahun', 'required');
		$this->form_validation->set_rules('jumlah_pdd', 'Jumlah Penduduk', 'required');

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
		$index = $_POST['start'] + 1;
		foreach ($dataProduk as $r) {
			$data[] = array(
				'index' 			=> $index,
				'id_kemiskinan' 	=> $r['id_kemiskinan'],
				'tipe_daerah' 		=> $r['tipe_daerah'],
				'bulan_kemiskinan' 	=> $r['bulan_kemiskinan'],
				'jumlah_kemiskinan' => $r['jumlah_kemiskinan'],
				'action' 					=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_kemiskinan']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_kemiskinan']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'
			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ta_kemiskinan'),
			"recordsFiltered" => $this->db->count_all_results('ta_kemiskinan'),
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

		$this->db->select('
                            a.id_kemiskinan, 
                            a.tipe_daerah,
							a.bulan_kemiskinan,
							a.jumlah_kemiskinan');
		$this->db->from('ta_kemiskinan a');
		$this->db->where('a.tipe_daerah', 'Perkotaan');
		$this->db->order_by('a.id_kemiskinan', 'DESC');

		$column_search = array('a.tipe_daerah', 'a.bulan_kemiskinan');

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

	public function process_datatables1($param)
	{

		$draw = intval($this->input->get("draw"));

		$dataProduk = $this->_get_datatables1($param);

		$data = [];
		$index = $_POST['start'] + 1;
		foreach ($dataProduk as $r) {
			$data[] = array(
				'index' 			=> $index,
				'id_kemiskinan' 	=> $r['id_kemiskinan'],
				'tipe_daerah' 		=> $r['tipe_daerah'],
				'bulan_kemiskinan' 	=> $r['bulan_kemiskinan'],
				'jumlah_kemiskinan' => $r['jumlah_kemiskinan'],
				'action' 					=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEditData" data-id="' . $this->encryption->encrypt($r['id_kemiskinan']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_kemiskinan']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'
			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ta_kemiskinan'),
			"recordsFiltered" => $this->db->count_all_results('ta_kemiskinan'),
			"data" => $data
		);

		return $result;
	}

	public function _get_datatables1($param)
	{
		$post = array();
		if (is_array($param)) {
			foreach ($param as $v) {
				$post[$v['name']] = $v['value'];
			}
		}

		$this->db->select('
                            a.id_kemiskinan, 
                            a.tipe_daerah,
							a.bulan_kemiskinan,
							a.jumlah_kemiskinan');
		$this->db->from('ta_kemiskinan a');
		$this->db->where('a.tipe_daerah', 'Desa');
		$this->db->order_by('a.id_kemiskinan', 'DESC');


		$column_search = array('a.tipe_daerah', 'a.bulan_kemiskinan');

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
				'tipe_daerah'			=> $this->input->post('daerah'),
				'bulan_kemiskinan'		=> $this->input->post('monday_date'),
				'jumlah_kemiskinan'		=> $this->input->post('jumlah_pdd'),
			);

			$this->db->insert('ta_kemiskinan', $data);


			$result['success'] = 'YEAH';
			$result['status'] = true;
			$result['message'] = 'Data Kemiskinan Berhasil Disimpan';
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

			$id = $this->input->post('id_kemiskinan');
			$data_kemiskinan   = $this->db->where('id_kemiskinan', $id);

			if ($data_kemiskinan) {

				$data = array(
					'tipe_daerah'			=> $this->input->post('daerah'),
					'bulan_kemiskinan'		=> $this->input->post('monday_date'),
					'jumlah_kemiskinan'		=> $this->input->post('jumlah_pdd'),
				);

				$this->db->update('ta_kemiskinan', $data);

				$result['success'] = 'YEAH';
				$result['status'] = true;
				$result['message'] = 'Data Kemiskinan Berhasil Diupdate';
			}
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function delete_data()
	{
		$id_kemiskinan     = $this->encryption->decrypt($this->input->post('id_kemiskinan', true));

		/*query delete*/
		$this->db->where('id_kemiskinan', $id_kemiskinan);
		$this->db->delete('ta_kemiskinan');

		return array('message' => 'SUCCESS');
	}
}
