<?php

function &ASSERT_INFO($print=false, $reset=false, $printTotal=false)
{
	static $__ASSERTIONS=null, $__TOTAL_ASSERTIONS=null;
	$memParam=false;
	if (is_null($__TOTAL_ASSERTIONS))
	{
		$__TOTAL_ASSERTIONS=array(
			'START_MEM_USAGE' => memory_get_usage($memParam),
			'END_MEM_USAGE' => memory_get_usage($memParam),
			'START_TIME' => time(),
			'END_TIME' => time(),
			'TIME' => 0,
			'START_MICROTIME'=>microtime(true),
			'END_MICROTIME'=>microtime(true),
			'MICROTIME' => 0,
			'num_assertions' => 0,
			'num_failed_assertions' => 0,
			'failedAssertions' => array(),
			'assertions' => array()
			);
	}
	if (is_null($__ASSERTIONS) || $reset || $printTotal)
	{
		if (!is_null($__ASSERTIONS))
		{
			$__TOTAL_ASSERTIONS['num_assertions']+=$__ASSERTIONS['num_assertions'];
			$__TOTAL_ASSERTIONS['num_failed_assertions']+=$__ASSERTIONS['num_failed_assertions'];
			$__TOTAL_ASSERTIONS['failedAssertions']+=$__ASSERTIONS['failedAssertions'];
		}
		$__ASSERTIONS=array(
			'START_MEM_USAGE' => memory_get_usage($memParam),
			'END_MEM_USAGE' => memory_get_usage($memParam),
			'CUSTOM_INFO' => array(),
			'START_TIME' => time(),
			'END_TIME' => time(),
			'TIME' => 0,
			'START_MICROTIME'=>microtime(true),
			'END_MICROTIME'=>microtime(true),
			'MICROTIME' => 0,
			'num_assertions' => 0,
			'num_failed_assertions' => 0,
			'failedAssertions' => array(),
			'assertions' => array()
			);
	}
	
	if ($print)
	{
		$info=&$__ASSERTIONS;
	}
	elseif($printTotal)
	{
		$msg='Total';
		$info=&$__TOTAL_ASSERTIONS;
	}
	else
	{
		$info=null;
	}
	
	if($info)
	{
		if (isset($msg))
		{
			echo $msg."\n";
		}
		$info['END_MEM_USAGE']=memory_get_usage($memParam);
		$info['MEM_USAGE']=$info['END_MEM_USAGE']-$info['START_MEM_USAGE'];
		
		$info['END_TIME']=time();
		$info['TIME']=$info['END_TIME']-$info['START_TIME'];
		$info['END_MICROTIME']=microtime(true);
			
		$info['MICROTIME']=$info['END_MICROTIME']-$info['START_MICROTIME'];
		$info['START_MICROTIME']=$info['END_MICROTIME'];
		$info['START_TIME']=$info['END_TIME'];
		
		echo '<pre>';
		echo 'Mem.:'.$info['MEM_USAGE']."\n";
		echo 'Time: '.$info['TIME'].' ('.$info['MICROTIME'].')'."\n";
		echo 'Num. assertions: '.$info['num_assertions']."\n".($info['num_failed_assertions']?'<span style="color: red; font-weight: bold;">Num. failed assertions: '.$info['num_failed_assertions'].'</span>':'')."\n";
		
		if ($info['assertions'])
		{
			
			foreach ($info['assertions'] as $assertion)
			{
				if ($assertion['status']!='failed')
				{
					continue;
				}
				if (!isset($infoOut))
				{
					echo "\n".'Failed assertions: '."\n\n".'<hr>';
					$infoOut=true;
				}
				echo "\n".$assertion['msg']."\n";
				echo 'File: '.$assertion['file']."\n";
				echo 'Line: '.$assertion['line']."\n\n".'<hr>';
			}
		}
		
		echo '</pre>';
	}
	if($printTotal)
	{
		return $__TOTAL_ASSERTIONS;
	}
	else
	{
		return $__ASSERTIONS;
	}
}
function ADD_ASSERTION($cond, $expectedValue, $receivedValue=null)
{
	$__ASSERTIONS=&ASSERT_INFO();
	
	$backtrace=debug_backtrace();
	
	$__ASSERTIONS['num_assertions']++;
	
	if (!$cond)
	{
		$__ASSERTIONS['num_failed_assertions']++;
	}
	
	$__ASSERTIONS['assertions'][]=
			array(
				'status' => $cond ? 'success':'failed',
				'msg' => 'Expected: '.print_r($expectedValue, true).("\n".'Received: '.print_r($receivedValue, true).(is_null($receivedValue)?'null':'')),
				'file' => $backtrace[1]['file'],
				'line' => $backtrace[1]['line']
				);
	
	return $cond;
}
function ASSERT_TRUE($boolCond)
{
	ADD_ASSERTION($boolCond, 'TRUE', 'FALSE');
}
function ASSERT_FALSE($boolCond)
{
	ADD_ASSERTION(!$boolCond, 'FALSE', 'TRUE');
}
function ASSERT_EQUALS($expectedValue, $receivedValue)
{
	return ADD_ASSERTION($expectedValue==$receivedValue, $expectedValue, $receivedValue);
}
function ASSERT_IDENTICAL($expectedValue, $receivedValue)
{
	ADD_ASSERTION($expectedValue===$receivedValue, $expectedValue, $receivedValue);
}
function ASSERT_MSG($boolCond, $msg)
{
	ADD_ASSERTION($boolCond, $msg);
}
function ASSERT_CLASS_IMPLEMENTS_PROPERTY($className, $propertyName)
{
	try
	{
		$reflectionClass=new ReflectionClass($className);
	}
	catch(Exception $err)
	{
		ADD_ASSERTION(1==0, $className.' class', 'class does not exist');
		return;
	}
	try
	{
		if ($property=$reflectionClass->getProperty($propertyName))
		{
			ADD_ASSERTION($property->getDeclaringClass()->getName()==$className, $className.' to implement '.$propertyName.' property<br>'.$className.' is declared in '.$reflectionClass->getFileName());
		}
	}
	catch(ReflectionException $err)
	{
		ADD_ASSERTION(1==0, $className.'::$'.$propertyName.' property', 'property does not exist');
	}
}
function ASSERT_CLASS_INITED($className)
{
	ASSERT_CLASS_IMPLEMENTS_PROPERTY($className, '___schema');
}
function ASSERT_CLASS_DOESNT_IMPLEMENTS_METHOD($className, $methodName)
{
	try
	{
		$reflectionClass=new ReflectionClass($className);
	}
	catch(Exception $err)
	{
		ADD_ASSERTION(1==0, $className.' class', 'class does not exist');
		return;
	}
	try
	{
		if ($method=$reflectionClass->getMethod($methodName))
		{
			$declaringClass=$method->getDeclaringClass();
			ADD_ASSERTION(!($declaringClass->getName()==$className &&
					$method->getFileName()==$reflectionClass->getFileName() &&
					$method->getStartLine()>=$reflectionClass->getStartLine() &&
					$method->getEndLine()<=$reflectionClass->getEndLine())
					,
					$className.' to NOT implement '.$methodName.' method<br>'.$className.' is declared in '.$reflectionClass->getFileName());
		}
	}
	catch(ReflectionException $err)
	{
		ADD_ASSERTION(1==0, $className.'::'.$methodName.' method', 'method does not exist');
	}
}
function ASSERT_CLASS_IMPLEMENTS_METHOD($className, $methodName)
{
	try
	{
		$reflectionClass=new ReflectionClass($className);
	}
	catch(Exception $err)
	{
		ADD_ASSERTION(1==0, $className.' class', 'class does not exist');
		return;
	}
	try
	{
		if ($method=$reflectionClass->getMethod($methodName))
		{
			$declaringClass=$method->getDeclaringClass();
			ADD_ASSERTION($declaringClass->getName()==$className &&
					$method->getFileName()==$reflectionClass->getFileName() &&
					$method->getStartLine()>=$reflectionClass->getStartLine() &&
					$method->getEndLine()<=$reflectionClass->getEndLine()
					,
					$className.' to implement '.$methodName.' method<br>'.$className.' is declared in '.$reflectionClass->getFileName());
		}
	}
	catch(ReflectionException $err)
	{
		ADD_ASSERTION(1==0, $className.'::'.$methodName.' method', 'method does not exist');
	}
}

