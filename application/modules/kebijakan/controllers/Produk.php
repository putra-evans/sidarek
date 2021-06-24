<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of OTG class
 *
 * @author Yuda Pramana
 */

class Produk extends SLP_Controller
{

    private $csrf;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_produk' => 'mp'));
        $this->csrf = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );
    }

    public function index()
    {
        $this->breadcrumb->add('Dashboard', site_url('home'));
        $this->breadcrumb->add('Produk Kebijakan', '#');

        $this->session_info['page_name']       = "Data Produk Kebijakan";
        $this->session_info['list_bidang']    = $this->mp->getListBidang();
        $this->template->build('form_produk/list', $this->session_info);
    }

    public function listview()
    {

        // Get Session
        $session = $this->app_loader->current_account();

        if (!$this->input->is_ajax_request() || empty($session)) {
            exit('No direct script access allowed');
        } else {
            $param = $this->input->post('param', true);
            $resultDT = $this->mp->process_datatables($param);
            $resultDT['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($resultDT));
        }
    }


    public function create()
    {

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {

            if ($this->mp->validasiDataValue('new') == false) {
                $result = array('status' => 0, 'message' => $this->form_validation->error_array());
            } else {
                $result = $this->mp->insert_data_produk();
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
            $produkId     = $this->encryption->decrypt($this->input->post('produkId', true));
            if (!empty($session)) {
                $data = $this->mp->delete_data_produk();
                if ($data['message'] == 'SUCCESS') {
                    $result = array('status' => 1, 'message' => 'Data kebijakan berhasil dihapus...', 'csrf' => $this->csrf);
                } else {
                    $result = array('status' => 0, 'message' => 'Proses delete data kebijakan gagal, silahkan periksa kembali data yang akan dihapus...', 'csrf' => $this->csrf);
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
            $result = $this->mp->update_data_produk();
            $result['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function export_to_excel()
    {
        require_once APPPATH . 'third_party/php_excel/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $template  = 'repository/template/produk_kebijakan.xls';
        $objPHPExcel = $objReader->load($template);
        //get data
        $id_bidang       = escape($this->input->get('bidang', TRUE));
        $tahun        = escape($this->input->get('tahun', TRUE));
        $id_tipe         = escape($this->input->get('tipe', TRUE));

        // var_dump($id_bidang);
        // var_dump($tahun);
        // var_dump($id_tipe);
        // exit;
        $dataKebijakan   = $this->mp->getDataListProdukReport($id_bidang, $tahun, $id_tipe);

        //set title
        // $objPHPExcel->setActiveSheetIndex(0)->getStyle('E')->getAlignment()->setWrapText(true);
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'DAFTAR PRODUK KEBIJAKAN');
        //set data hospital
        $noRow = 0;
        $baseRow = 6;
        if (count($dataKebijakan) > 0) {
            foreach ($dataKebijakan as $key => $dh) {
                $noRow++;
                $objPHPExcel->setActiveSheetIndex(0)->getRowDimension(12)->setRowHeight(-1);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('E')->getAlignment()->setWrapText(true);
                $row = $baseRow + $noRow;
                $objPHPExcel->setActiveSheetIndex(0)->insertNewRowBefore($row, 1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $row, $noRow);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $row, $dh['nomor']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $row, $dh['nama']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $row, $dh['tahun']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $row, $dh['judul']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $row, $dh['sasaran']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $row, $dh['target']);
                // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $row, $dh['nomor']);
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
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $row, '');
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $row, '');
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $row, '');
        }
        $objPHPExcel->setActiveSheetIndex(0)->removeRow($baseRow, 1);
        $file    = 'produk_kebijakan.xls';
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
