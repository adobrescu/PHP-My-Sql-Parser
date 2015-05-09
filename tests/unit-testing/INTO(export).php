<?php

$exportINTOs=array(
	'INTO   OUTFILE ',
	//'INTO	DUMPFILE',
	//'INTO'
	
);

$exportElements=array(
	'LINES',
	'FIELDS',
	'COLUMNS',
	
);

$exportOptions=array(
	'TERMINATED		BY',
	'OPTIONALLY ENCLOSED BY',
	'ENCLOSED BY',
	'ESCAPED BY',
	'STARTING BY',
	
);

foreach ( $exportINTOs as $exportINTO)
{
	foreach($exportElements as $exportElement)
	{
		foreach($exportOptions as $exportOption)
		{
			$query='SELECT `database`.`table`.`column` FROM tbl123 '.$exportINTO.'';
			
			if($exportINTO=='INTO')
			{
				$query .= ' @fld, @fld2';
			}
			else
			{
				$query .=' \'filename\' '.$exportElement.' '.$exportOption.' \'CHAR\'';
			}
			
			
			testQuery($query);
		}
		
	}
}
