<script>
	$(function(){ Valid.login() });
</script>
<div id="login_form" 
	 style="width:480px; height:280px; margin:0 auto; border-radius:5px; border:1px solid #909090; padding:20px" >

	 <?php

	 	if (isset($error_menssage)){
	 		echo '<div class="error">'.$error_menssage.'</div>';
	 	}

	    $attributes = array('id' => 'loginForm');
//
	 	echo form_open(null,$attributes);
	 	 
	 	 echo'<table width="300" height="200" class="login">';
               echo'<tr>';

        echo '<td width=20% valing="top">';
	 		echo form_label('Usuario : ');
	 		echo'</td>';

        echo '<td width=20% valing="top">';
		 	$data = array(
		 		'name'  => 'usuario',
		 		'id'    => 'usuario',
		 		'value' => set_value('usuario'),
		 		'class' => 'login',
		 		'style' => 'width:130%'
		 	);

		 	echo form_input($data);
		 	   echo'</tr>';
        echo '</td>';

           echo'<tr>';
        echo '<td width=20% valing="top">';
        echo form_label('Password : ');
           echo'</td>';

        echo '<td width=20% valing="top">';
		 	$data = array(
		 		'name'  =>  'password',
		 		'id'    => 'password',
		 		'value' => set_value('password'),
		 		'class' => 'login',
		 		'style' => 'width:130%'
		 	);

		 	echo form_password($data);
		 	   echo '</td>';
		 	   echo'</tr>';
               echo'</table>';
        
           
		 	$data = array(
		 		'name'  =>  'login',
		 		'id'    => 'login',
		 		'value' => 'Login',
		 		'class' => 'abutton',
		 		'style' => 'width:50%'
		 	);

		 	echo form_submit($data);
		 	
		 	

	 	echo form_close(); 
	 ?>

</div>