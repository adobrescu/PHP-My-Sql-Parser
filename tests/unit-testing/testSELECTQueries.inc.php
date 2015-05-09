<?php

function testSELECTQueries($selectExprs, $tblReferences, $wheres, $groupBys)
{
	static $parser=null;
	if(is_null($parser))
	{
		$parser=new \alib\utils\SqlParser();
	}
	
	$selectExprList='';
	
	foreach($selectExprs as $selectExpr)
	{
		if (!$selectExpr)
		{
			continue;
		}

		$selectExprList.=($selectExprList?',':'').$selectExpr;
		if (!is_array($tblReferences))
		{
			$tblReferences=array('');
		}
		if(!is_array($wheres))
		{
			$wheres=array('');
		}
		if (!is_array($groupBys))
		{
			$groupBys=array('');
		}
		foreach($tblReferences as $tblReference)
		{

			foreach ($wheres as $where)
			{
				foreach($groupBys as $groupBy)
				{
					
					if($where)
					{
						
						$appendWhere='c=d AND id ';
						
						$query2='seLect '.$selectExprList.($tblReference?' FROM '.$tblReference:'');
						
						
						$parser->parse($query2);
						
						$parser->appendWhere($appendWhere, 'AND');
						$rebuiltQuery=$parser->rebuildSource();
						
						ASSERT_EQUALS(preg_replace('/[\s]+/', '', 'seLect '.$selectExprList.($tblReference?' FROM '.$tblReference:'').' WHERE ('.$appendWhere.')'), preg_replace('/[\s]+/', '', $rebuiltQuery));
						
						 /////
						
						$query2='seLect '.$selectExprList.($tblReference?' FROM '.$tblReference:'').' WHERE '.$where;
						//$query2='seLect '.$selectExprList.($tblReference?' FROM '.$tblReference:'');//.' WHERE '.$where;
						
						$parser->parse($query2);
						
						$parser->appendWhere($appendWhere, 'AND');
						$parser->appendWhere($appendWhere, 'OR');
						$rebuiltQuery=$parser->rebuildSource();
						
						if(!ASSERT_EQUALS(preg_replace('/[\s]+/', '', 'seLect '.$selectExprList.($tblReference?' FROM '.$tblReference:'').' WHERE (('.$where.')AND ('.$appendWhere.'))OR ('.$appendWhere.')'), preg_replace('/[\s]+/', '', $rebuiltQuery)))
						{
							die('seLect '.$selectExprList.($tblReference?' FROM '.$tblReference:'').' WHERE (('.$where.')AND ('.$appendWhere.'))or ('.$appendWhere.')<br>'.$rebuiltQuery);
						}
						
					}
					
					$query='seLect '.$selectExprList.($tblReference?' FROM '.$tblReference:'').($where?' WHERE '.$where:'').($groupBy?' GROUP    BY '.$groupBy.' HAVING max(id)<=100 ':'').'  ORDER BY (select id55 from tbl1234) limit 10 offSET 100 procedure func((select 1), "axxa") ';
					testQuery($query, $hasWhere=$where?true:false, $hasGroupBy=$groupBy?true:false, $hasHaving=true, $hasOrderBy=true, $hasLimit=true);
					
					
				}
			}
		}
	}
}
