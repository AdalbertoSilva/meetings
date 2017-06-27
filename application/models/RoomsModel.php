<?php

/**
 * Classe base de salas.
 * @author Adalberto Silva <adalsilv@yahoo.com.br>
 */
class RoomsModel extends CI_Model
{
    private $model = 'rooms';
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

        $dados['status'] = 1;
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
        $this->db->where('status', 1);
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
        $this->db->where('status', 1);
        return $this->db->get($this->model);
    }

    /**
     * Busca relação de id e nome de salas ativas, para criação de listagem.
     */
    public function getViewList()
    {
        $roomsRawDataList = $this->getList()->result();

        $rooms = [];
        foreach ($roomsRawDataList as $roomsRawData) {
            $rooms[$roomsRawData->id] = $roomsRawData->name;
        }

        return $rooms;
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
            if ($this->db->update($this->model, ['status' => 0])) {
                return true;
            }
            return false;
        }

        return false;
    }
}
