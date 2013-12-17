<?php $this->load->view('includes/header'); ?>
<?php $this->load->view($view); ?>
<?php if ($this->session->userdata('username')): ?>
<?php $this->load->view('includes/footer'); ?>
<?php endif; ?>