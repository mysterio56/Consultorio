<section class="datagrid">
	<table>
		<thead>
			<tr>
				<th>Código</th>
				<th>Nombre</th>
				<th>Email</th>
				<th>Teléfono</th>
				<th>Celular</th>
				<th>Editar</th>
				<th>Activo</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach($empleados as $empleado){
					echo '<tr>';
						echo '<td>'.$empleado->codigo.'</td>';
						echo '<td>'.$empleado->nombre.' '.$empleado->apellido_p.' '.$empleado->apellido_m.'</td>';
						echo '<td>'.$empleado->email.'</td>';
						echo '<td>'.$empleado->telefono.'</td>';
						echo '<td>'.$empleado->celular.'</td>';

						echo '<td><a href="'.base_url('employees/editar/'.$empleado->id).'">
								  <img src="'.base_url('assets/images/edit.png').'" /></a></td>';

						$activo = $empleado->estatus?'active':'inactive';
						echo '<td><a href="'.base_url('employees/status/'.$empleado->id).'">
								  <img src="'.base_url('assets/images/'.$activo.'.png').'" /></a></td>';
					echo '</tr>';
				}
			?>
			<!--<tr>
				<td>Yolanda Cristina Núñez Toscano</td>
				<td>20</td>
				<td>yola123</td>
				<td><img src="<?php echo base_url('assets/images/edit.png');?>" /></td>
				<td><img src="<?php echo base_url('assets/images/inactive.png');?>" /></td>
			</tr>
			<tr class="alt">
				<td>Francisco Javier Sánchez Rosales</td>
				<td>25</td>
				<td>aslanlion56</td>
				<td><img src="<?php echo base_url('assets/images/edit.png');?>" /></td>
				<td><img src="<?php echo base_url('assets/images/active.png');?>" /></td>
			</tr>
			<tr>
				<td>Vasti Cristina Sánchez Núñez</td>
				<td>8 meses</td>
				<td>vasti123</td>
				<td><img src="<?php echo base_url('assets/images/edit.png');?>" /></td>
				<td><img src="<?php echo base_url('assets/images/active.png');?>" /></td>
			</tr>
			<tr class="alt">
				<td>Yolanda Cristina Núñez Toscano</td>
				<td>20</td>
				<td>yola123</td>
				<td><img src="<?php echo base_url('assets/images/edit.png');?>" /></td>
				<td><img src="<?php echo base_url('assets/images/inactive.png');?>" /></td>
			</tr>
			<tr>
				<td>Francisco Javier Sánchez Rosales</td>
				<td>25</td>
				<td>aslanlion56</td>
				<td><img src="<?php echo base_url('assets/images/edit.png');?>" /></td>
				<td><img src="<?php echo base_url('assets/images/active.png');?>" /></td>
			</tr>
			<tr class="alt">
				<td>Vasti Cristina Sánchez Núñez</td>
				<td>8 meses</td>
				<td>vasti123</td>
				<td><img src="<?php echo base_url('assets/images/edit.png');?>" /></td>
				<td><img src="<?php echo base_url('assets/images/active.png');?>" /></td>
			</tr>-->
		</tbody>
		<tfoot>
			<tr>
				<td colspan="100%">
					<div id="paging">
						<ul>
							<li>
								<a href="#">
									<span>Previous</span>
								</a>
							</li>
							<li>
								<a href="#" class="active">
									<span>1</span>
								</a>
							</li>
							<li>
								<a href="#">
									<span>2</span>
								</a>
							</li>
							<li>
								<a href="#">
									<span>3</span>
								</a>
							</li>
							<li>
								<a href="#">
									<span>4</span>
								</a>
							</li>
							<li>
								<a href="#">
									<span>5</span>
								</a>
							</li>
							<li>
								<a href="#">
									<span>Next</span>
								</a>
							</li>
						</ul>
					</div>
				</tr>
			</tfoot>
	</table>
</section>
<a class="abutton" href="<?= base_url('employees/agregar') ?>">Agregar</a>