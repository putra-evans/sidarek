<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_peragaan extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{

		$this->form_validation->set_rules('tahun', 'tahun', 'required');


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
				'id_peragaan_koperasi' 		=> $r['id_peragaan_koperasi'],
				'tahun' 					=> $r['tahun'],
				'total_jumlah_unit' 		=> $r['total_jumlah_unit'],
				'total_unit_aktif' 			=> $r['total_unit_aktif'],
				'total_unit_nonaktif' 		=> $r['total_unit_nonaktif'],
				'total_jumlah_anggota' 		=> $r['total_jumlah_anggota'],
				'total_anggota_laki' 		=> $r['total_anggota_laki'],
				'total_anggota_perempuan' 	=> $r['total_anggota_perempuan'],
				'total_unit_rat' 			=> $r['total_unit_rat'],
				'total_persen_rat' 			=> $r['total_persen_rat'],
				'total_jumlah_manager' 		=> $r['total_jumlah_manager'],
				'total_manager_laki' 		=> $r['total_manager_laki'],
				'total_manager_perempuan' 	=> $r['total_manager_perempuan'],
				'total_jumlah_karyawan' 	=> $r['total_jumlah_karyawan'],
				'total_karyawan_laki' 		=> $r['total_karyawan_laki'],
				'total_karyawan_perempuan' 	=> $r['total_karyawan_perempuan'],
				'total_modal_sendiri' 		=> $r['total_modal_sendiri'],
				'total_modal_luar' 			=> $r['total_modal_luar'],
				'total_aset' 				=> $r['total_aset'],
				'total_volume_usaha' 		=> $r['total_volume_usaha'],
				'total_snu' 				=> $r['total_snu'],
				'kabkota' 					=> '<a  href="'. site_url() .'ekonomikoperasi/peragaankabkota/tahun/'.$r['tahun'].'" type="button" class="btn btn-xs btn-primary btn-status-primary btnkabkota" data-id="' . $this->encryption->encrypt($r['id_peragaan_koperasi']) . '" title="Edit data">data </a>',
				'prov' 						=> '<a  href="'. site_url() .'ekonomikoperasi/peragaanprov/tahun/'.$r['tahun'].'" type="button" class="btn btn-xs btn-primary btn-status-primary btnkabkota" data-id="' . $this->encryption->encrypt($r['id_peragaan_koperasi']) . '" title="Edit data">data </a>',
				'action' 					=> '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_peragaan_koperasi']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_peragaan_koperasi']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ta_peragaan_koperasi'),
			"recordsFiltered" => $this->db->count_all_results('ta_peragaan_koperasi'),
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
							peragaan.id_peragaan_koperasi,
							peragaan.tahun,
							peragaan.total_jumlah_unit,
							peragaan.total_unit_aktif,
							peragaan.total_unit_nonaktif,
							peragaan.total_jumlah_anggota,
							peragaan.total_anggota_laki,
							peragaan.total_anggota_perempuan,
							peragaan.total_unit_rat,
							peragaan.total_persen_rat,
							peragaan.total_jumlah_manager,
							peragaan.total_manager_laki,
							peragaan.total_manager_perempuan,
							peragaan.total_jumlah_karyawan,
							peragaan.total_karyawan_laki,
							peragaan.total_karyawan_perempuan,
							peragaan.total_modal_sendiri,
							peragaan.total_modal_luar,
							peragaan.total_aset,
							peragaan.total_volume_usaha,
							peragaan.total_snu
		');
		$this->db->from('ta_peragaan_koperasi peragaan');

		$column_search = array('peragaan.tahun');

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
				'tahun'						=> $this->input->post('tahun'),
				'total_jumlah_unit'			=> $this->input->post('total_jumlah_unit'),
				'total_unit_aktif'			=> $this->input->post('total_unit_aktif'),
				'total_unit_nonaktif'		=> $this->input->post('total_unit_nonaktif'),
				'total_jumlah_anggota'		=> $this->input->post('total_jumlah_anggota'),
				'total_anggota_laki'		=> $this->input->post('total_anggota_laki'),
				'total_anggota_perempuan'	=> $this->input->post('total_anggota_perempuan'),
				'total_unit_rat'			=> $this->input->post('total_unit_rat'),
				'total_persen_rat'			=> $this->input->post('total_persen_rat'),
				'total_jumlah_manager'		=> $this->input->post('total_jumlah_manager'),
				'total_manager_laki'		=> $this->input->post('total_manager_laki'),
				'total_manager_perempuan'	=> $this->input->post('total_manager_perempuan'),
				'total_jumlah_karyawan'		=> $this->input->post('total_jumlah_karyawan'),
				'total_karyawan_laki'		=> $this->input->post('total_karyawan_laki'),
				'total_karyawan_perempuan'	=> $this->input->post('total_karyawan_perempuan'),
				'total_modal_sendiri'		=> $this->input->post('total_modal_sendiri'),
				'total_modal_luar'			=> $this->input->post('total_modal_luar'),
				'total_aset'				=> $this->input->post('total_aset'),
				'total_volume_usaha'	 	=> $this->input->post('total_volume_usaha'),
				'total_snu'					=> $this->input->post('total_snu'),
			);

			$this->db->insert('ta_peragaan_koperasi', $data);

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

			$idPassed = $this->input->post('id_peragaan_koperasi');
			$passed   = $this->db->where('id_peragaan_koperasi', $idPassed);

			if ($passed) {

				$data = array(
					'tahun'								=> $this->input->post('tahun'),
					'total_jumlah_unit'					=> $this->input->post('total_jumlah_unit'),
					'total_unit_aktif'					=> $this->input->post('total_unit_aktif'),
					'total_unit_nonaktif'				=> $this->input->post('total_unit_nonaktif'),
					'total_jumlah_anggota'				=> $this->input->post('total_jumlah_anggota'),
					'total_anggota_laki'				=> $this->input->post('total_anggota_laki'),
					'total_anggota_perempuan'			=> $this->input->post('total_anggota_perempuan'),
					'total_unit_rat'					=> $this->input->post('total_unit_rat'),
					'total_persen_rat'					=> $this->input->post('total_persen_rat'),
					'total_jumlah_manager'				=> $this->input->post('total_jumlah_manager'),
					'total_manager_laki'				=> $this->input->post('total_manager_laki'),
					'total_manager_perempuan'			=> $this->input->post('total_manager_perempuan'),
					'total_jumlah_karyawan'				=> $this->input->post('total_jumlah_karyawan'),
					'total_karyawan_laki'				=> $this->input->post('total_karyawan_laki'),
					'total_karyawan_perempuan'			=> $this->input->post('total_karyawan_perempuan'),
					'total_modal_sendiri'				=> $this->input->post('total_modal_sendiri'),
					'total_modal_luar'					=> $this->input->post('total_modal_luar'),
					'total_aset'						=> $this->input->post('total_aset'),
					'total_volume_usaha'				=> $this->input->post('total_volume_usaha'),
					'total_snu'							=> $this->input->post('total_snu'),
				);

				$this->db->update('ta_peragaan_koperasi', $data);

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
		$item     = $this->encryption->decrypt($this->input->post('id_peragaan_koperasi', true));

		/*query delete*/
		$this->db->where('id_peragaan_koperasi', $item);
		$this->db->delete('ta_peragaan_koperasi');

		return array('message' => 'SUCCESS');
	}
}
