/*
  +----------------------------------------------------------------------+
  | PHP Version 5                                                        |
  +----------------------------------------------------------------------+
  | Copyright (c) 1997-2007 The PHP Group                                |
  +----------------------------------------------------------------------+
  | This source file is subject to version 3.01 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | http://www.php.net/license/3_01.txt                                  |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Author:                                                              |
  +----------------------------------------------------------------------+
*/

/* $Id: php_alsqlp.h,v 1.2 2007/09/15 15:21:16 d3v310p3r Exp $ */

#ifndef PHP_ALSQLP_H
#define PHP_ALSQLP_H

#include "php.h"
#include "php_ini.h"
#include "ext/standard/info.h"
#include "parse_tree.h"

typedef struct php_sql_token
{
	zval* token_index;
	int token_type;
}php_sql_token;

#define YYSTYPE php_sql_token

#define PHP_SQL_STATEMENT_SELECT	10002
#define PHP_SQL_STATEMENT_INSERT	10003
#define PHP_SQL_STATEMENT_UPDATE	10004
#define PHP_SQL_STATEMENT_DELETE	10005
#define PHP_SQL_STATEMENT_REPLACE	10006
#define PHP_SQL_STATEMENT_UNION_SELECT	10007
#define PHP_SQL_STATEMENT_UNION		10008

#define PHP_SQL_WHERE				10020
#define PHP_SQL_ORDER_BY			10021
#define PHP_SQL_LIMIT				10022
#define PHP_SQL_COLUMN_NAME			10023
#define PHP_SQL_TABLE_NAME			10024
#define PHP_SQL_SELECT_OPTIONS_LIST	10025
#define PHP_SQL_GROUP_BY			10026
#define PHP_SQL_EXPR				10027
#define PHP_SQL_FROM				10028
#define PHP_SQL_HAVING				10029
#define PHP_SQL_SELECT_EXPR			10030
#define PHP_SQL_SELECT_EXPR_LIST	10031
#define PHP_SQL_EXPR_LIST			10032
#define PHP_SQL_TABLE_REFERENCES	10033
#define PHP_SQL_TABLE_FACTOR		10034
#define PHP_SQL_INDEX_HINT			10035
#define PHP_SQL_SELECT_TYPE			10036
#define PHP_SQL_SELECT_INTO_EXPORT_OPTIONS		10037
#define PHP_SQL_PROCEDURE			10038
#define PHP_SQL_SELECT_OPTION		10039
#define PHP_SQL_JOIN_TYPE			10040
#define PHP_SQL_JOIN_CONDITION		10041
#define PHP_SQL_FUNCTION3			10042
#define PHP_SQL_SEPARATOR			10043
#define PHP_SQL_SUBSELECT			10044
#define PHP_SQL_UPDATE_OPTIONS_LIST	10045
#define PHP_SQL_UPDATE_OPTION		10046
#define PHP_SQL_INSERT_OPTIONS_LIST	10047
#define PHP_SQL_INSERT_OPTION		10048
#define PHP_SQL_INTO				10049
#define PHP_SQL_PARTITION			10050
#define PHP_SQL_COLUMN_NAMES_LIST	10051
#define PHP_SQL_VALUES				10052
#define PHP_SQL_EXPR_LIST2			10053 /*with paranthesis eg: (a, 1+100, 1+select '1')*/
#define PHP_SQL_ON_DUPLICATE_KEY_UPDATE 10054
#define PHP_SQL_REPLACE_OPTIONS_LIST 10055
#define PHP_SQL_REPLACE_OPTION		10056
#define PHP_SQL_DELETE_OPTIONS_LIST 10057
#define PHP_SQL_DELETE_OPTION		10058
#define PHP_SQL_DELETE_TABLES_LIST	10059
#define PHP_SQL_DELETE_TABLE		10060
#define PHP_SQL_SORT_EXPR_LIST		10061
#define PHP_SQL_SORT_EXPR			10062
#define PHP_SQL_SORT_DIRECTION		10063
#define PHP_SQL_WITH_ROLLUP			10064
#define PHP_SQL_WHEN_THEN_EXPR_LIST	10065
#define PHP_SQL_WHEN_THEN_EXPR		10066
#define PHP_SQL_WHEN_THEN_ELSE_EXPR		10067
#define PHP_SQL_FUNCTION5			10068
#define PHP_SQL_FUNCTION5_SYNTAX	10069

#define PHP_SQL_SELECT_INTO_EXPORT_OPTIONS_OPTIONS		10070
#define PHP_SQL_SELECT_INTO_EXPORT_OPTIONS_FIELDS		10071
#define PHP_SQL_SELECT_INTO_EXPORT_OPTIONS_LINES		10072
#define PHP_SQL_SELECT_INTO_EXPORT_OPTIONS_LIST			10073
#define PHP_SQL_SELECT_INTO_EXPORT_OPTIONS_OPTION		10074
#define PHP_SQL_SET					10075

#define IS_TOKEN	100111



extern zend_module_entry alsqlp_module_entry;
//static zval* arrParser;
#define phpext_alsqlp_ptr &alsqlp_module_entry

#ifdef PHP_WIN32
#define PHP_ALSQLP_API __declspec(dllexport)
#else
#define PHP_ALSQLP_API
#endif

#ifdef ZTS
#include "TSRM.h"
#endif

PHP_MINIT_FUNCTION(alsqlp);
PHP_MSHUTDOWN_FUNCTION(alsqlp);
PHP_RINIT_FUNCTION(alsqlp);
PHP_RSHUTDOWN_FUNCTION(alsqlp);
PHP_MINFO_FUNCTION(alsqlp);

PHP_FUNCTION(confirm_alsqlp_compiled);	/* For testing, remove later. */
PHP_FUNCTION(parseSqlQuery);
/* 
  	Declare any global variables you may need between the BEGIN
	and END macros here:     

ZEND_BEGIN_MODULE_GLOBALS(alsqlp)
	long  global_value;
	char *global_string;
ZEND_END_MODULE_GLOBALS(alsqlp)
*/

/* In every utility function you add that needs to use variables 
   in php_alsqlp_globals, call TSRMLS_FETCH(); after declaring other 
   variables used by that function, or better yet, pass in TSRMLS_CC
   after the last function argument and declare your utility function
   with TSRMLS_DC after the last declared argument.  Always refer to
   the globals in your function as ALSQLP_G(variable).  You are 
   encouraged to rename these macros something shorter, see
   examples in any other php module directory.
*/

#ifdef ZTS
#define ALSQLP_G(v) TSRMG(alsqlp_globals_id, zend_alsqlp_globals *, v)
#else
#define ALSQLP_G(v) (alsqlp_globals.v)
#endif

#endif	/* PHP_ALSQLP_H */


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */

