<?php
	$this->load->view('header');
?>
<script type="text/javascript">
	$(document).ready(function(){
		var $imageupload = $('.imageupload');
        $imageupload.imageupload();
	});
</script>
<nav aria-label="breadcrumb" class="bg-sub-header">
  <ol class="breadcrumb bg-sub-header">
    <li class="breadcrumb-item" aria-current="page">Settings</li>
    <li class="breadcrumb-item active" aria-current="page">LINE Bot</li>
  </ol>
</nav><br/>
<form action="<?php echo site_url('settings/line'); ?>" method="post" enctype="multipart/form-data">
	<table class="table" style="width: 700px; margin: 0 auto 0 auto;">
		<tr>
			<td width="200">Official Account Name</td>
			<td><input type="text" class="form-control" name="line_name" value="<?php echo $line_name; ?>"/></td>
		</tr>
		<tr>
			<td>LINE ID</td>
			<td>
				<div class="input-group">
				  <span class="input-group-addon" id="txtLineID">@</span>
				  <input type="text" name="line_id" value="<?php echo $line_id; ?>" class="form-control" placeholder="LINE ID" aria-label="LINE ID" aria-describedby="txtLineID">
				</div>
			</td>
		</tr>
		<tr>
			<td>Logo</td>
			<td>
				<div class="imageupload panel panel-default">
				    <div class="file-tab panel-body">
				        <label class="btn btn-default btn-file">
				            <span>Browse</span>
				            <input type="file" name="line_logo" class="form-control">
				        </label>
				        <button type="button" class="btn btn-default">Remove</button>
				    </div>
				</div>
				<?php if($line_logo && file_exists('./uploads/' . $line_logo)){ ?>
				<img src="<?php echo base_url() . 'uploads/' . $line_logo; ?>" alt="Image preview" style="max-width: 150px; max-height: 150px">
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>Channel Secret</td>
			<td><input type="text" class="form-control" name="channel_secret" value="<?php echo $channel_secret; ?>"/></td>
		</tr>
		<tr>
			<td>Channel Access Token</td>
			<td>
				<textarea type="text" class="form-control" name="channel_access_token" rows="5"><?php echo $channel_access_token; ?></textarea></td>
		</tr>
		<tr><td colspan="2">
			<input type="submit" name="submit" value="Save" class="btn btn-primary float-right"/>
		</td></tr>
	</table>
</form>
<?php
	$this->load->view('footer');
?>