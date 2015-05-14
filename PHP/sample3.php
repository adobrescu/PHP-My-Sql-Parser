<?php
	/*
	 * This sample shows how to modify a UPDATE statement and a subquery by adding an LIMIT
	 */
	
	 include_once(__DIR__.'/lib/SqlParser.class.php');
	 
	 
	 $query='UPDATE tbl
		 SET field=(SELECT CONCAT(field1, field2) FROM tbl2 LIMIT 1)
		 LIMIT 1';
	 	 
	$parser=new \alib\utils\SqlParser();
	 
	$parser->parse($query);
	
	$subqueries=$parser->getNodesByType(\alib\utils\Sqlparser::PHP_SQL_SUBSELECT);
	
	$parser->setLimit(12);
	
	$subqueries=$parser->getNodesByType(\alib\utils\Sqlparser::PHP_SQL_SUBSELECT);
	
	$parser->setLimit(1, 100, $subqueries[0]);
	
	$newQuery=$parser->rebuildSource();
	
	
	echo 'Query: '.$query;
	echo '<hr>';
	echo 'Modified query: '.$newQuery;