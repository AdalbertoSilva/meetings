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
	<style>
		.erro {
			color: #f00;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1 class="text-center"><?= $title ?></h1>
		<div class="col-md-6 col-md-offset-3">
			<div class="row">
				<?= form_open('rooms/store')  ?>
					<div class="form-group">
						<label for="name">Nome</label><span class="erro"><?php echo form_error('name') ?  : ''; ?></span>
						<input type="text" name="name" id="name" class="form-control" value="<?= set_value('name') ? : (isset($name) ? $name : '') ?>" autofocus='true' />
					</div>
					<div class="form-group">
						<label for="seats">Lugares</label><span class="erro"><?php echo form_error('seats') ?  : ''; ?></span>
						<input type="text" name="seats" id="seats" class="form-control" value="<?= set_value('seats') ? : (isset($seats) ? $seats : ''); ?>" />
					</div>
					<div class="form-group text-right">
						<input type="submit" value="Salvar" class="btn btn-success" />
                        <?= anchor('', 'Voltar', ['class' => 'btn btn-default']) ?>
					</div>
					<input type='hidden' name="id" value="<?= set_value('id') ? : (isset($id) ? $id : ''); ?>">
				<?= form_close(); ?>
			</div>
			<div class="row"><hr></div>
		</div>	
	</div>
</body>
</html>