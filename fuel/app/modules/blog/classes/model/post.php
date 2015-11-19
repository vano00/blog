<?php
namespace Blog;
use \Validation as Validation;

class Model_Post extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'title',
		'slug',
		'small_description',
		'content',
		'category_id',
		'user_id',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
		'Orm\\Observer_Slug',
	);

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('title', 'Title', 'required|max_length[255]');
		$val->add_field('small_description', 'Small Description', 'required|max_length[200]');
		$val->add_field('content', 'Content', 'required');
		$val->add_field('category_id', 'Category Id', 'required|valid_string[numeric]');
		//$val->add_field('user_id', 'User Id', 'required|valid_string[numeric]');

		return $val;
	}

	protected static $_belongs_to = array(
		'category',
		'author' => array(
			'model_to' => 'Auth\Model\Auth_User',
			'key_from' => 'user_id',
			'key_to' => 'id',
			'cascade_save' => true,
			'cascade_delete' => false,
		),
	);

	protected static $_has_many = array(
		'comments' => array(
			'model_to' => '\Blog\Model_Comment',
			'key_from' => 'id',
			'key_to' => 'post_id',
			'cascade_save' => true,
			'cascade_delete' => true,

		),
		'published_comments' => array(
       		'model_to'          => '\Blog\Model_Comment',
       		'conditions' => array(
           		'where' => array(
               		array('status', '=', 'published'),
				), 
			),
		),
	);

}
