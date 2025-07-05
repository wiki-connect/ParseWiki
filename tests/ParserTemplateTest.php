<?php

use PHPUnit\Framework\TestCase;
use WikiConnect\ParseWiki\ParserTemplate;
use WikiConnect\ParseWiki\DataModel\Template;
use WikiConnect\ParseWiki\DataModel\Parameters;

class ParserTemplateTest extends TestCase
{
    public function testSimpleTemplate()
    {
        $templateText = '{{Infobox person|name=John Doe|birth_date=1990-01-01}}';
        $parser = new ParserTemplate($templateText);
        $template = $parser->getTemplate();

        $this->assertInstanceOf(Template::class, $template);
        $this->assertEquals('Infobox person', $template->getName());
        $params = $template->getParameters();
        $this->assertEquals('John Doe', $params['name']);
        $this->assertEquals('1990-01-01', $params['birth_date']);
    }

    public function testTemplateWithUnnamedParameter()
    {
        $templateText = '{{Coord|12.66|56.88|type=city}}';
        $parser = new ParserTemplate($templateText);
        $template = $parser->getTemplate();

        $params = $template->getParameters();
        $this->assertEquals('12.66', $params[1]);
        $this->assertEquals('56.88', $params[2]);
        $this->assertEquals('city', $params['type']);
    }

    public function testTemplateWithNestedTemplate()
    {
        $templateText = '{{Infobox|data={{Nested|a=1|b=2}}|other=val}}';
        $parser = new ParserTemplate($templateText);
        $template = $parser->getTemplate();

        $params = $template->getParameters();
        $this->assertStringContainsString('{{Nested|a=1|b=2}}', $params['data']);
        $this->assertEquals('val', $params['other']);
    }

    public function testTemplateWithoutParameters()
    {
        $templateText = '{{JustTemplate}}';
        $parser = new ParserTemplate($templateText);
        $template = $parser->getTemplate();

        $this->assertEquals('JustTemplate', $template->getName());
        $this->assertEmpty($template->getParameters());
    }

    public function testTemplateWithLinks()
    {
        $templateText = '{{Infobox|name=[[John Doe]]|link=[[Page|Label]]}}';
        $parser = new ParserTemplate($templateText);
        $template = $parser->getTemplate();

        $params = $template->getParameters();
        $this->assertEquals('[[John Doe]]', $params['name']);
        $this->assertEquals('[[Page|Label]]', $params['link']);
    }

    public function testParameterWithEqualsInValue()
    {
        $templateText = '{{Example|key=1+1=2}}';
        $parser = new ParserTemplate($templateText);
        $template = $parser->getTemplate();

        $params = $template->getParameters();
        $this->assertEquals('1+1=2', $params['key']);
    }

    public function testParameterWithSpacesInName()
    {
        $templateText = '{{Test| first name =John | last name = Doe }}';
        $parser = new ParserTemplate($templateText);
        $template = $parser->getTemplate();

        $params = $template->getParameters();
        $this->assertEquals('John', $params['first name']);
        $this->assertEquals('Doe', $params['last name']);
    }

    public function testOverwrittenDuplicateParameter()
    {
        $templateText = '{{T|x=1|x=2}}';
        $parser = new ParserTemplate($templateText);
        $template = $parser->getTemplate();
        $params = $template->getParameters();

        // "x=2" should overwrite "x=1"
        $this->assertEquals('2', $params['x']);
    }

    public function testParameterOrderPreservation()
    {
        $templateText = '{{T|first=1|second=2|third=3}}';
        $parser = new ParserTemplate($templateText);
        $template = $parser->getTemplate();
        $params = array_keys($template->getParameters());

        $this->assertEquals(['first', 'second', 'third'], $params);
    }
    public function testAccessingParametersObjectMethods()
    {
        $templateText = '{{Test|foo=bar|hello=world}}';
        $parser = new ParserTemplate($templateText);
        $template = $parser->getTemplate();

        // Parameters object
        $params = $template->parameters;

        $this->assertInstanceOf(Parameters::class, $params);
        $this->assertTrue($params->has('foo'));
        $this->assertEquals('bar', $params->get('foo'));

        // Modify a parameter
        $params->set('foo', 'baz');
        $this->assertEquals('baz', $params->get('foo'));

        // Delete a parameter
        $params->delete('hello');
        $this->assertFalse($params->has('hello'));
    }

    public function testToStringReflectsParameterChanges()
    {
        $templateText = '{{MyBox|key1=val1|key2=val2}}';
        $template = (new ParserTemplate($templateText))->getTemplate();

        // Modify parameters
        $template->parameters->set('key2', 'changed');
        $template->parameters->delete('key1');

        // toString reflects the changes
        $str = $template->toString();
        $this->assertStringNotContainsString('key1=val1', $str);
        $this->assertStringContainsString('key2=changed', $str);
    }

    public function testToStringWithLjustViaTemplate()
    {
        $templateText = '{{Box|a=1|bb=2}}';
        $template = (new ParserTemplate($templateText))->getTemplate();

        $output = $template->toString(false, 3); // ljust = 3

        $this->assertStringContainsString('|a  =1', $output);
        $this->assertStringContainsString('|bb =2', $output);
    }
    public function testChangeParameterNameThroughTemplate()
    {
        $templateText = '{{Test|a=1|b=2}}';
        $template = (new ParserTemplate($templateText))->getTemplate();

        $parameters = $template->parameters;

        $parameters->changeParameterName('a', 'x');

        $this->assertFalse($parameters->has('a'));
        $this->assertTrue($parameters->has('x'));
        $this->assertEquals('1', $parameters->get('x'));
    }
    public function testChangeParameterNamesThroughTemplate()
    {
        $templateText = '{{Test|a=x|b=y|c=z}}';
        $template = (new ParserTemplate($templateText))->getTemplate();
        $parameters = $template->parameters;

        $this->assertTrue($parameters->has('a'));
        $this->assertEquals('x', $parameters->get('a'));

        $parameters->changeParametersNames(['a' => 'b']);

        // Final result should have only one 'b' (with value of 'a'), and 'c' stays
        $this->assertEquals(['b' => 'x', 'c' => 'z'], $parameters->getParameters());
        $this->assertEquals('x', $parameters->get('b'));
        $this->assertEquals('z', $parameters->get('c'));
    }
}
