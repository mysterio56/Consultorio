<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<title><?= $title ?></title>
		<?php
			if(isset($cssFiles) && is_array($cssFiles)){
				foreach($cssFiles as $cssFile) {
		        	echo '<link href="'.base_url('assets/css/'.$cssFile).'" rel="stylesheet" type="text/css" />';
		        } 
		    }
        ?>
        <?php
	        if(isset($jsFiles) && is_array($jsFiles)){
				foreach($jsFiles as $jsFile) {
					echo '<script src="'.base_url('assets/js/'.$jsFile).'" type="text/javascript"></script>';
		        }
		    } 
        ?>
	</head>
	<body>
		<?php if ($this->session->userdata('username')): ?>
		<header class="header-container">
			<div id="header">
				<div id="logo">
					<a href="<?php echo base_url("welcome");?>">
						<?php if ($this->session->userdata('username')): ?>
							<img src="<?php echo base_url("assets/images/logos/".$logo."_logo.png");?>" />
						<?php endif; ?>
					</a>
				</div>
				<div id="menu">
					<?php if ($this->session->userdata('username')): ?>
						<?php $this->load->view('menu_header'); ?>
						<div id="welcome">
							<p>Bienvenido:</p><strong><?= "&nbsp".$this->session->userdata('nombre_completo'); ?></strong><a id="logout" href="<?= base_url(); ?>login/logout">Cerrar Sesión</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</header>
	<?php endif; ?>
		
	<?php if ($this->session->userdata('username')): ?>
	<?php $this->load->view('banner');	?>		
	<div id="wrapper">
	<?php else: ?>	
		<div id="wrapper_login">
	<?php endif; ?>
