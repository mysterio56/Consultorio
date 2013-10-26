<!DOCTYPE html>
<html lang="en">
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
		<header class="header-container">
			<div id="header">
				<div id="logo">
					<a href="<?php echo base_url("welcome");?>">
						<img src="<?php echo base_url("assets/images/header_logo.png");?>" />
					</a>
				</div>
				<div id="menu">
					<?php if ($this->session->userdata('username')): ?>
						<?php $this->load->view('menu_header'); ?>
						
						<div id="welcome">
							<p>Bienvenido:</p><strong><?= $user_name = "&nbsp;Dr. Francisco Javier Sanchez Rosales"; ?></strong><a id="logout" href="<?= base_url(); ?>login/logout">Cerrar Sesión</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</header>
	<div id="wrapper">
