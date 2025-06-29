<?php

namespace WikiConnect\ParseWiki;

/**
 * Class ParserCategories
 * @package WikiConnect\ParseWiki
 */
class ParserCategories
{
    /**
     * @var array<string, string> $categories
     */
    private array $categories = [];

    /**
     * @var string $namespace
     */
    private string $namespace;

    /**
     * @var string $text
     */
    private string $text;

    /**
     * ParserCategories constructor.
     * @param string $text
     * @param string $namespace
     */
    public function __construct(string $text, string $namespace = "")
    {
        $this->text = $text;
        $this->namespace = $namespace !== "" ? $namespace : "Category";
        $this->parse();
    }

    /**
     * Parse the text for categories.
     */
    public function parse(): void
    {
        $categories = [];

        $pattern = '/\[\[\s*' . preg_quote($this->namespace, '/') . '\s*:\s*([^\]\|]+)(?:\|[^\]]*)?\s*\]\]/u';

        if (preg_match_all($pattern, $this->text, $matches)) {
            foreach ($matches[1] as $category) {
                $category = trim($category);
                $categories[md5($category)] = $category;
            }
        }

        if (!empty($categories)) {
            $this->categories = $categories;
        }
    }

    /**
     * Get all categories found in the text.
     * @return array<string, string>
     */
    public function getCategories(): array
    {
        return $this->categories;
    }
}
