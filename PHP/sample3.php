<?php
 echo '<pre>';
	 include_once(__DIR__.'/lib/SqlParser.class.php');

define('CACHE_DIR', __DIR__.'/../tests/cache');
//276N173N205N313xNzGFBF241FBFBFgNBNGNBN313xNzGF241NBNBNgFBF323xNBNsxNBNtFBFBFzziOIFBFBF148ANxNBNz107178NxFBFBFgOzIFBFBFAF107ANBNBF107AO148213OAO253NxNsNAx276Dzz200DL.php
$query="SELECT fld 
				FROM tbl1 JOIN
					tbl2 USING(id)  
				RIGHT OUTER	JOIN `db`.`table` 
					ON `db`.`table`.`column`=tbl2.field12  INNER  JOIN db.tbl
					USING(db)		RIGHT JOIN `where` 
					on db.tbl.camp=`where`.`orderby`WHERE (tbl.id+(tbl2.camp-`db`.`table`.`column`))>=0
				GROUP BY `db`.`table`.`column` DESC, func(tbl2.camp) ASC
				HAVING MAX ( `db`.`table`.`column` = 10 )
				ORDER BY `select`.`from`.`having`, `procedure` ASC, db.tbl.`columns` ASC, 2 DESc
				LIMIT 10, 100
				PRoceDURE proc(a+b, (select 'abced\'efgh'))
				into 'filename' lock   IN	 SHARE MODE";
$query='SELECT *
	FROM tbl
	WHERE (a=1 AND b=10)';

$query='SELECT field From tbl ORDER BY a ASC LIMIT 30';
 $parser=new \alib\utils\SqlParser();
 $parser->parse($query);
 $parser->appendOrderBy(' (select 1) DESC, a ASC');
 
 //$parser->appendWhere('a=1', 'AND');// AND c>(1+s)');
echo $parser->rebuildSource();
 return;
 $query2=$parser->rebuildSource();
 $parseTree2=$parser->getParseTree();
 
 if($parseTree!=$parseTree2)
 {
	 die('error');
 }
 else
 {
	 echo 'success';
 }
 



