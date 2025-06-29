<?php
namespace WikiConnect\ParseWiki;

/**
 * Class ParserCategorys
 * @package WikiConnect\ParseWiki
 */
class ParserCategorys
{
    /**
     * @var array $categorys
     */
    private array $categorys;
    /**
     * @var string $namespace
     */
    private string $namespace;
    /**
     * @var string $text
     */
    private string $text;

    /**
     * ParserCategorys constructor.
     * @param string $text
     * @param string $namespace
     */
    public function __construct(string $text, string $namespace = "") {
        $this->text = $text;
        $this->namespace = $namespace == "" ? "Category" : $namespace;
        $this->categorys = array();
        $this->parse();
    }

    /**
     * Parse the text for categories
     */
    public function parse() : void
    {
        if (preg_match_all("\[\[\s*".$this->namespace."\s*\:([^\]\]]+?)\]\]", $this->text, $matches)) {
            foreach ($matches[1] as $nil => $mvalue) {
                $bleh = explode("|", $mvalue);
                $category = trim(array_shift($bleh));
                $bleh = null;
                $categories[md5($category)] = $category;
            }
        }

        if (!empty($categories)) {
            $this->categorys = $categories;
        }
    }

    /**
     * Get all categories found in the text
     * @return array
     */
    public function getCategorys() : array {
       return $this->categorys;
    }
}

