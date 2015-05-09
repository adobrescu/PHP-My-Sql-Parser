<?php


include_once('test-query.inc.php');


$queries=array();


$queries[]='DELETE tbl. * FROM tbl LEFT JOIN tbl2 USING (id)';
$queries[]='DELETE FROM tbl';
$queries[]='DELETE tbl.*, tbl2 FROM tbl LEFT JOIN tbl2 USING (id) WHERE (select "a") ';
$queries[]='DELETE db.`tbl` FROM tbl LEFT JOIN tbl2 USING (id) WHERE (select "a")';
$queries[]='DELETE FROM tbl where 1 ';
$queries[]='DELETE FROM tbl where 1 order by id limit 100';

foreach ($queries as $query)
{

	testQuery($query);
	//print_r(parseSqlQuery($query));

}