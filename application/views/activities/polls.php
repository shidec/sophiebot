<?php
	$this->load->view('header');
?>
<script type="text/javascript">
	$(document).ready(function(){
        $('.imageupload').imageupload();

		$('.imgResult').click(function(){
			var ctx = document.getElementById("myChart");
			var myChart = new Chart(ctx, {
			    type: 'bar',
			    data: {
			        labels: JSON.parse($(this).attr('option_captions')),
			        datasets: [{
			            label: $(this).attr('caption'),
			            data: JSON.parse($(this).attr('option_totals')),
			            backgroundColor: [
			                'rgba(255, 99, 132, 0.2)',
			                'rgba(54, 162, 235, 0.2)',
			                'rgba(255, 206, 86, 0.2)',
			                'rgba(75, 255, 86, 0.2)'
			            ],
			            borderColor: [
			                'rgba(255,99,132,1)',
			                'rgba(54, 162, 235, 1)',
			                'rgba(255, 206, 86, 1)',
			                'rgba(75, 255, 75, 1)'
			            ],
			            borderWidth: 1
			        }]
			    },
			    options: {
			        scales: {
			            yAxes: [{
			                ticks: {
			                    beginAtZero:true
			                }
			            }]
			        },
			        legend: {
			            display: false
			        },
	                title: {
	                    display: true,
	                    text: $(this).attr('caption')
	                }
			    }
			});
		});

		$('#chartModal').on('show.bs.modal', function (event) {
			
		});
	});
</script>
<nav aria-label="breadcrumb" class="bg-sub-header">
  <ol class="breadcrumb bg-sub-header">
    <li class="breadcrumb-item" aria-current="page">Activities</li>
    <li class="breadcrumb-item active" aria-current="page">Polls</li>
  </ol>
</nav><br/>
<div style="width: 800px; margin: 0 auto 0 auto;">
<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal">
  New Poll
</button>
</div><br/><br/>
<table class="table table-bordered" style="width: 800px; margin: 0 auto 0 auto;">
	<thead class="thead-dark">
		<tr>
			<!-- <th width="180">Period</th> -->
			<th>Content</th>
			<th width="240">Options</th>
			<th width="40">Result</th>
			<th width="20">Status</th>
			<th width="40">Action</th>
		</tr>
	</thead>
	<?php 
		foreach ($records as $r) { 
			$options = json_decode($r->options);
	?>
	<tr>
		<!-- <td align="center"><?php echo $r->start_time . '<br/>' . $r->end_time; ?></td> -->
		<td><?php echo $r->caption; ?></td>
		<td align="center"><?php echo implode(json_decode($r->options), ';'); ?></td>
		<td align="center">
			<img src="<?php echo base_url() . 'assets/img/chart.png'; ?>" class="pointer imgResult" data-toggle="modal" data-target="#chartModal"
				caption="<?php echo $r->caption; ?>"
				option_captions='<?php echo $r->options; ?>' 
				option_totals='<?php echo (array_key_exists($r->id, $answers) ? json_encode($answers[$r->id]) : '[]'); ?>'
			/>
		</td>
		<td align="center"><img src="<?php echo base_url() . 'assets/img/' . ($r->status == 1 ? 'on.png' : 'off.png'); ?>"></td>
		<td></td>
	</tr>
	<?php } ?>
</table>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="<?php echo site_url('activities/polls'); ?>" method="post" enctype="multipart/form-data">	
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Poll</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">        
		<table class="table" style="width: 600px; margin: 0px;">
			<tr>
				<td>Image<br/><small><i>*optional</i></small></td>
				<td>
					<div class="imageupload panel panel-default">
					    <div class="file-tab panel-body">
					        <label class="btn btn-default btn-file">
					            <span>Browse</span>
					            <input type="file" name="image" class="form-control">
					        </label>
					        <button type="button" class="btn btn-default">Remove</button>
					    </div>
					</div>
				</td>
			</tr>
			<tr>
				<td width="100">Caption</td>
				<td>
					<textarea type="text" class="form-control" name="caption" cols="60" rows="3"></textarea>
				</td>
			</tr>			
			<tr>
				<td>Option 1</td>
				<td>
					<input type="text" class="form-control" name="options[0]"/>
				</td>
			</tr>			
			<tr>
				<td>Option 2</td>
				<td>
					<input type="text" class="form-control" name="options[1]"/>
				</td>
			</tr>			
			<tr>
				<td>Option 3<br/><i><small>*optional</small></i></td>
				<td>
					<input type="text" class="form-control" name="options[2]"/>
				</td>
			</tr>			
			<tr>
				<td>Option 4<br/><i><small>*optional</small></i></td>
				<td>
					<input type="text" class="form-control" name="options[3]"/>
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
<!-- Chart Result -->
<div class="modal fade" id="chartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Result Chart</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">        
		<canvas id="myChart" width="400" height="300"></canvas>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php
	$this->load->view('footer');
?>