<?php

$options = array();

foreach ($categories as $category) {
	$options[$category->id] = $category->name;
}

echo Form::select('category_id', $category_id, $options, array('class' => 'col-md-4 form-control', 'placeholder'=>'Category id'));


?>