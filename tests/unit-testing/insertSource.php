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
$limits[]=' 50';
$limits[]=' 50';
$limits[]=' 50';

$offsets[]=101;
$offsets[]=101;

$offsetKeyword[]='OFFSET';
$offsetKeyword[]=',';
$nullNode=null;
foreach($queries as $query)
{ 
	foreach($orderBys as $orderBy)
	{
		$parser->parse($query);
		$oldOrderBy=$parser->rebuildSourceWithRecursiveCalls($parser->getNodesByType(\alib\utils\SqlParser::PHP_SQL_ORDER_BY, $nullNode, false)[0]);
		
		$parser->appendOrderBy($orderBy);
		$newOrderBy=$parser->rebuildSourceWithRecursiveCalls($parser->getNodesByType(\alib\utils\SqlParser::PHP_SQL_ORDER_BY)[0]);
		
		ASSERT_EQUALS(trimAll(($oldOrderBy?'':'ORDER BY').$oldOrderBy.($oldOrderBy?',':'').$orderBy), trimAll($newOrderBy));
	}
	
	foreach($wheres as $where)
	{
		$parser->parse($query);
		$oldWhere=$parser->rebuildSourceWithRecursiveCalls($parser->getNodesByType(\alib\utils\SqlParser::PHP_SQL_WHERE)[0]);
		
		$parser->appendWhere($where, 'AND');
		$newWhere=$parser->rebuildSourceWithRecursiveCalls($parser->getNodesByType(\alib\utils\SqlParser::PHP_SQL_WHERE)[0]);
		
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
	foreach($limits as $i=>$limit)
	{
		$parser->parse($query);
		if(isset($offsets[$i]))
		{
			if(isset($offsetKeyword[$i]))
			{
				$parser->setLimit($limit, $offsets[$i], $null, $offsetKeyword[$i]);
			}
			else
			{
				$parser->setLimit($limit, $offsets[$i]);
			}
		}
		else
		{
			$parser->setLimit($limit);
		}
		$newLimit=$parser->rebuildSourceWithRecursiveCalls($parser->getNodesByType(\alib\utils\SqlParser::PHP_SQL_LIMIT)[0]);
		
		$sqlLimit='LIMIT '.$limit.(isset($offsets[$i])?(isset($offsetKeyword[$i])?$offsetKeyword[$i]:' OFFSET ').$offsets[$i]:'');
		
		ASSERT_EQUALS( trimAll($sqlLimit, true), trimAll($newLimit, true));
		
	}
}