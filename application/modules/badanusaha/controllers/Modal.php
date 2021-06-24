<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 *
 * @author Yuda Pramana
 */

class Modal extends SLP_Controller
{

    private $csrf;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_modal' => 'mm'));
        $this->csrf = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );
    }

    public function index($id = null)
    {
        if (!isset($id)) {
            $this->breadcrumb->add('Dashboard', site_url('home'));
            $this->breadcrumb->add('BUMD', site_url('badanusaha/profil'));
            $this->breadcrumb->add('Progress Perkembangan', '#');
            $this->session_info['page_name'] = "Progress Perkembangan BUMD ";
            $this->session_info['id_profil_bu'] = $id;



            $this->db->from('ma_profil_bu');
            $this->db->where('id_jenis_bu', '1');
            $query = $this->db->get();
            $data = [];
            $data[''] = '-- Semua Bidang --';
            foreach ($query->result() as $key => $value) {
                $data[$value->id_profil_bu] = $value->nama;
            }

            $this->session_info['profil_bus'] = $data;
        } else {
            $this->db->select('*');
            $this->db->from('ma_profil_bu');
            $this->db->where('id_profil_bu', $id);
            $query = $this->db->get();
            $bu = $query->row();

            $this->breadcrumb->add('Dashboard', site_url('home'));
            $this->breadcrumb->add('BUMD', site_url('badanusaha/profil'));
            $this->breadcrumb->add('Progress Perkembangan', site_url('badanusaha/modal/index'));
            $this->breadcrumb->add('Spesifik', '#');

            $this->session_info['page_name'] = "Progress Perkembangan dari " . $bu->nama;
            $this->session_info['id_profil_bu'] = $id;
            $this->session_info['profil_bu'] = $bu->nama;

            $this->db->from('ma_profil_bu');
            $this->db->where('id_jenis_bu', '1');
            $query = $this->db->get()->row_array();



            // $data = [];
            // $data[''] = '-- Semua Bidang --';
            // foreach ($query->result() as $key => $value) {
            //     $data[$value->id_profil_bu] = $value->nama;
            // }

            $this->session_info['profil_bus'] = $query['nama'];
        }



        $this->template->build('form_modal/list', $this->session_info);
    }

    public function listview($id = null)
    {
        if (!isset($id)) {
            $param = $this->input->post('param', true);
            $resultDT = $this->mm->process_datatables($param, $id);
            $resultDT['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($resultDT));
        } else {
            $param = $this->input->post('param', true);
            $resultDT = $this->mm->process_datatables($param, $id);
            $resultDT['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($resultDT));
        }
    }

    public function fetch()
    {
        // Get Data from POST
        $komponen           = $this->input->post('komponen');
        $idModalPertahun    = $this->input->post('id_modal_pertahun');

        $table = 'ta_bu_' . $komponen;
        $idkomponen = 'id_bu_' . $komponen;

        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('id_modal_pertahun', $idModalPertahun);
        $result = $this->db->get();
        $rowData = $result->row_array();

        $id_komponen = $rowData[$idkomponen];
        unset($rowData['id_modal_pertahun']);
        unset($rowData[$idkomponen]);

        $data =  [
            'success' => true,
            'csrf' => $this->csrf,
            'data' => $rowData,
            'komponen' => $komponen,
            'id_komponen' => $id_komponen,
            'id_modal_pertahun' => $idModalPertahun,
        ];

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function create()
    {
        $postData = $this->input->post();

        if (isset($postData['id_modal_pertahun'])) {
            $idModalPertahun = $postData['id_modal_pertahun'];
            $komponen = $postData['komponen'];
            $idKomponen = $postData['id_komponen'];

            unset($postData['id_modal_pertahun']);
            unset($postData['komponen']);
            unset($postData['id_komponen']);

            $this->db->where('id_bu_' . $komponen, $idKomponen);
            $this->db->update('ta_bu_' . $komponen, $postData);

            $data =  [
                'status' => true,
                'success' => 'YEAH',
                'message' => 'Data ' . ucfirst($komponen) . ' Berhasil Disimpan',
                'csrf' => $this->csrf,
            ];
        } else {
            $data = $this->db->insert('ta_modal_pertahun', $postData);
            $idModalPertahun = $this->db->insert_id();
            $this->db->insert('ta_bu_aset', [
                'id_modal_pertahun' => $idModalPertahun
            ]);
            $this->db->insert('ta_bu_liabilitas', [
                'id_modal_pertahun' => $idModalPertahun
            ]);
            $this->db->insert('ta_bu_ekuitas', [
                'id_modal_pertahun' => $idModalPertahun
            ]);
            $this->db->insert('ta_bu_pendapatan', [
                'id_modal_pertahun' => $idModalPertahun
            ]);
            $this->db->insert('ta_bu_laba_rugi', [
                'id_modal_pertahun' => $idModalPertahun
            ]);

            $data =  [
                'status' => true,
                'success' => 'YEAH',
                'message' => 'Data Progress Perkembangan Berhasil Disimpan',
                'csrf' => $this->csrf,
            ];
        }


        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function delete()
    {

        $id_modal_pertahun     = $this->encryption->decrypt($this->input->post('id_modal_pertahun', true));

        /*query delete*/
        $this->db->where('id_modal_pertahun', $id_modal_pertahun);
        $this->db->delete('ta_modal_pertahun');

        $this->db->where('id_modal_pertahun', $id_modal_pertahun);
        $this->db->delete('ta_bu_aset');

        $this->db->where('id_modal_pertahun', $id_modal_pertahun);
        $this->db->delete('ta_bu_liabilitas');

        $this->db->where('id_modal_pertahun', $id_modal_pertahun);
        $this->db->delete('ta_bu_ekuitas');

        $this->db->where('id_modal_pertahun', $id_modal_pertahun);
        $this->db->delete('ta_bu_pendapatan');

        $this->db->where('id_modal_pertahun', $id_modal_pertahun);
        $this->db->delete('ta_bu_laba_rugi');

        $data =  [
            'status' => true,
            'success' => 'YEAH',
            'message' => 'Sukses Menghapus Progress Perkembangan',
            'csrf' => $this->csrf,
        ];

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function export_to_excel()
    {
        require_once APPPATH . 'third_party/php_excel/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $template  = 'repository/template/penyertaan_modal.xls';
        $objPHPExcel = $objReader->load($template);
        //get data
        $profil        = escape($this->input->get('profil', TRUE));
        $tahun          = escape($this->input->get('tahun', TRUE));

        $dataRealisasi   = $this->mm->getDataListBUReport($profil, $tahun);

        //set title
        // $objPHPExcel->setActiveSheetIndex(0)->getStyle('E')->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'DAFTAR Progress Perkembangan');
        //set data hospital
        $noRow = 0;
        $baseRow = 7;
        if (count($dataRealisasi) > 0) {
            foreach ($dataRealisasi as $key => $dh) {
                $noRow++;
                $objPHPExcel->setActiveSheetIndex(0)->getRowDimension(12)->setRowHeight(-1);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('E')->getAlignment()->setWrapText(true);
                $row = $baseRow + $noRow;
                $objPHPExcel->setActiveSheetIndex(0)->insertNewRowBefore($row, 1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $row, $noRow);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $row, $dh['nama_badan_usaha']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $row, $dh['tahun']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $row, $dh['penyertaan_modal']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $row, $dh['dividen']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $row, $dh['aset_lancar']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $row, $dh['aset_tidak_lancar']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $row, $dh['aset_total']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $row, $dh['liabilitas_jangka_panjang']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $row, $dh['liabilitas_jangka_pendek']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $row, $dh['liabilitas_total']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $row, $dh['ekuitas_total']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $row, $dh['pendapatan_usaha']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $row, $dh['harga_pokok_pendapatan']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $row, $dh['laba_rugi_pajak']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $row, $dh['taksiran_pajak']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $row, $dh['laba_rugi_nopajak']);
            }
        } else {
            $row = $baseRow + 1;
            $objPHPExcel->setActiveSheetIndex(0)->insertNewRowBefore($row, 1);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $row, 1);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $row, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $row, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $row, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $row, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $row, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $row, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $row, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $row, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $row, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $row, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $row, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $row, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $row, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $row, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $row, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $row, '');
        }
        $objPHPExcel->setActiveSheetIndex(0)->removeRow($baseRow, 1);
        $file    = 'penyertaan_modal.xlsx';
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=$file");
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
}
