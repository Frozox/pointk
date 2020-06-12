<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\Common\Inflector;

<<<<<<< HEAD
/**
 * Doctrine inflector has static methods for inflecting text.
 *
 * The methods in these classes are from several different sources collected
 * across several different php projects and several different authors. The
 * original author names and emails are not known.
 *
 * Pluralize & Singularize implementation are borrowed from CakePHP with some modifications.
 *
 * @link   www.doctrine-project.org
 * @since  1.0
 * @author Konsta Vesterinen <kvesteri@cc.hut.fi>
 * @author Jonathan H. Wage <jonwage@gmail.com>
=======
use Doctrine\Inflector\Inflector as InflectorObject;
use Doctrine\Inflector\InflectorFactory;
use Doctrine\Inflector\LanguageInflectorFactory;
use Doctrine\Inflector\Rules\Pattern;
use Doctrine\Inflector\Rules\Patterns;
use Doctrine\Inflector\Rules\Ruleset;
use Doctrine\Inflector\Rules\Substitution;
use Doctrine\Inflector\Rules\Substitutions;
use Doctrine\Inflector\Rules\Transformation;
use Doctrine\Inflector\Rules\Transformations;
use Doctrine\Inflector\Rules\Word;
use InvalidArgumentException;
use function array_keys;
use function array_map;
use function array_unshift;
use function array_values;
use function sprintf;
use function trigger_error;
use const E_USER_DEPRECATED;

/**
 * @deprecated
>>>>>>> ThomasN
 */
class Inflector
{
    /**
<<<<<<< HEAD
     * Plural inflector rules.
     *
     * @var string[][]
     */
    private static $plural = array(
        'rules' => array(
            '/(s)tatus$/i' => '\1\2tatuses',
            '/(quiz)$/i' => '\1zes',
            '/^(ox)$/i' => '\1\2en',
            '/([m|l])ouse$/i' => '\1ice',
            '/(matr|vert|ind)(ix|ex)$/i' => '\1ices',
            '/(x|ch|ss|sh)$/i' => '\1es',
            '/([^aeiouy]|qu)y$/i' => '\1ies',
            '/(hive|gulf)$/i' => '\1s',
            '/(?:([^f])fe|([lr])f)$/i' => '\1\2ves',
            '/sis$/i' => 'ses',
            '/([ti])um$/i' => '\1a',
            '/(c)riterion$/i' => '\1riteria',
            '/(p)erson$/i' => '\1eople',
            '/(m)an$/i' => '\1en',
            '/(c)hild$/i' => '\1hildren',
            '/(f)oot$/i' => '\1eet',
            '/(buffal|her|potat|tomat|volcan)o$/i' => '\1\2oes',
            '/(alumn|bacill|cact|foc|fung|nucle|radi|stimul|syllab|termin|vir)us$/i' => '\1i',
            '/us$/i' => 'uses',
            '/(alias)$/i' => '\1es',
            '/(analys|ax|cris|test|thes)is$/i' => '\1es',
            '/s$/' => 's',
            '/^$/' => '',
            '/$/' => 's',
        ),
        'uninflected' => array(
            '.*[nrlm]ese',
            '.*deer',
            '.*fish',
            '.*measles',
            '.*ois',
            '.*pox',
            '.*sheep',
            'people',
            'cookie',
            'police',
        ),
        'irregular' => array(
            'atlas' => 'atlases',
            'axe' => 'axes',
            'beef' => 'beefs',
            'brother' => 'brothers',
            'cafe' => 'cafes',
            'canvas' => 'canvases',
            'chateau' => 'chateaux',
            'niveau' => 'niveaux',
            'child' => 'children',
            'cookie' => 'cookies',
            'corpus' => 'corpuses',
            'cow' => 'cows',
            'criterion' => 'criteria',
            'curriculum' => 'curricula',
            'demo' => 'demos',
            'domino' => 'dominoes',
            'echo' => 'echoes',
            'foot' => 'feet',
            'fungus' => 'fungi',
            'ganglion' => 'ganglions',
            'gas' => 'gases',
            'genie' => 'genies',
            'genus' => 'genera',
            'goose' => 'geese',
            'graffito' => 'graffiti',
            'hippopotamus' => 'hippopotami',
            'hoof' => 'hoofs',
            'human' => 'humans',
            'iris' => 'irises',
            'larva' => 'larvae',
            'leaf' => 'leaves',
            'loaf' => 'loaves',
            'man' => 'men',
            'medium' => 'media',
            'memorandum' => 'memoranda',
            'money' => 'monies',
            'mongoose' => 'mongooses',
            'motto' => 'mottoes',
            'move' => 'moves',
            'mythos' => 'mythoi',
            'niche' => 'niches',
            'nucleus' => 'nuclei',
            'numen' => 'numina',
            'occiput' => 'occiputs',
            'octopus' => 'octopuses',
            'opus' => 'opuses',
            'ox' => 'oxen',
            'passerby' => 'passersby',
            'penis' => 'penises',
            'person' => 'people',
            'plateau' => 'plateaux',
            'runner-up' => 'runners-up',
            'sex' => 'sexes',
            'soliloquy' => 'soliloquies',
            'son-in-law' => 'sons-in-law',
            'syllabus' => 'syllabi',
            'testis' => 'testes',
            'thief' => 'thieves',
            'tooth' => 'teeth',
            'tornado' => 'tornadoes',
            'trilby' => 'trilbys',
            'turf' => 'turfs',
            'valve' => 'valves',
            'volcano' => 'volcanoes',
        )
    );

