	</div> <!-- cierre wrapper -->
	<footer class="footer-container">
		<div id="footer">
			<div id="logo-footer">
				<a href="http://masqweb.com/" target="_blank">
					<p>Powered by:</p> <img src="<?php echo base_url("assets/images/footer-logo.png");?>" />
				</a>
			</div>
			<div id="renew-footer">
				<?php if ($this->session->userdata('username')): ?>
					<input id="submit-footer" type="button" value="RENOVAR AHORA" />
					<p>Quedan <strong><?php echo $day = 31; ?></strong> días para renovar su licencia</p>
				<?php endif; ?>
			</div>
			
		</div>
	</footer>
</body>