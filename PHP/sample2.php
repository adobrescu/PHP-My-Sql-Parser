<?php
	/*
	 * 
	 */
	 echo '<pre>';
	 include_once(__DIR__.'/lib/SqlParser.class.php');
	 define('CACHE_DIR', __DIR__.'/../tests/cache');
	 $query='SELECT @param:=price  
			FROM (
					SELECT price + vat 
					FROM products LEFT JOIN tblaxxa
						USING(id)
					WHERE vat >0
				) tbl 
			WHERE tbl.price BETWEEN 0.99 AND 
				(
				SELECT AVG(tax)
				FROM another_table
				WHERE tax>3.14
				)';
	 	 
	 $parser=new \alib\utils\SqlParser();
	 //$query='SELECT DISTINCT HIGH_PRIORITY * FROM tbl WHERE a=b';
	 $query='UPDATE IGNORE tbl
		 SET a=1
		 WHERE b=(select c from d)';
	 $query='INSERT IGNORE INTO tbl (a ,b)
		 VALUES (1,2)';
	 $query='REPLACE IGNORE INTO tbl SET a=b';
	 $query='SELECT * FROM tbl WHERE a=b
		 ';
	 $parser->parse($query);
	 $parser->appendWhere('c=1', 'AND ');
	 echo $parser->rebuildSource().'<hr>';
	 print_r($parser->getTokens());
	 print_r($parser->getParseTree());
	 //$parser->appendWhere('c=1', 'AND ');
	 
	 
	 
	 die();
	// $parser->appendWhere('a=b');
	 // print_r($parser->getTokens());
	// print_r($parser->getParseTree());
	
	 echo $query;
	 //$subqueries=&$parser->getNodesByType(\alib\utils\SqlParser::PHP_SQL_STATEMENT_SELECT);
	 //$subqueries[1]['10020-0']['10027-0']['10027-1']['0']=0;
	// print_r($subqueries[1]['10020-0']);
	// $parser->appendWhere('customers.first_name="John"', 'AND', $subqueries[1]);
	 echo '<hr>';
	 echo $parser->rebuildSource().'<br>';
//	 print_r($subqueries[1]['10020-0']);
//	 print_r($parser->rebuildSource());
	 /*
	  statement_union {eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_UNION, 1, &$1);  add_assoc_zval(*arr_parser, "parse_tree", $$.token_index);}
	| statement_select { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_SELECT, 1, &$1); add_assoc_zval(*arr_parser, "parse_tree", $$.token_index);}
	| statement_update { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_UPDATE, 1, &$1); add_assoc_zval(*arr_parser, "parse_tree", $$.token_index);}
	| statement_delete { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_DELETE, 1, &$1); add_assoc_zval(*arr_parser, "parse_tree", $$.token_index);}
	| statement_replace { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_REPLACE, 1, &$1); add_assoc_zval(*arr_parser, "parse_tree", $$.token_index);}
	| statement_insert { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_INSERT, 1, &$1); add_assoc_zval(*arr_parser, "parse_tree", $$.token_index);}
	
	;




//permite SELECT-uri intre paranteze multiple
statement_union_select: 
statement_select:
statement_select_options_enum:
statement_select_option:
statement_select_expressions_list:
	

statement_select_expression {}
| select_type {}
| from {}
statement_update:
statement_update_options_enum:
statement_update_option:
statement_insert_options_enum:
statement_insert_option:
partition:
on_duplicate_key_update:
values:
parenthesised_expressions_list:
column_names_list:
into:
statement_replace_options_enum:
statement_replace_option:
delete_tables_list:
delete_table:
statement_delete_options_enum:
statement_delete_option:
table_references:
join_type:
table_factor:
table_name:
index_hint:
join_condition:
| where {}
group_by:
having:
sort_expressions_list:
sort_expression:
with_rollup:
expressions_list:
subquery:
column_reference:
expression:
when_expr_then_expr_list:
when_expr_then_expr:
else:
function_special_syntax_keyword:
order_by:
limit:
procedure:
into_export_options:
export_options:
export_options_fields:
export_options_lines:
export_options_list:
export_option:
separator:
sort_direction:

	  * 	  */