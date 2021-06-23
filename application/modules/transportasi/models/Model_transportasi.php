<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_transportasi extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{

		$this->form_validation->set_rules('jenis_penerbangan', 'Jenis Penerbangan', 'required');
		$this->form_validation->set_rules('monday_date', 'Bulan/Tahun', 'required');
		$this->form_validation->set_rules('jumlah_datang', 'Jumlah Datang (orang)', 'required');
		$this->form_validation->set_rules('jumlah_berangkat', 'Jumlah Berangkat (orang)', 'required');


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
				'index' 						=> $index,
				'id_transportasi' 				=> $r['id_transportasi'],
				'jenis_penerbangan' 			=> $r['jenis_penerbangan'],
				'bulan_transportasi' 			=> $r['bulan_transportasi'],
				'jumlah_datang' 				=> $r['jum_datang'],
				'jumlah_berangkat' 				=> $r['jum_berangkat'],
				'action' 					=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_transportasi']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_transportasi']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ta_transportasi'),
			"recordsFiltered" => $this->db->count_all_results('ta_transportasi'),
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
							a.id_transportasi,
							a.jenis_penerbangan,
							a.bulan_transportasi,
							a.jum_berangkat,
							a.jum_datang,
		');
		$this->db->from('ta_transportasi a');

		if (isset($post['jenis']) and $post['jenis'] != '') {
			$this->db->where('a.jenis_penerbangan', $post['jenis']);
		}

		if (isset($post['monday_date']) and $post['monday_date'] != '') {
			$this->db->where('a.bulan_transportasi', $post['monday_date']);
		}
		$column_search = array('a.jenis_penerbangan');

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

	public function getDataList($jenis, $tahun)
	{
		$this->db->select('
							a.id_transportasi,
							a.jenis_penerbangan,
							a.bulan_transportasi,
							a.jum_berangkat,
							a.jum_datang,
		');
		$this->db->from('ta_transportasi a');

		if ($jenis != '')
			$this->db->where('a.jenis_penerbangan', $jenis);

		if ($tahun != '')
			$this->db->where('a.bulan_transportasi', $tahun);

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
				'jenis_penerbangan'			=> $this->input->post('jenis_penerbangan'),
				'bulan_transportasi'		=> $this->input->post('monday_date'),
				'jum_berangkat'				=> $this->input->post('jumlah_berangkat'),
				'jum_datang'				=> $this->input->post('jumlah_datang'),

			);

			$this->db->insert('ta_transportasi', $data);

			$result['success'] = 'YEAH';
			$result['status'] = true;
			$result['message'] = 'Data Transportasi Berhasil Disimpan';
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

			$id_transportasi = $this->input->post('id_transportasi');
			$this->db->from('ta_transportasi');
			$passed   = $this->db->where('id_transportasi', $id_transportasi);

			if ($passed) {

				$data = array(
					'jenis_penerbangan'			=> $this->input->post('jenis_penerbangan'),
					'bulan_transportasi'		=> $this->input->post('monday_date'),
					'jum_berangkat'				=> $this->input->post('jumlah_berangkat'),
					'jum_datang'				=> $this->input->post('jumlah_datang'),
				);

				$this->db->update('ta_transportasi', $data);

				$result['success'] = 'YEAH';
				$result['status'] = true;
				$result['message'] = 'Data Transportasi Berhasil Diubah';
			}
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function delete_data()
	{
		$id_transportasi     = $this->encryption->decrypt($this->input->post('id_transportasi', true));

		/*query delete*/
		$this->db->where('id_transportasi', $id_transportasi);
		$this->db->delete('ta_transportasi');

		return array('message' => 'SUCCESS');
	}
}
