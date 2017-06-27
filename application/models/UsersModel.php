<?php

/**
 * Classe base de usuários.
 * @author Adalberto Silva <adalsilv@yahoo.com.br>
 */
class UsersModel extends CI_Model
{
    private $model =  'users';

    /**
     * Validação de e-mail e senha de usuários.
     *
     * @return bool
     */
    public function validate()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $this->db->where('status', 1);

        $query = $this->db->get($this->model);

        if ($query->num_rows() >= 1) {
            $this->session->set_userdata(['userId' => $query->row()->id]);
            return true;
        }
        $this->session->set_userdata(['userId' => 0]);
        return false;
    }

    /**
     * Informa se existe um usuário logado atualmente.
     */
    public function logged() {
        $logged = $this->session->userdata('logged');

        if (!isset($logged) || $logged != true) {
            echo 'Você não possui permissão, acesse o link abaixo para efetuar o login:'
            . '</br><a href="' . site_url("login"). '">Efetuar Login</a>';
            anchor('cadastro/create', 'Efetuar Login');
            die();
        }
    }

    /**
     * Retorna id do usuário logado atualmente.
     *
     * @return int
     */
    public function getLoggedUserId()
    {
        return $this->session->userdata('userId');
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
