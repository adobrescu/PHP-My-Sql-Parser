<?php


include_once('test-query.inc.php');


$queries=array();

$queries[]='INSERT delayed tbl set db.tbl.fld=1';
$queries[]='INSERT delayed into tbl set a=a+(tbl.f+`a`)';
$queries[]='INSERT into tbl set f=c';
$queries[]='INSERT into tbl partition (p, part) set coloana=valoare';
$queries[]='INSERT into tbl partition (p, part) set coloana=(select valoare) on duplicate key update fld=12';
$queries[]='INSERT delayed into tbl (a) values (1)';
$queries[]='INSERT delayed tbl (a) value ((select 1))';

$queries[]='INSERT delayed tbl (a) value ((select 1)) on duplicate key update a=(select fld from tbl2 where id2=10)';

$queries[]='INSERT tbl select a from tbl2';
$queries[]='INSERT tbl select a from tbl2 union distinct select 1';
$queries[]='INSERT tbl (camp) select a from tbl2 union distinct select 1';
$queries[]='INSERT INTO tbl () VALUES ()';
$queries[]='INSERT INTO tbl (`column`) VALUES ("test")';
$queries[]='INSERT INTO tbl (col, tbl.id) VALUES ("test")';
foreach ($queries as $query)
{

	testQuery($query);
	//print_r(parseSqlQuery($query));

}