<?php

namespace Doctrine\Bundle\DoctrineBundle\Twig;

<<<<<<< HEAD
use SqlFormatter;
=======
use Doctrine\SqlFormatter\HtmlHighlighter;
use Doctrine\SqlFormatter\NullHighlighter;
use Doctrine\SqlFormatter\SqlFormatter;
>>>>>>> ThomasN
use Symfony\Component\VarDumper\Cloner\Data;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * This class contains the needed functions in order to do the query highlighting
 */
class DoctrineExtension extends AbstractExtension
{
<<<<<<< HEAD
=======
    /** @var SqlFormatter */
    private $sqlFormatter;

>>>>>>> ThomasN
    /**
     * Define our functions
     *
     * @return TwigFilter[]
     */
    public function getFilters()
    {
        return [
<<<<<<< HEAD
            new TwigFilter('doctrine_pretty_query', [$this, 'formatQuery'], ['is_safe' => ['html']]),
=======
            new TwigFilter('doctrine_pretty_query', [$this, 'formatQuery'], ['is_safe' => ['html'], 'deprecated' => true]),
            new TwigFilter('doctrine_prettify_sql', [$this, 'prettifySql'], ['is_safe' => ['html']]),
            new TwigFilter('doctrine_format_sql', [$this, 'formatSql'], ['is_safe' => ['html']]),
>>>>>>> ThomasN
            new TwigFilter('doctrine_replace_query_parameters', [$this, 'replaceQueryParameters']),
        ];
    }

    /**
     * Get the possible combinations of elements from the given array
     */
    private function getPossibleCombinations(array $elements, int $combinationsLevel) : array
    {
        $baseCount = count($elements);
        $result    = [];

        if ($combinationsLevel === 1) {
            foreach ($elements as $element) {
                $result[] = [$element];
            }

            return $result;
        }

        $nextLevelElements = $this->getPossibleCombinations($elements, $combinationsLevel - 1);

        foreach ($nextLevelElements as $nextLevelElement) {
            $lastElement = $nextLevelElement[$combinationsLevel - 2];
            $found       = false;

            foreach ($elements as $key => $element) {
                if ($element === $lastElement) {
                    $found = true;
                    continue;
                }

                if ($found !== true || $key >= $baseCount) {
                    continue;
                }

                $tmp              = $nextLevelElement;
                $newCombination   = array_slice($tmp, 0);
                $newCombination[] = $element;
                $result[]         = array_slice($newCombination, 0);
            }
        }

        return $result;
    }

    /**
     * Escape parameters of a SQL query
     * DON'T USE THIS FUNCTION OUTSIDE ITS INTENDED SCOPE
     *
     * @internal
     *
     * @param mixed $parameter
     *
     * @return string
     */
    public static function escapeFunction($parameter)
    {
        $result = $parameter;

        switch (true) {
            // Check if result is non-unicode string using PCRE_UTF8 modifier
            case is_string($result) && ! preg_match('//u', $result):
                $result = '0x' . strtoupper(bin2hex($result));
                break;

            case is_string($result):
                $result = "'" . addslashes($result) . "'";
                break;

            case is_array($result):
                foreach ($result as &$value) {
                    $value = static::escapeFunction($value);
                }

<<<<<<< HEAD
                $result = implode(', ', $result);
=======
                $result = implode(', ', $result) ?: 'NULL';
>>>>>>> ThomasN
                break;

            case is_object($result):
                $result = addslashes((string) $result);
                break;

            case $result === null:
                $result = 'NULL';
                break;

            case is_bool($result):
                $result = $result ? '1' : '0';
                break;
        }

        return $result;
    }

