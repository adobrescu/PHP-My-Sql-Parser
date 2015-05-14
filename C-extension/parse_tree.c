#include "php_alsqlp.h"
#include "parse_tree.h"
#include "sql_defs.h"

/**
* return_value - zval that will be returned in the php script (see parserSqlQuery in alsqlp.c)	
* pSqlQuery - string containing the sql statement
**/

zval *tokensList;
int token_num=0;

int parse_sql_query(char *pSqlQuery, int tokens_start_index, zval*return_value)
{
    zval *parse_tree, *tokens;
    
    /*
		init return value as an array with 2 array elements
		"parse_tree" and "tokens"
	*/
    array_init(return_value);    
    
	//MAKE_STD_ZVAL(parse_tree);
    //array_init(parse_tree);

	MAKE_STD_ZVAL(tokens);
    array_init(tokens);
	
	//add_assoc_zval(return_value, "parse_tree", parse_tree);
	add_assoc_zval(return_value, "tokens", tokens);
    
	token_num=tokens_start_index;
	tokensList=tokens;
	
	/* parse */
    yy_scan_string(pSqlQuery);
    return yyparse(&return_value);
      
}
/*
* eval_rule
* 
* - Called when a sql rule is matched;
* - It adds the matched tokens and the previously matched rules nodes to the parse tree;
*
* subtree - a php_sql_token strcuture created by the parser where to put the new nodes (the $$ from sql.y)
* options - is set to EVAL_ADD_EMPTY_TOKENS, then all the nodes of a rule are created even their tokens were not found (eg. if in a SELECT statement the WHERE clause is missing, WHERE node is still created as an empty node)
* token_type - not all the tokens have a code (eg +, -, / etc); they have a generic code "IS_TOKEN" and their code is not added to parse tree array keys;
* num_args - the number of tokens/nodes received;
*
**/

int eval_rule(YYSTYPE*subtree, int options, int token_type, int num_args, ...)
{

	va_list va;
	int i, j;
	YYSTYPE *node;
	zval *empty_token;
	char key[20], key_num;
	
	/**
	* - all the args after num_args are added in an array;
	* - these array is initialised in subtree->token_index
	**/
	if(token_type)
	{
		(*subtree).token_type=token_type;
	}

	if(!num_args)
	{
		(*subtree).token_index=NULL;
		return 0;
	}
	
	MAKE_STD_ZVAL((*subtree).token_index);
	array_init((*subtree).token_index);

	
	j=0;
	/*
	* foreach argument after num_args
	*/
	for(va_start(va, num_args), i=0 ; node = va_arg(va , YYSTYPE*) , i<num_args; i ++) 
    {
		/*
			- if the node is not a token (the tokens have a token_index set by make_token to point to their coresponding index in the tokens list)
			then initialise token_index to an array;
			- in this array the received nodes as params will be added
		*/
		if((*node).token_index==NULL)
		{
			if((options&EVAL_ADD_EMPTY_TOKENS)==0)
			{
				continue;
			}
			MAKE_STD_ZVAL((*node).token_index);
			array_init((*node).token_index);
		}
		/*
			Create the key where the current node/param is stored;
			The key has the form "node type-node index" for nodes with a code (eg SELECT)
			or just "node index" for nodes without a code (eg +, - , paranthesis etc)
		*/
		//if((*node).token_type!=IS_TOKEN)
		{
			key_num=0;
			do
			{
				sprintf(key, "%u-%u", (*node).token_type, key_num);
				key_num++;
			}
			while(zend_symtable_exists(((*subtree).token_index->value).ht, key, strlen(key)+1));
		}
		/*else
		{
			sprintf(key, "%u", j);
		}
		*/
		

		add_assoc_zval((*subtree).token_index, key, (*node).token_index );
		j++;
    }
    va_end(va);
	
	return 0;


}


/*
*
* make_token
*
* - Called from sql.l (the scanner) everytime a token is found;
* - The function adds a zval to a tokens list (tokensList);
* - It creates and returns a php_sql_token struct; this struct will point to (hold in token_index the index of ) the zval added to the tokens list;
* - This structure will be added later by eval_rule to the parse tree;
* - When a rule from sql.y matches and eval_rule is called, the $1, $2 params are actually php_sql_token structures
* 
*	php_sql_token* token - the php_sql_token that will hold the string
*	string 	     - the token as the scanner founds it ( a char string)
*
*/
int make_token( YYSTYPE *token, char*string, int bison_token_type, int is_var )
{	
	zval *z_token;
	
	

    MAKE_STD_ZVAL(z_token); 
	array_init(z_token);

	//add_next_index_long(z_token, 0 );
	add_next_index_string(z_token, string, 1 );
	//add_next_index_long(z_token, token_num );
	add_next_index_long(z_token, is_var );
	
	//add_next_index_zval(tokensList, z_token );
	add_index_zval(tokensList, token_num, z_token);
	//add_next_index_string(tokensList, string, 1 );
		
	MAKE_STD_ZVAL((*token).token_index);
	ZVAL_LONG((*token).token_index, token_num);



	/*
	MAKE_STD_ZVAL((*token).token_index);
	array_init((*token).token_index); ///
	add_next_index_string((*token).token_index, string, 1 );
	add_next_index_long((*token).token_index, token_num );
	*/
	(*token).token_type=IS_TOKEN;
	
	token_num+=1;
	
	return bison_token_type;
}

