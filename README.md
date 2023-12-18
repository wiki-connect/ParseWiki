# ParseWiki
A library that helps parse wikitext data.

## Installation

Use composer to install the library and all its dependencies:

    composer require wiki-connect/parsewiki
## Example Usage

### Parse wikitext categorys
```php
use WikiConnect\ParseWiki\ParserCategorys;
$parser = new ParserCategorys($wikitext);
$parser->parse();
print_r($parser->getCategorys());
```
### Parse wikitext citations
```php
use WikiConnect\ParseWiki\ParserCitations;
$parser = new ParserCitations($wikitext);
$parser->parse($parser->getCitations());
```
### Parse wikitext internal links
```php
use WikiConnect\ParseWiki\ParserInternalLinks;
$parser = new ParserInternalLinks($wikitext);
$parser->parse($parser->getLinks());
```
### Parse wikitext external links
```php
use WikiConnect\ParseWiki\ParserExternalLinks;
$parser = new ParserExternalLinks($wikitext);
$parser->parse($parser->getLinks());
```
### Parse wikitext template
```php
use WikiConnect\ParseWiki\ParserTemplate;
$parser = new ParserTemplate($wikitext);
$parser->parse($parser->getTemplate());
```
### Parse wikitext templates
```php
use WikiConnect\ParseWiki\ParserTemplates;
$parser = new ParserTemplates($wikitext);
$parser->parse($parser->getTemplates());
```
