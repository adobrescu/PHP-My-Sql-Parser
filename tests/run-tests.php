<?php


header('Content-Type: text/html; charset=utf-8');




define('CONFIG_CACHE_DIR', __DIR__.'/cache');

echo '<pre>';


include_once('test-functions.inc.php');

$__testFiles=TEST_GET_TEST_FILES(__DIR__.'/unit-testing');


if(PHP_MINOR_VERSION>=4)
{
	$__testFiles=array_merge($__testFiles, TEST_GET_TEST_FILES(__DIR__.'/php-5.4'));
}

if(!$__testFiles)
{
	die('There are no test files in '.__DIR__);
}


ASSERT_INFO(false, true);
echo '<div style="padding-top: 400px; border: 5px green solid;">';
foreach($__testFiles as $testFile)
{
	//ASSERT_INFO(false, true);
	//echo str_replace('/', ' &raquo; ', preg_replace('/^[^$]+tests\//', '', $testFile))."\n".$testFile;
	include ($testFile);
	//ASSERT_INFO(true);
	//echo '------------------------------------------------------------------------------------------------------'."\n";
}
echo '</div>';
echo '<div style="position: relative; top: 0; border: 1px red solid; padding: 8px;">';

echo '</div>';
echo '<div style="position: relative; top: 0; border: 1px red solid; padding: 8px;">';
echo 'Num. test files: '.count($__testFiles)."\n";
ASSERT_INFO(true);
$testResults=ASSERT_INFO(false, false, true);

echo '</div>';

if($testResults['num_failed_assertions']==0)
{
	//header('Location: generate-php-5.3-no-traits.php');
}

