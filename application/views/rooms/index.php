<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meetings Manager</title>
    <?= link_tag('assets/css/bootstrap.min.css') ?>
    <?= link_tag('assets/css/bootstrap-theme.min.css') ?>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url('') ?>">Meetings Manager</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo site_url('reservations') ?>">Reservas</a></li>
                    <li><a href="<?php echo site_url('rooms') ?>">Salas</a></li>
                    <li><a href="<?php echo site_url('users') ?>">Usuários</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?php echo site_url('login') ?>">Efetuar Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <h1 class="text-center">Meetings Manager</h1>
    <div class="col-md-12">
        <div class="row">
            <?= anchor('rooms/create', 'Novo Cadastro', array('class' => 'btn btn-success')); ?>
        </div>
        <div class="alert">
            <?php $message = $this->session->flashdata('message');
                if ($message) {
                    echo $message;
                }
            ?>
        </div>
        <div class="row">
            <?php if ($rooms->num_rows() > 0): ?>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Lugares</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($rooms->result() as $room): ?>
                        <tr>
                            <td><?= $room->id ?></td>
                            <td><?= $room->name ?></td>
                            <td><?= $room->seats ?></td>
                            <td><?= anchor("rooms/edit/$room->id", "Editar") ?>
                                | <a href="#" class='confirma_exclusao' data-id="<?= $room->id ?>" data-name="<?= $room->name ?>" />Excluir</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <h4>Nenhum registro cadastrado.</h4>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_confirmation">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Confirmação de Exclusão</h4>
            </div>
            <div class="modal-body">
                <p>Deseja realmente excluir o registro <strong><span id="name_exclusao"></span></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                <button type="button" class="btn btn-danger" id="btn_excluir">Excluir</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="<?= base_url('assets/js/jquery.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>

<script>

    var base_url = "<?= base_url(); ?>";

    $(function(){
        $('.confirma_exclusao').on('click', function(e) {
            e.preventDefault();

            var name = $(this).data('name');
            var id = $(this).data('id');

            $('#modal_confirmation').data('name', name);
            $('#modal_confirmation').data('id', id);
            $('#modal_confirmation').modal('show');
        });

        $('#modal_confirmation').on('show.bs.modal', function () {
            var name = $(this).data('name');
            $('#name_exclusao').text(name);
        });

        $('#btn_excluir').click(function(){
            var id = $('#modal_confirmation').data('id');
            document.location.href = base_url + "/rooms/delete/"+id;
        });
    });
</script>

</body>
</html>