<?php echo Form::open(array("class"=>"form-horizontal")); ?>
<?php echo Form::csrf(); ?>

	<fieldset>
		<div class="form-group">
			<div class="row">
				<div class="col-md-2">
					<?php echo Form::label('Name', 'name', array('class'=>'control-label')); ?>
					<?php echo Form::input('name', Input::post('name', isset($category) ? $category->name : ''), array('class' => 'col-md-2 form-control', 'placeholder'=>'Name')); ?>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>