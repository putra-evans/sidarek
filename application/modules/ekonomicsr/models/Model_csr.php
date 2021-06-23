<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_csr extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{

		$this->form_validation->set_rules('alokasi_dana', 'Alokasi CSR', 'required');
		$this->form_validation->set_rules('realisasi_kemitraan', 'Realisasi Kemitraan', 'required');
		$this->form_validation->set_rules('realisasi_bina_lingkungan', 'Realisasi Bina Lingkungan', 'required');


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
				'id_csr' 					=> $r['id_csr'],
				'id_perusahaan' 			=> $r['id_perusahaan'],
				'nama_perusahaan' 			=> $r['nama_perusahaan'],
				'tahun' 					=> $r['tahun'],
				'alokasi_dana' 				=> $r['alokasi_dana'],
				'realisasi_kemitraan'  		=> $r['realisasi_kemitraan'],
				'realisasi_bina_lingkungan'	=> $r['realisasi_bina_lingkungan'],
				'jumlah_realisasi'			=> $r['jumlah_realisasi'],
				'keterangan' 				=> $r['keterangan'],
				'action' 					=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_csr']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_csr']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

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
							csr.id_csr,
							csr.id_perusahaan,
							csr.tahun,
							csr.alokasi_dana,
							csr.realisasi_kemitraan,
							csr.realisasi_bina_lingkungan,
							csr.jumlah_realisasi,
							csr.keterangan,
							per.nama as "nama_perusahaan"
		');
		$this->db->from('ta_csr csr');
		$this->db->join('ref_perusahaan per', 'per.id_perusahaan = csr.id_perusahaan', 'left');

		if (isset($post['id_perusahaan_filter']) and $post['id_perusahaan_filter'] != '') {
			$this->db->where('per.id_perusahaan', $post['id_perusahaan_filter']);
		}

		if (isset($post['tahun_filter']) and $post['tahun_filter'] != '') {
			$this->db->where('csr.tahun', $post['tahun_filter']);
		}

		$column_search = array('per.nama', 'csr.tahun');

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

	public function getDataListCSRReport($perusahaan)
	{
		$this->db->select('
							csr.id_csr,
							csr.id_perusahaan,
							csr.tahun,
							csr.alokasi_dana,
							csr.realisasi_kemitraan,
							csr.realisasi_bina_lingkungan,
							csr.jumlah_realisasi,
							csr.keterangan,
							per.nama as "nama_perusahaan"
					');
		$this->db->from('ta_csr csr');
		$this->db->join('ref_perusahaan per', 'per.id_perusahaan = csr.id_perusahaan', 'left');

		if ($perusahaan != '')
			$this->db->where('csr.id_perusahaan', $perusahaan);

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
				'id_perusahaan'					=> $this->input->post('id_perusahaan'),
				'tahun'							=> $this->input->post('tahun'),
				'alokasi_dana'					=> $this->input->post('alokasi_dana'),
				'realisasi_kemitraan'			=> $this->input->post('realisasi_kemitraan'),
				'realisasi_bina_lingkungan'		=> $this->input->post('realisasi_bina_lingkungan'),
				'jumlah_realisasi'				=> $this->input->post('jumlah_realisasi'),
				'keterangan'					=> $this->input->post('keterangan'),
			);

			$this->db->insert('ta_csr', $data);

			$result['success'] = 'YEAH';
			$result['status'] = true;
			$result['message'] = 'Data CSR Berhasil Disimpan';
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

			$idPassed = $this->input->post('id_csr');
			$this->db->from('ta_csr');
			$passed   = $this->db->where('id_csr', $idPassed);

			if ($passed) {

				$data = array(
					'id_perusahaan'					=> $this->input->post('id_perusahaan'),
					'tahun'							=> $this->input->post('tahun'),
					'alokasi_dana'					=> $this->input->post('alokasi_dana'),
					'realisasi_kemitraan'			=> $this->input->post('realisasi_kemitraan'),
					'realisasi_bina_lingkungan'		=> $this->input->post('realisasi_bina_lingkungan'),
					'jumlah_realisasi'				=> $this->input->post('jumlah_realisasi'),
					'keterangan'					=> $this->input->post('keterangan'),
				);

				$this->db->update('ta_csr', $data);

				$result['success'] = 'YEAH';
				$result['status'] = true;
				$result['message'] = 'Data Produk Kebijakan Berhasil Disimpan';
			}
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function delete_data()
	{
		$item     = $this->encryption->decrypt($this->input->post('id_csr', true));

		/*query delete*/
		$this->db->where('id_csr', $item);
		$this->db->delete('ta_csr');

		return array('message' => 'SUCCESS');
	}
}
