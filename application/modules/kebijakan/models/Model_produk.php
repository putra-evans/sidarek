<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_produk extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
	}

	public function validasiDataValue($role)
	{
		$this->form_validation->set_rules('id_bidang', 'Bidang Pemerintahan', 'required');
		$this->form_validation->set_rules('tanggal_terbit', 'tanggal_terbit', 'required');
		$this->form_validation->set_rules('nomor', 'Nomor', 'required');
		$this->form_validation->set_rules('tahun', 'Tahun', 'required');

		$this->form_validation->set_rules('judul', 'Judul Kebijakan', 'required');
		$this->form_validation->set_rules('sasaran', 'Sasaran Kebijakan', 'required');
		$this->form_validation->set_rules('target', 'Target Kebijakan', 'required');
		$this->form_validation->set_rules('pemerintah', 'Pemerintah', 'required');

		if (empty($_FILES['file_to_upload']['name'])) {
			$this->form_validation->set_rules('file_to_upload', 'Dokumen', 'required');
		}


		validation_message_setting();
		if ($this->form_validation->run() == FALSE)
			return false;
		else
			return true;
	}

	/**
	 * Get List Bidang
	 */
	public function getListBidang()
	{
		$query = $this->db->get("ref_bidang_ekonomi");
		$data = [];
		$data[''] = '-- Semua Bidang --';
		foreach ($query->result() as $key => $value) {
			$data[$value->id_bidang] = $value->nama;
		}

		return $data;
	}

	public function process_datatables($param)
	{

		$draw = intval($this->input->get("draw"));

		$dataProduk = $this->_get_datatables($param);

		$data = [];
		$index = 1;
		foreach ($dataProduk as $r) {
			$data[] = array(
				'index' 			=> $index,
				'id_produk' 		=> $r['id_produk'],
				'id_bidang' 		=> $r['id_bidang'],
				'id_tipe' 			=> $r['id_tipe'],
				'tanggal_terbit' 	=> $r['tanggal_terbit'],
				'nomor' 			=> $r['nomor'],
				'tahun' 			=> $r['tahun'],
				'judul' 			=> $r['judul'],
				'sasaran' 			=> $r['sasaran'],
				'pemerintah' 		=> $r['pemerintah'],
				'target' 			=> $r['target'],
				'file' 				=> $r['file'],
				'action' 			=> '<button type="button" class="btn btn-xs btn-primary btn-status-primary btnView" data-id="' . $this->encryption->encrypt($r['id_produk']) . '" title="View data"><i class="fa fa-search"></i> </button>
											<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_produk']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_produk']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

			);
			$index++;
		}

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ma_produk_kebijakan'),
			"recordsFiltered" => $this->db->count_all_results('ma_produk_kebijakan'),
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
							p.id_produk,
							p.id_bidang,
							p.tanggal_terbit,
							p.nomor,
							p.tahun,
							p.judul,
							p.sasaran,
							p.target,
							p.file,
							p.id_tipe,
							p.pemerintah');
		$this->db->from('ma_produk_kebijakan p');
		$this->db->join('ref_bidang_ekonomi b', 'p.id_bidang = b.id_bidang', 'left');
		$this->db->join('ref_tipe_kebijakan c', 'p.id_tipe = c.id_tipe', 'left');
		$this->db->order_by('p.id_produk', 'DESC');

		if (isset($post['id_bidang']) and $post['id_bidang'] != '') {
			$this->db->where('b.id_bidang', $post['id_bidang']);
		}

		if (isset($post['tahun']) and $post['tahun'] != '') {
			$this->db->where('p.tahun', $post['tahun']);
		}

		if (isset($post['id_tipe']) and $post['id_tipe'] != '') {
			$this->db->where('p.id_tipe', $post['id_tipe']);
		}

		if (isset($post['judul']) and $post['judul'] != '') {
			$this->db->like('p.judul', $post['judul'], 'after');
		}

		$column_search = array('p.judul', 'p.sasaran', 'p.target');

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

	public function getDataListProdukReport($id_bidang, $tahun, $id_tipe)
	{
		$this->db->select('
							p.id_produk,
							p.id_bidang,
							p.tanggal_terbit,
							p.nomor,
							p.tahun,
							p.judul,
							p.sasaran,
							p.target,
							p.file,
							p.id_tipe,
							b.nama,
							p.pemerintah');
		$this->db->from('ma_produk_kebijakan p');
		$this->db->join('ref_bidang_ekonomi b', 'p.id_bidang = b.id_bidang', 'left');
		$this->db->join('ref_tipe_kebijakan c', 'p.id_tipe = c.id_tipe', 'left');

		if ($id_bidang != '')
			$this->db->where('p.id_bidang', $id_bidang);
		if ($tahun != '')
			$this->db->where('p.tahun', $tahun);
		if ($id_tipe != '')
			$this->db->where('p.id_tipe', $id_tipe);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function insert_data_produk()
	{
		$result = [
			'status' => false,
			'success' => 'NOPE',
			'message' => null,
			'info' => null
		];

		try {

			// $fileName = $this->uploadkebijakan();

			$config = array(
				'upload_path' 		=> './assets/files/',
				'allowed_types' 	=> 'png|jpg|jpeg|pdf',
				'file_ext_tolower'	=> TRUE,
				'max_size' 			=> 10240,
				'max_filename' 		=> 0,
				'remove_spaces' 	=> TRUE,
			);
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$aksiupload = $this->upload->do_upload('file_to_upload');


			if (!$aksiupload) {
				echo "Gagal Upload";
				// return array('status' => false, 'message' => 'Ukuran file tidak sesuai');
			} else {
				$upload_data = $this->upload->data();
				$images  = $upload_data['file_name'];
				$data = array(
					'id_bidang'			=> $this->input->post('id_bidang'),
					'tahun'				=> $this->input->post('tahun'),
					'tanggal_terbit'	=> $this->input->post('tanggal_terbit'),
					'nomor'				=> $this->input->post('nomor'),
					'pemerintah'		=> $this->input->post('pemerintah'),
					'judul'				=> $this->input->post('judul'),
					'sasaran'			=> $this->input->post('sasaran'),
					'target'			=> $this->input->post('target'),
					'id_tipe'			=> $this->input->post('id_tipe'),
					'file'				=> $images,
				);

				$this->db->insert('ma_produk_kebijakan', $data);

				$result['success'] = 'YEAH';
				$result['status'] = true;
				$result['message'] = 'Data Produk Kebijakan Berhasil Disimpan';
			}
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function update_data_produk()
	{

		$result = [
			'status' => false,
			'success' => 'NOPE',
			'message' => null,
			'info' => null
		];

		try {

			$config = array(
				'upload_path' 		=> './assets/files/',
				'allowed_types' 	=> 'png|jpg|jpeg|pdf',
				'file_ext_tolower'	=> TRUE,
				'max_size' 			=> 10240,
				'max_filename' 		=> 0,
				'remove_spaces' 	=> TRUE,
			);
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$aksiupload = $this->upload->do_upload('file_to_upload');

			if (!$aksiupload) {
				$idProduk = $this->input->post('id_produk');
				$produk   = $this->db->where('id_produk', $idProduk);
				$upload_data = $this->upload->data();
				$images  = $upload_data['file_name'];

				if ($produk) {
					$data = array(
						'id_bidang'			=> $this->input->post('id_bidang'),
						'tahun'				=> $this->input->post('tahun'),
						'tanggal_terbit'	=> $this->input->post('tanggal_terbit'),
						'nomor'				=> $this->input->post('nomor'),
						'pemerintah'		=> $this->input->post('pemerintah'),
						'judul'				=> $this->input->post('judul'),
						'sasaran'			=> $this->input->post('sasaran'),
						'target'			=> $this->input->post('target'),
						'file'				=> $images,
					);

					if ($images == "") {
						unset($data['file']);
					}

					$this->db->update('ma_produk_kebijakan', $data);

					$result['success'] = 'YEAH';
					$result['status'] = true;
					$result['message'] = 'Data Produk Kebijakan Berhasil Diupdate';
				}
			} else {
				$idProduk = $this->input->post('id_produk');
				$produk   = $this->db->where('id_produk', $idProduk);
				$upload_data = $this->upload->data();
				$images  = $upload_data['file_name'];

				if ($produk) {
					$data = array(
						'id_bidang'			=> $this->input->post('id_bidang'),
						'tahun'				=> $this->input->post('tahun'),
						'tanggal_terbit'	=> $this->input->post('tanggal_terbit'),
						'nomor'				=> $this->input->post('nomor'),
						'pemerintah'		=> $this->input->post('pemerintah'),
						'judul'				=> $this->input->post('judul'),
						'sasaran'			=> $this->input->post('sasaran'),
						'target'			=> $this->input->post('target'),
						'file'				=> $images,
					);

					if ($images == "") {
						unset($data['file']);
					}

					$this->db->update('ma_produk_kebijakan', $data);

					$result['success'] = 'YEAH';
					$result['status'] = true;
					$result['message'] = 'Data Produk Kebijakan Berhasil Diupdate';
				}
			}
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function delete_data_produk()
	{
		$produkId     = $this->encryption->decrypt($this->input->post('produkId', true));

		/*query delete*/
		$this->db->where('id_produk', $produkId);
		$this->db->delete('ma_produk_kebijakan');

		return array('message' => 'SUCCESS');
	}

	public function uploadkebijakan()
	{
		$config['upload_path'] 			= './assets/files/';
		$config['allowed_types']        = 'jpg|png|jpeg|pdf';
		$config['max_size']             = 2048;

		$this->load->library('upload', $config);

		$this->upload->do_upload('file_to_upload');
		$file_data = $this->upload->data();
		$data = $file_data['file_name'];
		return $data;
	}
}
