<?php

namespace Fuel\Tasks;

class Clearcomments
{

	public function run($args = NULL)
	{
		echo "\n===========================================";
		echo "\nRunning DEFAULT task [Clearcomments:Run]";
		echo "\n-------------------------------------------\n\n";

		\DB::query(
           'DELETE FROM comments WHERE status="not_published";'
       	)->execute();
       	return 'Rejected comments deleted.';
	}

}
/* End of file tasks/clearcomments.php */
