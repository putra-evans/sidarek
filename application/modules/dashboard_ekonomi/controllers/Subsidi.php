<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of home class
 *
 * @author Yuda Pramana
 */

class Subsidi extends SLP_Controller
{

    private $csrf;

    public function __construct()
    {
        parent::__construct();
        $this->csrf = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );
    }

    public function index()
    {
        $this->breadcrumb->add('Dashboard', site_url('home'));
        $this->breadcrumb->add('Perkembangan Realisasi Subsidi', '#');
        $this->session_info['subsidi'] = $this->getSubsidi();

        $this->session_info['page_name'] = "Perkembangan Realisasi Subsidi";
        $this->template->build('form_subsidi/list', $this->session_info);
    }

    public function getSubsidi()
    {
        $query = $this->db->get("ma_subsidi");
        $data = [];
        $data[''] = '-- Semua Subsidi --';
        foreach ($query->result() as $key => $value) {
            $data[$value->id_subsidi] = $value->nama;
        }

        return $data;
    }
}

// This is the end of home class
