<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of FRONT_Controller class
 *
 * @author  Yogi Kaputra
 * @since   1.0
 *
 *
 */

class FRONT_Controller extends MY_Controller {

  var $session_info = array();

  public function __construct() {
    parent::__construct();

    $this->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0, max-age=0', FALSE);
		$this->output->set_header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		$this->output->set_header('Pragma: no-cache');

    $this->session_info['app_name']   = "Si - Darek";
    $this->session_info['app_footer'] = "Hak Cipta ©" . ((date('Y') == "2020") ? "2020" : "2020 - ".date('Y')) . " " . "Tanggap Covid-19. <i>Powerd by</i> Team IT Kominfo Prov. Sumbar";

    //$this->load->library('Menu_loader');

    // Setting up the template
    $this->template->set_layout('espire');
    $this->template->enable_parser(FALSE); // default true

    $this->template->set_partial('header', 'layouts/espire/header', FALSE);
    $this->template->set_partial('title', 'layouts/espire/title', FALSE);
    $this->template->set_partial('navigation', 'layouts/espire/navigation', FALSE);
    $this->template->set_partial('footer', 'layouts/espire/footer', FALSE);
    $this->template->set_partial('javascript', 'layouts/espire/javascript', FALSE);
  }

}

// This is the end of WRC_AdminCont class
