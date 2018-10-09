<?php
	$this->load->view('header');
?>
<nav aria-label="breadcrumb" class="bg-sub-header">
  <ol class="breadcrumb bg-sub-header">
    <li class="breadcrumb-item" aria-current="page">Settings</li>
    <li class="breadcrumb-item active" aria-current="page">Messages</li>
  </ol>
</nav><br/>
<form action="<?php echo site_url('settings/messages'); ?>" method="post">
	<table class="table" style="width: 600px; margin: 0 auto 0 auto;">
		<tr>
			<td width="180">Welcome Message</td>
			<td><textarea name="welcome_message" class="form-control"><?php echo $welcome_message; ?></textarea></td>
		</tr>
		<tr>
			<td width="180">Send birthday message</td>
			<td><input type="checkbox" class="form-control float-left" style="width: 10px;" name="birthday_message" value="1" <?php echo ($birthday_message ? 'checked="checked"':'');?>/></td>
		</tr>
		<tr><td colspan="2">
			<input type="submit" name="submit" value="Save" class="btn btn-primary float-right"/>
		</td></tr>
	</table>
</form>
<?php
	$this->load->view('footer');
?>