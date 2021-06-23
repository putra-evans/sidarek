<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of model odp
 *
 * @author Yogi "solop" Kaputra
 */

class Model_master extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getDataStudy()
  {
		$this->db->order_by('id ASC');
		$query = $this->db->get('ref_pendidikan');
    $dd_study[''] = 'Pilih Pendidikan';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_study[$row['id']] = $row['study'];
      }
    }
    return $dd_study;
  }

	public function getDataNegara()
  {
		$this->db->order_by('id ASC');
		$query = $this->db->get('wa_negara');
    $dd_negara[''] = 'Pilih Negara';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_negara[$row['name']] = $row['name'];
      }
    }
    return $dd_negara;
  }

	public function getDataProvince()
  {
		$this->db->order_by('id ASC');
		$query = $this->db->get('wa_province');
    $dd_prov[''] = 'Pilih Provinsi';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_prov[$row['id']] = $row['name'];
      }
    }
    return $dd_prov;
  }

	public function getDataRegency()
  {
		$this->db->where('province_id', '13');
		$this->db->order_by('status ASC');
		$this->db->order_by('name ASC');
		$query = $this->db->get('wa_regency');
    $dd_reg[''] = 'Pilih Kab/Kota';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_reg[$row['id']] = ($row['status'] == 1) ? "KAB ".$row['name'] : $row['name'];
      }
    }
    return $dd_reg;
  }

  public function getDataRegencyByProvince($id)
  {
		$this->db->where('province_id', $id);
		$this->db->order_by('name ASC');
		$this->db->order_by('status ASC');
		$query = $this->db->get('wa_regency');
    return $query->result_array();
  }

  public function getDataDistrictByRegency($id)
  {
		$this->db->where('regency_id', $id);
		$this->db->order_by('id ASC');
		$query = $this->db->get('wa_district');
    return $query->result_array();
  }

  public function getDataVillageByDistrict($id)
  {
		$this->db->where('district_id', $id);
		$this->db->order_by('id ASC');
		$query = $this->db->get('wa_village');
    return $query->result_array();
  }

	public function getDataMasterRsRujukan($id=0)
  {
		$this->db->where('status', '1');
		$this->db->where('flag', '1');
		if($id!=0)
			$this->db->where('id_rs !=', $id);
		$this->db->order_by('id_rs ASC');
		$query = $this->db->get('ms_rs_rujukan');
    $dd_rs[''] = 'Pilih Rumah Sakit';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_rs[$row['id_rs']] = $row['shortname'].' ['.$row['kode_fasyankes'].']';
      }
    }
    return $dd_rs;
  }

	public function getDataMasterHospital()
  {
		$this->db->where('status', '1');
		$this->db->order_by('id_rs ASC');
		$query = $this->db->get('ms_rs_rujukan');
    $dd_rs[''] = 'Pilih Rumah Sakit';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_rs[$row['id_rs']] = $row['shortname'].' ['.$row['kode_fasyankes'].']';
      }
    }
    return $dd_rs;
  }

	public function getDataMasterHospitalById($id)
  {
		$this->db->where('id_rs', $id);
		$this->db->where('status', '1');
		$this->db->order_by('id_rs ASC');
		$query = $this->db->get('ms_rs_rujukan');
    $dd_rs[''] = 'Pilih Rumah Sakit';
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $dd_rs[$row['id_rs']] = $row['shortname'].' ['.$row['kode_fasyankes'].']';
      }
    }
    return $dd_rs;
  }
}

// This is the end of auth signin model
