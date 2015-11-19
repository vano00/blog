<?php
return array(
	'_root_'  => 'blog/post/index',  // The default route
	'_404_'   => '',    // The main 404 route
	'admin'	  => 'blog/admin/post/index/' . Auth::get_screen_name()
);
