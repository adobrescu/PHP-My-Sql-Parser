%{ 
#include <stdio.h>
#include <stdlib.h>
#include "php_alsqlp.h"
#include "sql_defs.h"

extern eval_rule(YYSTYPE*, int options, int token_type, int num_args, ...);

// flex requires that you supply this function
void yyerror(zval **arr_parser, const char *msg)
{
    zend_printf("ERROR(PARSER): [%s]\n", msg);
	zval_dtor(arr_parser);
	MAKE_STD_ZVAL(*arr_parser);
	ZVAL_LONG(*arr_parser, 0);
	  
}

extern char *yytext;
//extern zval* arrParser3;

%}

%parse-param	{ zval **arr_parser }



%token						ADD
%token						ALL
%token						ALTER
%token						ANALYZE

%token						AS
%token						ASC
%token						ASENSITIVE
%token						BEFORE
/*%token						BETWEEN*/
%token						BIGINT
%token						BINARY
%token						BLOB
%token						BOTH
%token						BY
%token						CALL
%token						CASCADE
%token						CASE
%token						CHANGE
%token						CHAR
%token						CHARACTER
%token						CHECK
%token						COLLATE
%token						COLUMN
%token						CONDITION
%token						CONNECTION
%token						CONSTRAINT
%token						CONTINUE
%token						CONVERT
%token						CREATE

%token						CURRENT_DATE
%token						CURRENT_TIME
%token						CURRENT_TIMESTAMP
%token						CURRENT_USER
%token						CURSOR
%token						DATABASE
%token						DATABASES
%token						DAY_HOUR
%token						DAY_MICROSECOND
%token						DAY_MINUTE
%token						DAY_SECOND
%token						DEC
%token						DECIMAL
%token						DECLARE
%token						DEFAULT
%token						DELAYED
%token						DELETE
%token						DESC
%token						DESCRIBE
%token						DETERMINISTIC
%token						DISTINCT
%token						DISTINCTROW

%token						DOUBLE
%token						DROP
%token						DUAL
%token						EACH
%token						END
%token						ELSE
%token						ELSEIF
%token						ENCLOSED
%token						ESCAPED
%token						EXISTS
%token						EXIT
%token						EXPLAIN
%token						FALSE
%token						FETCH
%token						FLOAT
%token						FLOAT4
%token						FLOAT8
%token						FOR
%token						FORCE
%token						FOREIGN
%token						FROM
%token						FULLTEXT
%token						GOTO
%token						GRANT
%token						GROUP
%token						HAVING
%token						HIGH_PRIORITY
%token						HOUR_MICROSECOND
%token						HOUR_MINUTE
%token						HOUR_SECOND
%token						IF
%token						IGNORE

%token						INDEX
%token						INFILE

%token						INOUT
%token						INSENSITIVE
%token						INSERT
%token						SQL_INT
%token						INT1
%token						INT2
%token						INT3
%token						INT4
%token						INT8
%token						INTEGER
%token						INTERVAL
%token						INTO
%token						IS
%token						ITERATE

%token						KEY
%token						KEYS
%token						KILL
%token						LABEL
%token						LEADING
%token						LEAVE
%token						LEFT

%token						LIMIT
%token						LINES
%token						LOAD
%token						LOCALTIME
%token						LOCALTIMESTAMP
%token						LOCK
%token						LONG
%token						LONGBLOB
%token						LONGTEXT
%token						LOOP
%token						LOW_PRIORITY
%token						MATCH
%token						MEDIUMBLOB
%token						MEDIUMINT
%token						MEDIUMTEXT
%token						MIDDLEINT
%token						MINUTE_MICROSECOND
%token						MINUTE_SECOND

%token						MODIFIES

%token						NOT
%token						NO_WRITE_TO_BINLOG
%token						SQL_NULL
%token						NUMERIC
%token						ON
%token						OPTIMIZE
%token						OPTION
%token						OPTIONALLY

%token						ORDER
%token						OUT

%token						OUTFILE
%token						PRECISION
%token						PRIMARY
%token						PROCEDURE
%token						PURGE
%token						READ
%token						READS
%token						REAL
%token						REFERENCES

