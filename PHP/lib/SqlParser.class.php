<?php

namespace alib\utils;



const TOKEN_TYPE_STRING='D';
const TOKEN_TYPE_PARAMETER='E';
const TOKEN_TYPE_BACKQUOTED_ID='F';
const TOKEN_JOIN_TYPE='G';
const TOKEN_JOIN_INDEX_HINT='H';
const TOKEN_TYPE_KEYWORD='I';
const TOKEN_TYPE_EXPORT_OPTIONS='J';
const TOKEN_TYPE_UNION='K';
const TOKEN_TYPE_SELECT_TYPE='L';
const TOKEN_TYPE_HEX_NUMBER='M';
const TOKEN_TYPE_ID='N';
const TOKEN_TYPE_NUMBER='O';
const TOKEN_TYPE_OPERATOR='P';


class SqlParser
{
	public static $___useCached=true;
	protected $tokens, $parseTree;
	
	protected static $___keywords=array('ACCESSIBLE', 'ADD', 'ALL', 'ALTER', 'ANALYZE', 'AND', 'AS', 'ASC', 'ASENSITIVE', 'BEFORE', 'BETWEEN', 'BIGINT', 'BINARY', 'BLOB', 'BOTH', 'BY', 'CALL', 'CASCADE', 'CASE', 'CHANGE', 'CHAR', 'CHARACTER', 'CHECK', 'COLLATE', 'COLUMN', 'CONDITION', 'CONSTRAINT', 'CONTINUE', 'CONVERT', 'CREATE', 'CROSS', 'CURRENT_DATE', 'CURRENT_TIME', 'CURRENT_TIMESTAMP', 'CURRENT_USER', 'CURSOR', 'DATABASE', 'DATABASES', 'DAY_HOUR', 'DAY_MICROSECOND', 'DAY_MINUTE', 'DAY_SECOND', 'DEC', 'DECIMAL', 'DECLARE', 'DEFAULT', 'DELAYED', 'DELETE', 'DESC', 'DESCRIBE', 'DETERMINISTIC', 'DISTINCT', 'DISTINCTROW', 'DIV', 'DOUBLE', 'DROP', 'DUAL', 'EACH', 'ELSE', 'ELSEIF', 'ENCLOSED', 'ESCAPED', 'EXISTS', 'EXIT', 'EXPLAIN', 'FALSE', 'FETCH', 'FLOAT', 'FLOAT4', 'FLOAT8', 'FOR', 'FORCE', 'FOREIGN', 'FROM', 'FULLTEXT', 'GET', 'GRANT', 'GROUP', 'HAVING', 'HIGH_PRIORITY', 'HOUR_MICROSECOND', 'HOUR_MINUTE', 'HOUR_SECOND', 'IF', 'IGNORE', 'IN', 'INDEX', 'INFILE', 'INNER', 'INOUT', 'INSENSITIVE', 'INSERT', 'INT', 'INT1', 'INT2', 'INT3', 'INT4', 'INT8', 'INTEGER', 'INTERVAL', 'INTO', 'IO_AFTER_GTIDS', 'IO_BEFORE_GTIDS', 'IS', 'ITERATE', 'JOIN', 'KEY', 'KEYS', 'KILL', 'LEADING', 'LEAVE', 'LEFT', 'LIKE', 'LIMIT', 'LINEAR', 'LINES', 'LOAD', 'LOCALTIME', 'LOCALTIMESTAMP', 'LOCK', 'LONG', 'LONGBLOB', 'LONGTEXT', 'LOOP', 'LOW_PRIORITY', 'MASTER_BIND', 'MASTER_SSL_VERIFY_SERVER_CERT', 'MATCH', 'MAXVALUE', 'MEDIUMBLOB', 'MEDIUMINT', 'MEDIUMTEXT', 'MIDDLEINT	MINUTE_MICROSECOND', 'MINUTE_SECOND', 'MOD', 'MODIFIES', 'NATURAL', 'NOT', 'NO_WRITE_TO_BINLOG', 'NULL', 'NUMERIC', 'ON', 'OPTIMIZE', 'OPTION', 'OPTIONALLY', 'OR', 'ORDER', 'OUT', 'OUTER', 'OUTFILE', 'PARTITION', 'PRECISION', 'PRIMARY', 'PROCEDURE', 'PURGE', 'RANGE', 'READ', 'READS', 'READ_WRITE', 'REAL', 'REFERENCES', 'REGEXP', 'RELEASE', 'RENAME', 'REPEAT', 'REPLACE', 'REQUIRE', 'RESIGNAL', 'RESTRICT', 'RETURN', 'REVOKE', 'RIGHT', 'RLIKE', 'SCHEMA', 'SCHEMAS', 'SECOND_MICROSECOND', 'SELECT', 'SENSITIVE', 'SEPARATOR', 'SET', 'SHOW', 'SIGNAL', 'SMALLINT', 'SPATIAL', 'SPECIFIC', 'SQL', 'SQLEXCEPTION', 'SQLSTATE', 'SQLWARNING', 'SQL_BIG_RESULT', 'SQL_CALC_FOUND_ROWS', 'SQL_SMALL_RESULT', 'SSL', 'STARTING', 'STRAIGHT_JOIN', 'TABLE', 'TERMINATED', 'THEN', 'TINYBLOB', 'TINYINT', 'TINYTEXT', 'TO', 'TRAILING', 'TRIGGER', 'TRUE', 'UNDO', 'UNION', 'UNIQUE', 'UNLOCK', 'UNSIGNED', 'UPDATE', 'USAGE', 'USE', 'USING', 'UTC_DATE', 'UTC_TIME', 'UTC_TIMESTAMP', 'VALUES', 'VARBINARY', 'VARCHAR', 'VARCHARACTER', 'VARYING', 'WHEN', 'WHERE', 'WHILE', 'WITH', 'WRITE', 'XOR', 'YEAR_MONTH', 'ZEROFILL'		);
	 
