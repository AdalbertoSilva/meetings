<?php

/**
 * Classe base de reservas de salas.
 * @author Adalberto Silva <adalsilv@yahoo.com.br>
 */
class ReservationsModel extends CI_Model
{
    private $model = 'reservations';

    public function getLoggedUserId()
    {
        return $this->loggedUserId;
    }

    /**
     * Grava os dados na tabela.
     *
     * Caso o identificador seja informado é executada uma atualização,
     * do contrário é criado um novo registro.
     *
     * @param array $dados.
     * @param int $id Identificador.
     * @return boolean
     */
    public function store($dados, $id = null)
    {
        if (!$dados) {
            return false;
        }

        if ($id) {
            $this->db->where('id', $id);
            if ($this->db->update($this->model, $dados)) {
                return true;
            }
            return false;
        }

        if ($this->db->insert($this->model, $dados)) {
            return true;
        }
        return false;
    }

    /**
     * Busca informações de model, com base no id
     *
     * @param int $id Identificador no banco de
     *
     * @return bool|object
     */
    public function getById($id = null)
    {
        if (!$id) {
            return false;
        }

        $this->db->where('id', $id);
        return $this->db->get($this->model);
    }

    /**
     * Busca listagem de model.
     *
     * @return bool|object
     */
    public function getList()
    {
        $this->db->order_by("id", 'desc');
        return $this->db->get($this->model);
    }

    public function getFullList()
    {
        return $this->db->select(
            'reservations.id, '
            . 'reservations.reservationDate, '
            . 'users.name as userName, '
            . 'rooms.name as roomName'
        )
            ->order_by("id", 'desc')
            ->join('users', 'users.id = reservations.userId')
            ->join('rooms', 'rooms.id = reservations.roomId')
            ->get($this->model);
    }

    /**
     * Verifica se a sala não está reservada para aquele horário.
     *
     * @param int $roomId
     * @param string $reservationDate
     *
     * @return bool
     */
    public function isRoomReserved($roomId, $reservationDate)
    {
        $isRoomReserved = false;

        $this->db->where('roomId', $roomId);
        $reservations = $this->db->get($this->model)->result();

        foreach ($reservations as $reservation) {
            if ($isRoomReserved) {
                break;
            }
            $isRoomReserved = $this->compareTime($reservation->reservationDate, $reservationDate);
        }

        return $isRoomReserved;
    }

    /**
     * Verifica se usuário não possui uma sala reservada para o mesmo horário.
     *
     * @param int $userId
     * @param string $reservationDate
     *
     * @return bool
     */
    public function userHasRoomReserved($userId, $reservationDate)
    {
        $isRoomReserved = false;

        $this->db->where('userId', $userId);
        $reservations = $this->db->get($this->model)->result();

        foreach ($reservations as $reservation) {
            if ($isRoomReserved) {
                break;
            }
            $isRoomReserved = $this->compareTime($reservation->reservationDate, $reservationDate);
        }

        return $isRoomReserved;


    }

    /**
     * Deleta um registro.
     *
     * Altera o status de um usuário para 0, de forma a manter os registros
     * feitos por ele, mas sem que ele possa realizar o acesso o reservar mais
     * salas.
     *
     * @param int $id Identificador do dado a ser excluído
     * @return boolean;
     */
    public function delete($id)
    {
        if ($id) {
            $this->db->where('id', $id);
            if ($this->db->delete($this->model)) {
                return true;
            }
            return false;
        }

        return false;
    }

    /**
     * Compara dois periodos e informa se a diferença for menor do que uma hora.
     *
     * @param $savedReservationDateString
     * @param $newReservationDateString
     * @return bool
     */
    private function compareTime($savedReservationDateString, $newReservationDateString)
    {
        $result = false;
        $dateFormat = 'Y-m-d H:i:s';

        $savedDate = DateTime::createFromFormat(
            $dateFormat,
            $savedReservationDateString
        );

        $newDate = DateTime::createFromFormat(
            $dateFormat,
            $newReservationDateString
        );

        $diff = $newDate->diff($savedDate)->h;

        if ($diff == 0) {
            $result = true;
        }
        return $result;
    }
}
