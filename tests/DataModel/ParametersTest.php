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
    public function testChangeParameterNamePreservesOrder()
    {
        $parameters = new Parameters(['a' => '1', 'b' => '2', 'c' => '3']);
        $parameters->changeParameterName('b', 'bb');

        $this->assertEquals(['a' => '1', 'bb' => '2', 'c' => '3'], $parameters->getParameters());
    }

    public function testChangeParameterNameNoEffectIfKeyNotFound()
    {
        $parameters = new Parameters(['x' => '1']);
        $parameters->changeParameterName('y', 'z'); // "y" not present

        $this->assertTrue($parameters->has('x'));
        $this->assertEquals(['x' => '1'], $parameters->getParameters());
    }

    public function testChangeParametersNamesPreservesOrderAndPartialRename()
    {
        $parameters = new Parameters(['one' => '1', 'two' => '2', 'three' => '3']);
        $parameters->changeParametersNames(['two' => 'dos', 'three' => 'tres']);

        $this->assertEquals(['one' => '1', 'dos' => '2', 'tres' => '3'], $parameters->getParameters());
    }

    public function testChangeParametersNamesWithOverlap()
    {
        $parameters = new Parameters(['a' => 'x', 'b' => 'y', 'c' => 'z']);
        $parameters->changeParametersNames(['a' => 'b']); // overwrites original 'b'

        // Final result should have only one 'b' (with value of 'a'), and 'c' stays
        $this->assertEquals(['b' => 'x', 'c' => 'z'], $parameters->getParameters());
        $this->assertEquals('x', $parameters->get('b'));
        $this->assertEquals('z', $parameters->get('c'));
    }

    public function testChangeParameterNameToExistingKey()
    {
        $parameters = new Parameters(['foo' => '123', 'bar' => '456']);
        $parameters->changeParameterName('foo', 'bar'); // 'foo' becomes 'bar' → overwrite

        $this->assertTrue($parameters->has('bar'));
        $this->assertFalse($parameters->has('foo'));
        $this->assertEquals('123', $parameters->get('bar')); // Overwritten value
    }
}
