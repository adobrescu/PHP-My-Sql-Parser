<?php
	/*
	 * This sample shows how to get field names from the SELECT in a SELECT and from sub-queries
	 */
	
	 include_once(__DIR__.'/lib/SqlParser.class.php');
	 
	 
	$query='INSERT INTO tbl (field1, field2) VALUES (\'a\', \'b\')';
	 	 
	$parser=new \alib\utils\SqlParser();
	echo '<pre>';
	
	$parser->parse($query);
	$parser->addInsertColumns(
			array('field3', 'field4'),
			array('value3', '"value4"')
			);
	echo $parser->rebuildSource().'<br>';
	
	//////////////////////////////////////////////////
	$query='INSERT INTO tbl VALUES (\'a\', \'b\')';
	
	$parser->parse($query);
	$parser->addInsertColumns(
			array('field3', 'field4'),
			array('value3', '"value4"')
			);
	echo $parser->rebuildSource().'<br>';
	
	//////////////////////////////////////////////////
	$query='INSERT INTO tbl (field1, field2) (SELECT 1, 2 FROM tbl)';
	
	$parser->parse($query);
	$parser->addInsertColumns(
			array('field3', 'field4'),
			array('value3', '"value4"')
			);
	echo $parser->rebuildSource().'<br>';
	
	//////////////////////////////////////////////////
	$query='INSERT INTO tbl (SELECT 1, 2 FROM tbl)';
	
	$parser->parse($query);
	$parser->addInsertColumns(
			array('field3', 'field4'),
			array('value3', '"value4"')
			);
	echo $parser->rebuildSource().'<br>';
	
	//////////////////////////////////////////////////
	$query='INSERT INTO tbl 
		SET field1="string",
			field2=3.14';
	
	$parser->parse($query);
	$parser->addInsertColumns(
			array('field3', 'field4'),
			array('value3', '"value4"')
			);
	echo $parser->rebuildSource().'<br>';
	