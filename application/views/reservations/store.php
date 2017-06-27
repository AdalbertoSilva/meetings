<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $title ?> - Manager</title>
	<?= link_tag('assets/css/bootstrap.min.css') ?>
	<?= link_tag('assets/css/bootstrap-theme.min.css') ?>

    <script src="<?php echo base_url();?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url();?>assets/js/moment.js"></script>
    <script src="<?php echo base_url();?>assets/datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.js"></script>

    <script>
        $(document).ready(function(){
            $('#reservationDate').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD HH:mm:ss', minDate : new Date()  });

        });
    </script>

    <link href="<?php echo base_url();?>assets/datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">

	<style>
		.erro {
			color: #f00;
		}
	</style>
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
		<h1 class="text-center"><?= $title ?></h1>
		<div class="col-md-6 col-md-offset-3">
			<div class="row">
				<?= form_open('reservations/store') ?>
					<div class="form-group">
						<label for="reservationDate">Data de Reserva</label><span class="erro"><?php echo form_error('reservationDate') ?  : ''; ?></span>
						<input type="text" name="reservationDate" id="reservationDate" class="form-control" value="" autofocus='true' />
					</div>
					<div class="form-group">
						<label for="telefone">Sala</label><span class="erro"><?php echo form_error('room') ?  : ''; ?></span>
                        <?php echo form_dropdown('roomId', $rooms); ?>
					</div>
					<div class="form-group text-right">
						<input type="submit" value="Salvar" class="btn btn-success" />
                        <?= anchor('', 'Voltar', ['class' => 'btn btn-default']) ?>
					</div>
					<input type='hidden' name="id" value="<?= set_value('id') ? : (isset($id) ? $id : ''); ?>">
                    <input type='hidden' name="userId" value="<?= set_value('userId') ? : (isset($userId) ? $userId : ''); ?>">
				<?= form_close(); ?>
			</div>
			<div class="row"><hr></div>
		</div>	
	</div>
</body>
</html>