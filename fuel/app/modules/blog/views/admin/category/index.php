<?php if ($categories): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Nb posts</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($categories as $item): ?>		<tr>

			<td><?php echo $item->name; ?></td>
			<td><?php echo $item->nb_posts ?></td>
			<td>
				<div class="btn-toolbar">
					<div class="btn-group pull-right">
						<?php echo Html::anchor('blog/admin/category/edit/'.$item->id, 'Edit', array('class' => 'btn btn-default btn-sm')); ?>
						<?php echo Html::anchor('blog/admin/category/delete/'.$item->id.'?'.\Config::get('security.csrf_token_key').'='.\Security::fetch_token(), 'Delete', array('onclick' => "return confirm('Are you sure?')", 'class' => 'btn btn-sm btn-danger')); ?>
					</div>
				</div>
			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Categories.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('blog/admin/category/create', 'Add new Category', array('class' => 'btn btn-success')); ?>

</p>
