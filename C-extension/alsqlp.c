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

/* $Id: alsqlp.c,v 1.2 2007/09/15 15:13:53 d3v310p3r Exp $ */

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php_alsqlp.h"
#include "sql_defs.h"

/* If you declare any globals in php_alsqlp.h uncomment this:
ZEND_DECLARE_MODULE_GLOBALS(alsqlp)
*/

/* True global resources - no need for thread safety here */
static int le_alsqlp;

/* {{{ alsqlp_functions[]
 *
 * Every user visible function must have an entry in alsqlp_functions[].
 */
zend_function_entry alsqlp_functions[] = {
	PHP_FE(confirm_alsqlp_compiled,	NULL)		/* For testing, remove later. */
	PHP_FE(parseSqlQuery,	NULL)
	{NULL, NULL, NULL}	/* Must be the last line in alsqlp_functions[] */
};
/* }}} */

/* {{{ alsqlp_module_entry
 */
zend_module_entry alsqlp_module_entry = {
#if ZEND_MODULE_API_NO >= 20010901
	STANDARD_MODULE_HEADER,
#endif
	"alsqlp",
	alsqlp_functions,
	PHP_MINIT(alsqlp),
	PHP_MSHUTDOWN(alsqlp),
	PHP_RINIT(alsqlp),		/* Replace with NULL if there's nothing to do at request start */
	PHP_RSHUTDOWN(alsqlp),	/* Replace with NULL if there's nothing to do at request end */
	PHP_MINFO(alsqlp),
#if ZEND_MODULE_API_NO >= 20010901
	"0.1", /* Replace with version number for your extension */
#endif
	STANDARD_MODULE_PROPERTIES
};
/* }}} */

#ifdef COMPILE_DL_ALSQLP
ZEND_GET_MODULE(alsqlp)
#endif

/* {{{ PHP_INI
 */
/* Remove comments and fill if you need to have entries in php.ini
PHP_INI_BEGIN()
    STD_PHP_INI_ENTRY("alsqlp.global_value",      "42", PHP_INI_ALL, OnUpdateLong, global_value, zend_alsqlp_globals, alsqlp_globals)
    STD_PHP_INI_ENTRY("alsqlp.global_string", "foobar", PHP_INI_ALL, OnUpdateString, global_string, zend_alsqlp_globals, alsqlp_globals)
PHP_INI_END()
*/
/* }}} */

/* {{{ php_alsqlp_init_globals
 */
/* Uncomment this function if you have INI entries
static void php_alsqlp_init_globals(zend_alsqlp_globals *alsqlp_globals)
{
	alsqlp_globals->global_value = 0;
	alsqlp_globals->global_string = NULL;
}
*/
/* }}} */

/* {{{ PHP_MINIT_FUNCTION
 */