%token						RELEASE
%token						RENAME
%token						REPEAT
%token						REPLACE
%token						REQUIRE
%token						RESTRICT
%token						RETURN
%token						REVOKE

%token						RLIKE
%token						SCHEMA
%token						SCHEMAS
%token						SECOND_MICROSECOND
%token						SELECT
%token						SENSITIVE
%token						SEPARATOR
%token						SET
%token						SHOW
%token						SMALLINT
%token						SONAME
%token						SPATIAL
%token						SPECIFIC
%token						SQL
%token						SQLEXCEPTION
%token						SQLSTATE
%token						SQLWARNING
%token						SQL_BIG_RESULT
%token						SQL_BUFFER_RESULT
%token						SQL_CACHE
%token						SQL_CALC_FOUND_ROWS
%token						SQL_NO_CACHE
%token						SQL_SMALL_RESULT
%token						SSL
%token						STARTING
%token						STRAIGHT_JOIN
%token						TABLE
%token						TERMINATED
%token						THEN
%token						TINYBLOB
%token						TINYINT
%token						TINYTEXT
%token						TO
%token						TRAILING
%token						TRIGGER
%token						TRUE
%token						UNDO
%token						UNION
%token						UNIQUE
%token						UNLOCK
%token						UNSIGNED
%token						UPDATE
%token						UPGRADE
%token						USAGE
%token						USE
%token						USING
%token						UTC_DATE
%token						UTC_TIME
%token						UTC_TIMESTAMP
%token						VALUES
%token						VARBINARY
%token						VARCHAR
%token						VARCHARACTER
%token						VARYING
%token						WHEN
%token						WHERE
%token						WHILE
%token						WITH
%token						WRITE

%token						YEAR_MONTH
%token						ZEROFILL

%token						OFFSET
%token						VALUE
%token						PARTITION
%token						ON_DUPLICATE_KEY_UPDATE
%token						QUICK
%token						FIELDS
%token						COLUMNS
%token						ORDER_BY
%token						GROUP_BY
%token						EXPORT_OPTION
%token						WITH_ROLLUP
%token						JOIN_TYPE
%token						OPT_INDEX_HINT
%token						UNION_TYPE
%token						STRING
%token						NUMBER
%token						SELECT_TYPE

%left						OPERATOR_2_EXPRESSIONS
%left						OPERATOR_SIGN
%left						OPERATOR_1_OPERANDS
%left						OP_AND
%left						OP_MUL
%left						OPERATOR_2_EXPRESSIONS_ALLOW_NOT
%left						OPERATOR_EXPRESSION_2_EXPRESSIONS_LIST
%left						OPERATOR_1_OPERAND_END


%token VAR_ID



%token						ID


%start statement




%%

statement:
	statement_union {eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_UNION, 1, &$1);  add_assoc_zval(*arr_parser, "parse_tree", $$.token_index);}
	| statement_select { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_SELECT, 1, &$1); add_assoc_zval(*arr_parser, "parse_tree", $$.token_index);}
	| statement_update { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_UPDATE, 1, &$1); add_assoc_zval(*arr_parser, "parse_tree", $$.token_index);}
	| statement_delete { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_DELETE, 1, &$1); add_assoc_zval(*arr_parser, "parse_tree", $$.token_index);}
	| statement_replace { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_REPLACE, 1, &$1); add_assoc_zval(*arr_parser, "parse_tree", $$.token_index);}
	| statement_insert { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_INSERT, 1, &$1); add_assoc_zval(*arr_parser, "parse_tree", $$.token_index);}
	| ')' expression { zend_printf("DAXXA"); eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 1, &$2); add_assoc_zval(*arr_parser, "parse_tree", $$.token_index);}
	;



statement_union:
	statement_union_select UNION_TYPE statement_union_select { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_UNION, 3, &$1, &$2, &$3); }
	| statement_union UNION_TYPE statement_union_select { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_UNION, 3, &$1, &$2, &$3); }
	;

//permite SELECT-uri intre paranteze multiple
statement_union_select: 
	statement_select { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_SELECT, 1, &$1); }
	| '(' statement_union_select ')' { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_UNION_SELECT, 3, &$1, &$2, &$3); }
	;