	protected static $___tokenCodes=array
							(
								/*kewwords*/
								//'ACCESSIBLE' => 50, 'ADD' => 51, 'ALL' => 52, 'ALTER' => 53, 'ANALYZE' => 54, 'AND' => 55, 'AS' => 56, 'ASC' => 57, 'ASENSITIVE' => 58, 'BEFORE' => 59, 'BETWEEN' => 60, 'BIGINT' => 61, 'BINARY' => 62, 'BLOB' => 63, 'BOTH' => 64, 'BY' => 65, 'CALL' => 66, 'CASCADE' => 67, 'CASE' => 68, 'CHANGE' => 69, 'CHAR' => 70, 'CHARACTER' => 71, 'CHECK' => 72, 'COLLATE' => 73, 'COLUMN' => 74, 'CONDITION' => 75, 'CONSTRAINT' => 76, 'CONTINUE' => 77, 'CONVERT' => 78, 'CREATE' => 79, 'CROSS' => 80, 'CURRENT_DATE' => 81, 'CURRENT_TIME' => 82, 'CURRENT_TIMESTAMP' => 83, 'CURRENT_USER' => 84, 'CURSOR' => 85, 'DATABASE' => 86, 'DATABASES' => 87, 'DAY_HOUR' => 88, 'DAY_MICROSECOND' => 89, 'DAY_MINUTE' => 90, 'DAY_SECOND' => 91, 'DEC' => 92, 'DECIMAL' => 93, 'DECLARE' => 94, 'DEFAULT' => 95, 'DELAYED' => 96, 'DELETE' => 97, 'DESC' => 98, 'DESCRIBE' => 99, 'DETERMINISTIC' => 100, 'DISTINCT' => 101, 'DISTINCTROW' => 102, 'DIV' => 103, 'DOUBLE' => 104, 'DROP' => 105, 'DUAL' => 106, 'EACH' => 107, 'ELSE' => 108, 'ELSEIF' => 109, 'ENCLOSED' => 110, 'ESCAPED' => 111, 'EXISTS' => 112, 'EXIT' => 113, 'EXPLAIN' => 114, 'FALSE' => 115, 'FETCH' => 116, 'FLOAT' => 117, 'FLOAT4' => 118, 'FLOAT8' => 119, 'FOR' => 120, 'FORCE' => 121, 'FOREIGN' => 122, 'FROM' => 123, 'FULLTEXT' => 124, 'GET' => 125, 'GRANT' => 126, 'GROUP' => 127, 'HAVING' => 128, 'HIGH_PRIORITY' => 129, 'HOUR_MICROSECOND' => 130, 'HOUR_MINUTE' => 131, 'HOUR_SECOND' => 132, 'IF' => 133, 'IGNORE' => 134, 'IN' => 135, 'INDEX' => 136, 'INFILE' => 137, 'INNER' => 138, 'INOUT' => 139, 'INSENSITIVE' => 140, 'INSERT' => 141, 'INT' => 142, 'INT1' => 143, 'INT2' => 144, 'INT3' => 145, 'INT4' => 146, 'INT8' => 147, 'INTEGER' => 148, 'INTERVAL' => 149, 'INTO' => 150, 'IO_AFTER_GTIDS' => 151, 'IO_BEFORE_GTIDS' => 152, 'IS' => 153, 'ITERATE' => 154, 'JOIN' => 155, 'KEY' => 156, 'KEYS' => 157, 'KILL' => 158, 'LEADING' => 159, 'LEAVE' => 160, 'LEFT' => 161, 'LIKE' => 162, 'LIMIT' => 163, 'LINEAR' => 164, 'LINES' => 165, 'LOAD' => 166, 'LOCALTIME' => 167, 'LOCALTIMESTAMP' => 168, 'LOCK' => 169, 'LONG' => 170, 'LONGBLOB' => 171, 'LONGTEXT' => 172, 'LOOP' => 173, 'LOW_PRIORITY' => 174, 'MASTER_BIND' => 175, 'MASTER_SSL_VERIFY_SERVER_CERT' => 176, 'MATCH' => 177, 'MAXVALUE' => 178, 'MEDIUMBLOB' => 179, 'MEDIUMINT' => 180, 'MEDIUMTEXT' => 181, 'MIDDLEINT	MINUTE_MICROSECOND' => 182, 'MINUTE_SECOND' => 183, 'MOD' => 184, 'MODIFIES' => 185, 'NATURAL' => 186, 'NOT' => 187, 'NO_WRITE_TO_BINLOG' => 188, 'NULL' => 189, 'NUMERIC' => 190, 'ON' => 191, 'OPTIMIZE' => 192, 'OPTION' => 193, 'OPTIONALLY' => 194, 'OR' => 195, 'ORDER' => 196, 'OUT' => 197, 'OUTER' => 198, 'OUTFILE' => 199, 'PARTITION' => 200, 'PRECISION' => 201, 'PRIMARY' => 202, 'PROCEDURE' => 203, 'PURGE' => 204, 'RANGE' => 205, 'READ' => 206, 'READS' => 207, 'READ_WRITE' => 208, 'REAL' => 209, 'REFERENCES' => 210, 'REGEXP' => 211, 'RELEASE' => 212, 'RENAME' => 213, 'REPEAT' => 214, 'REPLACE' => 215, 'REQUIRE' => 216, 'RESIGNAL' => 217, 'RESTRICT' => 218, 'RETURN' => 219, 'REVOKE' => 220, 'RIGHT' => 221, 'RLIKE' => 222, 'SCHEMA' => 223, 'SCHEMAS' => 224, 'SECOND_MICROSECOND' => 225, 'SELECT' => 226, 'SENSITIVE' => 227, 'SEPARATOR' => 228, 'SET' => 229, 'SHOW' => 230, 'SIGNAL' => 231, 'SMALLINT' => 232, 'SPATIAL' => 233, 'SPECIFIC' => 234, 'SQL' => 235, 'SQLEXCEPTION' => 236, 'SQLSTATE' => 237, 'SQLWARNING' => 238, 'SQL_BIG_RESULT' => 239, 'SQL_CALC_FOUND_ROWS' => 240, 'SQL_SMALL_RESULT' => 241, 'SSL' => 242, 'STARTING' => 243, 'STRAIGHT_JOIN' => 244, 'TABLE' => 245, 'TERMINATED' => 246, 'THEN' => 247, 'TINYBLOB' => 248, 'TINYINT' => 249, 'TINYTEXT' => 250, 'TO' => 251, 'TRAILING' => 252, 'TRIGGER' => 253, 'TRUE' => 254, 'UNDO' => 255, 'UNION' => 256, 'UNIQUE' => 257, 'UNLOCK' => 258, 'UNSIGNED' => 259, 'UPDATE' => 260, 'USAGE' => 261, 'USE' => 262, 'USING' => 263, 'UTC_DATE' => 264, 'UTC_TIME' => 265, 'UTC_TIMESTAMP' => 266, 'VALUES' => 267, 'VARBINARY' => 268, 'VARCHAR' => 269, 'VARCHARACTER' => 270, 'VARYING' => 271, 'WHEN' => 272, 'WHERE' => 273, 'WHILE' => 274, 'WITH' => 275, 'WRITE' => 276, 'XOR' => 277, 'YEAR_MONTH' => 278, 'ZEROFILL' => 279,
								'ACCESSIBLE' => 100, 'ADD' => 101, 'ALL' => 102, 'ALTER' => 103, 'ANALYZE' => 104, 'AND' => 105, 'AS' => 106, 'ASC' => 107, 'ASENSITIVE' => 108, 'BEFORE' => 109, 'BETWEEN' => 110, 'BIGINT' => 111, 'BINARY' => 112, 'BLOB' => 113, 'BOTH' => 114, 'BY' => 115, 'CALL' => 116, 'CASCADE' => 117, 'CASE' => 118, 'CHANGE' => 119, 'CHAR' => 120, 'CHARACTER' => 121, 'CHECK' => 122, 'COLLATE' => 123, 'COLUMN' => 124, 'CONDITION' => 125, 'CONSTRAINT' => 126, 'CONTINUE' => 127, 'CONVERT' => 128, 'CREATE' => 129, 'CROSS' => 130, 'CURRENT_DATE' => 131, 'CURRENT_TIME' => 132, 'CURRENT_TIMESTAMP' => 133, 'CURRENT_USER' => 134, 'CURSOR' => 135, 'DATABASE' => 136, 'DATABASES' => 137, 'DAY_HOUR' => 138, 'DAY_MICROSECOND' => 139, 'DAY_MINUTE' => 140, 'DAY_SECOND' => 141, 'DEC' => 142, 'DECIMAL' => 143, 'DECLARE' => 144, 'DEFAULT' => 145, 'DELAYED' => 146, 'DELETE' => 147, 'DESC' => 148, 'DESCRIBE' => 149, 'DETERMINISTIC' => 150, 'DISTINCT' => 151, 'DISTINCTROW' => 152, 'DIV' => 153, 'DOUBLE' => 154, 'DROP' => 155, 'DUAL' => 156, 'EACH' => 157, 'ELSE' => 158, 'ELSEIF' => 159, 'ENCLOSED' => 160, 'ESCAPED' => 161, 'EXISTS' => 162, 'EXIT' => 163, 'EXPLAIN' => 164, 'FALSE' => 165, 'FETCH' => 166, 'FLOAT' => 167, 'FLOAT4' => 168, 'FLOAT8' => 169, 'FOR' => 170, 'FORCE' => 171, 'FOREIGN' => 172, 'FROM' => 173, 'FULLTEXT' => 174, 'GET' => 175, 'GRANT' => 176, 'GROUP' => 177, 'HAVING' => 178, 'HIGH_PRIORITY' => 179, 'HOUR_MICROSECOND' => 180, 'HOUR_MINUTE' => 181, 'HOUR_SECOND' => 182, 'IF' => 183, 'IGNORE' => 184, 'IN' => 185, 'INDEX' => 186, 'INFILE' => 187, 'INNER' => 188, 'INOUT' => 189, 'INSENSITIVE' => 190, 'INSERT' => 191, 'INT' => 192, 'INT1' => 193, 'INT2' => 194, 'INT3' => 195, 'INT4' => 196, 'INT8' => 197, 'INTEGER' => 198, 'INTERVAL' => 199, 'INTO' => 200, 'IO_AFTER_GTIDS' => 201, 'IO_BEFORE_GTIDS' => 202, 'IS' => 203, 'ITERATE' => 204, 'JOIN' => 205, 'KEY' => 206, 'KEYS' => 207, 'KILL' => 208, 'LEADING' => 209, 'LEAVE' => 210, 'LEFT' => 211, 'LIKE' => 212, 'LIMIT' => 213, 'LINEAR' => 214, 'LINES' => 215, 'LOAD' => 216, 'LOCALTIME' => 217, 'LOCALTIMESTAMP' => 218, 'LOCK' => 219, 'LONG' => 220, 'LONGBLOB' => 221, 'LONGTEXT' => 222, 'LOOP' => 223, 'LOW_PRIORITY' => 224, 'MASTER_BIND' => 225, 'MASTER_SSL_VERIFY_SERVER_CERT' => 226, 'MATCH' => 227, 'MAXVALUE' => 228, 'MEDIUMBLOB' => 229, 'MEDIUMINT' => 230, 'MEDIUMTEXT' => 231, 'MIDDLEINT	MINUTE_MICROSECOND' => 232, 'MINUTE_SECOND' => 233, 'MOD' => 234, 'MODIFIES' => 235, 'NATURAL' => 236, 'NOT' => 237, 'NO_WRITE_TO_BINLOG' => 238, 'NULL' => 239, 'NUMERIC' => 240, 'ON' => 241, 'OPTIMIZE' => 242, 'OPTION' => 243, 'OPTIONALLY' => 244, 'OR' => 245, 'ORDER' => 246, 'OUT' => 247, 'OUTER' => 248, 'OUTFILE' => 249, 'PARTITION' => 250, 'PRECISION' => 251, 'PRIMARY' => 252, 'PROCEDURE' => 253, 'PURGE' => 254, 'RANGE' => 255, 'READ' => 256, 'READS' => 257, 'READ_WRITE' => 258, 'REAL' => 259, 'REFERENCES' => 260, 'REGEXP' => 261, 'RELEASE' => 262, 'RENAME' => 263, 'REPEAT' => 264, 'REPLACE' => 265, 'REQUIRE' => 266, 'RESIGNAL' => 267, 'RESTRICT' => 268, 'RETURN' => 269, 'REVOKE' => 270, 'RIGHT' => 271, 'RLIKE' => 272, 'SCHEMA' => 273, 'SCHEMAS' => 274, 'SECOND_MICROSECOND' => 275, 'SELECT' => 276, 'SENSITIVE' => 277, 'SEPARATOR' => 278, 'SET' => 279, 'SHOW' => 280, 'SIGNAL' => 281, 'SMALLINT' => 282, 'SPATIAL' => 283, 'SPECIFIC' => 284, 'SQL' => 285, 'SQLEXCEPTION' => 286, 'SQLSTATE' => 287, 'SQLWARNING' => 288, 'SQL_BIG_RESULT' => 289, 'SQL_CALC_FOUND_ROWS' => 290, 'SQL_SMALL_RESULT' => 291, 'SSL' => 292, 'STARTING' => 293, 'STRAIGHT_JOIN' => 294, 'TABLE' => 295, 'TERMINATED' => 296, 'THEN' => 297, 'TINYBLOB' => 298, 'TINYINT' => 299, 'TINYTEXT' => 300, 'TO' => 301, 'TRAILING' => 302, 'TRIGGER' => 303, 'TRUE' => 304, 'UNDO' => 305, 'UNION' => 306, 'UNIQUE' => 307, 'UNLOCK' => 308, 'UNSIGNED' => 309, 'UPDATE' => 310, 'USAGE' => 311, 'USE' => 312, 'USING' => 313, 'UTC_DATE' => 314, 'UTC_TIME' => 315, 'UTC_TIMESTAMP' => 316, 'VALUES' => 317, 'VARBINARY' => 318, 'VARCHAR' => 319, 'VARCHARACTER' => 320, 'VARYING' => 321, 'WHEN' => 322, 'WHERE' => 323, 'WHILE' => 324, 'WITH' => 325, 'WRITE' => 326, 'XOR' => 327, 'YEAR_MONTH' => 328, 'ZEROFILL' => 329, 

								/*operators*/
								':=' => 'a', '||' => 'b', '&&' => 'c', '!=' => 'd', '/' => 'e', '%' => 'f', '=' => 'g', '<=>' => 'h', '>=' => 'i', '<<' => 'j', '>>' => 'k', '<>' => 'l', '<=' => 'm', '<' => 'n', '>' => 'o', '|' => 'p', '&' => 'q', '^' => 'r', '+' => 's', '-' => 't', '~' => 'u', '*' => 'v', '(' => 'x', ')' => 'z', ',' => 'A', '.' => 'B',
							);
	/*sql expression/(part of) statements codes as they are set by the parser (see sql.y and php_alsqlp.h; their values MUST match defines from php_alsqlp.h)*/
	const PHP_SQL_STATEMENT_SELECT=10002;
	const PHP_SQL_STATEMENT_INSERT=10003;
	const PHP_SQL_STATEMENT_UPDATE=10004;
	const PHP_SQL_STATEMENT_DELETE=10005;
	const PHP_SQL_STATEMENT_REPLACE=10006;
	const PHP_SQL_STATEMENT_UNION_SELECT=10007;
	const PHP_SQL_STATEMENT_UNION=10008;

