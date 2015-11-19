<div>
    <?php
      echo \Date::forge($post->created_at)->format('%d %B %Y at %H:%M');
    ?>
</div>
<div class="post_category">
    Category: <?php echo html::anchor('blog/post/category/'.$post->category->slug, $post->category->name) ?>
</div>
<div class="post_author">
    By <?php echo $post->author->username ?>
</div>