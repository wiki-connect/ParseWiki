<?php

namespace WikiConnect\ParseWiki;

use WikiConnect\ParseWiki\DataModel\Template;

/**
 * Class ParserTemplates
 *
 * Parse a text and extract all Templates.
 *
 * @package WikiConnect\ParseWiki
 */
class ParserTemplates
{
    /**
     * The text to parse.
     *
     * @var string
     */
    private string $text;

    /**
     * The templates found in the text.
     *
     * @var Template[]
     */
    private array $templates;

    /**
     * Constructor.
     *
     * @param string $text The text to parse.
     */
    public function __construct(string $text)
    {
        $this->text = $text;
        $this->templates = [];
        $this->parse();
    }

    /**
     * Find all templates in the given string.
     *
     * The regex pattern is a recursive pattern that matches templates
     * with any level of nesting.
     *
     * @param string $string The string to search for templates.
     *
     * @return array An array with the matches. The first element is an
     * array of all matches, the second element is an array of the
     * matches with the first two and last two characters removed.
     */
    private function find_sub_templates(string $string): array
    {
        $pattern = "/(\{{2}((?>[^\{\}]+)|(?R))*\}{2})/xm";
        preg_match_all($pattern, $string, $matches, PREG_SET_ORDER);

        return $matches;
    }

    /**
     * Parse a text and extract all Templates.
     *
     * This function is called by the constructor. It parses the
     * text and extracts all templates. Then it calls itself
     * recursively for each template found.
     */
    public function parse(): void
    {
        $text_templates = $this->find_sub_templates($this->text);

        foreach ($text_templates as $match) {
            $text_template = $match[0]; // Full match
            $_parser = new ParserTemplate($text_template);
            $this->templates[] = $_parser->getTemplate();

            $text_template2 = trim($text_template);

            // remove first 2 litters and 2 last
            $text_template2 = substr($text_template2, 2, -2);

            $this->parse_sub($text_template2);
        }
    }

    /**
     * Parse a text and extract all Templates.
     *
     * This function is called by the parse function. It parses
     * a text and extracts all templates. Then it calls itself
     * recursively for each template found.
     *
     * @param string $text The text to parse.
     */
    public function parse_sub(string $text): void
    {
        $text_templates = $this->find_sub_templates($text);

        foreach ($text_templates as $match) {
            $text_template = $match[0];
            $_parser = new ParserTemplate($text_template);
            $this->templates[] = $_parser->getTemplate();
        }
    }

    /**
     * Get all templates found in the text.
     *
     * If a name is given, only the templates with that name are returned.
     *
     * @param string|null $name The name of the template to return.
     *
     * @return Template[] An array of Template objects.
     */
    public function getTemplates(?string $name = null): array
    {
        $outtemplates = [];
        if (!empty($name)) {
            foreach ($this->templates as $template) {
                if ($template->getName() == $name) {
                    $outtemplates[] = $template;
                }
            }
        } else {
            $outtemplates = $this->templates;
        }
        return $outtemplates;
    }
}
