<?php

/**
 * Controler de Reservas de salas.
 * @author Adalberto Silva <adalsilv@yahoo.com.br>
 */
class Reservations extends CI_Controller
{
    /**
     * Reservations constructor.
     */
    function __construct() {
        parent::__construct();
        $this->load->model('ReservationsModel', 'ReservationsModel');
    }

    /**
     * Página inicial para informações de reservas.
     * @return view
     */
    public function index()
    {
        $data['reservations'] = $this->ReservationsModel->getFullList();
        $this->load->view('reservations/index', $data);
    }

    /**
     * Carrega o formulário para novo cadastro
     */
    public function create()
    {
        $this->load->model('UsersModel', 'UsersModel');
        $this->load->model('RoomsModel', 'RoomsModel');
        $this->UsersModel->logged();

        $rooms = $this->RoomsModel->getViewList();

        $data['title'] = 'Nova Reserva';
        $data['rooms'] = $rooms;
        $data['userId'] = $this->UsersModel->getLoggedUserId();
        $this->load->view('reservations/store', $data);
    }

    /**
     * Salva o registro no banco de dados.
     */
    public function store()
    {
        $this->load->model('UsersModel', 'UsersModel');
        $this->UsersModel->logged();

        $this->load->library('form_validation');

        $regras = [
            [
                'field' => 'roomId',
                'label' => 'Sala',
                'rules' => 'required'
            ],
            [
                'field' => 'reservationDate',
                'label' => 'Horário',
                'rules' => 'required'
            ],
            [
                'field' => 'userId',
                'label' => 'userId',
                'rules' => 'required'
            ]
        ];

        $this->form_validation->set_rules($regras);

        $validate = $this->form_validation->run() != false;

        $roomId = $this->input->post('roomId');
        $reservationDate = $this->input->post('reservationDate');
        $userId = $this->input->post('userId');

        if ($validate) {
            $roomReserved = $this->ReservationsModel->isRoomReserved(
                $roomId,
                $reservationDate
            );

            $userHasRoomReserved = $this->ReservationsModel->userHasRoomReserved(
                $userId,
                $reservationDate
            );

            if ($roomReserved) {
                $message = '</br>Sala já está reservada para o horário.';
                $validate = false;
            }

            if ($userHasRoomReserved) {
                $message .= '</br>Você já possui uma reserva para esse horário.';
                $validate = false;
            }
        }

        if (!$validate) {
            $data['title'] = 'Nova Reserva';
            $this->load->view('reservations/store', $data);
            $this->session->set_flashdata('message', $message);
            redirect('/reservations');
        }

        $dados = [
            "userId" => $userId,
            "roomId" => $roomId,
            "reservationDate" => $reservationDate
        ];

        if ($this->ReservationsModel->store($dados)) {
            $message = 'Dados gravados com sucesso!';
        } else {
            $message = "Ocorreu um erro. Por favor, tente novamente.";
        }
        $this->session->set_flashdata('message', $message);
        redirect('/reservations');
    }

    /**
     * Função que exclui o registro através do id.
     * @param int $id Identificador do registro a ser excluído.
     */
    public function delete($id = null) {
        $this->load->model('UsersModel', 'UsersModel');
        $this->UsersModel->logged();

        if ($this->ReservationsModel->delete($id)) {
            $message = "Registro excluído com sucesso!";
        } else {
            $message = "Ocorreu um erro ao excluir o registro.";
        }

        $this->session->set_flashdata('message', $message);
        redirect('/reservations');
    }
}
