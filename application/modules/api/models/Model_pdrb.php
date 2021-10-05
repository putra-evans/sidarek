<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of home model
 *
 * @author Yuda Pramana
 */

class Model_pdrb extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getDataPDRB($year)
    {
        $this->db->select('
                            a.id_pdrb,
                            a.id_lapangan_usaha,
                            a.jenis_pdrb,
                            a.triwulan,
                            a.tahun_pdrb,
                            a.harga_pdrb,

                            b.id_lapangan_usaha,
                            b.lapangan_usaha
        ');
        $this->db->from('ta_pdrb a');
        $this->db->join('ma_lapangan_usaha b',   'a.id_lapangan_usaha = b.id_lapangan_usaha');

        $this->db->where('a.tahun_pdrb', $year);

        $query = $this->db->get();
        $data = $query->result_array();
        // return $data;



        $arr = array();

        foreach ($data as $item) {
            $arr[$item['jenis_pdrb']][$item['lapangan_usaha']][] = floatval($item['harga_pdrb']);
        }

        return $arr;
        // var_dump($arr);
        // die;
    }
}
