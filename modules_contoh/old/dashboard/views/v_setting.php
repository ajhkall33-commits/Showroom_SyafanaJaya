<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<div class="card">
	<div class="card-header">
		<h4 class="card-title"><?=$title?></h4>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>Dashboard</th>
						<th>URL</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($items as $key => $item): ?>
						<tr>
							<td><?=$item->NAME?></td>
							<td><?=$item->URL?></td>
							<td>
								<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit-<?=$item->ID?>">
									<i class="fa fa-edit"></i>
								</button>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php foreach ($items as $key => $item): ?>
	<div class="modal fade" id="edit-<?=$item->ID?>">
		<div class="modal-dialog">
			<form action="<?=base_url('dashboard/update').'/'.$item->ID?>" method="POST" class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">URL DAHSBOARD <?=$item->NAME?></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input type="text" name="URL" class="form-control" value="<?=$item->URL?>">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">
						<i class="fa fa-save mr-2"></i> Save
					</button>
				</div>
			</form>
		</div>
	</div>
<?php endforeach ?>