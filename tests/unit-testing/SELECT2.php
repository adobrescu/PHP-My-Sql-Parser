<?php

include_once('test-query.inc.php');
include_once('testSELECTQueries.inc.php');

$selectExprs[]='(a+b) as c, (a+b) as \'c\', (a+b) as "c", (a+b) as `c`, (a+b)  c, (a+b)  \'c\', (a+b)  "c", (a+b)  `c`';
$selectExprs[]='1 in (0,1,2)';
$selectExprs[]='1 not in (1,2,3)';
$selectExprs[]='(select "1") in (select("0,1,2"))';
$selectExprs[]='(select "1") in ((select("0,1,2")))';
$selectExprs[]='(select "1") not in (select("0,1,2"))';
$selectExprs[]='(select "1") not in ((select("0,1,2")))';

$selectExprs[]='a is null';
$selectExprs[]='(select "a") is null';
$selectExprs[]='a is not null';
$selectExprs[]='(select "a") is not null';
$selectExprs[]='CASE a WHEN 1 then 2 when 3 then 6 end';



testSELECTQueries($selectExprs, $tblReferences='', $wheres='', $groupBys='');
$selectExprs=array();