<?php
	/*
	 * This sample shows how to modify a SELECT statement by adding select options (like SQL_CALC_FOUND_ROWS)
	 */
	
	 include_once(__DIR__.'/lib/SqlParser.class.php');
	 
	 
	 $query='SELECT ALL *, (SELECT field FROM tbl2) FROM tbl';
	 	 
	$parser=new \alib\utils\SqlParser();
	 
	$parser->parse($query);

	$parser->addSelectOptions('SQL_CALC_FOUND_ROWS');
	
	$subqueries=$parser->getNodesByType(\alib\utils\Sqlparser::PHP_SQL_SUBSELECT);
	
	$parser->addSelectOptions('DISTINCTROW', $subqueries[0]);
	
	$newQuery=$parser->rebuildSource();
	
	
	echo 'Query: '.$query;
	echo '<hr>';
	echo 'Modified query: '.$newQuery;