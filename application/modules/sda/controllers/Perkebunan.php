<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of OTG class
 *
 * @author Yuda Pramana
 */

class Perkebunan extends SLP_Controller
{

    private $csrf;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_perkebunan' => 'mp'));
        $this->csrf = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );
    }

    public function index()
    {
        $this->breadcrumb->add('Dashboard', site_url('home'));
        $this->breadcrumb->add('Perkebunan', '#');

        $this->session_info['page_name'] = "Perkebunan";
        $this->session_info['list_sektor']    = $this->mp->getListSektor();
        $this->session_info['list_komoditi']    = $this->mp->getListKomoditi();
        $this->template->build('form_perkebunan/list', $this->session_info);
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
                $result = $this->mp->insert_data_produksi();
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
                $data = $this->mp->delete_data_produksi();
                if ($data['message'] == 'SUCCESS') {
                    $result = array('status' => 1, 'message' => 'Data Perkebunan Berhasil Dihapus...', 'csrf' => $this->csrf);
                } else {
                    $result = array('status' => 0, 'message' => 'Proses delete data gagal, silahkan periksa kembali data yang akan dihapus...', 'csrf' => $this->csrf);
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
            $result = $this->mp->update_data_produksi();
            $result['csrf'] = $this->csrf;
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function fetch()
    {

        // Get Data from POST
        $tabel = $this->input->post('tabel');
        $id = $this->input->post('id');

        // Get Data from Query
        $this->db->from($tabel);
        $this->db->where('id_sektor', $id);
        $data = $this->db->get();

        // Generate Select Options
        $options = '<option value="">-- Semua Komoditi --</option>';
        foreach ($data->result() as $key => $value) {
            $options .= "<option value=" . $value->id_komoditi . ">" . $value->nama . "</option>";
        }

        $result = [
            'success' => 1,
            'options' => $options,
            'csrf' => $this->csrf
        ];

        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
    public function export_to_excel()
    {
        require_once APPPATH . 'third_party/php_excel/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $template  = 'repository/template/produksi_sda.xlsx';
        $objPHPExcel = $objReader->load($template);
        //get data
        $sektor      = escape($this->input->get('sektor', TRUE));
        $komoditi    = escape($this->input->get('komoditi', TRUE));

        $dataProduksi   = $this->mp->getDataListProduksiReport($sektor, $komoditi);

        //set title
        $objPHPExcel->setActiveSheetIndex(0)->getRowDimension(1)->setRowHeight(-1);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'PRODUKSI SUMBER DAYA ALAM');
        //set data produksi
        $noRow = 0;
        $baseRow = 6;
        if (count($dataProduksi) > 0) {
            foreach ($dataProduksi as $key => $dh) {
                $noRow++;
                $objPHPExcel->setActiveSheetIndex(0)->getRowDimension(12)->setRowHeight(-1);
                $objPHPExcel->setActiveSheetIndex(0)->getStyle('E')->getAlignment()->setWrapText(true);
                $row = $baseRow + $noRow;
                $objPHPExcel->setActiveSheetIndex(0)->insertNewRowBefore($row, 1);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $row, $noRow);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $row, $dh['sektor']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $row, $dh['komoditi']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $row, $dh['tahun']);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $row, $dh['produksi']);
                // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $row, $dh['sasaran']);
                // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $row, $dh['target']);
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
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $row, '');
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $row, '');
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $row, '');
            // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $row, '');
        }
        $objPHPExcel->setActiveSheetIndex(0)->removeRow($baseRow, 1);
        $file    = 'produksi_sda.xlsx';
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=$file");
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMp'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMp'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
}
