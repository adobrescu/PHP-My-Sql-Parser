<?php


include_once('test-query.inc.php');


$queries=array();


$queries[]='REPLACE tbl (a) VALUES (2)';

$queries[]='REPLACE INTO tbl VALUE (2,3)';

$queries[]='REPLACE DELAYED low_priority INTO tbl VALUES ((select "a"), 12)';

$queries[]='REPLACE DELAYED low_priority tbl VALUES ((select "a"), 12)';

$queries[]='REPLACE INTO tbl (a) value (34)';
 
$queries[]='REPLACE tbl SET c=(a+b)';
$queries[]='REPLACE delayed into tbl SET c=(a+b), db.tbl.fld="string"';

$queries[]='REPLACE tbl SELECT \'a \\\'string\'';

$queries[]='REPLACE tbl SELECT \'a \\\'string\' UNION ALL (select 2)';

$queries[]='REPLACE tbl SELECT \'a \\\'string\' UNION ALL (((select 2)))';


$queries[]='REPLACE low_priority into tbl (a,b) select (select 1,2) union all select 1,4';

foreach ($queries as $query)
{

	testQuery($query);
	//print_r(parseSqlQuery($query));

}