statement_select:
	SELECT	statement_select_options_enum	statement_select_expressions_list from where group_by having order_by limit procedure into_export_options select_type { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_SELECT, 12, &$1, &$2, &$3, &$4, &$5, &$6, &$7, &$8, &$9, &$10, &$11, &$12); }
	;
statement_select_options_enum:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_SELECT_OPTIONS,0); }
	| statement_select_options_enum		statement_select_option { eval_rule(&$$, 0, PHP_SQL_SELECT_OPTIONS, 2, &$1, &$2); }
	;
statement_select_option:
	ALL { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); } | DISTINCT { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); } | DISTINCTROW { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); } | HIGH_PRIORITY { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); } | STRAIGHT_JOIN { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); } | SQL_SMALL_RESULT { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); } | SQL_BIG_RESULT { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); } | SQL_BUFFER_RESULT { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); } | SQL_CACHE  { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); } | SQL_NO_CACHE { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); } | SQL_CALC_FOUND_ROWS { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	;

statement_select_expressions_list:
	statement_select_expression { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	| statement_select_expressions_list ',' statement_select_expression { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 3, &$1, &$2, &$3); }
	;

statement_select_expression:
	OP_MUL { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	| expression { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	| expression AS ID	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 3, &$1, &$2, &$3); }
	| expression ID	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2); }
	| expression AS STRING	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 3, &$1, &$2, &$3); }
	| expression STRING	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2); }
	| ID '.' OP_MUL { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 3, &$1, &$2, &$3); }
	| ID '.' ID '.' OP_MUL { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 5, &$1, &$2, &$3, &$4, &$5); }
	| ID '.' ID '.' ID '.' OP_MUL { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 7, &$1, &$2, &$3, &$4, &$5, &$6, &$7 ); }
	;
select_type:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| SELECT_TYPE { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
from:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| FROM table_references { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2); }
	;
statement_update:
	UPDATE statement_update_options_enum table_references SET expressions_list where order_by limit { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_UPDATE, 8, &$1, &$2, &$3, &$4, &$5, &$6, &$7, &$8); }
	;
statement_update_options_enum:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| statement_update_options_enum		statement_update_option { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2); }
	;
statement_update_option:
	LOW_PRIORITY { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); } | IGNORE { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	;

statement_delete:
	//single table
	DELETE statement_delete_options_enum  FROM table_name where order_by limit { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_DELETE, 7, &$1, &$2, &$3, &$4, &$5, &$6, &$7 ); }
	
	// multiple tables
	| DELETE statement_delete_options_enum delete_tables_list FROM table_references where { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_DELETE, 6, &$1, &$2, &$3, &$4, &$5, &$6 ); }
	
	//multiple tables USING 
	| DELETE statement_delete_options_enum FROM delete_tables_list USING table_references where { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_DELETE, 7, &$1, &$2, &$3, &$4, &$5, &$6, &$7 ); }
	;

statement_replace:
	//REPLACE ... VALUES (...)
	REPLACE statement_replace_options_enum into table_name '(' column_names_list ')' values parenthesised_expressions_list { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_REPLACE, 9, &$1, &$2, &$3, &$4, &$5, &$6, &$7, &$8, &$9 ); }
	| REPLACE statement_replace_options_enum into table_name values parenthesised_expressions_list { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_REPLACE, 6, &$1, &$2, &$3, &$4, &$5, &$6 ); }
	
	//REPLACE .... SET ...
	| REPLACE statement_replace_options_enum into table_name SET expressions_list { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_REPLACE, 6, &$1, &$2, &$3, &$4, &$5, &$6 ); }
	
	//REPLACE .... SELECT ...:
	| REPLACE statement_replace_options_enum into table_name '(' column_names_list ')' statement_select { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_REPLACE, 8, &$1, &$2, &$3, &$4, &$5, &$6, &$7, &$8 ); }
	| REPLACE statement_replace_options_enum into table_name '(' column_names_list ')' statement_union { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_REPLACE, 8, &$1, &$2, &$3, &$4, &$5, &$6, &$7, &$8 ); }
	| REPLACE statement_replace_options_enum into table_name  statement_select { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_REPLACE, 5, &$1, &$2, &$3, &$4, &$5 ); }
	| REPLACE statement_replace_options_enum into table_name  statement_union { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_REPLACE, 5, &$1, &$2, &$3, &$4, &$5 ); }
	;

statement_insert:
	//INSERT ... VALUES (...)
	INSERT statement_insert_options_enum into table_name partition '(' column_names_list ')' values parenthesised_expressions_list on_duplicate_key_update { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_INSERT, 11, &$1, &$2, &$3, &$4, &$5, &$6, &$7, &$8, &$9, &$10, &$11 ); }
	| INSERT statement_insert_options_enum into table_name partition values parenthesised_expressions_list on_duplicate_key_update { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_INSERT, 8, &$1, &$2, &$3, &$4, &$5, &$6, &$7, &$8 ); }

	//INSERT ... SELECT
	| INSERT statement_insert_options_enum into table_name partition '(' column_names_list ')' statement_select { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_INSERT, 9, &$1, &$2, &$3, &$4, &$5, &$6, &$7, &$8, &$9 ); }
	| INSERT statement_insert_options_enum into table_name partition '(' column_names_list ')' statement_union { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_INSERT, 9, &$1, &$2, &$3, &$4, &$5, &$6, &$7, &$8, &$9 ); }
	| INSERT statement_insert_options_enum into table_name partition statement_select { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_INSERT, 6, &$1, &$2, &$3, &$4, &$5, &$6 ); }
	| INSERT statement_insert_options_enum into table_name partition statement_union { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_INSERT, 6, &$1, &$2, &$3, &$4, &$5, &$6 ); }
	
	//INSERT ... SET ...
	| INSERT statement_insert_options_enum into table_name partition SET expressions_list on_duplicate_key_update { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_STATEMENT_INSERT, 8, &$1, &$2, &$3, &$4, &$5, &$6, &$7, &$8 ); }
	;

statement_insert_options_enum:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| statement_insert_options_enum		statement_insert_option { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2); }
	;
statement_insert_option:
	LOW_PRIORITY { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); } | DELAYED { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); } | HIGH_PRIORITY { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); } | IGNORE { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	;
partition:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| PARTITION '(' column_names_list ')' { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 4, &$1, &$2, &$3, &$4 ); }
	;
on_duplicate_key_update:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| ON_DUPLICATE_KEY_UPDATE expressions_list { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2 ); }
	;
values:
	VALUES { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	| VALUE { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	;

parenthesised_expressions_list:
	'(' ')' { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2 ); }
	| '(' expressions_list ')' { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 3, &$1, &$2, &$3 ); }
	;

column_names_list:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| column_reference { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	| column_names_list ',' column_reference { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 3, &$1, &$2, &$3 ); }
	;
into:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| INTO { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	;
statement_replace_options_enum:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| statement_replace_options_enum		statement_replace_option { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2); }
	;
statement_replace_option:
	LOW_PRIORITY { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); } | DELAYED { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); } | IGNORE { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	;

delete_tables_list:
	delete_table { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	| delete_tables_list ',' delete_table { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 3, &$1, &$2, &$3 ); }
	;
delete_table:
	table_name { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	| ID '.' OP_MUL { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 3, &$1, &$2, &$3 ); }
	| ID '.' ID '.' OP_MUL { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 5, &$1, &$2, &$3, &$4, &$5 ); }
	;

statement_delete_options_enum:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| statement_delete_options_enum		statement_delete_option { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2); }
	;
statement_delete_option:
	LOW_PRIORITY { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); } | QUICK { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); } | IGNORE { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	;

table_references:
	table_factor { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	| table_references ','  table_factor { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 3, &$1, &$2, &$3 ); }
	| table_references join_type table_factor join_condition { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 4, &$1, &$2, &$3, &$4); }
	;
join_type:
	JOIN_TYPE { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	| STRAIGHT_JOIN { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	;
table_factor:
	table_name index_hint						{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2 ); }
	| table_name ID	 index_hint					{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 3, &$1, &$2, &$3 ); }
	| table_name AS ID  index_hint			{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,4, &$1, &$2, &$3,&$4 ); }
	| subquery  { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	| subquery ID { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2 ); }
	| subquery AS ID { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 3, &$1, &$2, &$3 ); }
	| '(' table_references ')' { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 3, &$1, &$2, &$3 ); }
	
	
table_name:
	ID { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_TABLE_NAME, 1, &$1); }
	| ID '.' ID { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_TABLE_NAME, 3, &$1, &$2, &$3 ); }
	;

index_hint:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| OPT_INDEX_HINT '(' expressions_list ')' { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 4, &$1, &$2, &$3, &$4); }
	;

join_condition:
	USING '(' column_reference ')' { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 4, &$1, &$2, &$3, &$4); }
	| ON expression { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2); }
	;
where:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_WHERE,0); }
	| WHERE expression { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_WHERE, 2, &$1, &$2); }
	;
group_by:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_GROUP_BY,0); }
	| GROUP_BY sort_expressions_list with_rollup { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_GROUP_BY, 3, &$1, &$2, &$3); }
	;
having:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| HAVING expression { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2); }
	;
sort_expressions_list:
	sort_expression { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	| sort_expressions_list ',' sort_expression { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 3, &$1, &$2, &$3); }
	;
sort_expression:
	expression sort_direction {eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2); }
	;
with_rollup:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| WITH_ROLLUP { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	;
expressions_list:
	expression { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 1, &$1); }
	| expressions_list ',' expression { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 3, &$1, &$2, &$3); }
	;
subquery:
	'(' statement_select ')' { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 3, &$1, &$2, &$3); }
	;
column_reference:
	ID { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_COLUMN_NAME, 1, &$1); }
	| ID '.' ID { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_COLUMN_NAME, 3, &$1, &$2, &$3); }
	| ID '.' ID '.' ID { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_COLUMN_NAME, 5, &$1, &$2, &$3, &$4, &$5); }
	;
