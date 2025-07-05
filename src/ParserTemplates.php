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
    private int $maxDepth;

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
        $this->maxDepth = 10;
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
        $pattern = "/\{{2}(((?>[^\{\}]+)|(?R))*)\}{2}/xm";
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
        $stack = [['text' => $this->text, 'depth' => 0]];

        while (!empty($stack)) {
            $current = array_pop($stack);
            $currentText = $current['text'];
            $currentDepth = $current['depth'];

            if ($currentDepth >= $this->maxDepth) {
                continue;
            }

            $text_templates = $this->find_sub_templates($currentText);

            foreach ($text_templates as $match) {
                $template_full = $match[0]; // Including brackets
                $template_inner = $match[1]; // المحتوى فقط

                $_parser = new ParserTemplate($template_full);
                $this->templates[] = $_parser->getTemplate();

                // Add the inner template to the stack for later parsing
                $stack[] = [
                    'text' => $template_inner,
                    'depth' => $currentDepth + 1
                ];
            }
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
        if (empty($name)) {
            return $this->templates;
        }

        $outtemplates = [];
        foreach ($this->templates as $template) {
            if ($template->getName() == $name) {
                $outtemplates[] = $template;
            }
        }
        return $outtemplates;
    }
}
