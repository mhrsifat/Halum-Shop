<?php require_once('header.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Subscriber</h1>
	</div>
	<div class="content-header-right">
		<a href="subscriber-remove.php" class="btn btn-primary btn-sm">Remove Pending Subscribers</a>
		<a href="subscriber-csv.php" class="btn btn-primary btn-sm">Export as CSV</a>
	</div>
</section>


<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">        
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-hover table-striped">
			<thead>
			    <tr>
			        <th>#</th>
			        <th>Subscriber Email</th>
					<th>Status</th>
					<th>Change Status</th>
			        <th>Action</th>
			    </tr>
			</thead>
            <tbody>
            	<?php
            	$i=0;
            	$statement = $pdo->prepare("SELECT * FROM tbl_subscriber");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
            	foreach ($result as $row) {
            		$i++;
					if($row['subs_active'] == '1') {$isActive = 'Active';} else {$isActive =  'Inactive';}
            		?>
					<tr class="<?= ($isActive == 'Inactive') ? 'bg-r' : 'bg-g'?>">
	                    <td><?php echo $i; ?></td>
	                    <td><?php echo $row['subs_email']; ?></td>
						<td><?= $isActive  ?></td>
						<td><a href="#" class="btn btn-success btn-xs" data-href="subscriber-change-status.php?id=<?php echo $row['subs_id']; ?>" data-toggle="modal" data-target="#confirm-update">Change</a></td>

	                    <td><a href="#" class="btn btn-danger btn-xs" data-href="subscriber-delete.php?id=<?php echo $row['subs_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a></td>
	                </tr>
            		<?php
            	}
            	?>
            </tbody>
          </table>
        </div>
      </div>
  

</section>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm-update" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure want to Update this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Update</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>

<script>
$(document).ready(function() {

    // Set href for Update button
    $('#confirm-update').on('show.bs.modal', function (e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
});
</script>
