<?php

use PHPUnit\Framework\TestCase;
use WikiConnect\ParseWiki\ParserCitations;
use WikiConnect\ParseWiki\DataModel\Citation;

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
}