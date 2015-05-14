<?php
	/*
	 * This sample shows how to modify a SELECT query by adding a WHERE clause
	 */
	
	 include_once(__DIR__.'/lib/SqlParser.class.php');
	 
	 $query='SELECT customers.*, users.email
			FROM customers LEFT JOIN users
				USING(id_user)
			ORDER BY customers.first_name ASC
			LIMIT 10';
	 
	 $parser=new \alib\utils\SqlParser();
	 
	 $parser->parse($query);
	 $parser->appendWhere('customers.first_name="John"'); 
	 
	 $newQuery=$parser->rebuildSource();
	 
	 
	echo '<pre>';
	echo 'Query: '.$query;
	echo '<hr>';
	echo 'Modified query: '.$newQuery;
	 
	 
