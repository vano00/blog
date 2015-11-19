Hi,
   A new comment has been posted.

   Author: <?php echo $comment->name; ?>
   Email: <?php echo $comment->email; ?>
   Content:
   <?php echo $comment->content; ?>
   
   Go to the administration panel to accept / reject it.
   <?php echo Uri::base().'blog/admin/comment' ?>

Thanks,