<?php
	/*
	 * This sample shows how to get table names from a SELECT and from sub-queries
	 */
	
	 include_once(__DIR__.'/lib/SqlParser.class.php');
	 
	 
	 $query='SELECT ALL db.`tbl`.some_column alias1, 
				*, 
				column2, 
				SUM(col+col2) As someSum,
				(SELECT * FROM tabela) AS subselect_alias
			FROM tbl AS tbl_alias
			LEFT JOIN tbl2
				ON tbl_alias2.id=tbl3.id
		';
	
	$parser=new \alib\utils\SqlParser();
	$parser->parse($query);
?>
<pre>
<?php
	echo 'Query: '.$query;
	if($expressions=array_reverse($parser->getSelectExpressions()))
	{
		foreach($expressions as $columnNameOrAlias=>$expression)
		{
			echo $columnNameOrAlias.': '.$expression;
			echo "\n";
			echo '<hr>';
		}
	}