<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_komoditi extends CI_Model
{
	protected $_publishDate = "";
	public function __construct()
	{
		parent::__construct();
    }
    
    public function validasiDataValue($role)
	{
		$this->form_validation->set_rules('nama_komoditi', 'Nama Komoditi', 'required');

		validation_message_setting();
		if ($this->form_validation->run() == FALSE)
			return false;
		else
			return true;
	}

	public function process_datatables($param, $idsektor)
	{

		$draw = intval($this->input->get("draw"));

		$result = $this->_get_datatables($param, $idsektor);

		$data = [];
		$index = $_POST['start'] + 1;
		foreach ($result['data'] as $r) {
			$data[] = array(
				'index' 			=> $index,
                'id_komoditi' 		=> $r['id_komoditi'],
                'id_sektor' 		=> $r['id_sektor'],
				'komoditi' 		    => $r['komoditi'],
				'action' 			=> '<button type="button" class="btn btn-xs btn-orange btnEditKomoditi" data-id="' . $this->encryption->encrypt($r['id_komoditi']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btnDeleteKomoditi" data-id="' . $this->encryption->encrypt($r['id_komoditi']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

			);
			$index++;
        }

        // <button type="button" class="btn btn-xs btn-primary btnView" data-id="' . $this->encryption->encrypt($r['id_komoditi']) . '" title="View data"><i class="fa fa-search"></i> </button>
        

		$result = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $this->db->count_all_results('ma_komoditi'),
			"recordsFiltered" => $this->count_filtered($param, $idsektor),
            "data" => $data,
		);

		return $result;
    }
    
    public function _get_datatables_query($param, $idsektor){
        $post = array();
		if (is_array($param)) {
			foreach ($param as $v) {
				$post[$v['name']] = $v['value'];
			}
        }
        
        $this->db->select('
                            komoditi.id_komoditi, 
                            komoditi.nama AS komoditi,
                            komoditi.id_sektor');
		$this->db->from('ma_sektor sektor');
        $this->db->join('ma_komoditi komoditi', 'sektor.id_sektor = komoditi.id_sektor', 'left');
        $this->db->where('komoditi.id_sektor', $idsektor);

		$column_search = array('komoditi.nama');

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

	public function _get_datatables($param, $idsektor)
	{

        $this->_get_datatables_query($param, $idsektor);

		// Dont know
		if ($_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}

        $query = $this->db->get();
        
		return [
            'data' => $query->result_array(),
            'num_rows' => $query->num_rows()
        ];
    }
    
    public function count_filtered($param, $idsektor){

        $this->_get_datatables_query($param, $idsektor);
        $query = $this->db->get();
        return $query->num_rows();
    }

	public function insert_data_komoditi()
	{
		$result = [
			'status' => false,
			'success' => 'NOPE',
			'message' => null,
			'info' => null
		];

		try {

			$data = array(
                'id_sektor'		=> $this->input->post('id_sektor_for_komoditi'),
                'nama'			=> $this->input->post('nama_komoditi'),
			);

			$this->db->insert('ma_komoditi', $data);

			$result['success'] = 'YEAH';
			$result['status'] = true;
			$result['message'] = 'Data Produk Kebijakan Berhasil Disimpan';
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function update_data_komoditi()
	{

		$result = [
			'status' => false,
			'success' => 'NOPE',
			'message' => null,
			'info' => null
		];

		try {

            $idSektor   = $this->input->post('id_sektor_for_komoditi');
            $idKomoditi = $this->input->post('id_komoditi');

            $condition = array(
                                'id_sektor'     => $idSektor, 
                                'id_komoditi'   => $idKomoditi, 
                            );

            $this->db->where($condition); 

            $data = array(
                'nama'			=> $this->input->post('nama_komoditi'),
            );

			$this->db->update('ma_komoditi', $data);

				$result['success'] = 'YEAH';
				$result['status'] = true;
				$result['message'] = 'Data Produk Kebijakan Berhasil Disimpan';
			
		} catch (\Exception $e) {
			$result['info'] = $e->getMessage();
		}

		return $result;
	}

	public function delete_data_komoditi()
	{
		$produkId     = $this->encryption->decrypt($this->input->post('produkId', true));

		/*query delete*/
		$this->db->where('id_produk', $produkId);
		$this->db->delete('ma_komoditi');

		return array('message' => 'SUCCESS');
	}
}
