<?php

/**
 * Controller de Salas
 */
class Rooms extends CI_Controller
{
    /**
     * Rooms constructor.
     */
    function __construct() {
        parent::__construct();
        $this->load->model('RoomsModel', 'RoomsModel');
    }
    /**
     * Página inicial para informações sobre salas.
     * @return view
     */
    public function index()
    {
        $data['rooms'] = $this->RoomsModel->getList();
        $this->load->view('rooms/index', $data);
    }
    /**
     * Carrega o formulário para novo cadastro
     */
    public function create()
    {
        $data['title'] = 'Novo Cadastro';
        $this->load->view('rooms/store', $data);
    }

    /**
     * Salva o registro no banco de dados.
     */
    public function store()
    {
        $this->load->library('form_validation');

        $regras = [
            [
                'field' => 'name',
                'label' => 'Nome',
                'rules' => 'required'
            ],
            [
                'field' => 'seats',
                'label' => 'Lugares',
                'rules' => 'required'
            ]
        ];

        $this->form_validation->set_rules($regras);

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Novo Registro';
            $this->load->view('rooms/store', $data);
        } else {

            $id = $this->input->post('id');

            $dados = [
                "name" => $this->input->post('name'),
                "seats" => $this->input->post('seats')
            ];

            if ($this->RoomsModel->store($dados, $id)) {
                $message = 'Dados gravados com sucesso!';
            } else {
                $message = "Ocorreu um erro. Por favor, tente novamente.";
            }
            $this->session->set_flashdata('message', $message);
            redirect('rooms/index');

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
            redirect('/rooms');
        }

        $cadastros = $this->RoomsModel->getById($id);

        if ($cadastros->num_rows() < 1 ) {
            $message = "Registro não encontrado." ;
            $this->session->set_flashdata('message', $message);
            redirect('/rooms');
        }

        $data = [
            'title' => 'Edição de Registro',
            'id' => $cadastros->row()->id,
            'name' => $cadastros->row()->name,
            'seats' => $cadastros->row()->seats,
        ];

        $this->load->view('rooms/store', $data);
    }

    /**
     * Função que exclui o registro através do id.
     * @param int $id Identificador do registro a ser excluído.
     */
    public function delete($id = null) {
        if ($this->RoomsModel->delete($id)) {
            $message = "Registro excluído com sucesso!";
        } else {
            $message = "Ocorreu um erro ao excluir o registro.";
        }

        $this->session->set_flashdata('message', $message);
        redirect('/rooms');
    }
}
