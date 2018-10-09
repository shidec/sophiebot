<?php
	$this->load->view('header');
?>
<script type="text/javascript">
	$(document).ready(function(){
		
	});
</script>
<nav aria-label="breadcrumb" class="bg-sub-header">
  <ol class="breadcrumb bg-sub-header">
    <li class="breadcrumb-item" aria-current="page">Settings</li>
    <li class="breadcrumb-item active" aria-current="page">Users</li>
  </ol>
</nav><br/>
<table class="table table-bordered" style="width: 500px; margin: 0 auto 0 auto;">
	<thead class="thead-dark">
		<tr><th>Username</th><th width="120">Type</th><th width="40">Action</th></tr>
	</thead>
	<?php foreach ($records as $r) { ?>
	<tr>
		<td><?php echo $r->username; ?></td>
		<td><?php echo $usertypes[$r->usertype]; ?></td>
		<td></td>
	</tr>
	<?php } ?>
</table>
<?php
	$this->load->view('footer');
?>