	const PHP_SQL_WHERE=10020;
	const PHP_SQL_ORDER_BY=10021;
	const PHP_SQL_LIMIT=10022;
	const PHP_SQL_COLUMN_NAME=10023;
	const PHP_SQL_TABLE_NAME=10024;
	const PHP_SQL_SELECT_OPTIONS=10025;
	const PHP_SQL_GROUP_BY=10026;
	const PHP_SQL_EXPR=10027;
	
	
	const PHP_SQL_FROM=10028;
	const PHP_SQL_HAVING=10029;
	const PHP_SQL_SELECT_EXPR=10030;
	const PHP_SQL_SELECT_EXPR_LIST=10031;
	const PHP_SQL_EXPR_LIST=10032;
	const PHP_SQL_TABLE_REFERENCES=10033;
	const PHP_SQL_TABLE_FACTOR=10034;
	const PHP_SQL_INDEX_HINT=10035;
	const PHP_SQL_SELECT_TYPE=10036;
	const PHP_SQL_SELECT_INTO_EXPORT_OPTIONS=10037;
	const PHP_SQL_PROCEDURE=10038;
	const PHP_SQL_SELECT_OPTION=10039;
	const PHP_SQL_JOIN_TYPE=10040;
	const PHP_SQL_JOIN_CONDITION=10041;
	const PHP_SQL_FUNCTION3=10042;
	const PHP_SQL_SEPARATOR=10043;
	const PHP_SQL_SUBSELECT=10044;
	const PHP_SQL_UPDATE_OPTIONS_LIST=10045;
	const PHP_SQL_UPDATE_OPTION=10046;
	const PHP_SQL_INSERT_OPTIONS_LIST=10047;
	const PHP_SQL_INSERT_OPTION=10048;
	const PHP_SQL_INTO=10049;
	const PHP_SQL_PARTITION=10050;
	const PHP_SQL_COLUMN_NAMES_LIST=10051;
	const PHP_SQL_VALUES=10052;
	const PHP_SQL_EXPR_LIST2=10053; /*with paranthesis eg: (a, 1+100, 1+select '1')*/
	const PHP_SQL_ON_DUPLICATE_KEY_UPDATE=10054;
	const PHP_SQL_REPLACE_OPTIONS_LIST=10055;
	const PHP_SQL_REPLACE_OPTION=10056;
	const PHP_SQL_DELETE_OPTIONS_LIST=10057;
	const PHP_SQL_DELETE_OPTION=10058;
	const PHP_SQL_DELETE_TABLES_LIST=10059;
	const PHP_SQL_DELETE_TABLE=10060;
	const PHP_SQL_SORT_EXPR_LIST=10061;
	const PHP_SQL_SORT_EXPR=10062;
	const PHP_SQL_SORT_DIRECTION=10063;
	const PHP_SQL_WITH_ROLLUP=10064;
	const PHP_SQL_WHEN_THEN_EXPR_LIST=10065;
	const PHP_SQL_WHEN_THEN_EXPR=10066;
	const PHP_SQL_WHEN_THEN_ELSE_EXPR=10067;
	const PHP_SQL_FUNCTION5=10068;
	const PHP_SQL_FUNCTION5_SYNTAX=10069;

