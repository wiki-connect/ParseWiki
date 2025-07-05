<?php

use PHPUnit\Framework\TestCase;
use WikiConnect\ParseWiki\DataModel\Attribute;

class AttributeTest extends TestCase
{
    public function testParsingAttributes()
    {
        $attrText = 'name=\'foo\' group="bar"';
        $attribute = new Attribute($attrText);

        $array = $attribute->getAttributesArray();

        $this->assertIsArray($array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('group', $array);
        $this->assertEquals('\'foo\'', $array['name']);
        $this->assertEquals('"bar"', $array['group']);
    }

    public function testHasAndGet()
    {
        $attribute = new Attribute('name="source"');

        $this->assertTrue($attribute->has('name'));
        $this->assertFalse($attribute->has('group'));
        $this->assertEquals('"source"', $attribute->get('name'));
        $this->assertEquals('default', $attribute->get('group', 'default'));
    }

    public function testSetAndDelete()
    {
        $attribute = new Attribute('name="source"');

        $attribute->set('group', '"bar"');
        $this->assertTrue($attribute->has('group'));
        $this->assertEquals('"bar"', $attribute->get('group'));

        $attribute->delete('group');
        $this->assertFalse($attribute->has('group'));
    }

    public function testToString()
    {
        $attribute = new Attribute('name="x" group="y"');
        $expected1 = 'name="x" group="y"';
        $expected2 = 'group="y" name="x"'; // order not guaranteed

        $this->assertContains($attribute->toString(), [$expected1, $expected2]);
    }

    public function testsetContent()
    {
        $attribute = new Attribute('name="old"');
        $attribute->setContent('id="new"');

        $this->assertFalse($attribute->has('name'));
        $this->assertTrue($attribute->has('id'));
        $this->assertEquals('"new"', $attribute->get('id'));
    }
    public function testComplexAttributeParsing()
    {
        $attrText = "name=SPS2022 group='12' g 44=\"rt'\" 344=!23{{23}} po='grp=11'";
        $attribute = new Attribute($attrText);
        $array = $attribute->getAttributesArray();

        $this->assertArrayHasKey('name', $array);
        $this->assertEquals('SPS2022', $array['name']);

        $this->assertArrayHasKey('group', $array);
        $this->assertEquals("'12'", $array['group']);

        $this->assertArrayHasKey('g', $array);
        $this->assertEquals('', $array['g']);

        $this->assertArrayHasKey('44', $array);
        $this->assertEquals("\"rt'\"", $array['44']);

        $this->assertArrayHasKey('344', $array);
        $this->assertEquals('!23{{23}}', $array['344']);

        $this->assertArrayHasKey('po', $array);
        $this->assertEquals("'grp=11'", $array['po']);

        $this->assertEquals('default', $attribute->get('missing', 'default'));
    }
}