    /**
     * Return a query with the parameters replaced
     *
     * @param string     $query
     * @param array|Data $parameters
     *
     * @return string
     */
    public function replaceQueryParameters($query, $parameters)
    {
        if ($parameters instanceof Data) {
            $parameters = $parameters->getValue(true);
        }

        $i = 0;

        if (! array_key_exists(0, $parameters) && array_key_exists(1, $parameters)) {
            $i = 1;
        }

        return preg_replace_callback(
            '/\?|((?<!:):[a-z0-9_]+)/i',
            static function ($matches) use ($parameters, &$i) {
                $key = substr($matches[0], 1);

                if (! array_key_exists($i, $parameters) && ($key === false || ! array_key_exists($key, $parameters))) {
                    return $matches[0];
                }

                $value  = array_key_exists($i, $parameters) ? $parameters[$i] : $parameters[$key];
                $result = DoctrineExtension::escapeFunction($value);
                $i++;

                return $result;
            },
            $query
        );
    }

    /**
     * Formats and/or highlights the given SQL statement.
     *
     * @param  string $sql
     * @param  bool   $highlightOnly If true the query is not formatted, just highlighted
     *
     * @return string
     */
    public function formatQuery($sql, $highlightOnly = false)
    {
<<<<<<< HEAD
        SqlFormatter::$pre_attributes            = 'class="highlight highlight-sql"';
        SqlFormatter::$quote_attributes          = 'class="string"';
        SqlFormatter::$backtick_quote_attributes = 'class="string"';
        SqlFormatter::$reserved_attributes       = 'class="keyword"';
        SqlFormatter::$boundary_attributes       = 'class="symbol"';
        SqlFormatter::$number_attributes         = 'class="number"';
        SqlFormatter::$word_attributes           = 'class="word"';
        SqlFormatter::$error_attributes          = 'class="error"';
        SqlFormatter::$comment_attributes        = 'class="comment"';
        SqlFormatter::$variable_attributes       = 'class="variable"';

        if ($highlightOnly) {
            $html = SqlFormatter::highlight($sql);
            $html = preg_replace('/<pre class=".*">([^"]*+)<\/pre>/Us', '\1', $html);
        } else {
            $html = SqlFormatter::format($sql);
            $html = preg_replace('/<pre class="(.*)">([^"]*+)<\/pre>/Us', '<div class="\1"><pre>\2</pre></div>', $html);
        }

        return $html;
=======
        @trigger_error(sprintf('The "%s()" method is deprecated and will be removed in DoctrineBundle 3.0.', __METHOD__), E_USER_DEPRECATED);

        $this->setUpSqlFormatter(true, true);

        if ($highlightOnly) {
            return $this->sqlFormatter->highlight($sql);
        }

        return sprintf(
            '<div class="highlight highlight-sql"><pre>%s</pre></div>',
            $this->sqlFormatter->format($sql)
        );
    }

    public function prettifySql(string $sql) : string
    {
        $this->setUpSqlFormatter();

        return $this->sqlFormatter->highlight($sql);
    }

    public function formatSql(string $sql, bool $highlight) : string
    {
        $this->setUpSqlFormatter($highlight);

        return $this->sqlFormatter->format($sql);
    }

    private function setUpSqlFormatter(bool $highlight = true, bool $legacy = false) : void
    {
        $this->sqlFormatter = new SqlFormatter($highlight ? new HtmlHighlighter([
            HtmlHighlighter::HIGHLIGHT_PRE            => 'class="highlight highlight-sql"',
            HtmlHighlighter::HIGHLIGHT_QUOTE          => 'class="string"',
            HtmlHighlighter::HIGHLIGHT_BACKTICK_QUOTE => 'class="string"',
            HtmlHighlighter::HIGHLIGHT_RESERVED       => 'class="keyword"',
            HtmlHighlighter::HIGHLIGHT_BOUNDARY       => 'class="symbol"',
            HtmlHighlighter::HIGHLIGHT_NUMBER         => 'class="number"',
            HtmlHighlighter::HIGHLIGHT_WORD           => 'class="word"',
            HtmlHighlighter::HIGHLIGHT_ERROR          => 'class="error"',
            HtmlHighlighter::HIGHLIGHT_COMMENT        => 'class="comment"',
            HtmlHighlighter::HIGHLIGHT_VARIABLE       => 'class="variable"',
        ], ! $legacy) : new NullHighlighter());
>>>>>>> ThomasN
    }

    /**
     * Get the name of the extension
     *
     * @return string
     */
    public function getName()
    {
        return 'doctrine_extension';
    }
}
