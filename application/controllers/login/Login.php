<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controller para Login de usuários
 */
class Login extends CI_Controller {

    /**
     * Login constructor.
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * Função relacionada a página inicial da controller login.
     *
     * Caso o usuário já esteja logado, é redirecionado para a página inicial
     * da aplicação, que é a index de reservas.
     */
    function index()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'E-mail', 'required');
        $this->form_validation->set_rules('password', 'Senha', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        $this->load->model('UsersModel', 'UsersModel');
        $query = $this->UsersModel->validate();

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login/login');
        } else {

            if ($query) {
                $data = array(
                    'email' => $this->input->post('email'),
                    'logged' => true
                );
                $this->session->set_userdata($data);
                redirect();
            } else {
                redirect($this->index());
            }
        }
    }
}