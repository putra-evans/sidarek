<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 *
 * @author Yuda Pramana
 */

class Ntp extends SLP_Controller
{

    private $csrf;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_ntp' => 'mm'));
        $this->csrf = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );
    }

    public function index()
    {
        $this->breadcrumb->add('Dashboard', site_url('home'));
        $this->breadcrumb->add('NTP', site_url('#'));
        $this->breadcrumb->add('Nilai Tukar Petani', '#');
        $this->session_info['page_name'] = "Nilai Tukar Petani";

        $this->template->build('form_ntp/list', $this->session_info);
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
        $nm_tbl = $this->input->post('nm_tbl');
        $id_tbl = $this->input->post('id_tbl');
        $id_ntp = $this->input->post('id_ntp');

        $table = 'ta_ntp_' . $nm_tbl;
        $idtbl = 'id_' . $id_tbl;

        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('id_ntp', $id_ntp);
        $result = $this->db->get();
        $rowData = $result->row_array();

        $id_tbl = $rowData[$idtbl];
        unset($rowData['id_ntp']);
        unset($rowData[$idtbl]);

        $data =  [
            'success' => true,
            'csrf' => $this->csrf,
            'data' => $rowData,
            'nm_tbl' => $nm_tbl,
            'id_tbl' => $id_tbl,
            'id_ntp' => $id_ntp,
        ];

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function create()
    {
        $postData = $this->input->post();

        if (isset($postData['id_ntp'])) {
            $idntp = $postData['id_ntp'];
            $nm_tbl = $postData['nm_tbl'];
            $id_tbl = $postData['id_tbl'];

            unset($postData['id_ntp']);
            unset($postData['nm_tbl']);
            unset($postData['id_tbl']);

            $this->db->where('id_' . $nm_tbl, $id_tbl);
            $this->db->update('ta_ntp_' . $nm_tbl, $postData);

            $data =  [
                'status' => true,
                'success' => 'YEAH',
                'message' => 'Data ' . ucfirst($nm_tbl) . ' Berhasil Disimpan',
                'csrf' => $this->csrf,
            ];
        } else {
            $data = $this->db->insert('ta_ntp', $postData);
            $idntp = $this->db->insert_id();

            $this->db->insert('ta_ntp_tp', [
                'id_ntp' => $idntp
            ]);

            $this->db->insert('ta_ntp_hortikultur', [
                'id_ntp' => $idntp
            ]);


            $this->db->insert('ta_ntp_perkebunan', [
                'id_ntp' => $idntp
            ]);

            $this->db->insert('ta_ntp_peternakan', [
                'id_ntp' => $idntp
            ]);

            $this->db->insert('ta_ntp_perikanan', [
                'id_ntp' => $idntp
            ]);

            $this->db->insert('ta_ntp_perikanan_tangkap', [
                'id_ntp' => $idntp
            ]);

            $this->db->insert('ta_ntp_perikanan_budidaya', [
                'id_ntp' => $idntp
            ]);

            $data =  [
                'status' => true,
                'success' => 'YEAH',
                'message' => 'Data Berhasil Disimpan',
                'csrf' => $this->csrf,
            ];
        }


        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function delete()
    {

        $id_ntp     = $this->encryption->decrypt($this->input->post('id_ntp', true));

        /*query delete*/
        $this->db->where('id_ntp', $id_ntp);
        $this->db->delete('ta_ntp');

        $this->db->where('id_ntp', $id_ntp);
        $this->db->delete('ta_ntp_tp');

        $this->db->where('id_ntp', $id_ntp);
        $this->db->delete('ta_ntp_hortikultur');

        $this->db->where('id_ntp', $id_ntp);
        $this->db->delete('ta_ntp_perkebunan');

        $this->db->where('id_ntp', $id_ntp);
        $this->db->delete('ta_ntp_peternakan');

        $this->db->where('id_ntp', $id_ntp);
        $this->db->delete('ta_ntp_perikanan');

        $this->db->where('id_ntp', $id_ntp);
        $this->db->delete('ta_ntp_perikanan_tangkap');

        $this->db->where('id_ntp', $id_ntp);
        $this->db->delete('ta_ntp_perikanan_budidaya');

        $data =  [
            'status' => true,
            'success' => 'YEAH',
            'message' => 'Sukses Menghapus',
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