    /**
     * Singular inflector rules.
     *
     * @var string[][]
     */
    private static $singular = array(
        'rules' => array(
            '/(s)tatuses$/i' => '\1\2tatus',
            '/^(.*)(menu)s$/i' => '\1\2',
            '/(quiz)zes$/i' => '\\1',
            '/(matr)ices$/i' => '\1ix',
            '/(vert|ind)ices$/i' => '\1ex',
            '/^(ox)en/i' => '\1',
            '/(alias)(es)*$/i' => '\1',
            '/(buffal|her|potat|tomat|volcan)oes$/i' => '\1o',
            '/(alumn|bacill|cact|foc|fung|nucle|radi|stimul|syllab|termin|viri?)i$/i' => '\1us',
            '/([ftw]ax)es/i' => '\1',
            '/(analys|ax|cris|test|thes)es$/i' => '\1is',
            '/(shoe|slave)s$/i' => '\1',
            '/(o)es$/i' => '\1',
            '/ouses$/' => 'ouse',
            '/([^a])uses$/' => '\1us',
            '/([m|l])ice$/i' => '\1ouse',
            '/(x|ch|ss|sh)es$/i' => '\1',
            '/(m)ovies$/i' => '\1\2ovie',
            '/(s)eries$/i' => '\1\2eries',
            '/([^aeiouy]|qu)ies$/i' => '\1y',
            '/([lr])ves$/i' => '\1f',
            '/(tive)s$/i' => '\1',
            '/(hive)s$/i' => '\1',
            '/(drive)s$/i' => '\1',
            '/(dive)s$/i' => '\1',
            '/(olive)s$/i' => '\1',
            '/([^fo])ves$/i' => '\1fe',
            '/(^analy)ses$/i' => '\1sis',
            '/(analy|diagno|^ba|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i' => '\1\2sis',
            '/(c)riteria$/i' => '\1riterion',
            '/([ti])a$/i' => '\1um',
            '/(p)eople$/i' => '\1\2erson',
            '/(m)en$/i' => '\1an',
            '/(c)hildren$/i' => '\1\2hild',
            '/(f)eet$/i' => '\1oot',
            '/(n)ews$/i' => '\1\2ews',
            '/eaus$/' => 'eau',
            '/^(.*us)$/' => '\\1',
            '/s$/i' => '',
        ),
        'uninflected' => array(
            '.*[nrlm]ese',
            '.*deer',
            '.*fish',
            '.*measles',
            '.*ois',
            '.*pox',
            '.*sheep',
            '.*ss',
            'data',
            'police',
            'pants',
            'clothes',
        ),
        'irregular' => array(
            'abuses'     => 'abuse',
            'avalanches' => 'avalanche',
            'caches'     => 'cache',
            'criteria'   => 'criterion',
            'curves'     => 'curve',
            'emphases'   => 'emphasis',
            'foes'       => 'foe',
            'geese'      => 'goose',
            'graves'     => 'grave',
            'hoaxes'     => 'hoax',
            'media'      => 'medium',
            'neuroses'   => 'neurosis',
            'waves'      => 'wave',
            'oases'      => 'oasis',
            'valves'     => 'valve',
        )
    );

