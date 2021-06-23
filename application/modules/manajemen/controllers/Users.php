<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of users class
 *
 * @author Yogi "solop" Kaputra
 */

class Users extends SLP_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_users' => 'muser'));
    }

    public function index()
    {
        $this->breadcrumb->add('Dashboard', site_url('home'));
        $this->breadcrumb->add('Manajemen', '#');
        $this->breadcrumb->add('Users', site_url('manajemen/users'));

        $this->session_info['page_name']    = "Users";
        $this->session_info['data_level']   = $this->muser->getDataLevelAkses();
        $this->session_info['data_group']		= $this->muser->getDataListGroup();
        $this->template->build('form_admin/list', $this->session_info);
    }

    public function listview()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $data = array();
            $session = $this->app_loader->current_account();
            if (isset($session)) {
                $param = $this->input->post('param', true);
                $dataUser = $this->muser->get_datatables($param);
                $no = $this->input->post('start');
                foreach ($dataUser as $key => $u) {
                    $no++;
                    $row = array();
                    $arrGroup = explode(',', $u['group_user']);
                    $nm_group = '<ul style="margin-left:-30px;">';
                    foreach ($arrGroup as $g) {
                        $nm_group .= '<li>'.$g.'</li>';
                    }
                    $nm_group .= '</ul>';
                    $password = ($this->app_loader->is_admin()) ? '<li><strong>Password :</strong> '.$u['pass_plain'].'</li>' : '';
                    $row[] = '<input type="checkbox" name="checkid[]" value="'.$u['token'].'" onclick="event.stopPropagation();">';
                    $row[] = $no;
                    $row[] = '<ul class="list-unstyled" style="margin-bottom:0px;">'.
                          '<li><strong>Username :</strong> '.$u['username'].'</li>'.
                           $password.
                        '</ul>';
                    $row[] = $u['fullname'];
                    $row[] = ($u['email'] != '') ? $u['email'] : '-';
                    $row[] = $nm_group;
                    $row[] = convert_blokir($u['blokir']);
                    $row[] = convert_status($u['id_status']);
                    $row[] = '<button type="button" class="btn btn-xs btn-orange btnEdit" data-token="'.$u['token'].'" title="Edit data user"><i class="fa fa-pencil"></i> </button>';
                    $data[] = $row;
                }

                $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->muser->count_all(),
            "recordsFiltered" => $this->muser->count_filtered($param),
            "data" => $data,
          );
            }
            //output to json format
            echo json_encode($output);
        }
    }

    public function details()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $token  	= escape($this->input->post('tokenId', true));
            if (!empty($token) and !empty($session)) {
                $data = $this->muser->getDataDetailUsers($token);
                $row = array();
                $row['fullname']	= !empty($data) ? $data['fullname'] : '';
                $row['username']	= !empty($data) ? $data['username'] : '';
                $row['email']			= !empty($data) ? $data['email'] : '';
                $row['blokir']		= !empty($data) ? $data['blokir'] : 0;
                $row['status']		= !empty($data) ? $data['id_status'] : 1;
                $row['groupid']		= !empty($data) ? explode(',', str_replace(' ', '', $data['group_user'])) : array();
                $result = array('status' => 1, 'message' => $row, 'csrfHash' => $csrfHash);
            } else {
                $result = array('status' => 0, 'message' => array(), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function create()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            if (!empty($session)) {
                if ($this->muser->validasiDataValue('new') == false) {
                    $result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
                } else {
                    $data = $this->muser->insertDataUsers();
                    if ($data['message'] == 'ERROR') {
                        $result = array('status' => 0, 'message' => array('isi' => 'Username <b>'.$data['note'].'</b> yang diinputkan sudah ada yang menggunakan, silakan inputkan username lain...'), 'csrfHash' => $csrfHash);
                    } elseif ($data['message'] == 'SUCCESS') {
                        $result = array('status' => 1, 'message' => 'Data user <b>'.$data['note'].'</b> berhasil ditambahkan...', 'csrfHash' => $csrfHash);
                    }
                }
            } else {
                $result = array('status' => 0, 'message' => array('isi' => 'Proses input data user gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function update()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $token 		= escape($this->input->post('tokenId', true));
            if (!empty($session) and !empty($token)) {
                if ($this->muser->validasiDataValue('edit') == false) {
                    $result = array('status' => 0, 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
                } else {
                    $data = $this->muser->updateDataUsers();
                    if ($data['message'] == 'NODATA') {
                        $result = array('status' => 0, 'message' => array('isi' => 'Data user <b>'.$data['note'].'</b> gagal diupdate karena data tidak ditemukan, silahkan periksa kembali...'), 'csrfHash' => $csrfHash);
                    } elseif ($data['message'] == 'ERROR') {
                        $result = array('status' => 0, 'message' => array('isi' => 'Proses update data <b>'.$data['note'].'</b> gagal, karena username yang diinputkan sudah ada yang menggunakan, silakan inputkan username lain...'), 'csrfHash' => $csrfHash);
                    } elseif ($data['message'] == 'SUCCESS') {
                        $result = array('status' => 1, 'message' => 'Data user <b>'.$data['note'].'</b> berhasil diperbaharui...', 'csrfHash' => $csrfHash);
                    }
                }
            } else {
                $result = array('status' => 0, 'message' => array('isi' => 'Proses update data user gagal, mohon periksa data kembali...'), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function delete()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session   = $this->app_loader->current_account();
            $csrfHash  = $this->security->get_csrf_hash();
            $token     = escape($this->input->post('tokenId', true));
            if (!empty($session) and !empty($token)) {
                $data = $this->muser->deleteDataUsers();
                if ($data['message'] == 'SUCCESS') {
                    $result = array('status' => 1, 'message' => 'Data user berhasil dihapus...', 'csrfHash' => $csrfHash);
                } else {
                    $result = array('status' => 0, 'message' => 'Proses delete data user gagal, silahkan periksa kembali data yang akan dihapus...', 'csrfHash' => $csrfHash);
                }
            } else {
                $result = array('status' => 0, 'message' => 'Proses delete data gagal...', 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function searching()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $username = escape($this->input->post('username', true));
            if (!empty($session) and !empty($username)) {
                $data  = $this->muser->searchDataUsername($username);
                $result = array('message' => $data, 'csrfHash' => $csrfHash);
            } else {
                $result = array('message' => 0, 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }
}

// This is the end of users class
