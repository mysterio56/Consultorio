	</div> <!-- cierre wrapper -->
	<footer class="footer-container">
		<div id="footer">
			<div id="logo-footer">
				<a href="http://masqweb.com/" target="_blank">
					<p>Powered by:</p> <img src="<?php echo base_url("assets/images/footer-logo.png");?>" />
				</a>
			</div>

			<?php

			    $warning = false;
			    $days    = 56;

			    if($days <= 10 ){
			        $warning = true;
			        echo "<script> setTimeout('alert(\"Quedan ".$days." días para renovar su licencia\");',4000); </script>";
			    }
			    
			?>
	<?php if ($this->session->userdata('username')): ?>
        <div id="renew">
            <!--<input id="submit-renew" type="button" value="RENOVAR AHORA" />-->
            <a class="abutton" href="http://masqweb.com/" target="_blank">Renovar ahora</a>
            <br />
            <p class="<?= $warning?'error':''; ?>" >Quedan <strong><?= $days ?></strong> días para renovar su licencia</p>
        </div>
    <?php endif; ?>

		</div>
	</footer>
</body>