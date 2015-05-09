<?php

include_once('test-query.inc.php');

$parser=new \alib\utils\SqlParser();


$queries=array();
$queries[]='SELECT field From tbl ORDER BY a ASC LIMIT 30';
$queries[]='SELECT field From tbl ';
$queries[]='SELECT field From tbl where		a  =b	+
	(c+d) ORDER BY (select id from tbl2 limit 10,1)';


$orderBys=array();
$orderBys[]=' (select 1) DESC, a ASC';
$orderBys[]=' id in (1,23) desc';

$wheres=array();
$wheres[]=' a>b AND (tbl.fld<=100)';

$limits=array();
$limits[]=' LIMIT 50, 101';
$limits[]=' LIMIT 50 OFFSET 101';
$limits[]=' LIMIT 50';

foreach($queries as $query)
{
	foreach($orderBys as $orderBy)
	{
		$parser->parse($query);
		$oldOrderBy=$parser->rebuildSourceWithRecursiveCalls($parser->getTokenParseTreeNode(\alib\utils\SqlParser::PHP_SQL_ORDER_BY));
		
		$parser->appendOrderBy($orderBy);
		$newOrderBy=$parser->rebuildSourceWithRecursiveCalls($parser->getTokenParseTreeNode(\alib\utils\SqlParser::PHP_SQL_ORDER_BY));
		
		ASSERT_EQUALS(trimAll(($oldOrderBy?'':'ORDER BY').$oldOrderBy.($oldOrderBy?',':'').$orderBy), trimAll($newOrderBy));
	}
	
	foreach($wheres as $where)
	{
		$parser->parse($query);
		$oldWhere=$parser->rebuildSourceWithRecursiveCalls($parser->getTokenParseTreeNode(\alib\utils\SqlParser::PHP_SQL_WHERE));
		
		$parser->appendWhere($where, 'AND');
		$newWhere=$parser->rebuildSourceWithRecursiveCalls($parser->getTokenParseTreeNode(\alib\utils\SqlParser::PHP_SQL_WHERE));
		
		if($oldWhere)
		{
			$oldWhere=preg_replace('/^[\\s]*WHERE/i', 'WHERE (', $oldWhere).' )';
			if(!ASSERT_EQUALS( trimAll($oldWhere.' AND ( '.$where.' )', true), trimAll($newWhere, true)))
			{
				
			}
		}
		else
		{
			ASSERT_EQUALS( trimAll('WHERE  ( '.$where.' )', true), trimAll($newWhere, true));
		}
	}
	foreach($limits as $limit)
	{
		$parser->parse($query);		
		$parser->setLimit($limit);
		$newLimit=$parser->rebuildSourceWithRecursiveCalls($parser->getTokenParseTreeNode(\alib\utils\SqlParser::PHP_SQL_LIMIT));
		
		ASSERT_EQUALS( trimAll($limit, true), trimAll($newLimit, true));
		
	}
}