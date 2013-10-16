<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?= $title ?></title>
	<link rel="stylesheet" href="<?php echo base_url("assets/css/styles.css");?>" type="text/css" media="screen"/>
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
						<div id="logout">
							<a href="<?php echo base_url();?>login/logout">Cerrar Sesión</a>
						</div>
						<div id="welcome">
							<p>Bienvenido:</p><strong><?php echo $user_name = "&nbsp;Dr. Francisco Javier Sanchez Rosales"; ?></strong>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</header>
	<div id="wrapper">
