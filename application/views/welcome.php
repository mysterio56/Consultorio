<?php

	
	echo '<section class="main-container">';
		echo '<div id="div-container">';

		if($this->session->userdata('type_user') != 'admin'){
			
			$this->load->view('servicios');

		}

			$this->load->view('tabs');
			
		echo '</div>';
	echo '</section>';

?>