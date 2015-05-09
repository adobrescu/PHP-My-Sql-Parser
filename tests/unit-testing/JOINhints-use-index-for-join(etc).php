<?php


$joinHints=array(
	'USE INDEX FOR JOIN (index_list, key2)',
	'USE INDEX (index_list, key2)',
	'USE KEY FOR JOIN (index_list, key2)',
	'USE KEY (index_list, key2)',
	
	'IGNORE INDEX FOR JOIN (index_list, key2)',
	'IGNORE INDEX (index_list, key2)',
	'IGNORE KEY FOR JOIN (index_list, key2)',
	'IGNORE KEY (index_list, key2)',
	
	'FORCE INDEX FOR JOIN (index_list, key2)',
	'FORCE INDEX (index_list, key2)',
	'FORCE KEY FOR JOIN (index_list, key2)',
	'FORCE KEY (index_list, key2)',
	
	/*
	 USE {INDEX|KEY} [FOR JOIN] (index_list)
  | IGNORE {INDEX|KEY} [FOR JOIN] (index_list)
  | FORCE {INDEX|KEY} [FOR JOIN] (index_list)
	*/
);

$parser=new \alib\utils\SqlParser();

foreach($joinHints as $joinHint)
{
	$query='SELECT * 
		FROM `where` as tbl '.$joinHint.' LEFT   JOIN `orderby` o
			USING (`insert`)
		INNER  JOIN `update`.`table` AS b
			ON `replace`.`bigint`=`delete`.`varchar`';
	$tokens=$parser->parseTokens($query);
	//$tokens=$parser->getTokens();
	ASSERT_EQUALS(\alib\utils\TOKEN_JOIN_INDEX_HINT, $tokens[6][1]);
	
	testQuery($query);

}