    /**
     * Words that should not be inflected.
     *
     * @var array
     */
    private static $uninflected = array(
        '.*?media', 'Amoyese', 'audio', 'bison', 'Borghese', 'bream', 'breeches',
        'britches', 'buffalo', 'cantus', 'carp', 'chassis', 'clippers', 'cod', 'coitus', 'compensation', 'Congoese',
        'contretemps', 'coreopsis', 'corps', 'data', 'debris', 'deer', 'diabetes', 'djinn', 'education', 'eland',
        'elk', 'emoji', 'equipment', 'evidence', 'Faroese', 'feedback', 'fish', 'flounder', 'Foochowese',
        'Furniture', 'furniture', 'gallows', 'Genevese', 'Genoese', 'Gilbertese', 'gold', 
        'headquarters', 'herpes', 'hijinks', 'Hottentotese', 'information', 'innings', 'jackanapes', 'jedi',
        'Kiplingese', 'knowledge', 'Kongoese', 'love', 'Lucchese', 'Luggage', 'mackerel', 'Maltese', 'metadata',
        'mews', 'moose', 'mumps', 'Nankingese', 'news', 'nexus', 'Niasese', 'nutrition', 'offspring',
        'Pekingese', 'Piedmontese', 'pincers', 'Pistoiese', 'plankton', 'pliers', 'pokemon', 'police', 'Portuguese',
        'proceedings', 'rabies', 'rain', 'rhinoceros', 'rice', 'salmon', 'Sarawakese', 'scissors', 'sea[- ]bass',
        'series', 'Shavese', 'shears', 'sheep', 'siemens', 'species', 'staff', 'swine', 'traffic',
        'trousers', 'trout', 'tuna', 'us', 'Vermontese', 'Wenchowese', 'wheat', 'whiting', 'wildebeest', 'Yengeese'
    );

    /**
     * Method cache array.
     *
     * @var array
     */
    private static $cache = array();

    /**
     * The initial state of Inflector so reset() works.
     *
     * @var array
     */
    private static $initialState = array();

