# WikiConnect ParseWiki

A powerful PHP library for parsing MediaWiki-style content from raw wiki text.

---

## 📚 Overview

This library allows you to extract:
- Templates (single, multiple, nested)
- Internal wiki links
- External links
- Citations (references)
- Categories (with or without display text)
Perfect for handling wiki-formatted text in PHP projects.

---

## 🗂️ Project Structure

- `ParserTemplates`: Parses multiple templates.
- `ParserTemplate`: Parses a single template.
- `ParserInternalLinks`: Parses internal wiki links.
- `ParserExternalLinks`: Parses external links.
- `ParserCitations`: Parses citations and references.
- `ParserCategories`: Parses categories from wiki text.
- `DataModel` classes:
  - `Attribute`
  - `Citation`
  - `ExternalLink`
  - `InternalLink`
  - `Parameters`
  - `Template`
- `tests/`: Contains PHPUnit test files:
  - `ParserCategoriesTest`
  - `ParserCitationsTest`
  - `ParserExternalLinksTest`
  - `ParserInternalLinksTest`
  - `ParserTemplatesTest`
  - `ParserTemplateTest`
  - `DataModel` tests:
    - `AttributeTest`
    - `ParametersTest`
    - `TemplateTest`
---

## 🚀 Features

- ✅ Parse single and multiple templates.
- ✅ Support nested templates.
- ✅ Handle named and unnamed template parameters.
- ✅ Extract internal links with or without display text.
- ✅ Extract external links with or without labels.
- ✅ Parse citations including attributes and special characters.
- ✅ Parse categories, support custom namespaces, handle whitespaces and special characters.
- ✅ Full PHPUnit test coverage.

---
## 🧩 Wikitext Features Support

| Feature                    | Read ✅ | Modify ✏️ | Replace 🔄 |
|--------------------------- |---------|------------|------------|
| **Templates**              | ✅ Yes  | ✅ Yes    | ✅ Yes     |
| **Parameters**             | ✅ Yes  | ✅ Yes    | ✅ Yes     |
| **Citations**              | ✅ Yes  | ✅ Yes    | ✅ Yes     |
| **Citations>Attributes**   | ✅ Yes  | ✅ Yes    | ✅ Yes     |
| **Internal Links**         | ✅ Yes  |     |      |
| **External Links**         | ✅ Yes  |     |      |
| **Categories**             | ✅ Yes  |      |       |
| **HTML Tags**              |   |     |      |
| **Parser Functions**       |   |   |       |
| **Tables**                 |   |      |       |
| **Sections**               |   |      |       |
| **Magic Words**            |   |      |       |

> 🟡 **Note:** Some features are partially supported or under development. Contributions are welcome!

---

## ⚙️ Requirements

- PHP 8.0 or higher
- PHPUnit 9 or higher

---

## 💻 Installation

```bash
composer require wiki-connect/parsewiki
```

Make sure you have proper PSR-4 autoloading for the `WikiConnect\ParseWiki` namespace.

---

## 🧪 Running Tests

```bash
vendor/bin/phpunit tests
```

### Test Coverage:
- **Templates:** Single, multiple, nested, named/unnamed parameters.
- **Internal Links:** Simple, with display text, special characters.
- **External Links:** With/without labels, multiple links, whitespace handling.
- **Citations:** With/without attributes, special characters.
- **Categories:** Simple, with display text, custom namespaces, whitespaces, special characters.

---

## ✨ Example Usage

### Parsing Templates

```php
use WikiConnect\ParseWiki\ParserTemplates;

$text = '{{Infobox person|name=John Doe|birth_date=1990-01-01}}';

$parser = new ParserTemplates($text);
$templates = $parser->getTemplates();

foreach ($templates as $template) {
    echo $template->getName();
    print_r($template->getParameters());
}
```

### Parsing Internal Links

```php
use WikiConnect\ParseWiki\ParserInternalLinks;

$text = 'See [[Main Page|the main page]] and [[Help]].';

$parser = new ParserInternalLinks($text);
$links = $parser->getTargets();

foreach ($links as $link) {
    echo 'Target: ' . $link->getTarget() . PHP_EOL;
    echo 'Text: ' . ($link->getText() ?? $link->getTarget()) . PHP_EOL;
}
```

### Parsing External Links

```php
use WikiConnect\ParseWiki\ParserExternalLinks;

$text = 'Visit [https://example.com Example Site] and [https://nolabel.com].';

$parser = new ParserExternalLinks($text);
$links = $parser->getLinks();

foreach ($links as $link) {
    echo 'URL: ' . $link->getLink() . PHP_EOL;
    echo 'Label: ' . ($link->getText() ?: 'No label') . PHP_EOL;
}
```

### Parsing Citations

```php
use WikiConnect\ParseWiki\ParserCitations;

$text = 'Some text with a citation.<ref name="source">This is a citation</ref>';

$parser = new ParserCitations($text);
$citations = $parser->getCitations();

foreach ($citations as $citation) {
    echo 'Content: ' . $citation->getContent() . PHP_EOL;
    echo 'Attributes: ' . $citation->getAttributes() . PHP_EOL;
}
```

### Parsing Categories

```php
use WikiConnect\ParseWiki\ParserCategories;

$text = 'Some text [[Category:Science]] and [[Category:Math|Displayed]].';

$parser = new ParserCategories($text);
$categories = $parser->getCategories();

foreach ($categories as $category) {
    echo 'Category: ' . $category . PHP_EOL;
}
```

---

## 🙌 Author

Developed with ❤️ by Gerges.
