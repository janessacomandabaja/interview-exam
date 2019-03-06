<div class="row-fluid">
	<table class="table table-bordered" id="table_records">
		<thead>
			<tr>
				<th>ID</th>
				<th>NAME</th>	
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>
<?php $this->start('script_own')?>
<script>
	$(document).ready(function(){
		$("#table_records").dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sServerMethod": "POST",
			"sAjaxSource": "<?php echo Router::url(array('controller' => 'Record', 'action' =>'listings'), true); ?>"
		});
	})
</script>
<?php $this->end()?>