    /**
     * Converts a word into the format for a Doctrine table name. Converts 'ModelName' to 'model_name'.
     */
    public static function tableize(string $word) : string
    {
        return strtolower(preg_replace('~(?<=\\w)([A-Z])~', '_$1', $word));
=======
     * @var LanguageInflectorFactory|null
     */
    private static $factory;

    /** @var InflectorObject|null */
    private static $instance;

    private static function getInstance() : InflectorObject
    {
        if (self::$factory === null) {
            self::$factory = self::createFactory();
        }

        if (self::$instance === null) {
            self::$instance = self::$factory->build();
        }

        return self::$instance;
    }

    private static function createFactory() : LanguageInflectorFactory
    {
        return InflectorFactory::create();
    }

    /**
     * Converts a word into the format for a Doctrine table name. Converts 'ModelName' to 'model_name'.
     *
     * @deprecated
     */
    public static function tableize(string $word) : string
    {
        @trigger_error(sprintf('The "%s" method is deprecated and will be dropped in doctrine/inflector 2.0. Please update to the new Inflector API.', __METHOD__), E_USER_DEPRECATED);

        return self::getInstance()->tableize($word);
>>>>>>> ThomasN
    }

    /**
     * Converts a word into the format for a Doctrine class name. Converts 'table_name' to 'TableName'.
     */
    public static function classify(string $word) : string
    {
<<<<<<< HEAD
        return str_replace([' ', '_', '-'], '', ucwords($word, ' _-'));
=======
        @trigger_error(sprintf('The "%s" method is deprecated and will be dropped in doctrine/inflector 2.0. Please update to the new Inflector API.', __METHOD__), E_USER_DEPRECATED);

        return self::getInstance()->classify($word);
>>>>>>> ThomasN
    }

    /**
     * Camelizes a word. This uses the classify() method and turns the first character to lowercase.
<<<<<<< HEAD
     */
    public static function camelize(string $word) : string
    {
        return lcfirst(self::classify($word));
    }

    /**
     * Uppercases words with configurable delimeters between words.
     *
     * Takes a string and capitalizes all of the words, like PHP's built-in
     * ucwords function. This extends that behavior, however, by allowing the
     * word delimeters to be configured, rather than only separating on
=======
     *
     * @deprecated
     */
    public static function camelize(string $word) : string
    {
        @trigger_error(sprintf('The "%s" method is deprecated and will be dropped in doctrine/inflector 2.0. Please update to the new Inflector API.', __METHOD__), E_USER_DEPRECATED);

        return self::getInstance()->camelize($word);
    }

    /**
     * Uppercases words with configurable delimiters between words.
     *
     * Takes a string and capitalizes all of the words, like PHP's built-in
     * ucwords function. This extends that behavior, however, by allowing the
     * word delimiters to be configured, rather than only separating on
>>>>>>> ThomasN
     * whitespace.
     *
     * Here is an example:
     * <code>
     * <?php
     * $string = 'top-o-the-morning to all_of_you!';
     * echo \Doctrine\Common\Inflector\Inflector::ucwords($string);
     * // Top-O-The-Morning To All_of_you!
     *
     * echo \Doctrine\Common\Inflector\Inflector::ucwords($string, '-_ ');
     * // Top-O-The-Morning To All_Of_You!
     * ?>
     * </code>
     *
     * @param string $string The string to operate on.
     * @param string $delimiters A list of word separators.
     *
<<<<<<< HEAD
     * @return string The string with all delimeter-separated words capitalized.
     */
    public static function ucwords(string $string, string $delimiters = " \n\t\r\0\x0B-") : string
    {
=======
     * @return string The string with all delimiter-separated words capitalized.
     *
     * @deprecated
     */
    public static function ucwords(string $string, string $delimiters = " \n\t\r\0\x0B-") : string
    {
        @trigger_error(sprintf('The "%s" method is deprecated and will be dropped in doctrine/inflector 2.0. Please use the "ucwords" function instead.', __METHOD__), E_USER_DEPRECATED);

>>>>>>> ThomasN
        return ucwords($string, $delimiters);
    }

    /**
     * Clears Inflectors inflected value caches, and resets the inflection
     * rules to the initial values.
<<<<<<< HEAD
     */
    public static function reset() : void
    {
        if (empty(self::$initialState)) {
            self::$initialState = get_class_vars('Inflector');

            return;
        }

        foreach (self::$initialState as $key => $val) {
            if ($key !== 'initialState') {
                self::${$key} = $val;
            }
        }
=======
     *
     * @deprecated
     */
    public static function reset() : void
    {
        @trigger_error(sprintf('The "%s" method is deprecated and will be dropped in doctrine/inflector 2.0. Please update to the new Inflector API.', __METHOD__), E_USER_DEPRECATED);

        self::$factory = null;
        self::$instance = null;
>>>>>>> ThomasN
    }

    /**
     * Adds custom inflection $rules, of either 'plural' or 'singular' $type.
     *
     * ### Usage:
     *
     * {{{
     * Inflector::rules('plural', array('/^(inflect)or$/i' => '\1ables'));
     * Inflector::rules('plural', array(
     *     'rules' => array('/^(inflect)ors$/i' => '\1ables'),
     *     'uninflected' => array('dontinflectme'),
     *     'irregular' => array('red' => 'redlings')
     * ));
     * }}}
     *
     * @param string  $type         The type of inflection, either 'plural' or 'singular'
     * @param array|iterable $rules An array of rules to be added.
     * @param boolean $reset        If true, will unset default inflections for all
     *                              new rules that are being defined in $rules.
     *
     * @return void
<<<<<<< HEAD
     */
    public static function rules(string $type, iterable $rules, bool $reset = false) : void
    {
        foreach ($rules as $rule => $pattern) {
            if ( ! is_array($pattern)) {
                continue;
            }

            if ($reset) {
                self::${$type}[$rule] = $pattern;
            } else {
                self::${$type}[$rule] = ($rule === 'uninflected')
                    ? array_merge($pattern, self::${$type}[$rule])
                    : $pattern + self::${$type}[$rule];
            }

            unset($rules[$rule], self::${$type}['cache' . ucfirst($rule)]);

            if (isset(self::${$type}['merged'][$rule])) {
                unset(self::${$type}['merged'][$rule]);
            }

            if ($type === 'plural') {
                self::$cache['pluralize'] = self::$cache['tableize'] = array();
            } elseif ($type === 'singular') {
                self::$cache['singularize'] = array();
            }
        }

        self::${$type}['rules'] = $rules + self::${$type}['rules'];
=======
     *
     * @deprecated
     */
    public static function rules(string $type, iterable $rules, bool $reset = false) : void
    {
        @trigger_error(sprintf('The "%s" method is deprecated and will be dropped in doctrine/inflector 2.0. Please update to the new Inflector API.', __METHOD__), E_USER_DEPRECATED);

        if (self::$factory === null) {
            self::$factory = self::createFactory();
        }

        self::$instance = null;

        switch ($type) {
            case 'singular':
                self::$factory->withSingularRules(self::buildRuleset($rules), $reset);
                break;
            case 'plural':
                self::$factory->withPluralRules(self::buildRuleset($rules), $reset);
                break;
            default:
                throw new InvalidArgumentException(sprintf('Cannot define custom inflection rules for type "%s".', $type));
        }
    }

    private static function buildRuleset(iterable $rules) : Ruleset
    {
        $regular = [];
        $irregular = [];
        $uninflected = [];

        foreach ($rules as $rule => $pattern) {
            if ( ! is_array($pattern)) {
                $regular[$rule] = $pattern;

                continue;
            }

            switch ($rule) {
                case 'uninflected':
                    $uninflected = $pattern;
                    break;
                case 'irregular':
                    $irregular = $pattern;
                    break;
                case 'rules':
                    $regular = $pattern;
                    break;
            }
        }

        return new Ruleset(
            new Transformations(...array_map(
                static function (string $pattern, string $replacement) : Transformation {
                    return new Transformation(new Pattern($pattern), $replacement);
                },
                array_keys($regular),
                array_values($regular)
            )),
            new Patterns(...array_map(
                static function (string $pattern) : Pattern {
                    return new Pattern($pattern);
                },
                $uninflected
            )),
            new Substitutions(...array_map(
                static function (string $word, string $to) : Substitution {
                    return new Substitution(new Word($word), new Word($to));
                },
                array_keys($irregular),
                array_values($irregular)
            ))
        );
>>>>>>> ThomasN
    }

    /**
     * Returns a word in plural form.
     *
     * @param string $word The word in singular form.
     *
     * @return string The word in plural form.
<<<<<<< HEAD
     */
    public static function pluralize(string $word) : string
    {
        if (isset(self::$cache['pluralize'][$word])) {
            return self::$cache['pluralize'][$word];
        }

        if (!isset(self::$plural['merged']['irregular'])) {
            self::$plural['merged']['irregular'] = self::$plural['irregular'];
        }

        if (!isset(self::$plural['merged']['uninflected'])) {
            self::$plural['merged']['uninflected'] = array_merge(self::$plural['uninflected'], self::$uninflected);
        }

        if (!isset(self::$plural['cacheUninflected']) || !isset(self::$plural['cacheIrregular'])) {
            self::$plural['cacheUninflected'] = '(?:' . implode('|', self::$plural['merged']['uninflected']) . ')';
            self::$plural['cacheIrregular']   = '(?:' . implode('|', array_keys(self::$plural['merged']['irregular'])) . ')';
        }

        if (preg_match('/(.*)\\b(' . self::$plural['cacheIrregular'] . ')$/i', $word, $regs)) {
            self::$cache['pluralize'][$word] = $regs[1] . $word[0] . substr(self::$plural['merged']['irregular'][strtolower($regs[2])], 1);

            return self::$cache['pluralize'][$word];
        }

        if (preg_match('/^(' . self::$plural['cacheUninflected'] . ')$/i', $word, $regs)) {
            self::$cache['pluralize'][$word] = $word;

            return $word;
        }

        foreach (self::$plural['rules'] as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                self::$cache['pluralize'][$word] = preg_replace($rule, $replacement, $word);

                return self::$cache['pluralize'][$word];
            }
        }
=======
     *
     * @deprecated
     */
    public static function pluralize(string $word) : string
    {
        @trigger_error(sprintf('The "%s" method is deprecated and will be dropped in doctrine/inflector 2.0. Please update to the new Inflector API.', __METHOD__), E_USER_DEPRECATED);

        return self::getInstance()->pluralize($word);
>>>>>>> ThomasN
    }

    /**
     * Returns a word in singular form.
     *
     * @param string $word The word in plural form.
     *
     * @return string The word in singular form.
<<<<<<< HEAD
     */
    public static function singularize(string $word) : string
    {
        if (isset(self::$cache['singularize'][$word])) {
            return self::$cache['singularize'][$word];
        }

        if (!isset(self::$singular['merged']['uninflected'])) {
            self::$singular['merged']['uninflected'] = array_merge(
                self::$singular['uninflected'],
                self::$uninflected
            );
        }

        if (!isset(self::$singular['merged']['irregular'])) {
            self::$singular['merged']['irregular'] = array_merge(
                self::$singular['irregular'],
                array_flip(self::$plural['irregular'])
            );
        }

        if (!isset(self::$singular['cacheUninflected']) || !isset(self::$singular['cacheIrregular'])) {
            self::$singular['cacheUninflected'] = '(?:' . implode('|', self::$singular['merged']['uninflected']) . ')';
            self::$singular['cacheIrregular'] = '(?:' . implode('|', array_keys(self::$singular['merged']['irregular'])) . ')';
        }

        if (preg_match('/(.*)\\b(' . self::$singular['cacheIrregular'] . ')$/i', $word, $regs)) {
            self::$cache['singularize'][$word] = $regs[1] . $word[0] . substr(self::$singular['merged']['irregular'][strtolower($regs[2])], 1);

            return self::$cache['singularize'][$word];
        }

        if (preg_match('/^(' . self::$singular['cacheUninflected'] . ')$/i', $word, $regs)) {
            self::$cache['singularize'][$word] = $word;

            return $word;
        }

        foreach (self::$singular['rules'] as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                self::$cache['singularize'][$word] = preg_replace($rule, $replacement, $word);

                return self::$cache['singularize'][$word];
            }
        }

        self::$cache['singularize'][$word] = $word;

        return $word;
=======
     *
     * @deprecated
     */
    public static function singularize(string $word) : string
    {
        @trigger_error(sprintf('The "%s" method is deprecated and will be dropped in doctrine/inflector 2.0. Please update to the new Inflector API.', __METHOD__), E_USER_DEPRECATED);

        return self::getInstance()->singularize($word);
>>>>>>> ThomasN
    }
}