function ASSERT_CLASSES_METHOD_HAVE_SAME_CODE($className1, $className2, $methodName)
{
	$classSource1=new \alib\utils\PHPMethodSource($className1, $methodName);
	$classSource2=new \alib\utils\PHPMethodSource($className2, $methodName);
	
	$source1=$classSource1->getSource();
	$source2=$classSource2->getSource();
	
	ADD_ASSERTION($source1==$source2, $source1, $source2);
	
	
}
function ASSERT_IN_ARRAY($value, $array)
{
	ADD_ASSERTION(array_key_exists($value, $array), 'Array key: '.$value, $array);
}
function TEST_GET_TEST_FILES($dirName, $return=true)
{
	static $testFiles=null;
	
	if($return)
	{
		$testFiles=array();
	}
	//$return=is_null($testFiles);
	
	if ($files=glob($dirName.'/*.test.php'))
	{
		foreach($files as $file)
		{
			$testFiles[]=$file;
		}
	}
	
	if ($dirs=glob($dirName.'/*', GLOB_ONLYDIR))
	{
		foreach($dirs as $dir)
		{
			TEST_GET_TEST_FILES($dir, false);
		}
	}
	
	if ($return)
	{
		return $testFiles;
	}
	
}
function class_uses_all($class, $autoload = true)
    {
        $traits = [];

        // Get traits of all parent classes
        do {
            $traits = array_merge(class_uses($class, $autoload), $traits);
        } while ($class = get_parent_class($class));

        // Get traits of all parent traits
        $traitsToSearch = $traits;
        while (!empty($traitsToSearch)) {
            $newTraits = class_uses(array_pop($traitsToSearch), $autoload);
            $traits = array_merge($newTraits, $traits);
            $traitsToSearch = array_merge($newTraits, $traitsToSearch);
        };

        foreach ($traits as $trait => $same) {
            $traits = array_merge(class_uses($trait, $autoload), $traits);
        }

        return array_unique($traits);
    }
