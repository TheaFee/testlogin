<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class BaseViewTest extends TestCase
{
    public function testSetVars()
    {
		$reflector = new ReflectionClass( "\Classes\View\BaseView" );
		$property = $reflector->getProperty( "vars" );
		$property->setAccessible( true );
       
        $test = new \Classes\View\BaseView('.', 'index', 'index');

        $arr = ['foo'=>'bar', 'a'=>'b'];
        $test->setVars($arr);
        
        $this->assertSame($arr, $property->getValue($test));


    }
}

