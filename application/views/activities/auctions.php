<?php
	$this->load->view('header');
?>
<script type="text/javascript">
	$(document).ready(function(){
		
	});
</script>
<nav aria-label="breadcrumb" class="bg-sub-header">
  <ol class="breadcrumb bg-sub-header">
    <li class="breadcrumb-item" aria-current="page">Activities</li>
    <li class="breadcrumb-item active" aria-current="page">Auctions</li>
  </ol>
</nav><br/>
<div style="width: 800px; margin: 0 auto 0 auto;">
<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal">
  New Auction
</button>
</div><br/><br/>
<table class="table table-bordered" style="width: 800px; margin: 0 auto 0 auto;">
	<thead class="thead-dark">
		<tr>
			<th>Content</th>
			<th width="120">Start Time</th>
			<th width="120">Start Price</th>
			<th width="200">Last Bid</th>
			<th width="20">Status</th>
			<th width="40">Action</th>
		</tr>
	</thead>
	<?php foreach ($records as $r) { ?>
	<tr>
		<td><?php echo $r->caption; ?></td>
		<td align="center"><?php echo $r->start_time; ?></td>
		<td align="center"><?php echo $r->start_price; ?></td>
		<td align="center"><?php echo ($r->last_time ? "{$r->display_name}<br/>{$r->last_time}<br/>{$r->last_price}" : "&nbsp;"); ?></td>
		<td align="center"><img src="<?php echo base_url() . 'assets/img/' . ($r->status == 1 ? 'on.png' : 'off.png'); ?>"></td>
		<td></td>
	</tr>
	<?php } ?>
</table>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="<?php echo site_url('activities/auctions'); ?>" method="post" enctype="multipart/form-data">	
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Auction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">        
		<table class="table" style="width: 500px;">
			<tr>
				<td width="100">Type</td>
				<td>
					<select name="type" class="form-control">
						<option selected="selected" value="0">Text</option>	
					</select>
				</td>
			</tr>
			<tr>
				<td>Content</td>
				<td>
					<textarea type="text" class="form-control" name="caption" cols="60" rows="8"></textarea>
				</td>
			</tr>			
			<tr>
				<td>Start Price</td>
				<td>
					<input type="text" class="form-control bfh-number" name="start_price" data-max="99999999"/>
				</td>
			</tr>
		</table>		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" name="submit" class="btn btn-primary" value="Save changes"/>
      </div>
      </form>
    </div>
  </div>
</div>
<?php
	$this->load->view('footer');
?>