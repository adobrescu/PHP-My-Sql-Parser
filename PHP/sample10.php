<?php
	/*
	 * This sample shows how to get table names from a SELECT and from sub-queries
	 */
	
	 include_once(__DIR__.'/lib/SqlParser.class.php');
	 
	 
	 $query='SELECT *, 
			(
				SELECT GROUP_CONCAT(field3)
				FROM tbl4 tbl_alias4
				LEFT JOIN (
							SELECT field4
							FROM tbl5 AS tbl_alias5
							) AS nested_subselect_alias
				ON tbl4.some_field=nested_subselect_alias.some_field
				GROUP BY field4
			) 
		FROM tbl AS tbl_alias
		LEFT JOIN tbl2 tbl_alias2
			USING(id)
		INNER JOIN db.tbl3
			ON tbl_alias2.id=tbl3.id
		LEFT JOIN (SELECT field FROM tbl4) alias3
			ON tbl_alias2.field2=alias3.field2';
	 	 
	$parser=new \alib\utils\SqlParser();
	 
	$parser->parse($query);
	echo '<pre>';	
	echo 'Rebuild Query: <br>'.$parser->rebuildSource();
	echo "\n----------------------------------------------------------------------\n";
	
	echo 'Table Aliases: <br>';
	print_r($parser->getTableNameAliases());
	//print_r($parser->getTokens());
	echo "\n----------------------------------------------------------------------\n";
	if($subqueries=$parser->getNodesByType(\alib\utils\Sqlparser::PHP_SQL_SUBSELECT))
	{
		foreach($subqueries as $i=>$subquery)
		{
			echo 'Sub-SELECT: <br>';
			echo $parser->rebuildSource(null, $subquery);
			print_r($parser->getTableNameAliases(true, $subquery));
			echo "\n----------------------------------------------------------------------\n";
		}
	}