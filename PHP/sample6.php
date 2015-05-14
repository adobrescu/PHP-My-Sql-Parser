<?php
	/*
	 * This sample shows how to get table names from a SELECT and from sub-queries
	 */
	
	 include_once(__DIR__.'/lib/SqlParser.class.php');
	 
	 
	 $query='SELECT ALL *, 
		 (SELECT field FROM tbl2),
		 (SELECT CONCAT(\'NN\', field2) FROM tbl3 LEFT JOIN tbl4 USING(id))
		 FROM tbl';
	 	 
	$parser=new \alib\utils\SqlParser();
	 
	$parser->parse($query);
	$null=null;
	$subqueries=$parser->getNodesByType(\alib\utils\SqlParser::PHP_SQL_SUBSELECT, $null, $skipSubqueries=false, $stopOnFirstMatch=false);
	
	echo '<pre>';
	
	echo "Query: \n\n".$query;
	echo "\n\n----------------------------------------------------------------------------------------------\n\n";
	echo "All Table Names: \n";
	print_r($parser->getTableNames(false));
	echo "\n\n----------------------------------------------------------------------------------------------\n\n";
	echo "Main SELECT Table Names:\n";
	print_r($parser->getTableNames());
	echo "\n\n----------------------------------------------------------------------------------------------\n\n";
	for($i=0; $i<count($subqueries); $i++)
	{
		echo "Subquery ".($i+1).":\n\n";
		echo $parser->rebuildSource(null, $subqueries[$i]);
		echo "\n\n\nSubquery Table Names:\n\n";
		print_r($parser->getTableNames(true, $subqueries[$i]));
		echo "\n\n----------------------------------------------------------------------------------------------\n\n";
	}
	
	
	