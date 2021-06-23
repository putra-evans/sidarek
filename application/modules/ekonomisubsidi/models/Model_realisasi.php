<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_realisasi extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{

		$this->form_validation->set_rules('alokasi', 'Nama Subsidi', 'required');
		$this->form_validation->set_rules('realisasi', 'Nama Subsidi', 'required');


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
				'id_subsidi_realisasi' 		=> $r['id_subsidi_realisasi'],
				'id_subsidi' 				=> $r['id_subsidi'],
				'id_regency' 				=> $r['id_regency'],
				'tahun' 					=> $r['tahun'],
				'alokasi' 					=> $r['alokasi'],
				'realokasi_i' 				=> $r['realokasi_i'],
				'realokasi_ii' 				=> $r['realokasi_ii'],
				'realisasi' 				=> $r['realisasi'],
				'persentase' 				=> $r['persentase'],
				'regency_name' 				=> $r['regency_name'],
				'subsidi_name' 				=> $r['subsidi_name'],
				'kategori_name' 			=> $r['kategori_name'],
				'rincian'					=> '<button type="button" class="btn btn-xs btn-success btn-status-danger btnDetail" data-id="' . $this->encryption->encrypt($r['id_subsidi_realisasi']) . '" title="Delete data"><i class="fa fa-chain"></i> </button>',
				'action' 					=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_subsidi_realisasi']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_subsidi_realisasi']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ta_subsidi_realisasi'),
			"recordsFiltered" => $this->db->count_all_results('ta_subsidi_realisasi'),
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
							realisasi.id_subsidi_realisasi,
							realisasi.id_subsidi,
							realisasi.tahun,
							realisasi.alokasi,
							realisasi.realokasi_i,
							realisasi.realokasi_ii,
							realisasi.realisasi,
							realisasi.persentase,
							regency.id as "id_regency",
							regency.name as "regency_name",
							subsidi.nama as "subsidi_name",
							kategori.nama as "kategori_name"
		');
		$this->db->from('ta_subsidi_realisasi realisasi');
		$this->db->join('wa_regency regency', 'regency.id = realisasi.id_regency', 'left');
		$this->db->join('ma_subsidi subsidi', 'subsidi.id_subsidi = realisasi.id_subsidi', 'left');
		$this->db->join('ref_subsidi_kategori kategori', 'kategori.id_subsidi_kategori = subsidi.id_subsidi_kategori');

		if (isset($post['id_subsidi_filter']) and $post['id_subsidi_filter'] != '') {
			$this->db->where('subsidi.id_subsidi', $post['id_subsidi_filter']);
		}

		if (isset($post['id_regency_filter']) and $post['id_regency_filter'] != '') {
			$this->db->where('regency.id', $post['id_regency_filter']);
		}

		if (isset($post['tahun_filter']) and $post['tahun_filter'] != '') {
			$this->db->where('realisasi.tahun', $post['tahun_filter']);
		}

		$column_search = array('subsidi.nama', 'regency.name', 'realisasi.tahun');

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

	public function hitungPersentase($alokasi, $realisasi)
	{
		$persen = round($realisasi / $alokasi * 100, 2);
		return $persen;
	}

	public function getDataListRealisasiReport($subsidi, $regency, $tahun)
	{
		$this->db->select('
							realisasi.id_subsidi_realisasi,
							realisasi.id_subsidi,
							realisasi.id_regency,
							realisasi.tahun,
							realisasi.alokasi,
							realisasi.realokasi_i,
							realisasi.realokasi_ii,
							realisasi.realisasi,
							realisasi.persentase,
							regency.id as "id_regency",
							regency.name as "regency_name",
							subsidi.nama as "subsidi_name",
							kategori.nama as "kategori_name"
					');
		$this->db->from('ta_subsidi_realisasi realisasi');
		$this->db->join('wa_regency regency', 'regency.id = realisasi.id_regency', 'left');
		$this->db->join('ma_subsidi subsidi', 'subsidi.id_subsidi = realisasi.id_subsidi', 'left');
		$this->db->join('ref_subsidi_kategori kategori', 'kategori.id_subsidi_kategori = subsidi.id_subsidi_kategori');

		if ($subsidi != '')
			$this->db->where('realisasi.id_subsidi', $subsidi);
		if ($regency != '')
			$this->db->where('realisasi.id_regency', $regency);
		if ($tahun != '')
			$this->db->where('realisasi.tahun', $tahun);

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

			$persentase = $this->hitungPersentase($this->input->post('alokasi'), $this->input->post('realisasi'));
			$data = array(
				'id_regency'			=> $this->input->post('id_regency'),
				'id_subsidi'			=> $this->input->post('id_subsidi'),
				'tahun'					=> $this->input->post('tahun'),
				'alokasi'				=> $this->input->post('alokasi'),
				'realokasi_i'			=> $this->input->post('realokasi_i'),
				'realokasi_ii'			=> $this->input->post('realokasi_ii'),
				'realisasi'				=> $this->input->post('realisasi'),
				'persentase'			=> $persentase,
			);

			$this->db->insert('ta_subsidi_realisasi', $data);

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

			$idPassed = $this->input->post('id_subsidi_realisasi');
			$passed   = $this->db->where('id_subsidi_realisasi', $idPassed);

			if ($passed) {

				$persentase = $this->hitungPersentase($this->input->post('alokasi'), $this->input->post('realisasi'));
				$data = array(
					'id_regency'			=> $this->input->post('id_regency'),
					'id_subsidi'			=> $this->input->post('id_subsidi'),
					'tahun'					=> $this->input->post('tahun'),
					'alokasi'				=> $this->input->post('alokasi'),
					'realokasi_i'			=> $this->input->post('realokasi_i'),
					'realokasi_ii'			=> $this->input->post('realokasi_ii'),
					'realisasi'				=> $this->input->post('realisasi'),
					'persentase'			=> $persentase,
				);

				$this->db->update('ta_subsidi_realisasi', $data);

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
		$realisasi     = $this->encryption->decrypt($this->input->post('id_subsidi_realisasi', true));

		/*query delete*/
		$this->db->where('id_subsidi_realisasi', $realisasi);
		$this->db->delete('ta_subsidi_realisasi');

		return array('message' => 'SUCCESS');
	}
}
