<?php

include_once('../PHP/lib/SqlParser.class.php');
include_once('test-query.inc.php');

$testFiles=array(
	
	'DELETE.php',
	'INSERT.php',
	'REPLACE.php',
	'SELECT.php',
	'SELECT2.php',
	'SELECT3.php',
	'SELECT4.php',
	'UPDATE.php',
	'JOINs.php',
	'JOINhints-use-index-for-join(etc).php',
	'INTO(export).php',
	
	'insertSource.php'
	);


foreach($testFiles as $testFile)
{
	include_once($testFile);
}

