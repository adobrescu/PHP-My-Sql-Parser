<?php

function testQuery($query)
{
	static $parser=null, $assertParser=null;
	if(is_null($parser))
	{
		$parser=new \alib\utils\SqlParser();
		$assertParser=new \alib\utils\SqlParser();
	}
	$parser->parse($query);
	
	$rebuiltQuery=$parser->rebuildSource();
	
	$assertParser->parse($rebuiltQuery);
	
	ASSERT_IDENTICAL($tokens=$parser->getTokens(), $assertParser->getTokens());
	ASSERT_IDENTICAL($parser->getParseTree(), $assertParser->getParseTree());

	if(strpos($query, '/*')===false)
	{
		ASSERT_EQUALS(preg_replace('/[\s]+/', '', $query), preg_replace('/[\s]+/', '', $rebuiltQuery));
	}
	
	//////////////////////
	
	$firstToken=reset($tokens);
		
	if (strtoupper($firstToken[0])!='SELECT')
	{
		return;
	}
	
	$query=preg_replace('/^select/', 'select ALL DISTINCT DISTINCTROW HIGH_PRIORITY STRAIGHT_JOIN SQL_SMALL_RESULT SQL_BIG_RESULT  SQL_BUFFER_RESULT SQL_CACHE SQL_NO_CACHE SQL_CALC_FOUND_ROWS ', $query);
	//print_r(parseSqlQuery($query)); echo $query.'<br>'.$rebuiltQuery;  continue;
	//echo $query.'<br>';
	$parser->parse($query);

	$rebuiltQuery=$parser->rebuildSourceWithRecursiveCalls();

	$assertParser->parse($rebuiltQuery);

	ASSERT_IDENTICAL($parser->getTokens(), $assertParser->getTokens());
	ASSERT_IDENTICAL($parser->getParseTree(), $assertParser->getParseTree());


	if(strpos($query, '/*')===false)
	{
		ASSERT_EQUALS(preg_replace('/[\s]+/', '', $query), preg_replace('/[\s]+/', '', $rebuiltQuery));
	}
}
