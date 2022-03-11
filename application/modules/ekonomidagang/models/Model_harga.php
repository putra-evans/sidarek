<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_harga extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{
		$this->form_validation->set_rules('id_komoditas', 'Data Harga Komoditas', 'required');

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
				'id_komoditas_harga'	 		=> $r['id_komoditas_harga'],
				'id_komoditas' 					=> $r['id_komoditas'],
				'id_komoditas_jenis' 			=> $r['id_komoditas_jenis'],
				'id_komoditas_kategori' 		=> $r['id_komoditas_kategori'],
				'minggu_tahun' 					=> $r['minggu_tahun'],
				'monday_date' 					=> $r['monday_date'],
				'harga' 						=> $r['harga'],
				'satuan' 						=> $r['satuan'],
				'nama_komoditas' 				=> $r['nama_komoditas'],
				'jenis_komoditas' 				=> $r['jenis_komoditas'],
				'kategori_komoditas' 			=> $r['kategori_komoditas'],
				'action' 						=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_komoditas_harga']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_komoditas_harga']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ta_komoditas_harga'),
			"recordsFiltered" => $this->db->count_all_results('ta_komoditas_harga'),
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
		// $this->db->select('
		// 					harga.id_komoditas_harga,					
		// 					harga.id_komoditas,
		// 					harga.id_komoditas_jenis,
		// 					harga.minggu_tahun,
		// 					harga.monday_date,
		// 					harga.harga,
		// 					jenis.satuan,
		// 					komoditas.nama as "nama_komoditas",
		// 					jenis.nama as "jenis_komoditas",
		// 					kategori.nama as "kategori_komoditas",
		// 					jenis.id_komoditas_kategori
		// ');
		// $this->db->from('ta_komoditas_harga harga');
		// $this->db->join('ref_komoditas 			komoditas', 'komoditas.id_komoditas = harga.id_komoditas', 'left');
		// $this->db->join('ma_komoditas_jenis 	jenis', 'jenis.id_komoditas_jenis = harga.id_komoditas_jenis', 'left');
		// $this->db->join('ma_komoditas_kategori 	kategori', 'kategori.id_komoditas_kategori = jenis.id_komoditas_kategori', 'left');
		// $this->db->order_by("id_komoditas, id_komoditas_kategori", "asc");


		$this->db->select('
							jenis.id_komoditas_jenis,
							jenis.id_komoditas,
							jenis.id_komoditas_kategori,
							komoditas.nama as "nama_komoditas",
							kategori.nama as "kategori_komoditas",
							jenis.satuan,
							jenis.nama as "jenis_komoditas",
							harga.id_komoditas_harga,
							IFNULL(harga.harga, 0) as "harga",
							harga.minggu_tahun,
							harga.monday_date
		');
		$this->db->from('ma_komoditas_jenis jenis');
		$this->db->join('ref_komoditas komoditas', 'komoditas.id_komoditas = jenis.id_komoditas', 'left');
		$this->db->join('ma_komoditas_kategori kategori', 'kategori.id_komoditas_kategori = jenis.id_komoditas_kategori', 'left');
		$this->db->join(
			'ta_komoditas_harga 	harga',
			'harga.id_komoditas_jenis = jenis.id_komoditas_jenis 
							AND harga.minggu_tahun = ' . $post['minggu_tahun_filter'] . '
							AND YEAR(harga.monday_date) = ' . $post['tahun_filter'] . '',
			'left'
		);
		$this->db->order_by('jenis.id_komoditas, jenis.id_komoditas_kategori, jenis.id_komoditas_jenis', 'ASC');

		// $this->db->query("SELECT jenis.id_komoditas_jenis, jenis.id_komoditas, jenis.id_komoditas_kategori, komoditas.nama as 'nama_komoditas', kategori.nama as 'kategori_komoditas', jenis.satuan, jenis.nama as 'jenis_komoditas', harga.id_komoditas_harga, IFNULL(harga.harga, 0) as 'harga', harga.minggu_tahun, harga.monday_date FROM ma_komoditas_jenis jenis LEFT JOIN ref_komoditas komoditas ON komoditas.id_komoditas = jenis.id_komoditas LEFT JOIN ma_komoditas_kategori kategori ON kategori.id_komoditas_kategori = jenis.id_komoditas_kategori LEFT JOIN ta_komoditas_harga harga ON harga.id_komoditas_jenis = jenis.id_komoditas_jenis AND harga.minggu_tahun = 3 AND YEAR(harga.monday_date) WHERE (komoditas.nama LIKE '%%' ESCAPE '!' OR jenis.nama LIKE '%%' ESCAPE '!' OR kategori.nama LIKE '%%' ESCAPE '!' ) ORDER BY jenis.id_komoditas ASC, jenis.id_komoditas_kategori ASC, jenis.id_komoditas_jenis ASC
		// ");

		$column_search = array('komoditas.nama', 'jenis.nama', 'kategori.nama');

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
				'id_komoditas'				=> $this->input->post('id_komoditas'),
				'id_komoditas_jenis'		=> $this->input->post('id_komoditas_jenis'),
				'minggu_tahun'				=> $this->input->post('minggu_tahun'),
				'monday_date'				=> $this->input->post('monday_date'),
				'harga'						=> $this->input->post('harga')
			);

			$this->db->insert('ta_komoditas_harga', $data);

			$result['success'] = 'YEAH';
			$result['status'] = true;
			$result['message'] = 'Data Subsidi Berhasil Disimpan';
		} catch (Exception $e) {
			die($e->getMessage());
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

			$idPass = $this->input->post('id_komoditas_harga');
			$passed   = $this->db->where('id_komoditas_harga', $idPass);

			if ($passed) {

				$data = array(
					'id_komoditas'				=> $this->input->post('id_komoditas'),
					'id_komoditas_jenis'		=> $this->input->post('id_komoditas_jenis'),
					'minggu_tahun'				=> $this->input->post('minggu_tahun'),
					'monday_date'				=> $this->input->post('monday_date'),
					'harga'						=> $this->input->post('harga')
				);

				$this->db->update('ta_komoditas_harga', $data);

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
		$itemID     = $this->encryption->decrypt($this->input->post('id_komoditas_harga', true));

		/*query delete*/
		$this->db->where('id_komoditas_harga', $itemID);
		$this->db->delete('ta_komoditas_harga');

		return array('message' => 'SUCCESS');
	}

	public function input_data()
	{
		$pk = $this->input->post('pk');

		if ($pk['harga'] != '') {
			$this->db->where('id_komoditas_harga', $pk['harga']);
			$data = array('harga' => $this->input->post('value'));
			$this->db->update('ta_komoditas_harga', $data);
		} else {
			$data = array(
				'id_komoditas'				=> $pk['komoditas'],
				'id_komoditas_jenis'		=> $pk['jenis'],
				'minggu_tahun'				=> $pk['minggu_tahun'],
				'monday_date'				=> $pk['monday_date'],
				'harga'						=> $this->input->post('value')
			);

			$this->db->insert('ta_komoditas_harga', $data);
		}

		return array('message' => 'SUCCESS');
	}
}
