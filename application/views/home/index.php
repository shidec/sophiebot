<?php
	$this->load->view('header');
?>
<script type="text/javascript">
	$(document).ready(function(){
		var ctx = document.getElementById("myChart");
		var myChart = new Chart(ctx, {
		    type: 'bar',
		    data: {
		        labels: <?php echo $event->options; ?>,
		        datasets: [{
		            label: "<?php echo $event->caption; ?>",
		            data: <?php echo $result; ?>,
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
                    display: false,
                    text: "<?php echo $event->caption; ?>"
                }
		    }
		});
	});
</script>
<nav aria-label="breadcrumb" class="bg-sub-header">
  <ol class="breadcrumb bg-sub-header">
    <li class="breadcrumb-item active" aria-current="page">Home</li>
  </ol>
</nav><br/>
<div style="display: block; width: 600px; margin-left:auto; margin-right: auto;">
	<?php if($current_event == 'flash_sales'){?>
	<div class="card align-middle">
		<div class="card-header">Current Event : Flash Sales</div>
	    <div class="card-body">
	    	<p>
	    		<?php echo $event->text; ?><br/><br/>
	    		Stock : <?php echo $event->current_stock . '/' . $event->stock; ?>
	    	</p>
	    	<table class="table">
	    		<tr><th colspan="3">Buyers</th></tr>
	    		<?php foreach ($users as $u) { ?>
	    		<tr>
	    			<td width="10"><img src="<?php echo $u->picture_url; ?>" width="40" height="40" class="circle"></td>
	    			<td><?php echo $u->display_name; ?></td>
	    			<td width="180"><?php echo $u->time; ?></td>
	    		</tr>	
	    		<?php
	    			}
	    		?>
	    	</table>
	    </div>
	</div>
	<?php }else if($current_event == 'auctions'){?>
	<div class="card align-middle">
		<div class="card-header">Current Event : Auction</div>
	    <div class="card-body">
	    	<p>
	    		<?php echo $event->caption . 
	    			"<br/>Starting price: " . number_format($event->start_price, 0, ',', '.') .
	    			"<br/>Current bid: " . number_format($event->last_price, 0, ',', '.'); ?><br/>
	    	</p>
	    	<table class="table">
	    		<tr><th colspan="4">Bidders</th></tr>
	    		<?php foreach ($users as $u) { ?>
	    		<tr>
	    			<td width="10"><img src="<?php echo $u->picture_url; ?>" width="40" height="40" class="circle"></td>
	    			<td><?php echo $u->display_name; ?></td>
	    			<td width="100"><?php echo number_format($u->price, 0, ',', '.'); ?></td>
	    			<td width="180"><?php echo $u->time; ?></td>
	    		</tr>	
	    		<?php
	    			}
	    		?>
	    	</table>
	    </div>
	</div>
	<?php }else if($current_event == 'polls'){?>
	<div class="card align-middle">
		<div class="card-header">Current Event : Poll</div>
	    <div class="card-body">
	    	<p>
	    		<?php if($event->image){ ?>
	    		<img src="<?php echo base_url() . 'uploads/polls/' . $event->image; ?>" style="max-height: 200px"/><br/>
	    		<?php } ?>
	    		<?php echo $event->caption; ?><br/>
	    	</p>
	    	<?php if($users) { ?>
	    	<ul class="nav nav-tabs">
			  <li class="nav-item">
			    <a class="nav-link active" data-toggle="tab" href="#result" role="tab">Result</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" data-toggle="tab" href="#participants" role="tab">Participants</a>
			  </li>
			</ul>
			<div class="tab-content">
	  			<div class="tab-pane active" id="result" role="tabpanel">
		    		<canvas id="myChart" width="400" height="300"></canvas>
		    	</div>
		    	<div class="tab-pane" id="participants" role="tabpanel">		    	
			    	<table class="table">			    		
			    		<?php foreach ($users as $u) { ?>
			    		<tr>
			    			<td width="10"><img src="<?php echo $u->picture_url; ?>" width="40" height="40" class="circle"></td>
			    			<td><?php echo $u->display_name; ?></td>
			    			<td width="180"><?php echo $u->time; ?></td>
			    		</tr>	
			    		<?php } ?>
			    	</table>
		    	</div>
	    	</div>
	    	<?php }else{ ?>
	    	<div class="alert alert-info text-center" role="alert">no result yet</div>
	    	<?php } ?>
	    </div>
	</div>
	<?php } ?>
</div>
<?php
	$this->load->view('footer');
?>