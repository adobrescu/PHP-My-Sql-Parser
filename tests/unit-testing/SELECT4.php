<?php

include_once('test-query.inc.php');
include_once('testSELECTQueries.inc.php');
//and \'string\', a && b, a and ( b or c), a and ((b or c) || d), a and ((b or c) || d) xor e, a and ((b or c) || d) and not e, a and ((b or c) || d) or not (a && b)
$queries=array();
$queries[]='SELECT "axăî皮u哦上ixa" 
			 FROM tbl 
			 INTO OUTFILE axxa FIELDS TERMINATED	BY "a"  ENCLOSED BY "c"';
$queries[]='SELECT "axxa" 
			 FROM tbl 
			 INTO OUTFILE axxa FIELDS TERMINATED	BY "a"  ENCLOSED BY "c"';
$queries[]='SELECT "axxa" 
			 FROM tbl 
			 INTO OUTFILE axxa COLUMNS TERMINATED	BY "a"  ENCLOSED BY "c"';

$queries[]='SELECT "axxa" 
			 FROM tbl 
			 INTO OUTFILE axxa COLUMNS TERMINATED	BY "a"  ENCLOSED BY "c" LINES TERMINATED BY "c"';
$queries[]='SELECT "axxa" 
			 FROM tbl 
			 INTO OUTFILE axxa COLUMNS  ENCLOSED BY "c" LINES TERMINATED BY "c" TERMINATED	BY "a" ';
$queries[]='SELECT "axxa" 
			 FROM tbl 
			 INTO OUTFILE axxa COLUMNS TERMINATED	BY "a"  ENCLOSED BY "c" LINES STARTING BY "c"';

$queries[]='SELECT "axxa" 
			 FROM tbl 
			 INTO OUTFILE axxa COLUMNS TERMINATED	BY "a"  ENCLOSED BY "c" LINES starting by "x" TERMINATED BY "c" ';

$queries[]='SELECT "axxa" 
			 FROM tbl 
			 INTO OUTFILE axxa COLUMNS TERMINATED	BY "a"  ENCLOSED BY "c" LINES TERMINATED BY "c" starting by "x" ';

$queries[]='SELECT a UNION SELECT b UNION (select a from b left join c using(id)) UNION ALL (select b) union distinct select "a"';
$queries[]='SELECT a UNION SELECT b UNION (select a from b left join c using(id)) UNION ALL ((((select b)))) union distinct select "a"';

$queries[]='select  (select 1) union distinct  (select 1)';
$queries[]='select \'

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce cursus est nisi, in ornare nisl varius vel. Aenean venenatis odio vel arcu mollis, eu aliquam diam viverra. Nam feugiat odio eget aliquam luctus. Aenean imperdiet libero nec augue vehicula, eu varius est adipiscing. Duis hendrerit augue in nunc ultrices tempor. Nunc et mattis tellus, eu viverra lorem. In sagittis lobortis augue, eget consectetur augue volutpat a. Phasellus elit arcu, pellentesque sed ante nec, ullamcorper pretium purus. Sed lorem enim, mollis non turpis a, feugiat rutrum nulla. Proin ac erat quis erat vulputate porta. Cras venenatis, arcu ut rutrum varius, nibh nunc varius mauris, eget varius sem sapien nec leo. Pellentesque laoreet arcu dignissim, pharetra ante vel, viverra nunc. Curabitur tellus mi, aliquam et augue vitae, lobortis vestibulum lacus. Proin facilisis vestibulum nibh, vitae molestie metus dignissim vitae. Morbi vel tellus sit amet tellus pulvinar porttitor non id elit. Duis eget facilisis urna.

Nam pellentesque quis quam eu viverra. Proin ultrices mauris ut justo euismod posuere eget aliquet nibh. Aenean consequat massa quis tempus fermentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In nec ornare nibh. Sed accumsan mauris quis arcu pretium, quis tempus dui bibendum. Pellentesque luctus lectus a purus dapibus, quis pharetra ipsum dapibus.

In congue sed est in euismod. Vivamus quis nisl eget nunc venenatis placerat et et eros. Morbi eget placerat nulla. Donec dapibus risus mi, vel rutrum est vehicula ac. Ut imperdiet leo ac lacus ultricies faucibus. Aenean ut odio justo. Donec ac cursus odio, ut aliquam leo.

Quisque eu nisi eget libero egestas sagittis. Integer in pharetra felis. Ut dolor augue, venenatis sit amet mattis vitae, posuere ut augue. Sed iaculis arcu vitae elit scelerisque, in vestibulum metus consequat. Sed molestie vitae augue vel faucibus. Vivamus dapibus laoreet tellus sit amet sollicitudin. Nullam in pulvinar felis. Donec eu velit augue. Donec posuere vel massa eu suscipit. Donec quis neque nisl. Vivamus tempus, nisi eget euismod semper, augue erat sagittis enim, a sollicitudin neque sapien vehicula sem. Ut eu orci metus. In non lacus at ante interdum vulputate et sed urna. Nulla nisi quam, imperdiet vel bibendum at, auctor ut leo.

Vivamus condimentum pellentesque porttitor. Quisque bibendum tincidunt feugiat. In faucibus quam justo, vel lobortis elit accumsan gravida. Praesent mollis eget lacus ac lobortis. Mauris odio neque, malesuada quis urna sed, blandit placerat est. Morbi vel sodales nibh. Aliquam nec quam ac urna sagittis sollicitudin. Praesent velit augue, mollis ac rhoncus eget, pharetra ut lorem. Nullam accumsan auctor tortor. Donec rutrum sollicitudin nisl et dapibus. Fusce nulla odio, consectetur at rhoncus vel, condimentum in nisl. Maecenas in malesuada ligula, nec vehicula dolor. Sed vestibulum auctor tellus. Fusce varius nisl eu dui pellentesque accumsan. Aliquam mollis, nunc ac ornare iaculis, ante lacus ultrices enim, sit amet tincidunt mauris felis quis orci. Curabitur eget massa a lacus tincidunt vestibulum ac id purus. 
\' from tbl';
$queries[]='SELECT FOUND_ROWS()';
foreach ($queries as $query)
{
	//print_r(parseSqlQuery($query));
	testQuery($query);

}