	const PHP_SQL_SELECT_INTO_EXPORT_OPTIONS_OPTIONS=10070;
	const PHP_SQL_SELECT_INTO_EXPORT_OPTIONS_FIELDS=10071;
	const PHP_SQL_SELECT_INTO_EXPORT_OPTIONS_LINES=10072;
	const PHP_SQL_SELECT_INTO_EXPORT_OPTIONS_LIST=10073;
	const PHP_SQL_SELECT_INTO_EXPORT_OPTIONS_OPTION=10074;
	const PHP_SQL_SET=10075;
	const PHP_SQL_TABLE_FACTOR_ALIAS=10076;
	const PHP_SQL_EXPR_ALIAS=10077;
	/*end codes*/
	/*regexp used to split sql stamenets in tokens when alsqlp extension is not available*/
	static protected $___regexpTokens='';
	static protected $___regexpTokenDefs=array(
		/*string*/			1 =>'(
									(										
										["] #match single or double quote not preceded by a backslash
									)
									(
										(?:
											\\\"
											|
											""
											|
											[^"]
										)*
									)
									(")
									|
									(										
										[\'] #match single or double quote not preceded by a backslash
									)
									(
										(?:
											\\\\\\\\
											|
											\\\\\'
											|
											\'\'
											|
											[^\']
										)*
									)
									(\')
									
								)
								
								',
		/*parameter*/		2 => '(\@[a-z\_][a-z\_0-9]*)',
		/*backquoted_id*/	3 => '(`(?:[^`]|``)*`)',
		/*join type*/		
							//50 => '(NATURAL[\\s]+OUTER[\\s]+JOIN|STRAIGHT_JOIN|INNER[\\s]+JOIN|CROSS[\\s]+JOIN|LEFT[\\s]+JOIN|LEFT[\\s]+OUTER[\\s]+JOIN|RIGHT[\\s]+OUTER[\\s]+JOIN|RIGHT[\\s]+JOIN|NATURAL[\\s]+LEFT[\\s]+OUTER[\\s]+JOIN|NATURAL[\\s]+LEFT[\\s]+JOIN|NATURAL[\\s]+JOIN|NATURAL[\\s]+RIGHT[\\s]+OUTER[\\s]+JOIN|NATURAL[\\s]+RIGHT[\\s]+JOIN)',
							50 => '(STRAIGHT_JOIN|(?:NATURAL[\\s]+|)(?:LEFT[\\s]+|RIGHT[\\s]+|INNER[\\s]+|CROSS[\\s]+|)(?:OUTER[\\s]+|)JOIN)',
		/*join index hint*/	
							//70 => '(IGNORE[\\s]+INDEX|IGNORE[\\s]+KEY|IGNORE[\\s]+INDEX[\\s]+FOR[\\s]+JOIN|IGNORE[\\s]+KEY[\\s]+FOR[\\s]+JOIN|FORCE[\\s]+INDEX)',
							70 => '((?:USE|IGNORE|FORCE)[\\s]+(?:INDEX|KEY)(?:(?:[\\s]+FOR[\\s]+JOIN)|))',
		/*keyword*/			4 => '(ON[\\s]+DUPLICATE[\\s]+KEY[\\s]+UPDATE|IS[\\s]+NULL|IS[\\s]+NOT[\\s]+NULL|ORDER[\\s]+BY|GROUP[\\s]+BY|WITH[\\s]+ROLLUP|INTO[\\s]+OUTFILE|INTO[\\s]+DUMPFILE)',
		/*export options*/	110 => '((?:OPTIONALLY[\\s]+|)(?:TERMINATED|ENCLOSED|ESCAPED|STARTING)[\\s]+BY)',
		/*union*/			100 => '(UNION[\\s]+DISTINCT|UNION[\\s]+ALL|UNION)',
		/*select type*/		45 => '(LOCK[\\s]+IN[\\s]+SHARE[\\s]+MODE|FOR[\\s]+UPDATE)',
		/*hex_number*/		5 => '([xb]\'[0-9a-z]+\')',
		/*id*/				6 => '([a-z\_][a-z0-9\_]*)',
		/*number*/			7 => '([0-9]*[\.]{0,1}[0-9]*e[\+\-][0-9]+|[0-9]*[.][0-9]+|0x[0-9a-z]+|[0-9]+)',
		/*operator*/		8 => '(\:\=|\|\||\&\&|\!\=|\/|\%|\=|\<\=\>|\>\=|\<\<|\>\>|\<\>|\<\=|\<|\>|\||\&|\^|\+|\-|\~|\*|\(|\)|\,|\.)'
			);
	static protected $___regexpTokenTypes=array(
		/*string*/			1=> TOKEN_TYPE_STRING,
		/*parameter*/		8 => TOKEN_TYPE_PARAMETER, 
		/*backquoted_id*/	9 => TOKEN_TYPE_BACKQUOTED_ID,
		/*join type*/		10 => TOKEN_JOIN_TYPE,
		/*join index hint*/	11 => TOKEN_JOIN_INDEX_HINT,
		/*keyword*/			12 => TOKEN_TYPE_KEYWORD, 
		/*export options*/	13 => TOKEN_TYPE_EXPORT_OPTIONS,
		/*union*/			14 => TOKEN_TYPE_UNION,
		/*select type*/		15 => TOKEN_TYPE_SELECT_TYPE,
		/*hex_number*/		16 => TOKEN_TYPE_HEX_NUMBER,
		/*id*/				17 => TOKEN_TYPE_ID, 
		/*number*/			18 => TOKEN_TYPE_NUMBER, 
		/*operator*/		19 => TOKEN_TYPE_OPERATOR
		);
	static public function ___getKeywords()
	{
		return static::$___keywords;
	}
	
	public function getGetCacheFileName($source='')
	{
		$sourceCode='';
		foreach($this->tokens as $i=>$token)
		{
			$sourceCode.=isset(static::$___tokenCodes[strtoupper($token[0])]) ? static::$___tokenCodes[strtoupper($token[0])]:$token[1];	
		}
		
		$cacheFileNameParts=str_split($sourceCode, 250);
		$cacheFileName=CONFIG_CACHE_DIR.'/sql-parse-trees';
		
		if(!is_dir($cacheFileName))
		{
			mkdir($cacheFileName);
		}
		
		$numCacheFilenNameParts=count($cacheFileNameParts);
		for($i=0; $i<$numCacheFilenNameParts-2; $i++)
		{
			$cacheFileName.='/'.$cacheFileNameParts[$i];

			if(!is_dir($cacheFileName))
			{
				mkdir($cacheFileName);
			}
		}
		
		
		$cacheFileName.='/'.$cacheFileNameParts[$numCacheFilenNameParts-1].'.php';
		return $cacheFileName;
	}	
	public function parse($source, $tokensStartIndex=0)
	{
		if(static::$___useCached || !extension_loaded('alsqlp'))
		{
			$this->parseTokens($source);
			
			$cacheFileName=$this->getGetCacheFileName($source);
			
			if(file_exists($cacheFileName))
			{
				include($cacheFileName);
				return;
			}
			
		}
		
		if(extension_loaded('alsqlp'))
		{
			if(is_array($sourceStruct=parseSqlQuery($source, $tokensStartIndex)))
			{
				if (!static::$___useCached)
				{
					$this->tokens=$sourceStruct['tokens'];
				}
				
				$this->parseTree=$sourceStruct['parse_tree'];
			}
			else
			{
				$sourceStruct=$this->tokens=$this->parseTree=null;
			}
			
			if(static::$___useCached)
			{
				file_put_contents($cacheFileName, '<?php'."\n".'$this->parseTree='.var_export($this->parseTree, true).';');
			}
		}
	}
	
	public function &getExtensionTokens()
	{
		return $this->extensionTokens;
	}
	public function &getTokens()
	{
		return $this->tokens;
	}
	public function &getParseTree()
	{
		return $this->parseTree;
	}
	
	public function rebuildSource($inserts=null, $startNode=null)
	{
		return $this->rebuildSourceWithRecursiveCalls($startNode, $inserts);
		
	}
	public function rebuildSourceWithRecursiveCalls(&$node=null, $inserts=null)
	{
		if (is_null($node))
		{
			if(!$this->parseTree)
			{
				echo ('No parse tree');
				return '';
			}
			$node=$this->parseTree;
		}
		$source='';
		
		if (!is_array($node))
		{
			if(isset($inserts['token_index']))
			{
				foreach($inserts['token_index'] as $tokenIndex=>$insert)
				{
					if($node==$tokenIndex)
					{
						$source.=$insert;
					}
				}
			}
			return ($this->tokens[$node][0]=='('?'':' ').$this->tokens[$node][0].$source;
		}
		
		
		
		foreach($node as $childTokenType=>$childNode)
		{
			if(isset($inserts['token_type']))
			{
				//foreach($inserts as $insert)
				{
					//if(isset($insert['token_type']))
					{
						foreach($inserts['token_type'] as $tokenType=>$sourceInsert)
						{
							if($tokenType==substr($childTokenType, 0, strlen($tokenType)))
							{
								$source.=($source?' ':'').$sourceInsert;
							}
						}
					}
				}
			}
			$source.=$this->rebuildSourceWithRecursiveCalls($childNode, $inserts);
		}
		
		return $source;
	}
	
	protected static function ___buildRegexpTokens()
	{
		foreach(static::$___regexpTokenDefs as $r)
		{
			static::$___regexpTokens.=(static::$___regexpTokens?'|':'').$r;
		}
	}
	
	public function parseTokens($source, $debug=false)
	{
		
		$this->tokens=array();
		
		if(!static::$___regexpTokens)
		{
			static::___buildRegexpTokens();
		}
		
		if(preg_match_all('/'.static::$___regexpTokens.'/xis', $source, $matches, PREG_PATTERN_ORDER)>0)
		{
			if($debug)
			{
				print_r($matches); exit();
			}
			foreach($matches[1] as $i=>$match)
			{
				$numericTokenType=TOKEN_TYPE_STRING; //string
		
				if ($match=='')
				{
					foreach(static::$___regexpTokenTypes as $tokenType=>$numericTokenType)
					{
						if($matches[$tokenType][$i]!='')	
						{
							$match=$matches[$tokenType][$i];
							break;
						}
					}
				}
				
				
				$this->tokens[]=array(0=>$match,1=>$numericTokenType);
				
			}
		}
		
		return $this->tokens;
	}

	/**
	 * getNodesByType
	 * 
	 * Returns an array containing references to nodes of type $findTokenType
	 * 
	 * @param string	$findTokenType		- type of nodes to find
	 * @param array		$startNode			- to what node to start searching
	 * @param boolean	$skipSubqueries		- search through sub-selects or not
	 * @param boolean	$stopOnFirstMatch	- stop on first node found or not
	 * @param array		$nodes				- found nodes are added to $nodes
	 */
	public function getNodesByType($findTokenType, &$startNode=null, $skipSubqueries=true, $stopOnFirstMatch=true, &$nodes=null)
	{
		if($returnValue=is_null($nodes))
		{
			$nodes=array();
		}
		
		if(is_null($startNode))
		{
			$startNode=&$this->parseTree;
		}
		
		if(!is_array($startNode))
		{
			return;
		}
		
		foreach($startNode as $childNodeType=>&$childNode)
		{
			if(substr($childNodeType,0,5)==$findTokenType)
			{
				$nodes[]=&$childNode;
				if($stopOnFirstMatch)
				{
					break;
				}
			}
		}
		
		if(!$nodes || !$stopOnFirstMatch)
		{
			foreach($startNode as $childNodeType=>&$childNode)
			{
				$childNodeType=substr($childNodeType,0,5);

				if($skipSubqueries && $childNodeType==static::PHP_SQL_SUBSELECT)
				{
					continue;
				}
				$this->getNodesByType($findTokenType, $childNode, $skipSubqueries, $stopOnFirstMatch, $nodes);
			}
		}
		if($returnValue)
		{
			return $nodes;
		}
	}
	public function insertSource($toTokenType, $toTokenName, $source, $operator, $replace, $encloseWithParanthesis, &$startNode=null)
	{
		$numTokens=count($this->tokens);
		$numTokens=max(array_keys($this->tokens))+1;
		$tokenNode=&$this->getNodesByType($toTokenType, $startNode)[0];
	
		if($tokenNode && !$replace)
		{
			if($encloseWithParanthesis)
			{
				array_splice($tokenNode, 1, 0, array($numTokens));
				$this->tokens[$numTokens]=array(0=>'(', 1=>1);
			}
			
			array_splice($tokenNode, count($tokenNode), 0, array($numTokens+1));
			
			$this->tokens[$numTokens+1]=array(0=>($encloseWithParanthesis?') ':'').$operator.($encloseWithParanthesis?' ( ':'').$source.($encloseWithParanthesis?' )':''), 1=>1);
		}
		else
		{
			$tokenNode=array($numTokens);
			$this->tokens[$numTokens]=array(0=>' '.$toTokenName.' '.($encloseWithParanthesis?'( ':'').$source.($encloseWithParanthesis?' )':''), 1=>1);
					
		}
		
			
		//$rebuiltQuery=$this->rebuildSource();
		//$this->parse($rebuiltQuery);
	}
	public function appendWhere($cond, $operator=null, &$startNode=null)
	{
		$this->insertSource(static::PHP_SQL_WHERE, 'WHERE', $cond, $operator, $replace=false, $encloseWithParanthesis=true, $startNode);
	}
	public function appendOrderBy($orderBy, &$startNode=null)
	{
		$this->insertSource(static::PHP_SQL_ORDER_BY, 'ORDER BY', $orderBy, ',', $replace=false, $encloseWithParanthesis=false, $startNode);
	}
	public function addSelectOptions($selectOptions, &$startNode=null)
	{
		$this->insertSource(static::PHP_SQL_SELECT_OPTIONS, '', $selectOptions, '', $replace=false, $encloseWithParanthesis=false, $startNode);
	}
	public function setLimit($limit, $offset=null, &$startNode=null, $offsetKeyword='OFFSET')
	{
		$limit='LIMIT '.$limit.($offset?' '.$offsetKeyword.' '.$offset:'');
		
		$this->insertSource(static::PHP_SQL_LIMIT, '',	$limit, '', $replace=true, $encloseWithParanthesis=false, $startNode);
	}
	public function addInsertColumns($columnNames, $columnValues)
	{
		$sqlColumnNames=$sqlColumnValues='';
		
		if($columnNamesNode=$this->getNodesByType(static::PHP_SQL_SET))
		{
			foreach($columnNames as $i=>$columnName)
			{
				$sqlColumnNames.=($sqlColumnNames?', ':'').$columnName.'='.$columnValues[$i];
			}
			return $this->insertSource(static::PHP_SQL_EXPR_LIST, '', $sqlColumnNames, ',', $replace=false, $encloseWithParanthesis=false, $columnNamesNode);
		}
		
		foreach($columnNames as $i=>$columnName)
		{
			$sqlColumnNames.=($sqlColumnNames?', ':'').$columnName;
			$sqlColumnValues.=($sqlColumnValues?', ':'').$columnValues[$i];
		}
		
		if($columnNamesNode=&$this->getNodesByType(static::PHP_SQL_COLUMN_NAMES_LIST)[0])
		{
			$this->insertSource(static::PHP_SQL_COLUMN_NAMES_LIST, '', $sqlColumnNames, ',', $replace=false, $encloseWithParanthesis=false);
			$this->parse($this->rebuildSource());
		}
		
		if($columnNamesNode=&$this->getNodesByType(static::PHP_SQL_VALUES)[0])
		{
			return $this->insertSource(static::PHP_SQL_EXPR, '', $sqlColumnValues, ',', $replace=false, $encloseWithParanthesis=false, $columnNamesNode);
		}
		elseif($columnNamesNode=&$this->getNodesByType(static::PHP_SQL_STATEMENT_SELECT)[0])	
		{
			return $this->addSelectColumns($sqlColumnValues, $columnNamesNode);
		}
		
			
	}
	public function addSelectColumns($columnNames, &$startNode=null)
	{
		$node=$this->getNodesByType(static::PHP_SQL_SELECT_EXPR_LIST, $startNode)[0];
		$this->insertSource(static::PHP_SQL_SELECT_EXPR_LIST, '', $columnNames, ',', $replace=false, $encloseWithParanthesis=false);
		
	}
	public function getTokenTreeNodes($tokenType, &$node=null, $depth=0)
	{
		static $nodes;
		
		if(is_null($node))
		{
			$node=&$this->parseTree;
			$nodes=array();
			$return=true;
		}
		else
		{
			$return=false;
		}
		
		
		{
			$tokenTypeLen=strlen($tokenType);
			
			foreach($node as $childTokenType=>&$childNode)
			{
				if(substr($childTokenType, 0, $tokenTypeLen)==$tokenType)
				{
					$nodes[]=&$childNode;
				}
				
				if(is_array($childNode))
				{
					$this->getTokenTreeNodes($tokenType, $childNode, $depth+1);
				}
			}
		}
		
		if($return)
		{
			return $nodes;
		}
	}
	public function getFieldNames($skipSubqueries=true, $startNode=null, $onlyInSelectExprList=true)
	{
		if($onlyInSelectExprList)
		{
			$startNode=$this->getNodesByType(static::PHP_SQL_SELECT_EXPR_LIST, $startNode)[0];
		}
		if($tokens=$this->getNodesByType(static::PHP_SQL_COLUMN_NAME, $startNode, $skipSubqueries=true, false))
		{
			foreach($tokens as $token)
			{
				$fieldName='';
				foreach($token as $tokenPart)
				{
					$fieldName.=$this->tokens[$tokenPart][0];
				}
				$fieldName=str_replace('`', '', $fieldName);
				$fieldNames[$fieldName]=$fieldName;
			}
		}
		
		return $fieldNames;
	}
	public function getSelectExpressions($skipSubqueries=true, $startNode=null, $onlyInSelectExprList=true)
	{
		if($selectExpressionNodes=$this->getNodesByType(static::PHP_SQL_SELECT_EXPR, $startNode, $skipSubqueries=true, $stopOnFirstMatch=false))
		{
			foreach($selectExpressionNodes as $selectExpressionNode)
			{
				$alias='';
				
				
				if(isset($selectExpressionNode[static::PHP_SQL_EXPR_ALIAS.'-0']))
				{
					//expression with ALIAS
					//if the ALIAS node has 2 elements then it is as "expr AS alias_name"
					//if there is only one element then it is an "expr alias_name"
					$aliasTokenIndex=$selectExpressionNode[static::PHP_SQL_EXPR_ALIAS.'-0'][count($selectExpressionNode[static::PHP_SQL_EXPR_ALIAS.'-0'])==2?1:0];					
					$alias=$this->tokens[$aliasTokenIndex][0];
					
					//remove the ALIAS part from expression
					unset($selectExpressionNode[static::PHP_SQL_EXPR_ALIAS.'-0']);
				}
				elseif(isset($selectExpressionNode[static::PHP_SQL_EXPR.'-0'][static::PHP_SQL_COLUMN_NAME.'-0']))
				{
					//the expression doesn't have an ALIAS part end it contains a column name
					foreach($selectExpressionNode[static::PHP_SQL_EXPR.'-0'][static::PHP_SQL_COLUMN_NAME.'-0'] as $columnNameExpressionTokenIndex)
					{
						$alias.=$this->tokens[$columnNameExpressionTokenIndex][0];
					}
				}
				elseif(count($selectExpressionNode)==1)
				{
					//the expression contains only one element that is an index poiting to corresponding token
					$alias=$this->tokens[current($selectExpressionNode)][0];
				}
				
				if($alias)
				{
					$selectExpressions[$alias]=$this->rebuildSourceWithRecursiveCalls($selectExpressionNode);
				}
				else
				{
					$selectExpressions[]=$this->rebuildSourceWithRecursiveCalls($selectExpressionNode);
				}
			}
		}
		
		return $selectExpressions;
	}
	public function getTableNames($skipSubqueries=true, $startNode=null)
	{
		if($tokens=$this->getNodesByType(static::PHP_SQL_TABLE_NAME, $startNode, $skipSubqueries, false))
		{
			foreach($tokens as $token)
			{
				$tableName='';
				foreach($token as $tokenPart)
				{
					$tableName.=$this->tokens[$tokenPart][0];
				}
				$tableName=str_replace('`', '', $tableName);
				$tableNames[$tableName]=$tableName;
			}
		}
		
		return $tableNames;
	}
	public function getTableNameAliases($skipSubqueries=true, $startNode=null)
	{
		//, &$startNode=null, $skipSubqueries=true, $stopOnFirstMatch=true, &$nodes=null)
		if($nodes=$this->getNodesByType(static::PHP_SQL_TABLE_FACTOR, $startNode, $skipSubqueries, $stopOnFirstMatch=false))
		{
			//print_r($nodes);
			foreach($nodes as $node)
			{
				$tableFactorAliasNode=isset($node[static::PHP_SQL_TABLE_FACTOR_ALIAS.'-0']) ? $node[static::PHP_SQL_TABLE_FACTOR_ALIAS.'-0']:null;
				if(!$tableFactorAliasNode)
				{
					$alias='';
				}
				else
				{
					$alias=$this->tokens[count($tableFactorAliasNode)>1?$tableFactorAliasNode[1]:$tableFactorAliasNode[0]][0];
				}
				$tblName=isset($node['10024-0'])?$this->tokens[end($node['10024-0'])][0]:'';
				//echo $tblName."\n";
				$aliases[]=array($tblName=>$alias);
			}
			
			return $aliases;
		}
	}
}
