<?php


include_once('test-query.inc.php');
include_once('testSELECTQueries.inc.php');


$selectExprs=array();
$selectExprs[]='*';

$selectExprs[]='123.45e+678, 1.45e+678, 123, 123.45, 123e+678, 4.45, 0x90ef, x\'123ef\', b\'0111\'';

$selectExprs[]='"double quoted string"';
$selectExprs[]='"double quoted string with \"double quote\" inside"';
$selectExprs[]='\'single quoted string\'';
$selectExprs[]='\'single quoted string with \\\'single quote\\\' inside\'';





//logical operators
$selectExprs[]='+12, -4, +(a-b), -(a*c)';
$selectExprs[]='"a", "b" , c as d';

$selectExprs[]='"axxa" and \'string\', a && b, a and ( b or c), a and ((b or c) || d), a and ((b or c) || d) xor e, a and ((b or c) || d) and not e, a and ((b or c) || d) or not (a && b)';

$selectExprs[]='~(a and b) and ~c';
//math. operators
$selectExprs[]='((a+b)*c)+d';
$selectExprs[]='(a+b)*c/v';
$selectExprs[]='(((a+b)*c/v))-((((a/c)+b)% 3) mod 4.34)';
$selectExprs[]='(a mod 10) div a/100%c';

//string operators

$selectExprs[]='a like \'sring\'';
$selectExprs[]='a not like \'string\'';

$selectExprs[]='a regexp \'sring\'';
$selectExprs[]='a not regexp \'sring\'';

$selectExprs[]='((a+b)*c)/d mod 4 not regexp \'string\'+expresie';

//comparaison operators
$selectExprs[]='(not a=b) && c';
$selectExprs[]='(not a<=>b) and c>=(b+a)';
$selectExprs[]='(~ a>=b) and c>(b<a)';
$selectExprs[]='(~ a<=>b) and c>=(b+a)';
$selectExprs[]='((~ a<=>b) and c>=(b+a))+(a<=b+c+(d=e))+ not a<>v and c!=d';

//bitwise operators
$selectExprs[]='( a | b ) & c';
$selectExprs[]='( a | b ) & c<<d>>120';
$selectExprs[]='(( a | b ) & c<<d>>120)^a+b';
$selectExprs[]='(( a | b ) & c<<d>>120)^a+b and ~(a&b+100)';


//attr op.

$selectExprs[]='@a:=b&c';

//function

$selectExprs[]='function (a)';
$selectExprs[]='function (a,b)';

$selectExprs[]='function ((a+b*(((c-d) mod 4 + ~10)+a-c)/2+1))';

$selectExprs[]='count_function(*)';

$selectExprs[]='group_concat( distinct a, b, c)';
$selectExprs[]='group_concat( a, b, c order by a)';
$selectExprs[]='group_concat( a, b, c order by a asc)';
$selectExprs[]='group_concat( a, b, c order by a desc)';
$selectExprs[]='group_concat( distinct a, b, c order by a)';
$selectExprs[]='group_concat( distinct a, b, c order by a asc)';
$selectExprs[]='group_concat( distinct a, b, c order by a desc)';
$selectExprs[]='group_concat( a, b, c order by (select "a"))';

$selectExprs[]='group_concat( a, b, c order by (select "a") asc)';
$selectExprs[]='group_concat( a, b, c order by (select "a") desc)';
$selectExprs[]='group_concat( distinct a, b, c order by(select " a"))';
$selectExprs[]='group_concat( distinct a, b, c order by(select " a") asc)';
$selectExprs[]='group_concat( distinct a, b, c order by(select " a") desc)';

$selectExprs[]='DATEADD( a , interval a day)';

$selectExprs[]='group_concat( distinct a, b, c order
	by (select \'a\'))';
$selectExprs[]='group_concat( distinct a, b, c order
	by (select \'a\') asc)';
$selectExprs[]='group_concat( distinct a, b, c order
	by (select \'a\') asc separator \'str\\\'ing\')';
$selectExprs[]='group_concat( distinct a, b, c  separator \'str\\\'ing\')';
$selectExprs[]='group_concat(  a, b, c order
	by (select \'a\') asc separator \'str\\\'ing\')';
$selectExprs[]='group_concat(  a, b, c order
	by (select \'a\')  separator \'str\\\'ing\')';
testSELECTQueries($selectExprs, $tblReferences='', $wheres='', $groupBys='');
$selectExprs=array();