PHP_MINIT_FUNCTION(alsqlp)
{
	/* If you have INI entries, uncomment these lines 
	REGISTER_INI_ENTRIES();
	*/


	REGISTER_LONG_CONSTANT("SQL_INSERT", SQL_INSERT ,CONST_CS|CONST_PERSISTENT);
	REGISTER_LONG_CONSTANT("SQL_INSERT_SET", SQL_INSERT_SET ,CONST_CS|CONST_PERSISTENT);
	REGISTER_LONG_CONSTANT("SQL_INSERT_SELECT", SQL_INSERT_SELECT ,CONST_CS|CONST_PERSISTENT);
	
	REGISTER_LONG_CONSTANT("SQL_SELECT", SQL_SELECT ,CONST_CS|CONST_PERSISTENT);
	
	
	REGISTER_LONG_CONSTANT("SQL_UPDATE", SQL_UPDATE ,CONST_CS|CONST_PERSISTENT);

	REGISTER_LONG_CONSTANT("SQL_DELETE", SQL_DELETE ,CONST_CS|CONST_PERSISTENT);
	REGISTER_LONG_CONSTANT("SQL_DELETE_MULTIPLE", SQL_DELETE_MULTIPLE ,CONST_CS|CONST_PERSISTENT);


	
	REGISTER_LONG_CONSTANT("SQL_UNION_ALL", SQL_UNION_ALL ,CONST_CS|CONST_PERSISTENT);
	REGISTER_LONG_CONSTANT("SQL_REPLACE", SQL_REPLACE ,CONST_CS|CONST_PERSISTENT);
	REGISTER_LONG_CONSTANT("SQL_REPLACE_SET", SQL_REPLACE_SET ,CONST_CS|CONST_PERSISTENT);
	REGISTER_LONG_CONSTANT("SQL_REPLACE_SELECT", SQL_REPLACE_SELECT ,CONST_CS|CONST_PERSISTENT);
	
	
	REGISTER_LONG_CONSTANT("SQL_TABLE_REF", SQL_TABLE_REF ,CONST_CS|CONST_PERSISTENT);
	REGISTER_LONG_CONSTANT("SQL_EXPR", SQL_EXPR ,CONST_CS|CONST_PERSISTENT);
	REGISTER_LONG_CONSTANT("SQL_EXPR_ALIAS", SQL_EXPR_ALIAS ,CONST_CS|CONST_PERSISTENT);
	REGISTER_LONG_CONSTANT("SQL_EXPR_LIST", SQL_EXPR_LIST ,CONST_CS|CONST_PERSISTENT);
	
	REGISTER_LONG_CONSTANT("SQL_COLUMN", SQL_COLUMN ,CONST_CS|CONST_PERSISTENT);
	REGISTER_LONG_CONSTANT("SQL_COLUMN2", SQL_COLUMN2 ,CONST_CS|CONST_PERSISTENT);
	REGISTER_LONG_CONSTANT("SQL_COLUMN3", SQL_COLUMN3 ,CONST_CS|CONST_PERSISTENT);
		
	REGISTER_LONG_CONSTANT("SQL_FUNC", SQL_FUNC ,CONST_CS|CONST_PERSISTENT);
	REGISTER_LONG_CONSTANT("SQL_AGG_FUNC", SQL_AGG_FUNC ,CONST_CS|CONST_PERSISTENT);


	REGISTER_LONG_CONSTANT("SQL_FUNC", SQL_FUNC ,CONST_CS|CONST_PERSISTENT);
	
	REGISTER_LONG_CONSTANT("SQL_INSERT_VALUES", SQL_INSERT_VALUES ,CONST_CS|CONST_PERSISTENT);
	

	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MSHUTDOWN_FUNCTION
 */
PHP_MSHUTDOWN_FUNCTION(alsqlp)
{
	/* uncomment this line if you have INI entries
	UNREGISTER_INI_ENTRIES();
	*/
	return SUCCESS;
}
/* }}} */

/* Remove if there's nothing to do at request start */
/* {{{ PHP_RINIT_FUNCTION
 */
PHP_RINIT_FUNCTION(alsqlp)
{
	return SUCCESS;
}
/* }}} */

/* Remove if there's nothing to do at request end */
/* {{{ PHP_RSHUTDOWN_FUNCTION
 */
PHP_RSHUTDOWN_FUNCTION(alsqlp)
{
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MINFO_FUNCTION
 */
PHP_MINFO_FUNCTION(alsqlp)
{
	php_info_print_table_start();
	php_info_print_table_header(2, "alsqlp support", "enabled");
	php_info_print_table_end();

	/* Remove comments if you have entries in php.ini
	DISPLAY_INI_ENTRIES();
	*/
}
/* }}} */


/* Remove the following function when you have succesfully modified config.m4
   so that your module can be compiled into PHP, it exists only for testing
   purposes. */

/* Every user-visible function in PHP should document itself in the source */
/* {{{ proto string confirm_alsqlp_compiled(string arg)
   Return a string to confirm that the module is compiled in */
PHP_FUNCTION(confirm_alsqlp_compiled)
{
	char *arg = NULL;
	int arg_len, len;
	char *strg;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &arg, &arg_len) == FAILURE) {
		return;
	}

	len = spprintf(&strg, 0, "Congratulations! You have successfully modified ext/%.78s/config.m4. Module %.78s is now compiled into PHP.", "alsqlp", arg);
	RETURN_STRINGL(strg, len, 0);
}
/* }}} */
/* The previous line is meant for vim and emacs, so it can correctly fold and 
   unfold functions in source code. See the corresponding marks just before 
   function definition, where the functions purpose is also documented. Please 
   follow this convention for the convenience of others editing your code.
*/


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
/* {{{ proto array parseSqlQuery(string sql_query)
    */
PHP_FUNCTION(parseSqlQuery)
{
	char *sql_query = NULL;
	int argc = ZEND_NUM_ARGS();
	zval **function_name;
	zval *retval;
	int sql_query_len;
	
	if (zend_parse_parameters(argc TSRMLS_CC, "s", &sql_query, &sql_query_len) == FAILURE) 
		return;
	
	parse_sql_query(sql_query, return_value );
	
	
}
/* }}} */


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */

