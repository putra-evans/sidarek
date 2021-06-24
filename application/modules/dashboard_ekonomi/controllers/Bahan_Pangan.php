<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of home class
 *
 * @author Yuda Pramana
 */

class Bahan_pangan extends SLP_Controller
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
        $this->breadcrumb->add('Perkembangan Harga Bahan Pangan', '#');

        $this->session_info['page_name'] = "Perkembangan Harga Bahan Pangan";
        $this->template->build('form_bahan_pangan/list', $this->session_info);
    }
}

// This is the end of home class
