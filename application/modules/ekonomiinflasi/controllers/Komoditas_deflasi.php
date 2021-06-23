<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of OTG class
 *
 * @author Yuda Pramana
 */

class Komoditas_deflasi extends SLP_Controller
{

    private $csrf;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Model_komoditas_deflasi' => 'mkd'));
        $this->csrf = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );
    }

    public function index()
    {

        $this->breadcrumb->add('Dashboard', site_url('home'));
        $this->breadcrumb->add('Data Komoditas Penyumbang Deflasi', '#');

        $this->session_info['page_name'] = "Data Komoditas Penyumbang Deflasi";
        $this->session_info['komoditas_penyumbang'] = $this->getKomoditasPenyumbang();
        $this->session_info['jenis_penyumbang'] = $this->getJenisPenyumbang();

        $this->template->build('form_komoditas_deflasi/list', $this->session_info);
    }

    public function getKomoditasPenyumbang()
    {
        $this->db->from('ref_komoditas_penyumbang');
        $query = $this->db->get();
        $data = [];
        $data[''] = '-- Pilih Tipe --';
        foreach ($query->result() as $key => $value) {
            $data[$value->id_komoditas_penyumbang] = $value->nama_komoditas_penyumbang;
        }

        return $data;
    }
    public function getJenisPenyumbang()
    {
        $this->db->from('ref_jenis_komoditas_penyumbang');
        $query = $this->db->get();
        $data = [];
        $data[''] = '-- Pilih Tipe --';
        foreach ($query->result() as $key => $value) {
            $data[$value->id_jenis_komoditas] = $value->jenis_komoditas;
        }

        return $data;
    }

    public function getDaerah()
    {
        $query = $this->db->get("ref_daerah_inflasi");
        $data = [];
        $data[''] = '-- Pilih Daerah --';
        foreach ($query->result() as $key => $value) {
            $data[$value->id_daerah_inflasi] = $value->nama;
        }

        return $data;
    }

    public function getBulan()
    {
        $data = array(
            ''  => '-- Pilih Bulan --',
            1   => 'Januari',
            2   => 'Februari',
            3   => 'Maret',
            4   => 'April',
            5   => 'May',
            6   => 'Juni',
            7   => 'Juli',
            8   => 'Agustus',
            9   => 'September',
            10  => 'Oktober',
            11  => 'November',
            12  => 'Desember',
        );

        return $data;
    }

    public function listview()
    {

        // Get Session
        $session = $this->app_loader->current_account();

        if (!$this->input->is_ajax_request() || empty($session)) {
            exit('No direct script access allowed');
        } else {
            $param = $this->input->post('param', true);
            $resultDT = $this->mkd->process_datatables($param);
            $resultDT['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($resultDT));
        }
    }


    public function create()
    {

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {

            if ($this->mkd->validasiDataValue('new') == false) {
                $result = array('status' => 0, 'message' => $this->form_validation->error_array());
            } else {
                $result = $this->mkd->insert_data();
            }

            $result['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function delete()
    {

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session   = $this->app_loader->current_account();
            $id_kom_inflasi     = $this->encryption->decrypt($this->input->post('id_kom_inflasi', true));
            if (!empty($session)) {
                $data = $this->mkd->delete_data();
                if ($data['message'] == 'SUCCESS') {
                    $result = array('status' => 1, 'message' => 'Data komoditas inflasi berhasil dihapus...', 'csrf' => $this->csrf);
                } else {
                    $result = array('status' => 0, 'message' => 'Proses delete data komoditas inflasi gagal, silahkan periksa kembali data yang akan dihapus...', 'csrf' => $this->csrf);
                }
            } else {
                $result = array('status' => 0, 'message' => 'Proses delete data gagal...', 'csrf' => $this->csrf);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function update()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $result = $this->mkd->update_data();
            $result['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }


    public function export_to_excel()
    {
        require_once APPPATH . 'third_party/php_excel/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $template  = 'repository/template/komoditas_deflasi.xls';
        $objPHPExcel = $objReader->load($template);
        //get data
        $jenis       = escape($this->input->get('jenis', TRUE));
        $bulan       = escape($this->input->get('bulan', TRUE));

        $komoditas_deflasi   = $this->mkd->ListKomdeflasiReport($jenis, $bulan);

        //set title
        // $objPHPExcel->setActiveSheetIndex(0)->getStyle('E')->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'DATA KOMODITAS PENYUMBANG DEFLASI PROVINSI SUMATERA BARAT');
        //set data hospital
        $noRow = 0;
        $baseRow = 6;
        if (count($komoditas_deflasi) > 0) {
            foreach ($komoditas_deflasi as $key => $dh) {
                $noRow++;
                $objPHPExcel->setActiveSheetIndex(0)->getRowDimension(12)->setRowHeight(-1);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('E')->getAlignment()->setWrapText(true);
                $row = $baseRow + $noRow;
                $objPHPExcel->setActiveSheetIndex(0)->insertNewRowBefore($row, 1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $row, $noRow);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $row, $dh['nama_komoditas_penyumbang']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $row, $dh['bulan']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $row, $dh['inflasi_deflasi']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $row, $dh['andil']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $row, $dh['jenis_komoditas']);
                // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $row, $dh['jumlah_realisasi']);
                // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $row, $dh['nomor']);
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
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $row, '');
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $row, '');
        }
        $objPHPExcel->setActiveSheetIndex(0)->removeRow($baseRow, 1);
        $file    = 'komoditas_deflasi.xls';
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
