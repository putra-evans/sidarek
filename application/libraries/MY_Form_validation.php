<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of SLP_Controller class
 *
 * @author  Yogi Kaputra
 * @since   1.0
 *
 *
 */

class MY_Form_validation extends CI_Form_validation
{

    public $CI;

    public function __construct()
    {
        parent::__construct();
    }

    function run($module = '', $group = '')
    {
        (is_object($module)) and $this->CI = &$module;
        return parent::run($group);
    }

    function config($param)
    {
        $config = array(
            'harga' => array(
                array(
                    'field' => 'id_komoditas',
                    'label' => 'id_komoditas',
                    'rules' => 'required',
                )
            )
        );
    }
}
