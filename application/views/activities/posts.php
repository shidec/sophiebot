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
    <li class="breadcrumb-item active" aria-current="page">Posts</li>
  </ol>
</nav><br/>
<div style="width: 700px; margin: 0 auto 0 auto;">
<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal">
  New Post
</button>
</div><br/><br/>
<table class="table table-bordered" style="width: 700px; margin: 0 auto 0 auto;">
	<thead class="thead-dark">
		<tr><th width="180">Time</th><th width="40">Type</th><th>Content</th><th width="40">Action</th></tr>
	</thead>
	<?php foreach ($records as $r) { ?>
	<tr>
		<td><?php echo $r->time; ?></td>
		<td><?php echo $posttypes[$r->type]; ?></td>
		<td><?php echo $r->content; ?></td>
		<td></td>
	</tr>
	<?php } ?>
</table>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="<?php echo site_url('activities/posts'); ?>" method="post" enctype="multipart/form-data">	
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Post</h5>
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
					<textarea type="text" class="form-control" name="content" cols="60" rows="8"></textarea>
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