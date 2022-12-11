<?php
$this->load->view('template/header');
$this->load->view('template/sidebar_' . $this->session->userdata('controller'));
$this->load->view($page);
$this->load->view('template/footer');
