<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of home model
 *
 * @author Yuda Pramana
 */

class Model_inflasi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getDataInflasi($year)
    {
        $this->db->select('
                            inflasi.tahun_inflasi,
                            tipe.nama as "nama_tipe",
                            daerah.nama as "nama_daerah",
                            detail.bulan_inflasi,
                            detail.persen_inflasi
        ');
        $this->db->from('ta_inflasi_detail          detail');
        $this->db->join('ta_inflasi 	            inflasi',   'inflasi.id_inflasi = detail.id_inflasi');
        $this->db->join('ref_tipe_inflasi 	        tipe',      'tipe.id_tipe_inflasi = inflasi.id_tipe_inflasi');
        $this->db->join('ref_daerah_inflasi 	    daerah',    'daerah.id_daerah_inflasi = inflasi.id_daerah_inflasi');
        $this->db->where('inflasi.tahun_inflasi', $year);

        $query = $this->db->get();
        $data = $query->result_array();
        // return $data;



        $arr = array();

        foreach ($data as $item) {
            $arr[$item['nama_daerah']][$item['nama_tipe']][] = floatval($item['persen_inflasi']);
        }

        return $arr;
    }
}
