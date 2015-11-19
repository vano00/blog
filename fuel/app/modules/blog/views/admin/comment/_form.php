<?php echo Form::open(array("class"=>"form-horizontal")); ?>
<?php echo Form::csrf(); ?>

	<fieldset>
		<div class="form-group">
			<div class="row">
				<div class="col-md-4">
					<?php echo Form::label('Name', 'name', array('class'=>'control-label')); ?>
					<?php echo Form::input('name', Input::post('name', isset($comment) ? $comment->name : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Name')); ?>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-4">
					<?php echo Form::label('Email', 'email', array('class'=>'control-label')); ?>
					<?php echo Form::input('email', Input::post('email', isset($comment) ? $comment->email : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Email')); ?>
				</div>
			</div>
		</div>
		<div class="form-group">
			<?php echo Form::label('Content', 'content', array('class'=>'control-label')); ?>
			<?php echo Form::textarea('content', Input::post('content', isset($comment) ? $comment->content : ''), array('class' => 'col-md-8 form-control', 'rows' => 8, 'placeholder'=>'Content')); ?>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-2">
					<?php echo Form::label('Status', 'status', array('class'=>'control-label')); ?>
						<?php
						echo Form::select(
						    'status',
						    $comment->status,
						    array(
						        'not_published' => 'not published',
						        'pending' => 'pending',
						        'published' => 'published',
							),
							array('class' => 'form-control') 
						);
						?> 
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-md-2">
					<?php echo Form::label('Post: ', null, array('class'=>'control-label')); ?>
					<?php echo $comment->post ? $comment->post->title : '<i>Post deleted</i>'; ?>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>