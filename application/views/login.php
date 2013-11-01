<script>
	$(function(){ Valid.login() });
</script>
<div id="login_form" 
	 style="width:400px; margin:100px auto; border-radius:5px; border:1px solid #909090; pading:20px" >

	 <?php

	 	if (isset($error_menssage)){
	 		echo '<div class="error">'.$error_menssage.'</div>';
	 	}

	    $attributes = array('id' => 'loginForm');

	 	echo form_open(null,$attributes);

	 		echo form_label('Usuario : ');
		 	$data = array(
		 		'name'  => 'usuario',
		 		'id'    => 'usuario',
		 		'value' => set_value('usuario'),
		 		'style' => 'width:90%'
		 	);

		 	echo form_input($data);

		 	echo form_label('Password : ');
		 	$data = array(
		 		'name'  =>  'password',
		 		'id'    => 'password',
		 		'value' => '',
		 		'style' => 'width:90%'
		 	);

		 	echo form_password($data);

		 	$data = array(
		 		'name'  =>  'login',
		 		'id'    => 'login',
		 		'value' => 'Login',
		 		'style' => 'width:40%'
		 	);

		 	echo form_submit($data);

	 	echo form_close(); 
	 ?>
</div>