expression:
	NUMBER { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 1, &$1); }
	| STRING { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 1, &$1); }
	| VAR_ID { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 1, &$1); }
	| SQL_NULL { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 1, &$1); }
	
	| column_reference { $$=$1;/*eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 1, &$1);*/ }

	// NOT expr, ~ expr
	| OPERATOR_1_OPERANDS expression { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 2, &$1, &$2); }

	//+ expr, - expr
	| OPERATOR_SIGN expression { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 2, &$1, &$2); }
	
	// expr / expr , expr MOD expr, expr * expr , expr BETWEEN expr AND expr, ...
	| expression OPERATOR_2_EXPRESSIONS expression { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 3, &$1, &$2, &$3); }
	
	// expr + expr , expr - expr
	| expression OPERATOR_SIGN expression { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 3, &$1, &$2, &$3); }
	
	//expr REGEXP expr , expr LIKE expr
	| expression OPERATOR_2_EXPRESSIONS_ALLOW_NOT expression { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 3, &$1, &$2, &$3); }

	//expr NOT REGEXP expr , expr NOT LIKE expr ( permite si: expr ~ expr , expr ~ expr)
	| expression OPERATOR_1_OPERANDS OPERATOR_2_EXPRESSIONS_ALLOW_NOT expression { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 4, &$1, &$2, &$3, &$4); }
	
	// expr *  expr
	| expression OP_MUL expression {eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 3, &$1, &$2, &$3); }

	// expr IS NULL , expr IS NOT NULL
	| expression OPERATOR_1_OPERAND_END { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 2, &$1, &$2); }
	
	// expression IN ( expression, expression, ...) - expression poate fi un subselect (SELECT ...)
	| expression OPERATOR_EXPRESSION_2_EXPRESSIONS_LIST '(' expressions_list ')' { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 5, &$1, &$2, &$3, &$4, &$5); }
	
	//expression IN (SELECT ...)
	| expression OPERATOR_EXPRESSION_2_EXPRESSIONS_LIST '(' statement_select ')' { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 5, &$1, &$2, &$3, &$4, &$5); }

	// expression NOT IN ( expression, expression, ...) - expression poate fi un subselect (SELECT ...)
	| expression OPERATOR_1_OPERANDS OPERATOR_EXPRESSION_2_EXPRESSIONS_LIST '(' expressions_list ')' { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 6, &$1, &$2, &$3, &$4, &$5, &$6); }

	//expression NOT IN (SELECT ...)
	| expression OPERATOR_1_OPERANDS OPERATOR_EXPRESSION_2_EXPRESSIONS_LIST '(' statement_select ')' { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 6, &$1, &$2, &$3, &$4, &$5, &$6); }

	| '(' expression ')' { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 3, &$1, &$2, &$3); }
	| subquery { $$=$1; /*eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 1, &$1);*/ }
	
	//FUNCTION()
	//no arguments
	| ID '(' ')' { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 3, &$1, &$2, &$3); }

	//COUNT(*)
	| ID '(' OP_MUL ')' { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 4, &$1, &$2, &$3, &$4); }

	//GROUP_CONCAT(expr, expr, ... ORDER BY ... SEPARATOR ...)
	//FUNCTION(expr, expr,...)
	| ID '(' expressions_list order_by separator ')' { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 6, &$1, &$2, &$3, &$4, &$5, &$6); }

	//GROUP_CONCAT(DISTINCT expr, expr, ... ORDER BY ... SEPARATOR ...)
	| ID '(' DISTINCT expressions_list order_by separator ')' { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 7, &$1, &$2, &$3, &$4, &$5, &$6, &$7); }

	//DATEADD(expr INTERVAL expr DAY|MINUTE|ETC)
	| ID '(' expressions_list ',' function_special_syntax_keyword expression ID ')' { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 8, &$1, &$2, &$3, &$4, &$5, &$6, &$7, &$8); }


	| CASE expression when_expr_then_expr_list else END { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 5, &$1, &$2, &$3, &$4, &$5); }
	//mysql sporta si CASE WHEN 1 THEN 5 WHEN 10 THEN ... END (nu are expresia de dupa CASE0
	| CASE when_expr_then_expr_list else END { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_EXPR, 4, &$1, &$2, &$3, &$4); }
	;

when_expr_then_expr_list:
	when_expr_then_expr { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	| when_expr_then_expr_list when_expr_then_expr { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2); }
	;

when_expr_then_expr:
	WHEN expression THEN expression { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 4, &$1, &$2, &$3, &$4); }
	;

else:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| ELSE expression { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2); }
	;

function_special_syntax_keyword:
	INTERVAL {eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1);}
	;
order_by:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_ORDER_BY,0); }
	| ORDER_BY sort_expressions_list { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_ORDER_BY, 2, &$1, &$2); }
	;
limit:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_LIMIT,0); }
	| LIMIT NUMBER ',' NUMBER { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_LIMIT, 4, &$1, &$2, &$3, &$4); }
	| LIMIT NUMBER OFFSET NUMBER { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_LIMIT, 4, &$1, &$2, &$3, &$4); }
	| LIMIT NUMBER { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, PHP_SQL_LIMIT, 2, &$1, &$2); }
	;
procedure:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| PROCEDURE ID '(' expressions_list ')' { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 5, &$1, &$2, &$3, &$4, &$5); }
	;
into_export_options:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| INTO expressions_list	export_options 	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 3, &$1, &$2, &$3); }
	;

export_options:
	export_options_fields export_options_lines { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2 ); }
	;
export_options_fields:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| FIELDS export_options_list { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2 ); }
	| COLUMNS export_options_list { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2 ); };
	;
export_options_lines:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| LINES export_options_list { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2 ); };
	;
export_options_list:
	export_option { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	| export_options_list export_option  { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2 ); }
	;
export_option:
	EXPORT_OPTION STRING { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2 ); }
	;
separator:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| SEPARATOR STRING { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 2, &$1, &$2); }
	;
sort_direction:
	{ eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN,0); }
	| ASC { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	| DESC { eval_rule(&$$, EVAL_ADD_EMPTY_TOKENS, IS_TOKEN, 1, &$1); }
	;

%%