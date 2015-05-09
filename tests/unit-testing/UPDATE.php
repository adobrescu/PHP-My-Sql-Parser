<?php


include_once('test-query.inc.php');


$queries=array();


$queries[]='UPDATE tbl SET id=3, id2=3, db.tbl.c=4/(a+b)';
$queries[]='UPDATE tbl, tbl3 SET tbl.id=tbl3.id/100+(select a from tbl)';
$queries[]='UPDATE tbl INNER JOIN (select id from tbl2) USING(id) SET `db`.`tbl`.f=(((a+b)/3)*(d+e))';
$queries[]='UPDATE tbl `alias1` INNER JOIN (select id from tbl2) AS `alias2` USING(id) SET camp="string \" "';

$queries[]='UPDATE tbl `alias1` INNER JOIN (select id from tbl2) AS `alias2` USING(id) SET camp="string \"" 
	WHERE `alias1`.id=alias2.fld';

$queries[]='UPDATE tbl, tbl3 SET tbl.id=tbl3.id/100+(select a from tbl) ORDER BY id ASC, fld DESC, a';
$queries[]='UPDATE tbl, tbl3 SET tbl.id=tbl3.id/100+(select a from tbl) ORDER BY id ASC, fld DESC, a
	LIMIT 10';
$queries[]='UPDATE tbl, tbl3 SET tbl.id=tbl3.id/100+(select a from tbl) ORDER BY id ASC, fld DESC, a
	LIMIT 10, 100';
$queries[]='UPDATE tbl, tbl3 SET tbl.id=tbl3.id/100+(select a from tbl) ORDER BY id ASC, fld DESC, a
	LIMIT 10 OFFSET 30';
$queries[]='UPDATE IGNORE tbl, tbl3 SET tbl.id=tbl3.id/100+(select a from tbl) ORDER BY id ASC, fld DESC, a
	LIMIT 10 OFFSET 30';
$queries[]='UPDATE IGNORE LOW_PRIORITY tbl, tbl3 SET tbl.id=tbl3.id/100+(select a from tbl) ORDER BY id ASC, fld DESC, a
	LIMIT 10 OFFSET 30';
foreach ($queries as $query)
{

	testQuery($query);
	//print_r(parseSqlQuery($query));

}