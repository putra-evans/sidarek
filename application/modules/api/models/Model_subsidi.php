<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of home model
 *
 * @author Yuda Pramana
 */

class Model_subsidi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getDataSubsidi($year, $id_subsidi)
    {
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

        if($id_subsidi){
            $this->db->where('subsidi.id_subsidi', $id_subsidi);
        }
        $this->db->where('realisasi.tahun', $year);




        $query = $this->db->get();
        $data = $query->result_array();

        $dataseries = array();
        $categories = [];
        foreach ($data as $item) {
            $categories[] = $item['regency_name'];
            $dataseries[$item['kategori_name']][$item['subsidi_name']]['alokasi'][] = floatval($item['alokasi']);
            $dataseries[$item['kategori_name']][$item['subsidi_name']]['realokasi_i'][] = floatval($item['realokasi_i']);
            $dataseries[$item['kategori_name']][$item['subsidi_name']]['realokasi_ii'][] = floatval($item['realokasi_ii']);
            $dataseries[$item['kategori_name']][$item['subsidi_name']]['realisasi'][] = floatval($item['realisasi']);
            // $dataseries[$item['kategori_name']][$item['subsidi_name']]['persentase'][] = floatval($item['persentase']);
        }

        return [
            'categories' => $categories,
            'dataseries' => $dataseries
        ];
    }
}