function trace($var, $exit=false, $forcePre=false)
{
	$debugTrace=debug_backtrace();
	$maxFctName=0;
	foreach ($debugTrace as $i=>$debug)
	{
		$functionName=(isset($debug['class'])?$debug['class'].'::':'').$debug['function'];
		if(strlen($functionName)>$maxFctName)
		{
			$maxFctName=strlen($functionName);
		}
	}
	if($exit)
	{
		//ob_end_clean();
		foreach ($debugTrace as $i=>$debug)
		{
			if ($i==0)
			{
				continue;
			}
			$functionName=($debug['class']?$debug['class'].'::':'').$debug['function'];
			$debugInfo .= $debug['line'].str_repeat(' ', 6-strlen($debug['line'])).': '.($functionName?$functionName.str_repeat(' ', $maxFctName-strlen($functionName)):'').' : '.$debug['file'];
			$argNum=1;

			$argNum++;
			$debugInfo.="\n";
		}
	}
	if (!isset($_GET['ajx']) || $forcePre)
	{
		echo '<pre>';
	}
	if (is_array($var) || is_object($var))
	{
		print_r($var);
		if ($exit) echo "\n".$debugInfo;
	}
	else
	{
		print_r(nl2br($var));
		if($exit)
		{
			echo "\n".$debugInfo;
		}
	}
    if (!isset($_GET['ajx']) || $forcePre)
    {
		echo '</pre><hr>';
    }
    if ($exit)
    {
		exit();
    }
}
function trimAll($str, $toLowerCase=false)
{
	if($toLowerCase)
	{
		$str=strtolower($str);
	}
	return preg_replace('/[\\s]+/', '', $str);
}