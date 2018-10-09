<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">
  <head>
    <title><?php echo $title; ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-imageupload.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-formhelpers.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/theme-0.css">
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.slim.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-imageupload.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-formhelpers.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/js/Chart.bundle.min.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/js/Chart.min.js"></script>
  </head>
  <body>
	<div class="container">
	<nav class="navbar navbar-dark bg-header">
	  <nav class="nav">
		  <a class="nav-link text-header active" href="<?php echo site_url('home'); ?>">
			<img src="<?php echo base_url(); ?>assets/img/home.png"/>
			&nbsp;Home
		  </a>
		  <a class="nav-link text-header active" href="<?php echo site_url('chats'); ?>">
			<img src="<?php echo base_url(); ?>assets/img/chat.png"/>
			&nbsp;Chats
		  </a>
		  <div class="dropdown">
			<a class="nav-link text-header dropdown-toggle pointer" type="button" id="dropdownActivities" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  <img src="<?php echo base_url(); ?>assets/img/activities.png"/>
			  Activities
			</a>
			<div class="dropdown-menu" aria-labelledby="dropdownActivities">
			  <a class="dropdown-item" href="<?php echo site_url('activities/posts'); ?>">Posts</a>
			  <a class="dropdown-item" href="<?php echo site_url('activities/flash_sales'); ?>">Flash Sales</a>
			  <a class="dropdown-item" href="<?php echo site_url('activities/auctions'); ?>">Auctions</a>
			  <a class="dropdown-item" href="<?php echo site_url('activities/polls'); ?>">Polls</a>
			  <a class="dropdown-item" href="<?php echo site_url('activities/quizzes'); ?>">Quizzes</a>
			</div>
		  </div>
		  <a class="nav-link text-header" href="<?php echo site_url('customers'); ?>">
			<img src="<?php echo base_url(); ?>assets/img/users.png"/>
			&nbsp;Customers
		  </a>
		  <div class="dropdown">
			<a class="nav-link text-header dropdown-toggle pointer" type="button" id="dropdownSettings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  <img src="<?php echo base_url(); ?>assets/img/settings.png"/>
			  Settings
			</a>
			<div class="dropdown-menu" aria-labelledby="dropdownSettings">
			  <a class="dropdown-item" href="<?php echo site_url('settings/messages'); ?>">Messages</a>
			  <a class="dropdown-item" href="<?php echo site_url('settings/users'); ?>">Users</a>
			  <a class="dropdown-item" href="<?php echo site_url('settings/line'); ?>">LINE Bot</a>
			</div>
		  </div>
		</nav>
		<div class="dropdown">
		  <a class="nav-link text-header dropdown-toggle pointer" type="button" id="dropdownUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    <img src="<?php echo base_url(); ?>assets/img/user.png"/>
		    &nbsp;<?php echo $this->user->username; ?>
		  </a>
		  <div class="dropdown-menu" aria-labelledby="dropdownUser">
		    <a class="dropdown-item" href="<?php echo site_url('logout'); ?>">Logout</a>
		  </div>
		</div>
	</nav>