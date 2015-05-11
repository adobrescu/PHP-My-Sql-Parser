<?php
include_once('test-query.inc.php');
$p=new \alib\utils\SqlParser();
$q='SELECT fld 
				FROM tbl1 STRAIGHT_JOIN
					tbl2 USING(id)  
				into \'filename\' lock   IN	 SHARE MODE';

$joinTypes=array(
	'STRAIGHT_JOIN',
	'NATURAL	RIGHT		OUTER JOIN',
	'LEFT   OUTER		JOIN',
	'INNER  JOIN',
	'CROSS			JOIN',
	'JOIN',
	
	
	'LEFT		  JOIN',
	
	'RIGHT JOIN',
	'RIGHT OUTER	JOIN',
	
	'STRAIGHT_JOIN',
	
	
	'NATURAL	LEFT	OUTER		JOIN',
	'NATURAL
		LEFT 
		JOIN',
	'NATURAL	
	JOIN',
	'NATURAL  OUTER	
	JOIN',
	'NATURAL	RIGHT		OUTER JOIN',
	'NATURAL 
	RIGHT			JOIN'
	);
$intoTypes=array(
	
	'into',
	'into	outfile',
	'INTO   DUMPFILE',
	''
);
$selectTypes=array(
	
	'lock   IN	 SHARE MODE',
	'FOR   uPDATE',
	''
	
);

$numJoinTypes=count($joinTypes);
$parser=new \alib\utils\SqlParser();

foreach($joinTypes as $joinType)
{
	$query='SELECT "string \" asa\" FROM a '.$joinType.' b USING(i)';
	$tokens=$parser->parseTokens($query);
	//$tokens=$parser->getTokens();
	ASSERT_EQUALS(\alib\utils\TOKEN_JOIN_TYPE, $tokens[4][1]);
}

foreach($selectTypes as $selectType)
{
	foreach($joinTypes as $joinType)
	{
		//foreach($joinTypes as $joinType2)
		{
			//foreach($joinTypes as $joinType3)
			{
				//foreach($joinTypes as $joinType4)
				{
					//$joinType2=$joinTypes[rand(0, $numJoinTypes-1)];
					//$joinType3=$joinTypes[rand(0, $numJoinTypes-1)];
					//$joinType4=$joinTypes[rand(0, $numJoinTypes-1)];

					foreach($intoTypes as $intoType)
					{

						$query='SELECT fld 
							FROM tbl1 '.$joinType.'
								tbl2 USING(id)  
							'.$joinType.' `db`.`table` 
								ON `db`.`table`.`column`=tbl2.field12  '.
							$joinType.' db.tbl
								USING(db)		'.
							$joinType.' `where` 
								on db.tbl.camp=`where`.`orderby`'.
							'WHERE (tbl.id+(tbl2.camp-`db`.`table`.`column`))>=0
							GROUP BY `db`.`table`.`column` DESC, func(tbl2.camp) ASC
							HAVING MAX ( `db`.`table`.`column` = 10 )
							ORDER BY `select`.`from`.`having`, `procedure` ASC, db.tbl.`columns` ASC, 2 DESc
							LIMIT 10, 100
							PRoceDURE proc(a+b, (select \'abced\\\'efgh\'))
							';


						$query .= ($intoType?$intoType.' \'filename\'':'').' ';



						$query .= $selectType;

						 //print_r(parseSqlQuery($query)); die('');


						testQuery($query);
					}
				}
			}
		}

	}
	
}

