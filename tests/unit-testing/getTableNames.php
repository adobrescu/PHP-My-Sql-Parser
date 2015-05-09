<?php

include_once('test-query.inc.php');

$parser=new \alib\utils\SqlParser();

$query='SELECT fld, 132+b, concat(tbl.fld2+camp, "axxa") from `tbl123`, tbl222';
$parser->parse($query);

$fieldNames=$parser->getFieldNames();
ASSERT_TRUE(isset($fieldNames['fld']));
ASSERT_TRUE(isset($fieldNames['b']));
ASSERT_TRUE(isset($fieldNames['tbl.fld2']));
ASSERT_TRUE(isset($fieldNames['camp']));
ASSERT_EQUALS(4, count($fieldNames));

$tableNames=$parser->getTableNames();
ASSERT_TRUE(isset($tableNames['tbl123']));
ASSERT_TRUE(isset($tableNames['tbl222']));
ASSERT_EQUALS(2, count($tableNames));

$query='INSERT INTO `table`(`col`, `table`.col2) values (2, 4)';
$parser->parse($query);
$fieldNames=$parser->getFieldNames();
ASSERT_TRUE(isset($fieldNames['col']));
ASSERT_TRUE(isset($fieldNames['table.col2']));
ASSERT_EQUALS(2, count($fieldNames));

$tableNames=$parser->getTableNames();
ASSERT_TRUE(isset($tableNames['table']));
ASSERT_EQUALS(1, count($tableNames));

$query='INSERT INTO tbl
		SET coloana=col2+tbl.col3,
			coloana2=4
		';
$parser->parse($query);
$fieldNames=$parser->getFieldNames();

ASSERT_EQUALS(4, count($fieldNames));
ASSERT_TRUE(isset($fieldNames['coloana']));
ASSERT_TRUE(isset($fieldNames['coloana2']));
ASSERT_TRUE(isset($fieldNames['col2']));
ASSERT_TRUE(isset($fieldNames['tbl.col3']));

$tableNames=$parser->getTableNames();
ASSERT_EQUALS(1, count($tableNames));
ASSERT_TRUE(isset($tableNames['tbl']));

$query='SELECT col1, tbl.col2, tbl3.col4
	FROM tbl left join tbl3
		using(id)';
$parser->parse($query);
$fieldNames=$parser->getFieldNames();
print_r($fieldNames);

