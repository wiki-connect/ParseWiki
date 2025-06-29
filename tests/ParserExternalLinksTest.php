<?php

use PHPUnit\Framework\TestCase;
use WikiConnect\ParseWiki\ParserExternalLinks;
use WikiConnect\ParseWiki\DataModel\ExternalLink;

class ParserExternalLinksTest extends TestCase
{
    public function testSingleExternalLinkWithLabel()
    {
        $text = 'This is a [https://example.com Example Site] link.';
        $parser = new ParserExternalLinks($text);
        $links = $parser->getLinks();

        $this->assertCount(1, $links);
        $this->assertInstanceOf(ExternalLink::class, $links[0]);
        $this->assertEquals('https://example.com', $links[0]->getLink());
        $this->assertEquals('Example Site', $links[0]->getText());
    }

    public function testMultipleExternalLinks()
    {
        $text = 'Links: [https://a.com A] and [https://b.org B].';
        $parser = new ParserExternalLinks($text);
        $links = $parser->getLinks();

        $this->assertCount(2, $links);
        $this->assertEquals('https://a.com', $links[0]->getLink());
        $this->assertEquals('A', $links[0]->gettext());
        $this->assertEquals('https://b.org', $links[1]->getlink());
        $this->assertEquals('B', $links[1]->gettext());
    }

    public function testExternalLinkWithoutLabel()
    {
        $text = 'Visit [https://nolabel.com] for more info.';
        $parser = new ParserExternalLinks($text);
        $links = $parser->getLinks();

        $this->assertCount(1, $links);
        $this->assertEquals('https://nolabel.com', $links[0]->getlink());
        $this->assertEquals('', $links[0]->gettext());
    }

    public function testNoExternalLinks()
    {
        $text = 'There are no links here.';
        $parser = new ParserExternalLinks($text);
        $links = $parser->getLinks();

        $this->assertCount(0, $links);
    }

    public function testExternalLinkWithWhitespaceAndLineBreaks()
    {
        $text = "Check this:\n[https://foo.com   Foo Bar]\nAnd this:\n[https://bar.com\nBar Site]";
        $parser = new ParserExternalLinks($text);
        $links = $parser->getLinks();

        $this->assertCount(2, $links);
        $this->assertEquals('https://foo.com', $links[0]->getlink());
        $this->assertEquals('Foo Bar', $links[0]->gettext());
        $this->assertEquals('https://bar.com', $links[1]->getlink());
        $this->assertEquals('Bar Site', $links[1]->gettext());
    }
}