<script>
	$(function(){ Valid.login() });
</script>
<div id="login_form" >

	 <?php

	 	if (isset($error_menssage)){
	 		echo '<div class="error">'.$error_menssage.'</div>';
	 	}

	    $attributes = array('id' => 'loginForm');
//
	 	
	 	 echo form_open(null,$attributes);
	 	 echo'<table >';
			
			echo '<tr>';
				echo '<td colspan="100%" align="center">';
				 	 echo '<a href="http://masqweb.com/" target="_blank"> 
				 	 			<img style="width: 200px;" src="'.base_url("assets/images/footer-logo.png").'" />
				 	 	   </a>';
				echo '</td>';
			echo '</tr>';

               echo'<tr>';

        echo '<td>';
	 		echo form_label('Usuario : ');
	 		echo'</td>';

        echo '<td>';
		 	$data = array(
		 		'name'  => 'usuario',
		 		'id'    => 'usuario',
		 		'value' => set_value('usuario')
		 	);

		 	echo form_input($data);
		 	   echo'</tr>';
        echo '</td>';

           echo'<tr>';
        echo '<td>';
        echo form_label('Clave : ');
           echo'</td>';

        echo '<td>';
		 	$data = array(
		 		'name'  =>  'password',
		 		'id'    => 'password',
		 		'value' => set_value('password')
		 	);

		 	echo form_password($data);
		 	   echo '</td>';
		 	   echo'</tr>';
               echo'</table>';
        
           
		 	$data = array(
		 		'name'  => 'login',
		 		'id'    => 'login',
		 		'value' => 'Entrar',
		 		'class' => 'abutton',
		 		'style' => 'font-size: 20px;width:50%'
		 	);

		 	echo form_submit($data);
		 	
		 	

	 	echo form_close(); 
	 ?>

</div>