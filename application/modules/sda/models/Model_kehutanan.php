<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_kehutanan extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{
		$this->form_validation->set_rules('id_sektor', 'Sektor', 'required');
		$this->form_validation->set_rules('id_komoditi', 'Komoditi', 'required');
		$this->form_validation->set_rules('produksi', 'Jumlah Produksi', 'required');
		$this->form_validation->set_rules('tahun', 'Tahun', 'required');

		validation_message_setting();
		if ($this->form_validation->run() == FALSE)
			return false;
		else
			return true;
	}

	/**
	 * Get List Bidang
	 */
	public function getListSektor()
	{
		$this->db->from('ma_sektor');
		$this->db->where('id_sektor', 5);
		$query = $this->db->get();

		// var_dump($query);
		// exit;
		$data = [];
		$data[''] = '-- Sektor --';
		foreach ($query->result() as $key => $value) {

			// $data[$value->nama];
			$data[$value->id_sektor] = $value->nama;
		}

		return $data;
	}

	public function getListKomoditi()
	{
		$this->db->from('ma_komoditi');
		$this->db->where('id_sektor', 5);
		$query = $this->db->get();

		// var_dump($query);
		// exit;
		$data = [];
		$data[''] = '-- Semua Komoditi --';
		foreach ($query->result() as $key => $value) {

			// $data[$value->nama];
			$data[$value->id_komoditi] = $value->nama;
		}

		return $data;
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
				'id_produksi_sda' 	=> $r['id_produksi_sda'],
				'id_sektor' 		=> $r['id_sektor'],
				'id_komoditi' 		=> $r['id_komoditi'],
				'sektor' 			=> $r['sektor'],
				'komoditi' 			=> $r['komoditi'],
				'produksi' 			=> $r['produksi'],
				'tahun' 			=> $r['tahun'],
				'action' 			=> '<button type="button" class="btn btn-xs btn-primary btnView" data-id="' . $this->encryption->encrypt($r['id_produksi_sda']) . '" title="View data"><i class="fa fa-search"></i> </button>
											<button type="button" class="btn btn-xs btn-orange btnEdit" data-id="' . $this->encryption->encrypt($r['id_produksi_sda']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_produksi_sda']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ta_produksi_sda'),
			"recordsFiltered" => $this->count_filtered($param),
			"data" => $data
		);

		return $result;
	}

	public function _get_datatables($param)
	{
		$this->_get_datatables_query($param);

		// Dont know
		if ($_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}

		$query = $this->db->get();
		return $query->result_array();
	}

	public function count_filtered($param)
	{

		$this->_get_datatables_query($param);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function _get_datatables_query($param)
	{
		$post = array();
		if (is_array($param)) {
			foreach ($param as $v) {
				$post[$v['name']] = $v['value'];
			}
		}

		// Query Filter
		$this->db->select('
							p.id_produksi_sda,
							p.id_sektor,
							p.id_komoditi,
							p.tahun,
							p.produksi,
							b.nama as sektor,
							c.nama as komoditi
							');
		$this->db->from('ta_produksi_sda p');
		$this->db->join('ma_sektor b', 'p.id_sektor = b.id_sektor', 'left');
		$this->db->join('ma_komoditi c', 'p.id_komoditi = c.id_komoditi', 'left');
		$this->db->where('b.id_sektor', '5');

		if (isset($post['tahun_filter']) and $post['tahun_filter'] != '') {
			$this->db->where('p.tahun', $post['tahun_filter']);
		}

		if (isset($post['id_komoditi_filter']) and $post['id_komoditi_filter'] != '') {
			$this->db->where('c.id_komoditi', $post['id_komoditi_filter']);
		}

		$column_search = array('b.nama', 'c.nama');

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
	}

	public function getDataListProduksiReport($sektor, $komoditi)
	{
		$this->db->select('
							p.id_produksi_sda,
							p.id_sektor,
							p.id_komoditi,
							p.tahun,
							p.produksi,
							b.nama as sektor,
							c.nama as komoditi
							');
		$this->db->from('ta_produksi_sda p');
		$this->db->join('ma_sektor b', 'p.id_sektor = b.id_sektor', 'left');
		$this->db->join('ma_komoditi c', 'p.id_komoditi = c.id_komoditi', 'left');

		if ($sektor != '') {
			$this->db->where('b.id_sektor', $sektor);
		}

		if ($komoditi != '') {
			$this->db->where('c.id_komoditi', $komoditi);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function insert_data_produksi()
	{
		$result = [
			'status' => false,
			'success' => 'NOPE',
			'message' => null,
			'info' => null
		];

		try {

			$data = array(
				'id_sektor'		=> $this->input->post('id_sektor'),
				'id_komoditi'	=> $this->input->post('id_komoditi'),
				'tahun'			=> $this->input->post('tahun'),
				'produksi'		=> $this->input->post('produksi'),
			);

			$this->db->insert('ta_produksi_sda', $data);

			$result['success'] = 'YEAH';
			$result['status'] = true;
			$result['message'] = 'Data Kehutanan Berhasil Disimpan';
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function update_data_produksi()
	{

		$result = [
			'status' => false,
			'success' => 'NOPE',
			'message' => null,
			'info' => null
		];

		try {

			$idProduksiSDA = $this->input->post('id_produksi_sda');

			$produk   = $this->db->where('id_produksi_sda', $idProduksiSDA);

			if ($produk) {

				$data = array(
					'id_sektor'		=> $this->input->post('id_sektor'),
					'id_komoditi'	=> $this->input->post('id_komoditi'),
					'tahun'			=> $this->input->post('tahun'),
					'produksi'		=> $this->input->post('produksi'),
				);

				$this->db->update('ta_produksi_sda', $data);

				$result['success'] = 'YEAH';
				$result['status'] = true;
				$result['message'] = 'Data Kehutanan Berhasil diupdate';
			}
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function delete_data_produksi()
	{
		$produkId     = $this->encryption->decrypt($this->input->post('id_produksi_sda', true));

		/*query delete*/
		$this->db->where('id_produksi_sda', $produkId);
		$this->db->delete('ta_produksi_sda');

		return array('message' => 'SUCCESS');
	}

	public function uploadfile()
	{
		$config['upload_path'] 			= './assets/files/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';

		$this->load->library('upload', $config);

		$this->upload->do_upload('file_to_upload');
		$file_data = $this->upload->data();
		$data = $file_data['file_name'];
		return $data;
	}
}
