<?php

use PHPUnit\Framework\TestCase;
use WikiConnect\ParseWiki\ParserCitations;
use WikiConnect\ParseWiki\DataModel\Citation;
use WikiConnect\ParseWiki\DataModel\Attribute;

class ParserCitationsTest extends TestCase
{
    public function testSingleCitation()
    {
        $text = 'Some text with a citation.<ref>Reference content</ref> More text.';
        $parser = new ParserCitations($text);
        $citations = $parser->getCitations();

        $this->assertCount(1, $citations);
        $this->assertInstanceOf(Citation::class, $citations[0]);
        $this->assertEquals('Reference content', $citations[0]->getContent());
    }

    public function testMultipleCitations()
    {
        $text = 'First<ref>First ref</ref> and second<ref>Second ref</ref>.';
        $parser = new ParserCitations($text);
        $citations = $parser->getCitations();

        $this->assertCount(2, $citations);
        $this->assertEquals('First ref', $citations[0]->getContent());
        $this->assertEquals('Second ref', $citations[1]->getContent());
    }

    public function testCitationWithAttributes()
    {
        $text = 'Text<ref name="foo" group="bar">Attr ref</ref> end.';
        $parser = new ParserCitations($text);
        $citations = $parser->getCitations();

        $this->assertCount(1, $citations);
        $this->assertStringContainsString('name="foo"', $citations[0]->getAttributes());
        $this->assertStringContainsString('group="bar"', $citations[0]->getAttributes());
        $this->assertEquals('Attr ref', $citations[0]->getContent());
    }

    public function testNoCitations()
    {
        $text = 'This text has no citations.';
        $parser = new ParserCitations($text);
        $citations = $parser->getCitations();

        $this->assertIsArray($citations);
        $this->assertCount(0, $citations);
    }

    public function testCitationWithSpecialCharacters()
    {
        $text = 'Text<ref>Content with <b>HTML</b> & special chars!</ref> end.';
        $parser = new ParserCitations($text);
        $citations = $parser->getCitations();

        $this->assertCount(1, $citations);
        $this->assertEquals('Content with <b>HTML</b> & special chars!', $citations[0]->getContent());
    }
    public function testAttributeParsingFromCitation()
    {
        $text = 'Text<ref name="test" group="alpha">Some content</ref>';
        $parser = new ParserCitations($text);
        $citations = $parser->getCitations();

        $this->assertCount(1, $citations);

        $attrs = $citations[0]->Attrs();

        $this->assertInstanceOf(Attribute::class, $attrs);
        $this->assertTrue($attrs->has('name'));
        $this->assertTrue($attrs->has('group'));
        $this->assertEquals('"test"', $attrs->get('name'));
        $this->assertEquals('"alpha"', $attrs->get('group'));

        $toStr = $attrs->toString();
        $this->assertStringContainsString('name="test"', $toStr);
        $this->assertStringContainsString('group="alpha"', $toStr);
    }
    public function testSelfClosingCitationTag()
    {
        $text = 'Some text before <ref name="test" group="alpha" novalue novalue2/> and after.';
        $parser = new ParserCitations($text);
        $citations = $parser->getCitations();

        $this->assertCount(1, $citations);

        $citation = $citations[0];

        // تحقق من عدم وجود محتوى داخل الوسم
        $this->assertEquals('', $citation->getContent());

        // تحقق من السمات
        $this->assertStringContainsString('name="test"', $citation->getAttributes());
        $this->assertStringContainsString('group="alpha"', $citation->getAttributes());

        // تحقق من السمات ككائن Attribute
        $attrs = $citation->Attrs();
        $this->assertTrue($attrs->has('name'));
        $this->assertEquals('"test"', $attrs->get('name'));
        $this->assertEquals('"alpha"', $attrs->get('group'));
        $this->assertEquals('', $attrs->get('novalue2'));

        $attrs->set('novalue2', 'new');
        $this->assertEquals('new', $attrs->get('novalue2'));
    }
}
