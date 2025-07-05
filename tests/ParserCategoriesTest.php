<?php

use PHPUnit\Framework\TestCase;
use WikiConnect\ParseWiki\ParserCategories;

class ParserCategoriesTest extends TestCase
{
    public function testSingleCategory()
    {
        $text = 'Some text [[Category:Science]] more text.';
        $parser = new ParserCategories($text);
        $categories = $parser->getCategories();

        $this->assertCount(1, $categories);
        $this->assertContains('Science', $categories);
    }

    public function testMultipleCategories()
    {
        $text = '[[Category:Math]] and [[Category:Physics]]';
        $parser = new ParserCategories($text);
        $categories = $parser->getCategories();

        $this->assertCount(2, $categories);
        $this->assertContains('Math', $categories);
        $this->assertContains('Physics', $categories);
    }

    public function testCategoryWithDisplayText()
    {
        $text = '[[Category:Biology|Bio]]';
        $parser = new ParserCategories($text);
        $categories = $parser->getCategories();

        $this->assertCount(1, $categories);
        $this->assertContains('Biology', $categories);
    }

    public function testNoCategories()
    {
        $text = 'This text has no categories.';
        $parser = new ParserCategories($text);
        $categories = $parser->getCategories();

        $this->assertIsArray($categories);
        $this->assertCount(0, $categories);
    }

    public function testCustomNamespace()
    {
        $text = '[[Custom:TestCategory]]';
        $parser = new ParserCategories($text, 'Custom');
        $categories = $parser->getCategories();

        $this->assertCount(1, $categories);
        $this->assertContains('TestCategory', $categories);
    }

    public function testCategoryWithWhitespace()
    {
        $text = '[[  Category  :   SpaceCat   ]]';
        $parser = new ParserCategories($text);
        $categories = $parser->getCategories();

        $this->assertCount(1, $categories);
        $this->assertContains('SpaceCat', $categories);
    }

    public function testCategoryWithSpecialCharacters()
    {
        $text = '[[Category:Cat & Dog/2024]]';
        $parser = new ParserCategories($text);
        $categories = $parser->getCategories();

        $this->assertCount(1, $categories);
        $this->assertContains('Cat & Dog/2024', $categories);
    }
}
