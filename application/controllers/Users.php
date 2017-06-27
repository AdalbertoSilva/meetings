<?php

/**
 * Controller para usuários
 * @author Adalberto Silva <adalsilv@yahoo.com.br>
 */
class Users extends CI_Controller
{
    /**
     * Users constructor.
     */
    function __construct() {
        parent::__construct();
        $this->load->model('UsersModel', 'UsersModel');
    }
    /**
     * Página inicial para informações de usuários.
     * @return view
     */
    public function index()
    {
        $data['users'] = $this->UsersModel->getList();
        $this->load->view('users/index', $data);
    }
    /**
     * Carrega o formulário para novo cadastro
     */
    public function create()
    {
        $data['title'] = 'Usuários';
        $this->load->view('users/store', $data);
    }

    /**
     * Salva o registro no banco de dados.
     */
    public function store()
    {
        $this->load->library('form_validation');

        $regras = [
            [
                'field' => 'email',
                'label' => 'E-mail',
                'rules' => 'required|valid_email'
            ],
            [
                'field' => 'name',
                'label' => 'Nome',
                'rules' => 'required'
            ],
            [
                'field' => 'password',
                'label' => 'Senha',
                'rules' => 'required'
            ]
        ];

        $this->form_validation->set_rules($regras);

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Novo Registro';
            $this->load->view('users/store', $data);
        } else {

            $id = $this->input->post('id');

            $dados = [
                "name" => $this->input->post('name'),
                "password" => $this->input->post('password'),
                "email" => $this->input->post('email'),
            ];

            if ($this->UsersModel->store($dados, $id)) {
                $message = 'Dados gravados com sucesso!';
            } else {
                $message = "Ocorreu um erro. Por favor, tente novamente.";
            }
            $this->session->set_flashdata('message', $message);
            redirect('/users');
        }
    }

    /**
     * Edição de cadastro.
     * @param int $id Identificador do registro
     */
    public function edit($id){

        if (!isset($id)) {
            $message = "Registro não encontrado." ;
            $this->session->set_flashdata('message', $message);
            redirect('/users');
        }

        $cadastros = $this->UsersModel->getById($id);

        if ($cadastros->num_rows() < 1 ) {
            $message = "Registro não encontrado." ;
            $this->session->set_flashdata('message', $message);
            redirect('/users');
        }

        $data = [
            'title' => 'Edição de Registro',
            'id' => $cadastros->row()->id,
            'name' => $cadastros->row()->name,
            'password' => $cadastros->row()->password,
            'email' => $cadastros->row()->email
        ];

        $this->load->view('users/store', $data);
    }

    /**
     * Função que exclui o registro através do id.
     * @param int $id Identificador do registro a ser excluído.
     */
    public function delete($id = null) {
        if ($this->UsersModel->delete($id)) {
            $message = "Registro excluído com sucesso!";
        } else {
            $message = "Ocorreu um erro ao excluir o registro.";
        }

        $this->session->set_flashdata('message', $message);
        redirect('/users');
    }

    /**
     * @return object
     */
    public function getLoad()
    {
        $this->load->view('template/menu');
    }
}
