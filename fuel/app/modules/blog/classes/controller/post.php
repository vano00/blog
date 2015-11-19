<?php
namespace Blog;
use Input;
use View;
use Response;
use Session;

class Controller_Post extends \Controller_Template
{

	public function action_index()
	{
		// Pagination configuration
   		$config = array(
			'per_page' => 3,
			'uri_segment' => 'page',
		);

		// Get the category_slug route parameter
   		$category_slug = $this->param('category_slug');

   		if (is_null($category_slug)) {
       		$config['total_items'] = Model_Post::count();
   		} else {
       		$config['total_items'] = Model_Post::count(
           		array(
	               	'where' => array(
	                	'category_id' => Model_Category::find('first', array('where' => array(array('slug' => $category_slug))))->id
					), 
               	)
			);
 		}

		// Create a pagination instance named 'posts'
		$pagination = \Pagination::forge('posts', $config);

		$data['posts'] = Model_Post::query()
    		->related(array('author', 'category'))
    		->rows_offset($pagination->offset)
    		->rows_limit($pagination->per_page);

		if (!is_null($category_slug)) {
    		$data['posts']->where('category_id', Model_Category::find('first', array('where' => array(array('slug' => $category_slug))))->id);
		}

		$data['posts'] = $data['posts']->get();

		$this->template->title = "Posts";
		$this->template->content = View::forge('post/index', $data);
		$this->template->content->set('pagination', $pagination, false);

	}

	public function action_view($slug = null)
	{
		is_null($slug) and Response::redirect('blog/post');

    	$data['post'] = Model_Post::find(
       		'first',
       		array(
           		'where' => array(
               		array('slug' => $slug),
           		),
           		'related' => array('published_comments','author','category'),
			) 
		);


		if ( ! $data['post'])
		{
			Session::set_flash('error', 'Could not find post with slug: '.$slug);
			Response::redirect('blog/post');
		}
		
		// Is the user sending a comment? If yes, process it.
	   	if (Input::method() == 'POST')
	   	{
	       	$val = Model_Comment::validate('create');
	       	
	       	if ($val->run())
	       	{
	           $comment = Model_Comment::forge(array(
	               	'name' => Input::post('name'),
	               	'email' => Input::post('email'),
	               	'content' => Input::post('content'),
		            'status' => 'pending',
		            'post_id' => $data['post']->id,
				));

		        if ($comment and $comment->save())
		        {

		        	// Manually loading the Email package
					\Package::load('email');

					$email = \Email::forge();

					// Sending an email to the post's author
					$email->to(
						$data['post']->author->email,
						$data['post']->author->username
					);

					// Setting a subject
					$email->subject('New comment');

					// Setting the body and using a view since the message is long
					$email->body(
					\View::forge('comment/email', array('comment' => $comment,))->render());
					
					// Sending the email
					$email->send();
					unset($email);

					if ($data['post']->published_comments) {

						// Sending an email for all commenters
						$email = \Email::forge();

						// Sending an email to the post's author

						$emails = array();

						foreach ($data['post']->published_comments as $published_comment) {
							$emails[$published_comment->email] = '\'' . $published_comment->name . '\'';
						};
						
						$email->to(
							$emails
						);

						// Setting a subject
						$email->subject('New comment');

						// Setting the body and using a view since the message is long
						$email->body(
						\View::forge('comment/email_other', array('comment' => $comment, 'post' => $data['post']))->render());
						
						// Sending the email
						$email->send();
						unset($email);
					}
					

		            Session::set_flash(
		                'success',
		                e('Your comment has been saved, it will'.
		                 ' be reviewed by our administrators')
					); 
		        }
				else {
		            Session::set_flash(
		                'error',
		                e('Could not save comment.')
		            );
				} 
			}
			else {
			        Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Post";
		$this->template->content = View::forge('post/view', $data);
		$this->template->content->set(
       		'post_content',
       		$data['post']->content,
			false 
		);

	}

}
