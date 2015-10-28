%{
#include <stdlib.h>

#include <string.h>
#include "php_alsqlp.h"
#include "sql.tab.h"

extern YYSTYPE yylval;
extern make_token ( YYSTYPE*, char*, int, int );

%}

%x string dbl_string line_comment comment

/*strings*/
SINGLE_QUOTED_STRING_CHR			[^'\\]|\\.|''
DOUBLE_QUOTED_STRING_CHR		[^\"\\]|\\\"|\\\\
QUOTED_ID_CHR		[^\`]
LINE_COMMENT_CHR	[^\r\n]
COMMENT_CHR			[^\*]|[\*][^\/]

/*numbers*/
FLOAT_E_NUMBER		[0-9]*[.]*[0-9]*[e][+][0-9]+
FLOAT_NUMBER		[0-9]*[.][0-9]+
NUMBER				[0-9]+
HEX_NUMBER			0x[0-9a-z]+
HEX_NUMBER_STRING	x'[0-9a-z]+'
BIT_NUMBER			b'[0-1]+'


/*OPERATORS*/
/*logical operators*/
OP_OR					or|\|\|
OP_XOR					xor
OP_AND					and|&&
OP_NOT					not|!=

/*math. operators*/
OP_ADD					\+
OP_SUB					\-
OP_MUL					\*
OP_DIV					\/|div
OP_MOD					%|mod

/*string operators*/
OP_LIKE					LIKE
OP_REGEXP				REGEXP

/*comparaison operators*/
OP_EQ					=
OP_NEQ_NULL_SAFE		<=>
OP_GT_EQ				>=
OP_GT					>
OP_LT_EQ				<=
OP_LT					<
OP_NEQ					<>|!=

/*bitwise operators*/
OP_BIT_OR				\|
OP_BIT_AND				&
OP_BIT_LSHIFT			<<
OP_BIT_RSHIFT			>>
OP_BIT_XOR				\^
OP_BIT_NOT				~

/*attr op.*/
OP_ATTR					\:\=



/*statements*/



ID						[a-z_][a-z0-9_]*
BACKQUOTED_ID			`[a-z][a-z0-9_]*`

WHITESPACE				[ \t\n\r]
/* 
IF						{ return make_token(&yylval, yytext, IF, 0); } 
COLUMNS { return make_token(&yylval, yytext, COLUMNS, 0); }
*/
%%

[']						{ BEGIN(string); yymore(); }
<string>{SINGLE_QUOTED_STRING_CHR}*	{ yymore(); }
<string>[']				{ make_token(&yylval, yytext, STRING, 1); BEGIN(0); return STRING;}

["]						{ BEGIN(dbl_string); yymore(); }
<dbl_string>{DOUBLE_QUOTED_STRING_CHR}*	{ yymore(); }
<dbl_string>["]			{ make_token(&yylval, yytext, STRING, 1); BEGIN(0); return STRING; }



[\-]{2}[ ]				{BEGIN(line_comment); yymore(); }
<line_comment>{LINE_COMMENT_CHR}*	{ yymore(); }
<line_comment>[\r\n]	{ BEGIN(0); }

[\/][\*]					{BEGIN(comment); yymore(); }
<comment>{COMMENT_CHR}*	{ yymore(); }
<comment>[\*][\/]	{ BEGIN(0);}


{FLOAT_E_NUMBER}|{FLOAT_NUMBER}|{NUMBER}|{HEX_NUMBER}|{HEX_NUMBER_STRING}|{BIT_NUMBER} { return make_token(&yylval, yytext, NUMBER, 1); }








ADD						{ return make_token(&yylval, yytext, ADD, 0); }
ALL						{ return make_token(&yylval, yytext, ALL, 0); }
ALTER						{ return make_token(&yylval, yytext, ALTER, 0); }
ANALYZE						{ return make_token(&yylval, yytext, ANALYZE, 0); }

AS						{ return make_token(&yylval, yytext, AS, 0); }
ASC						{ return make_token(&yylval, yytext, ASC, 0); }
ASENSITIVE						{ return make_token(&yylval, yytext, ASENSITIVE, 0); }
BEFORE						{ return make_token(&yylval, yytext, BEFORE, 0); }

BIGINT						{ return make_token(&yylval, yytext, BIGINT, 0); }
BINARY						{ return make_token(&yylval, yytext, BINARY, 0); }
BLOB						{ return make_token(&yylval, yytext, BLOB, 0); }
BOTH						{ return make_token(&yylval, yytext, BOTH, 0); }
BY						{ return make_token(&yylval, yytext, BY, 0); }
CALL						{ return make_token(&yylval, yytext, CALL, 0); }
CASCADE						{ return make_token(&yylval, yytext, CASCADE, 0); }
CASE						{ return make_token(&yylval, yytext, CASE, 0); }
CHANGE						{ return make_token(&yylval, yytext, CHANGE, 0); }
CHAR						{ return make_token(&yylval, yytext, CHAR, 0); }
CHARACTER						{ return make_token(&yylval, yytext, CHARACTER, 0); }
CHECK						{ return make_token(&yylval, yytext, CHECK, 0); }
COLLATE						{ return make_token(&yylval, yytext, COLLATE, 0); }
COLUMN						{ return make_token(&yylval, yytext, COLUMN, 0); }
CONDITION						{ return make_token(&yylval, yytext, CONDITION, 0); }
CONNECTION						{ return make_token(&yylval, yytext, CONNECTION, 0); }
CONSTRAINT						{ return make_token(&yylval, yytext, CONSTRAINT, 0); }
CONTINUE						{ return make_token(&yylval, yytext, CONTINUE, 0); }
CONVERT						{ return make_token(&yylval, yytext, CONVERT, 0); }
CREATE						{ return make_token(&yylval, yytext, CREATE, 0); }

CURRENT_DATE						{ return make_token(&yylval, yytext, CURRENT_DATE, 0); }
CURRENT_TIME						{ return make_token(&yylval, yytext, CURRENT_TIME, 0); }
CURRENT_TIMESTAMP						{ return make_token(&yylval, yytext, CURRENT_TIMESTAMP, 0); }
CURRENT_USER						{ return make_token(&yylval, yytext, CURRENT_USER, 0); }
CURSOR						{ return make_token(&yylval, yytext, CURSOR, 0); }
DATABASE						{ return make_token(&yylval, yytext, DATABASE, 0); }
DATABASES						{ return make_token(&yylval, yytext, DATABASES, 0); }
DAY_HOUR						{ return make_token(&yylval, yytext, DAY_HOUR, 0); }
DAY_MICROSECOND						{ return make_token(&yylval, yytext, DAY_MICROSECOND, 0); }
DAY_MINUTE						{ return make_token(&yylval, yytext, DAY_MINUTE, 0); }
DAY_SECOND						{ return make_token(&yylval, yytext, DAY_SECOND, 0); }
DEC						{ return make_token(&yylval, yytext, DEC, 0); }
DECIMAL						{ return make_token(&yylval, yytext, DECIMAL, 0); }
DECLARE						{ return make_token(&yylval, yytext, DECLARE, 0); }
DEFAULT						{ return make_token(&yylval, yytext, DEFAULT, 0); }
DELAYED						{ return make_token(&yylval, yytext, DELAYED, 0); }
DELETE						{ return make_token(&yylval, yytext, DELETE, 0); }
DESC						{ return make_token(&yylval, yytext, DESC, 0); }
DESCRIBE						{ return make_token(&yylval, yytext, DESCRIBE, 0); }
DETERMINISTIC						{ return make_token(&yylval, yytext, DETERMINISTIC, 0); }
DISTINCT						{ return make_token(&yylval, yytext, DISTINCT, 0); }
DISTINCTROW						{ return make_token(&yylval, yytext, DISTINCTROW, 0); }

DOUBLE						{ return make_token(&yylval, yytext, DOUBLE, 0); }
DROP						{ return make_token(&yylval, yytext, DROP, 0); }
DUAL						{ return make_token(&yylval, yytext, DUAL, 0); }
EACH						{ return make_token(&yylval, yytext, EACH, 0); }
END							{ return make_token(&yylval, yytext, END, 0); }
ELSE						{ return make_token(&yylval, yytext, ELSE, 0); }
ELSEIF						{ return make_token(&yylval, yytext, ELSEIF, 0); }
ENCLOSED						{ return make_token(&yylval, yytext, ENCLOSED, 0); }
ESCAPED						{ return make_token(&yylval, yytext, ESCAPED, 0); }
EXISTS						{ return make_token(&yylval, yytext, EXISTS, 0); }
EXIT						{ return make_token(&yylval, yytext, EXIT, 0); }
EXPLAIN						{ return make_token(&yylval, yytext, EXPLAIN, 0); }
FALSE						{ return make_token(&yylval, yytext, FALSE, 0); }
FETCH						{ return make_token(&yylval, yytext, FETCH, 0); }
FLOAT						{ return make_token(&yylval, yytext, FLOAT, 0); }
FLOAT4						{ return make_token(&yylval, yytext, FLOAT4, 0); }
FLOAT8						{ return make_token(&yylval, yytext, FLOAT8, 0); }
FOR						{ return make_token(&yylval, yytext, FOR, 0); }
FORCE						{ return make_token(&yylval, yytext, FORCE, 0); }
FOREIGN						{ return make_token(&yylval, yytext, FOREIGN, 0); }
FROM						{ return make_token(&yylval, yytext, FROM, 0); }
FULLTEXT						{ return make_token(&yylval, yytext, FULLTEXT, 0); }
GOTO						{ return make_token(&yylval, yytext, GOTO, 0); }
GRANT						{ return make_token(&yylval, yytext, GRANT, 0); }
GROUP						{ return make_token(&yylval, yytext, GROUP, 0); }
HAVING						{ return make_token(&yylval, yytext, HAVING, 0); }
HIGH_PRIORITY						{ return make_token(&yylval, yytext, HIGH_PRIORITY, 0); }
HOUR_MICROSECOND						{ return make_token(&yylval, yytext, HOUR_MICROSECOND, 0); }
HOUR_MINUTE						{ return make_token(&yylval, yytext, HOUR_MINUTE, 0); }
HOUR_SECOND						{ return make_token(&yylval, yytext, HOUR_SECOND, 0); }

IGNORE						{ return make_token(&yylval, yytext, IGNORE, 0); }

INDEX						{ return make_token(&yylval, yytext, INDEX, 0); }
INFILE						{ return make_token(&yylval, yytext, INFILE, 0); }

INOUT						{ return make_token(&yylval, yytext, INOUT, 0); }
INSENSITIVE						{ return make_token(&yylval, yytext, INSENSITIVE, 0); }
INSERT						{ return make_token(&yylval, yytext, INSERT, 0); }
INT						{ return make_token(&yylval, yytext, SQL_INT, 0); }
INT1						{ return make_token(&yylval, yytext, INT1, 0); }
INT2						{ return make_token(&yylval, yytext, INT2, 0); }
INT3						{ return make_token(&yylval, yytext, INT3, 0); }
INT4						{ return make_token(&yylval, yytext, INT4, 0); }
INT8						{ return make_token(&yylval, yytext, INT8, 0); }
INTEGER						{ return make_token(&yylval, yytext, INTEGER, 0); }
INTERVAL						{ return make_token(&yylval, yytext, INTERVAL, 0); }

IS						{ return make_token(&yylval, yytext, IS, 0); }
ITERATE						{ return make_token(&yylval, yytext, ITERATE, 0); }

KEY						{ return make_token(&yylval, yytext, KEY, 0); }
KEYS						{ return make_token(&yylval, yytext, KEYS, 0); }
KILL						{ return make_token(&yylval, yytext, KILL, 0); }
LABEL						{ return make_token(&yylval, yytext, LABEL, 0); }
LEADING						{ return make_token(&yylval, yytext, LEADING, 0); }
LEAVE						{ return make_token(&yylval, yytext, LEAVE, 0); }
LEFT						{ return make_token(&yylval, yytext, LEFT, 0); }

LIMIT						{ return make_token(&yylval, yytext, LIMIT, 0); }
LINES						{ return make_token(&yylval, yytext, LINES, 0); }
LOAD						{ return make_token(&yylval, yytext, LOAD, 0); }
LOCALTIME						{ return make_token(&yylval, yytext, LOCALTIME, 0); }
LOCALTIMESTAMP						{ return make_token(&yylval, yytext, LOCALTIMESTAMP, 0); }
LOCK						{ return make_token(&yylval, yytext, LOCK, 0); }
LONG						{ return make_token(&yylval, yytext, LONG, 0); }
LONGBLOB						{ return make_token(&yylval, yytext, LONGBLOB, 0); }
LONGTEXT						{ return make_token(&yylval, yytext, LONGTEXT, 0); }
LOOP						{ return make_token(&yylval, yytext, LOOP, 0); }
LOW_PRIORITY						{ return make_token(&yylval, yytext, LOW_PRIORITY, 0); }
MATCH						{ return make_token(&yylval, yytext, MATCH, 0); }
MEDIUMBLOB						{ return make_token(&yylval, yytext, MEDIUMBLOB, 0); }
MEDIUMINT						{ return make_token(&yylval, yytext, MEDIUMINT, 0); }
MEDIUMTEXT						{ return make_token(&yylval, yytext, MEDIUMTEXT, 0); }
MIDDLEINT						{ return make_token(&yylval, yytext, MIDDLEINT, 0); }
MINUTE_MICROSECOND						{ return make_token(&yylval, yytext, MINUTE_MICROSECOND, 0); }
MINUTE_SECOND						{ return make_token(&yylval, yytext, MINUTE_SECOND, 0); }

MODIFIES						{ return make_token(&yylval, yytext, MODIFIES, 0); }


NO_WRITE_TO_BINLOG						{ return make_token(&yylval, yytext, NO_WRITE_TO_BINLOG, 0); }
NULL						{ return make_token(&yylval, yytext, SQL_NULL, 0); }
NUMERIC						{ return make_token(&yylval, yytext, NUMERIC, 0); }
ON						{ return make_token(&yylval, yytext, ON, 0); }
OPTIMIZE						{ return make_token(&yylval, yytext, OPTIMIZE, 0); }
OPTION						{ return make_token(&yylval, yytext, OPTION, 0); }
OPTIONALLY						{ return make_token(&yylval, yytext, OPTIONALLY, 0); }

ORDER						{ return make_token(&yylval, yytext, ORDER, 0); }
OUT						{ return make_token(&yylval, yytext, OUT, 0); }

OUTFILE						{ return make_token(&yylval, yytext, OUTFILE, 0); }
PRECISION						{ return make_token(&yylval, yytext, PRECISION, 0); }
PRIMARY						{ return make_token(&yylval, yytext, PRIMARY, 0); }
PROCEDURE						{ return make_token(&yylval, yytext, PROCEDURE, 0); }
PURGE						{ return make_token(&yylval, yytext, PURGE, 0); }
READ						{ return make_token(&yylval, yytext, READ, 0); }
READS						{ return make_token(&yylval, yytext, READS, 0); }
REAL						{ return make_token(&yylval, yytext, REAL, 0); }
REFERENCES						{ return make_token(&yylval, yytext, REFERENCES, 0); }

RELEASE						{ return make_token(&yylval, yytext, RELEASE, 0); }
RENAME						{ return make_token(&yylval, yytext, RENAME, 0); }
REPEAT						{ return make_token(&yylval, yytext, REPEAT, 0); }
REPLACE						{ return make_token(&yylval, yytext, REPLACE, 0); }
REQUIRE						{ return make_token(&yylval, yytext, REQUIRE, 0); }
RESTRICT						{ return make_token(&yylval, yytext, RESTRICT, 0); }
RETURN						{ return make_token(&yylval, yytext, RETURN, 0); }
REVOKE						{ return make_token(&yylval, yytext, REVOKE, 0); }

RLIKE						{ return make_token(&yylval, yytext, RLIKE, 0); }
SCHEMA						{ return make_token(&yylval, yytext, SCHEMA, 0); }
SCHEMAS						{ return make_token(&yylval, yytext, SCHEMAS, 0); }
SECOND_MICROSECOND						{ return make_token(&yylval, yytext, SECOND_MICROSECOND, 0); }
SELECT						{ return make_token(&yylval, yytext, SELECT, 0); }
SENSITIVE						{ return make_token(&yylval, yytext, SENSITIVE, 0); }
SEPARATOR						{ return make_token(&yylval, yytext, SEPARATOR, 0); }
SET						{ return make_token(&yylval, yytext, SET, 0); }
SHOW						{ return make_token(&yylval, yytext, SHOW, 0); }
SMALLINT						{ return make_token(&yylval, yytext, SMALLINT, 0); }
SONAME						{ return make_token(&yylval, yytext, SONAME, 0); }
SPATIAL						{ return make_token(&yylval, yytext, SPATIAL, 0); }
SPECIFIC						{ return make_token(&yylval, yytext, SPECIFIC, 0); }
SQL						{ return make_token(&yylval, yytext, SQL, 0); }
SQLEXCEPTION						{ return make_token(&yylval, yytext, SQLEXCEPTION, 0); }
SQLSTATE						{ return make_token(&yylval, yytext, SQLSTATE, 0); }
SQLWARNING						{ return make_token(&yylval, yytext, SQLWARNING, 0); }
SQL_BIG_RESULT						{ return make_token(&yylval, yytext, SQL_BIG_RESULT, 0); }
SQL_BUFFER_RESULT				{ return make_token(&yylval, yytext, SQL_BUFFER_RESULT, 0); }
SQL_CACHE				{ return make_token(&yylval, yytext, SQL_CACHE, 0); }
SQL_CALC_FOUND_ROWS						{ return make_token(&yylval, yytext, SQL_CALC_FOUND_ROWS, 0); }
SQL_NO_CACHE						{ return make_token(&yylval, yytext, SQL_NO_CACHE, 0); }
SQL_SMALL_RESULT						{ return make_token(&yylval, yytext, SQL_SMALL_RESULT, 0); }
SSL						{ return make_token(&yylval, yytext, SSL, 0); }
STARTING						{ return make_token(&yylval, yytext, STARTING, 0); }

TABLE						{ return make_token(&yylval, yytext, TABLE, 0); }
TERMINATED						{ return make_token(&yylval, yytext, TERMINATED, 0); }
THEN						{ return make_token(&yylval, yytext, THEN, 0); }
TINYBLOB						{ return make_token(&yylval, yytext, TINYBLOB, 0); }
TINYINT						{ return make_token(&yylval, yytext, TINYINT, 0); }
TINYTEXT						{ return make_token(&yylval, yytext, TINYTEXT, 0); }
TO						{ return make_token(&yylval, yytext, TO, 0); }
TRAILING						{ return make_token(&yylval, yytext, TRAILING, 0); }
TRIGGER						{ return make_token(&yylval, yytext, TRIGGER, 0); }
TRUE						{ return make_token(&yylval, yytext, TRUE, 0); }
UNDO						{ return make_token(&yylval, yytext, UNDO, 0); }

UNIQUE						{ return make_token(&yylval, yytext, UNIQUE, 0); }
UNLOCK						{ return make_token(&yylval, yytext, UNLOCK, 0); }
UNSIGNED						{ return make_token(&yylval, yytext, UNSIGNED, 0); }
UPDATE						{ return make_token(&yylval, yytext, UPDATE, 0); }
UPGRADE						{ return make_token(&yylval, yytext, UPGRADE, 0); }
USAGE						{ return make_token(&yylval, yytext, USAGE, 0); }
USE						{ return make_token(&yylval, yytext, USE, 0); }
USING						{ return make_token(&yylval, yytext, USING, 0); }
UTC_DATE						{ return make_token(&yylval, yytext, UTC_DATE, 0); }
UTC_TIME						{ return make_token(&yylval, yytext, UTC_TIME, 0); }
UTC_TIMESTAMP						{ return make_token(&yylval, yytext, UTC_TIMESTAMP, 0); }
VALUES						{ return make_token(&yylval, yytext, VALUES, 0); }
VARBINARY						{ return make_token(&yylval, yytext, VARBINARY, 0); }
VARCHAR						{ return make_token(&yylval, yytext, VARCHAR, 0); }
VARCHARACTER						{ return make_token(&yylval, yytext, VARCHARACTER, 0); }
VARYING						{ return make_token(&yylval, yytext, VARYING, 0); }
WHEN						{ return make_token(&yylval, yytext, WHEN, 0); }
WHERE						{ return make_token(&yylval, yytext, WHERE, 0); }
WHILE						{ return make_token(&yylval, yytext, WHILE, 0); }
WITH						{ return make_token(&yylval, yytext, WITH, 0); }
WRITE						{ return make_token(&yylval, yytext, WRITE, 0); }

YEAR_MONTH						{ return make_token(&yylval, yytext, YEAR_MONTH, 0); }
ZEROFILL						{ return make_token(&yylval, yytext, ZEROFILL, 0); }

OFFSET { return make_token(&yylval, yytext, OFFSET, 0); }
QUICK { return make_token(&yylval, yytext, QUICK, 0); }
VALUE { return make_token(&yylval, yytext, VALUE, 0); }

PARTITION { return make_token(&yylval, yytext, PARTITION, 0); }
ON{WHITESPACE}+DUPLICATE{WHITESPACE}+KEY{WHITESPACE}+UPDATE  { return make_token(&yylval, yytext, ON_DUPLICATE_KEY_UPDATE, 0); }
ORDER{WHITESPACE}+BY { return make_token(&yylval, yytext, ORDER_BY, 0); }

GROUP{WHITESPACE}+BY { return make_token(&yylval, yytext, GROUP_BY, 0); }

WITH{WHITESPACE}+ROLLUP { return make_token(&yylval, yytext, WITH_ROLLUP, 0); }

INTO{WHITESPACE}+OUTFILE { return make_token(&yylval, yytext, INTO, 0); }
INTO{WHITESPACE}+DUMPFILE { return make_token(&yylval, yytext, INTO, 0); }
INTO { return make_token(&yylval, yytext, INTO, 0); }

FIELDS { return make_token(&yylval, yytext, FIELDS, 0); }


UNION { return make_token(&yylval, yytext, UNION_TYPE, 0); }
UNION{WHITESPACE}+ALL { return make_token(&yylval, yytext, UNION_TYPE, 0); }
UNION{WHITESPACE}+DISTINCT { return make_token(&yylval, yytext, UNION_TYPE, 0); }

TERMINATED{WHITESPACE}+BY  { return make_token(&yylval, yytext, EXPORT_OPTION, 0); }
ENCLOSED{WHITESPACE}+BY { return make_token(&yylval, yytext, EXPORT_OPTION, 0); }
OPTIONALLY{WHITESPACE}+ENCLOSED{WHITESPACE}+BY { return make_token(&yylval, yytext, EXPORT_OPTION, 0); }
ESCAPED{WHITESPACE}+BY { return make_token(&yylval, yytext, EXPORT_OPTION, 0); }
STARTING{WHITESPACE}+BY { return make_token(&yylval, yytext, EXPORT_OPTION, 0); } 

USE{WHITESPACE}+INDEX	{ return make_token(&yylval, yytext, OPT_INDEX_HINT, 0); }
USE{WHITESPACE}+KEY	{ return make_token(&yylval, yytext, OPT_INDEX_HINT, 0); }
USE{WHITESPACE}+INDEX{WHITESPACE}+FOR{WHITESPACE}+JOIN	{ return make_token(&yylval, yytext, OPT_INDEX_HINT, 0); }
USE{WHITESPACE}+KEY{WHITESPACE}+FOR{WHITESPACE}+JOIN	{ return make_token(&yylval, yytext, OPT_INDEX_HINT, 0); }
IGNORE{WHITESPACE}+INDEX	{ return make_token(&yylval, yytext, OPT_INDEX_HINT, 0); }
IGNORE{WHITESPACE}+KEY	{ return make_token(&yylval, yytext, OPT_INDEX_HINT, 0); }
IGNORE{WHITESPACE}+INDEX{WHITESPACE}+FOR{WHITESPACE}+JOIN	{ return make_token(&yylval, yytext, OPT_INDEX_HINT, 0); }
IGNORE{WHITESPACE}+KEY{WHITESPACE}+FOR{WHITESPACE}+JOIN	{ return make_token(&yylval, yytext, OPT_INDEX_HINT, 0); }
FORCE{WHITESPACE}+INDEX	{ return make_token(&yylval, yytext, OPT_INDEX_HINT, 0); }
FORCE{WHITESPACE}+KEY	{ return make_token(&yylval, yytext, OPT_INDEX_HINT, 0); }
FORCE{WHITESPACE}+INDEX{WHITESPACE}+FOR{WHITESPACE}+JOIN	{ return make_token(&yylval, yytext, OPT_INDEX_HINT, 0); }
FORCE{WHITESPACE}+KEY{WHITESPACE}+FOR{WHITESPACE}+JOIN	{ return make_token(&yylval, yytext, OPT_INDEX_HINT, 0); }

INNER{WHITESPACE}+JOIN { return make_token(&yylval, yytext, JOIN_TYPE, 0); }
CROSS{WHITESPACE}+JOIN { return make_token(&yylval, yytext, JOIN_TYPE, 0); }
JOIN	{ return make_token(&yylval, yytext, JOIN_TYPE, 0); }

STRAIGHT_JOIN	{ return make_token(&yylval, yytext, STRAIGHT_JOIN, 0); }

LEFT{WHITESPACE}+OUTER{WHITESPACE}+JOIN { return make_token(&yylval, yytext, JOIN_TYPE, 0); }
LEFT{WHITESPACE}+JOIN { return make_token(&yylval, yytext, JOIN_TYPE, 0); }
RIGHT{WHITESPACE}+OUTER{WHITESPACE}+JOIN { return make_token(&yylval, yytext, JOIN_TYPE, 0); }
RIGHT{WHITESPACE}+JOIN { return make_token(&yylval, yytext, JOIN_TYPE, 0); }

NATURAL{WHITESPACE}+LEFT{WHITESPACE}+OUTER{WHITESPACE}+JOIN { return make_token(&yylval, yytext, JOIN_TYPE, 0); }
NATURAL{WHITESPACE}+LEFT{WHITESPACE}+JOIN { return make_token(&yylval, yytext, JOIN_TYPE, 0); }
NATURAL{WHITESPACE}+JOIN  { return make_token(&yylval, yytext, JOIN_TYPE, 0); }
NATURAL{WHITESPACE}+RIGHT{WHITESPACE}+OUTER{WHITESPACE}+JOIN { return make_token(&yylval, yytext, JOIN_TYPE, 0); }
NATURAL{WHITESPACE}+RIGHT{WHITESPACE}+JOIN { return make_token(&yylval, yytext, JOIN_TYPE, 0); }
NATURAL{WHITESPACE}+OUTER{WHITESPACE}+JOIN { return make_token(&yylval, yytext, JOIN_TYPE, 0); }

FOR{WHITESPACE}+UPDATE { return make_token(&yylval, yytext, SELECT_TYPE, 0); }
LOCK{WHITESPACE}+IN{WHITESPACE}+SHARE{WHITESPACE}+MODE { return make_token(&yylval, yytext, SELECT_TYPE, 0); }

IS{WHITESPACE}+NULL						{ return make_token(&yylval, yytext, OPERATOR_1_OPERAND_END, 0); }
IS{WHITESPACE}+{OP_NOT}{WHITESPACE}+NULL	{ return make_token(&yylval, yytext, OPERATOR_1_OPERAND_END, 0); }


{OP_OR}|{OP_XOR}|{OP_AND}|{OP_DIV}|{OP_MOD}|{OP_EQ}|{OP_NEQ_NULL_SAFE}|{OP_GT_EQ}|{OP_GT}|{OP_LT_EQ}|{OP_LT}|{OP_NEQ}|{OP_BIT_OR}|{OP_BIT_AND}|{OP_BIT_LSHIFT}|{OP_BIT_RSHIFT}|{OP_BIT_XOR}|{OP_ATTR}|BETWEEN			{ return make_token(&yylval, yytext, OPERATOR_2_EXPRESSIONS, 0); } 
{OP_ADD}|{OP_SUB} { return make_token(&yylval, yytext, OPERATOR_SIGN, 0); } 
{OP_LIKE}|{OP_REGEXP} { return make_token(&yylval, yytext, OPERATOR_2_EXPRESSIONS_ALLOW_NOT, 0); } 
{OP_NOT}|{OP_BIT_NOT}					{ return make_token(&yylval, yytext, OPERATOR_1_OPERANDS, 0); } 
{OP_MUL}					{ return make_token(&yylval, yytext, OP_MUL, 0); }


IN	{ return make_token(&yylval, yytext, OPERATOR_EXPRESSION_2_EXPRESSIONS_LIST, 0); }



[\@]{ID}			{ return make_token(&yylval, yytext, VAR_ID, 1); }
{ID}|{BACKQUOTED_ID}	{ return make_token(&yylval, yytext, ID, 1); }

[\(]	{ return make_token(&yylval, yytext, '(', 0); }
[\)]	{ return make_token(&yylval, yytext, ')', 0); }

[\,]	{ return make_token(&yylval, yytext, ',', 0); }
[\.]	{ return make_token(&yylval, yytext, '.', 0); }


{WHITESPACE} 		;

%%
