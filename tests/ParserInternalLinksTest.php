<?php

use PHPUnit\Framework\TestCase;
use WikiConnect\ParseWiki\ParserInternalLinks;
use WikiConnect\ParseWiki\DataModel\InternalLink;

class ParserInternalLinksTest extends TestCase
{
    public function testSingleSimpleInternalLink()
    {
        $text = 'This is a [[Page]] link.';
        $parser = new ParserInternalLinks($text);
        $links = $parser->getTargets();

        $this->assertCount(1, $links);
        $this->assertInstanceOf(InternalLink::class, $links[0]);
        $this->assertEquals('Page', $links[0]->getTarget());

    }

    public function testMultipleInternalLinks()
    {
        $text = 'Links: [[Page1]], [[Page2|Display2]], and [[Page3]].';
        $parser = new ParserInternalLinks($text);
        $links = $parser->getTargets();

        $this->assertCount(3, $links);
        $this->assertEquals('Page1', $links[0]->getTarget());
        $this->assertNotNull($links[0]->getText());
        $this->assertEquals('Page2', $links[1]->getTarget());
        $this->assertEquals('Display2', $links[1]->getText());
        $this->assertEquals('Page3', $links[2]->getTarget());
        $this->assertNotNull($links[2]->getText());
    }

    public function testInternalLinkWithDisplayText()
    {
        $text = 'See [[Main Page|the main page]].';
        $parser = new ParserInternalLinks($text);
        $links = $parser->getTargets();

        $this->assertCount(1, $links);
        $this->assertEquals('Main Page', $links[0]->getTarget());
        $this->assertEquals('the main page', $links[0]->getText());
    }

    public function testInternalLinksWithSpecialCharacters()
    {
        $text = 'Try [[A&B|A and B]] and [[C/D]].';
        $parser = new ParserInternalLinks($text);
        $links = $parser->getTargets();

        $this->assertCount(2, $links);
        $this->assertEquals('A&B', $links[0]->getTarget());
        $this->assertEquals('A and B', $links[0]->getText());
        $this->assertEquals('C/D', $links[1]->getTarget());
        $this->assertNotNull($links[1]->getText());
    }

    public function testNoInternalLinks()
    {
        $text = 'There are no links here.';
        $parser = new ParserInternalLinks($text);
        $links = $parser->getTargets();

        $this->assertIsArray($links);
        $this->assertCount(0, $links);
    }
}