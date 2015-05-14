<?php
	/*
	 * This sample shows how to get field names from the SELECT in a SELECT and from sub-queries
	 */
	
	 include_once(__DIR__.'/lib/SqlParser.class.php');
	 
	 
	 $query='SELECT ALL field1, field2, field3+100, CONCAT(field4, \'string\'),
		 (SELECT subfield1, 2+subfield2 FROM tbl2 WHERE subfield10>0),
		 (SELECT CONCAT(\'NN\', subfield3) FROM tbl3 LEFT JOIN tbl4 USING(id))
		 FROM tbl';
	 	 
	$parser=new \alib\utils\SqlParser();
	 
	$parser->parse($query);
	
	$null=null;
	$subqueries=$parser->getNodesByType(\alib\utils\SqlParser::PHP_SQL_SUBSELECT, $null, $skipSubqueries=false, $stopOnFirstMatch=false);
	
	echo '<pre>';
	print_r(count($subqueries));
	echo "Query: \n\n".$query;
	echo "\n\n----------------------------------------------------------------------------------------------\n\n";
	echo "Main SELECT Field Names:\n";
	print_r($parser->getFieldNames());
	echo "\n\n----------------------------------------------------------------------------------------------\n\n";
	for($i=0; $i<count($subqueries); $i++)
	{
		echo "Subquery ".($i+1).":\n\n";
		echo $parser->rebuildSource(null, $subqueries[$i]);
		echo "\n\n\nSubquery Field Names:\n\n";
		print_r($parser->getFieldNames(true, $subqueries[$i]));
		echo "\n\n----------------------------------------------------------------------------------------------\n\n";
	}
	
	
	