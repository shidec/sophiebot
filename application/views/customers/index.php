<?php
	$this->load->view('header');
?>
<script type="text/javascript">
	$(document).ready(function(){
		
	});
</script>
<nav aria-label="breadcrumb" class="bg-sub-header">
  <ol class="breadcrumb bg-sub-header">
    <li class="breadcrumb-item  active" aria-current="page">Customers</li>
  </ol>
</nav><br/>
<table class="table table-bordered" style="width: 700px; margin: 0 auto 0 auto;">
	<thead class="thead-dark">
		<tr>
			<th colspan="2">Display Name</th>
			<th width="180">Joined</th>
			<th width="20">Active</th>
			<th width="40">Action</th>
		</tr>
	</thead>
	<?php foreach ($records as $r) { ?>
	<tr><td width="10" style="padding: 4px;"><img src="<?php echo $r->picture_url; ?>" width="40" height="40" class="circle"></td>
		<td><?php echo $r->display_name; ?></td>
		<td><?php echo $r->joined; ?></td>
		<td align="center"><img src="<?php echo base_url() . 'assets/img/' . ($r->following ? 'on.png' : 'off.png'); ?>"></td>
		<td></td>
	</tr>
	<?php } ?>
</table>
<?php
	$this->load->view('footer');
?>