<?php

	/*
	 * This sample shows how to modify a SELECT SUBquery by adding a WHERE clause
	 */
	
	 include_once(__DIR__.'/lib/SqlParser.class.php');
	 
	 
	 $query='SELECT field1, field2, SUM(field3+10)
		 FROM `table` INNER JOIN (
									SELECT `value`, `update` 
									FROM tbl 
									WHERE `value`>0
								) AS sub_query
			ON `table`.id=tbl.`update`
		WHERE field1 NOT IN (
				SELECT some_field
				FROM some_table
				WHERE some_field IS NOT NULL
				)';
	 	 
	$parser=new \alib\utils\SqlParser();
	 
	$parser->parse($query);
	
	$subqueries=$parser->getNodesByType(\alib\utils\Sqlparser::PHP_SQL_SUBSELECT);
	
	$parser->appendWhere('field2="val"', 'AND', $subqueries[1]);
	$newQuery=$parser->rebuildSource();
	
	echo '<pre>';
	echo 'Query: '.$query;
	echo '<hr>';
	echo 'Modified query: '.$newQuery;