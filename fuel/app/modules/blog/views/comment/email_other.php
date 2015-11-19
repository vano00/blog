Hi,
   A new comment has been posted on post "<?php echo $post->title; ?>".

   Author: <?php echo $comment->name; ?>
   Email: <?php echo $comment->email; ?>
   Content:
   <?php echo $comment->content; ?>
   
   Go to the post :
   <?php echo Uri::base().'blog/post/view/' . $post->slug; ?>

Thanks,