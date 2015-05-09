<?php

include_once('test-query.inc.php');
include_once('testSELECTQueries.inc.php');

$selectExprs[]='CASE (select "a") WHEN (select "1") then 2 when 3 then 6 else (select 12) end';
$selectExprs[]='CASE WHEN 1 then 2 when 3 then 6 end';
$selectExprs[]='tb.aas, db.aas';
$selectExprs[]='`db`.tbl.`field`';
$selectExprs[]='a.*, `tbl`.field+db.tbl.field2';
$selectExprs[]='a.*, `tbl`.field+db.tbl.field2 \'alias \\\' field2\', db.tbl.col "a"';

testSELECTQueries($selectExprs, $tblReferences='', $wheres='', $groupBys='');

$selectExprs=array();
$selectExprs[]='group_concat(a,b order by a asc, b desc)';

$tblReferences[]=' tbl ';
$tblReferences[]=' tbl, tbl2 ';
$tblReferences[]=' tbl, tbl2 left join tbl3 on 2';
$tblReferences[]=' tbl, tbl2 right join tbl3 using(id)';
$tblReferences[]=' tbl, tbl2 right join tbl3 using(od), tbl4 left outer join d on id=id2';
$tblReferences[]=' tbl left join (select id, id2 from tbl) using(id)';
$tblReferences[]='db.tbl';
$tblReferences[]='db.tbl alias';
$tblReferences[]='`db`.tbl alias';
$tblReferences[]='db.tbl as alias';
$tblReferences[]='a left join b using(id)';
$tblReferences[]='a ignore key (k) left join b using(id) ';
$tblReferences[]='a ignore index (k) left join b using(id) ';
$tblReferences[]='`a` left join (b inner join c using(id)) on id1=id2';
$tblReferences[]='`a` as `alias` left join (b inner join c using(id)) on id1=id2';

$wheres[]='a=b';
$wheres[]='(select id from tbl)>1';
$groupBys[]='id';
$groupBys[]='id, IFNULL(fld,0) ';
$groupBys[]='id, IFNULL(fld,0) DESC, (select 1) ASC ';
$groupBys[]='id, IFNULL(fld,0) DESC, (select 1) ASC WITH   ROLLUP';

testSELECTQueries($selectExprs, $tblReferences, $wheres, $groupBys);
