<?php
   namespace Blog;
   
   class Presenter_Admin_Category_Selector extends \Presenter
   {
       public function view()
       {
           $this->categories = Model_Category::find('all');
       }
}