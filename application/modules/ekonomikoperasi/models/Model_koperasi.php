<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_koperasi extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{

		$this->form_validation->set_rules('nama', 'Nama Perusahaan', 'required');


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
				'index' 				=> $index,
				'id_koperasi'	 		=> $r['id_koperasi'],
				'nama' 					=> $r['nama'],
				'id_regency' 			=> $r['id_regency'],
				'alamat' 				=> $r['alamat'],
				'status' 				=> $r['status'],
				'badan_hukum' 			=> $r['badan_hukum'],
				'jenis_usaha' 			=> $r['jenis_usaha'],
				'izin_usaha' 			=> $r['izin_usaha'],
				'tanggal_izin_usaha'	=> $r['tanggal_izin_usaha'],
				'surat_ojk' 			=> $r['surat_ojk'],
				'regency_name' 			=> $r['regency_name'],
				'action' 				=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_koperasi']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_koperasi']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ma_koperasi'),
			"recordsFiltered" => $this->db->count_all_results('ma_koperasi'),
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
							kop.id_koperasi,					
							kop.nama,
							kop.id_regency,
							kop.alamat,
							kop.status,
							kop.badan_hukum,
							kop.jenis_usaha,
							kop.izin_usaha,
							kop.tanggal_izin_usaha,
							kop.surat_ojk,
							regency.name as "regency_name"
		');
		$this->db->from('ma_koperasi kop');
		$this->db->join('wa_regency regency', 'regency.id = kop.id_regency', 'left');


		if (isset($post['nama']) and $post['nama'] != '') {
			$this->db->where('kop.nama', $post['nama']);
		}

		$column_search = array('kop.nama', 'kop.alamat', 'regency.name');

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
				'nama'							=> $this->input->post('nama'),
				'id_regency'					=> $this->input->post('id_regency'),
				'alamat'						=> $this->input->post('alamat'),
				'status'						=> $this->input->post('status'),
				'badan_hukum'					=> $this->input->post('badan_hukum'),
				'jenis_usaha'					=> $this->input->post('jenis_usaha'),
				'izin_usaha'					=> $this->input->post('izin_usaha'),
				'tanggal_izin_usaha'			=> $this->input->post('tanggal_izin_usaha'),
				'surat_ojk'						=> $this->input->post('surat_ojk'),
			);

			$this->db->insert('ma_koperasi', $data);

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

			$idPerusahaan = $this->input->post('id_koperasi');
			$perusahaan   = $this->db->where('id_koperasi', $idPerusahaan);

			if ($perusahaan) {

				$data = array(
					'nama'							=> $this->input->post('nama'),
					'id_regency'					=> $this->input->post('id_regency'),
					'alamat'						=> $this->input->post('alamat'),
					'status'						=> $this->input->post('status'),
					'badan_hukum'					=> $this->input->post('badan_hukum'),
					'jenis_usaha'					=> $this->input->post('jenis_usaha'),
					'izin_usaha'					=> $this->input->post('izin_usaha'),
					'tanggal_izin_usaha'			=> $this->input->post('tanggal_izin_usaha'),
					'surat_ojk'						=> $this->input->post('surat_ojk'),
				);

				$this->db->update('ma_koperasi', $data);

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
		$itemID     = $this->encryption->decrypt($this->input->post('id_koperasi', true));

		/*query delete*/
		$this->db->where('id_koperasi', $itemID);
		$this->db->delete('ma_koperasi');

		return array('message' => 'SUCCESS');
	}
}
