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
$queries[]='SELECT SQL_CALC_FOUND_ROWS  CONCAT(`content_items`.`id_content_item`, `content_items`.`id_content_item`, `content_items_alias_1`.`id_content_item`, 
	`content_items_alias_1`.`id_content_item`, `content_items_alias_2`.`id_content_item`, CONCAT(`content_translations`.`id_content_item`, 
	`content_translations`.`lang`), CONCAT(`content_translations`.`id_content_item`, \'-\', `content_translations`.`lang`)) AS ____PATH____, 
	`content_translations`.* 
FROM `content_items` INNER JOIN `content_items` AS content_items_alias_1
	ON `content_items`.`id_content_item`=`content_items_alias_1`.`parent_id_content_item`
INNER JOIN `content_items` AS content_items_alias_2
	ON `content_items_alias_1`.`id_content_item`=`content_items_alias_2`.`parent_id_content_item`
INNER JOIN `content_translations`
	ON `content_items_alias_2`.`id_content_item`=`content_translations`.`id_content_item`

WHERE CONCAT(`content_items`.`id_content_item`) IN (1) AND (content_translations.lang=\'en\')';

//$queries[]="SELECT '\\\\', 'a'";
$queries[]="SELECT ' axxa'";

/*$queries[]='SELECT "\\\\"';
$queries[]='SELECT SQL_CALC_FOUND_ROWS  CONCAT(`users`.`id_user`, `content_items`.`id_content_item`, \'\\\\\', CONCAT(`content_translations`.`id_content_item`, \'-\', `content_translations`.`lang`)) AS ____PATH____, 
	`content_translations`.* 
FROM `users` INNER JOIN `content_items`
	ON `users`.`id_user`=`content_items`.`id_user`
INNER JOIN `content_translations`
	ON `content_items`.`id_content_item`=`content_translations`.`id_content_item`

WHERE CONCAT(`users`.`id_user`) IN (1)';
 * 
 */
//echo $queries2; die();
$queries[]="SELECT ''' oaresce \\'";
$queries[]='SELECT """"';
$queries[]="SELECT '\\\\', 'a'";
$queries[]="SELECT SQL_CALC_FOUND_ROWS  CONCAT(`users`.`id_user`, '\\\\', `content_items`.`id_content_item`, '\\\\', 
	CONCAT(`content_translations`.`id_content_item`, '-', `content_translations`.`lang`)) AS ____PATH____, 
	`content_translations`.* 
FROM `users` INNER JOIN `content_items`
	ON `users`.`id_user`=`content_items`.`id_user`
INNER JOIN `content_translations`
	ON `content_items`.`id_content_item`=`content_translations`.`id_content_item`

WHERE CONCAT(`users`.`id_user`) IN (1)";
$queries=array('SELECT SUBSTR(
							information_schema.INNODB_SYS_TABLES.NAME, 
							LOCATE(\'/\', information_schema.INNODB_SYS_TABLES.NAME)
							+1) AS table_name, 
					GROUP_CONCAT(information_schema.INNODB_SYS_FIELDS.NAME) AS column_names,
					SUM(IF(LCASE(information_schema.COLUMNS.IS_NULLABLE)=\'YES\',1,0)) AS index_is_nullable,
					information_schema.INNODB_SYS_INDEXES.NAME AS index_name,
					information_schema.INNODB_SYS_INDEXES.TYPE,
					GROUP_CONCAT(IF(IFNULL(information_schema.COLUMNS.EXTRA, \'\')=\'auto_increment\', 1, 0)) AS extra
				FROM information_schema.INNODB_SYS_TABLES INNER JOIN  information_schema.INNODB_SYS_INDEXES
					USING(TABLE_ID)
				INNER JOIN information_schema.INNODB_SYS_FIELDS
					USING(INDEX_ID)
				INNER JOIN information_schema.COLUMNS
					ON information_schema.COLUMNS.TABLE_SCHEMA=\'trendyflendy.ro\'
						AND information_schema.COLUMNS.TABLE_NAME=SUBSTR(information_schema.INNODB_SYS_TABLES.NAME, LOCATE(\'/\', information_schema.INNODB_SYS_TABLES.NAME)+1)
						AND information_schema.COLUMNS.COLUMN_NAME=information_schema.INNODB_SYS_FIELDS.NAME
				WHERE information_schema.INNODB_SYS_TABLES.NAME LIKE \'trendyflendy@002ero/%\'
					AND ( information_schema.INNODB_SYS_INDEXES.TYPE=3 OR information_schema.INNODB_SYS_INDEXES.TYPE=2)
					
				GROUP BY information_schema.INNODB_SYS_TABLES.NAME, index_name
				HAVING index_is_nullable=0');	
$queries2=array('SELECT IF(COLUMNS,1,0) AS index_is_nullable
					');	
foreach ($queries as $query)
{
	//print_r(parseSqlQuery($query));
	testQuery($query);

}

