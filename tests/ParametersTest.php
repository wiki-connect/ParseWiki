<?php

use PHPUnit\Framework\TestCase;
use WikiConnect\ParseWiki\DataModel\Parameters;

class ParametersTest extends TestCase
{
    public function testGetSetHasDelete()
    {
        $parameters = new Parameters();
        $parameters->set('foo', 'bar');

        $this->assertTrue($parameters->has('foo'));
        $this->assertEquals('bar', $parameters->get('foo'));
        $this->assertEquals('', $parameters->get('nonexistent'));

        $parameters->delete('foo');
        $this->assertFalse($parameters->has('foo'));
    }

    public function testChangeParameterName()
    {
        $parameters = new Parameters(['old' => 'value']);
        $parameters->changeParameterName('old', 'new');

        $this->assertFalse($parameters->has('old'));
        $this->assertTrue($parameters->has('new'));
        $this->assertEquals('value', $parameters->get('new'));
    }

    public function testChangeMultipleParameterNames()
    {
        $parameters = new Parameters(['a' => '1', 'b' => '2']);
        $parameters->changeParametersNames(['a' => 'x', 'b' => 'y']);

        $this->assertTrue($parameters->has('x'));
        $this->assertTrue($parameters->has('y'));
        $this->assertEquals('1', $parameters->get('x'));
        $this->assertEquals('2', $parameters->get('y'));
    }

    public function testToStringVariants()
    {
        $params = new Parameters(['1' => 'val1', 'key' => 'val2']);
        $this->assertEquals('|val1|key=val2', $params->toString());

        $expectedMulti = "|val1\n|key=val2";
        $this->assertEquals($expectedMulti, $params->toString(0, true));
    }

    public function testToStringWithLjust()
    {
        $params = new Parameters(['a' => '1', 'bb' => '2']);
        $out = $params->toString(3);

        $this->assertStringContainsString('|a  =1', $out);
        $this->assertStringContainsString('|bb =2', $out);
    }
}
