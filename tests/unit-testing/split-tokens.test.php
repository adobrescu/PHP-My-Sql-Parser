<?php


include_once('test-query.inc.php');
return;
$sqlParser=new \alib\utils\SqlParser();


$selectExprs[]='(((tbl2.a+b)*c/v))-((((a/c)+b)% 3)+"string \"s"+`alias`+\'string 2\' mod 4.34)';

$selectExprs[]='DELETE FROM tbl where 1';

$selectExprs='SELECT (a+b) as c, (a+b) as \'c\', (a+b) as "c", (a+b) as `c`, (a+b)  c, (a+b)  \'c\', (a+b)  "c", (a+b)  `c`, 1 in (0,1,2)';//,  (((a+b)*c/v))-((((a/c)+b)% 3) mod 4.34) FROM tbl';
//$selectExprs='seLect "axxa", "aaaxtores", *, 555.45e+678, 1.45e+678, 123, 123.45, 123e+678, 4.45';
//testQuery($selectExprs);
//$selectExprs='"string cu 123456" tbl555 @param xxx1234 ,111.222 "alt string" 123.11 ,@param2 `coloana` 567   \'string \\\'escapat cu 123.1\' `alta coloana`';
//echo $selectExprs.'<br><pre>';
$selectExprs='seLect \'string 
	\'';
$sqlParser->parse2($selectExprs);
echo '<pre>';
print_r($sqlParser->getTokens());