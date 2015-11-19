<div class="post_view">
	<h2>
		<?php echo $post->title; ?>
	</h2>
	<?php echo \View::forge('post/small_description', array('post' => $post)); ?>
	<div class="post_content">
		<?php echo \Security::xss_clean($post_content); ?>
	</div>
	<?php echo \View::forge('post/additional_informations', array('post' => $post)); ?>
	<hr>
	<div class="comments">
	   	<?php
	   	foreach ($post->published_comments as $comment):
	       echo \View::forge('comment/item', array('comment' => $comment));
		endforeach;
		?>
	</div>
	<?php echo View::forge('comment/_form'); ?>
</div>
<br><?php echo Html::anchor('blog/post', 'Back'); ?>