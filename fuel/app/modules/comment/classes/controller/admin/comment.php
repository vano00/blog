<?php
namespace Comment;
use Controller_Admin;
use Input;
use View;
use Response;
use Session;

class Controller_Admin_Comment extends Controller_Admin
{

	public function action_index()
	{
		$data['comments'] = Model_Comment::find(
			'all',
			array(
				'related' => array('post'),
				// display last comments first
        		'order_by' => array('id' => 'DESC')
        	)
		);
		$this->template->title = "Comments";
		$this->template->content = View::forge('admin/index', $data);

	}

	public function action_edit($id = null)
	{
		$comment = Model_Comment::find($id);
		$val = Model_Comment::validate('edit');

		if (!$comment)
		{
			Session::set_flash('error', e('Comment #' . $id . ' doesn\'t exist'));

			Response::redirect('admin/comment');
		}

		if ($val->run())
		{
			$comment->name = Input::post('name');
			$comment->email = Input::post('email');
			$comment->content = Input::post('content');
			$comment->status = Input::post('status');

			if (\Security::check_token() and $comment->save())
			{
				Session::set_flash('success', e('Updated comment #' . $id));

				Response::redirect('admin/comment');
			}

			else
			{
				if (!\Security::check_token()) {

					Session::set_flash('error', e('Could not update comment #' . $id . ', CSRF token not valid!'));

				} else {

					Session::set_flash('error', e('Could not update comment #' . $id));
				}
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$comment->name = $val->validated('name');
				$comment->email = $val->validated('email');
				$comment->content = $val->validated('content');
				$comment->status = $val->validated('status');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('comment', $comment, false);
		}

		$this->template->title = "Comments";
		$this->template->content = View::forge('admin/edit');

	}

	public function action_delete($id = null)
	{
		if ($comment = Model_Comment::find($id) and \Security::check_token())
		{
			$comment->delete();

			Session::set_flash('success', e('Deleted comment #'.$id));
		}

		else
		{
			if (!\Security::check_token()) {

				Session::set_flash('error', e('Could not delete comment #' . $id . ', CSRF token not valid!'));

			} else {

				Session::set_flash('error', e('Could not delete comment #'.$id));
			}
		}

		Response::redirect('admin/comment');

	}

}
