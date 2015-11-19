<?php

namespace Fuel\Migrations;

class Create_indexes
{
  public function up()
  {
    // For optimizing relations
    \DBUtil::create_index('comments', 'post_id');
    \DBUtil::create_index('posts', 'category_id');
    \DBUtil::create_index('posts', 'user_id');
    // For optimizing slug retrieval
    \DBUtil::create_index('posts', 'slug');
    \DBUtil::create_index('categories', 'slug');
  }

  public function down()
  {
    \DBUtil::drop_index('comments', 'post_id');
    \DBUtil::drop_index('posts', 'category_id');
    \DBUtil::drop_index('posts', 'user_id');
    \DBUtil::drop_index('posts', 'slug');
    \DBUtil::drop_index('categroies', 'slug');
  } 
}