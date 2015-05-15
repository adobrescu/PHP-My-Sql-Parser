<?php
	/*
	 * Modifies a UPDATE statement
	 */
	
	include_once(__DIR__.'/lib/SqlParser.class.php');
	 
	 
	$query='
			UPDATE tbl SET
				field=\'string\',
				total=(SELECT SUM(amount) FROM another_tbl2 WHERE tbl2.id_owner=tbl.id_owner),
				some_total=(SELECT COUNT(*) FROM another_table)
			LIMIT 10

		';
	 	 
	$parser=new \alib\utils\SqlParser();
	
	
	$parser->parse($query);

	
	
	$parser->appendWhere('owner_permissions & 1');
	$startNode=null;
	if($subqueries=$parser->getNodesByType(\alib\utils\Sqlparser::PHP_SQL_SUBSELECT, $startNode, $skipSubqueries=true, $stopOnFirstMatch=false))
	{
		foreach($subqueries as &$subquery)
		{
			if($tableNames=$parser->getTableNames($skipSubqueries=true, $subquery))
			{
				foreach($tableNames as $tableName)
				{
					$parser->appendWhere('(`'.$tableName.'`'.'.`owner_permissions` & 1)=1', 'AND',$subquery);
				}
			}
		}
	}
	
	echo '<pre>';
	echo 'Query:<br>'.$query.'<br>';
	echo 'Modified Query:<br>'.$parser->rebuildSource();