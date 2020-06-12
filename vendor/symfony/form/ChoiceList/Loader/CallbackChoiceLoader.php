<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Form\ChoiceList\Loader;

<<<<<<< HEAD
use Symfony\Component\Form\ChoiceList\ArrayChoiceList;

/**
 * Loads an {@link ArrayChoiceList} instance from a callable returning an array of choices.
 *
 * @author Jules Pietri <jules@heahprod.com>
 */
class CallbackChoiceLoader implements ChoiceLoaderInterface
=======
/**
 * Loads an {@link ArrayChoiceList} instance from a callable returning iterable choices.
 *
 * @author Jules Pietri <jules@heahprod.com>
 */
class CallbackChoiceLoader extends AbstractChoiceLoader
>>>>>>> ThomasN
{
    private $callback;

    /**
<<<<<<< HEAD
     * The loaded choice list.
     *
     * @var ArrayChoiceList
     */
    private $choiceList;

    /**
     * @param callable $callback The callable returning an array of choices
=======
     * @param callable $callback The callable returning iterable choices
>>>>>>> ThomasN
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

<<<<<<< HEAD
    /**
     * {@inheritdoc}
     */
    public function loadChoiceList(callable $value = null)
    {
        if (null !== $this->choiceList) {
            return $this->choiceList;
        }

        return $this->choiceList = new ArrayChoiceList(($this->callback)(), $value);
    }

    /**
     * {@inheritdoc}
     */
    public function loadChoicesForValues(array $values, callable $value = null)
    {
        // Optimize
        if (empty($values)) {
            return [];
        }

        return $this->loadChoiceList($value)->getChoicesForValues($values);
    }

    /**
     * {@inheritdoc}
     */
    public function loadValuesForChoices(array $choices, callable $value = null)
    {
        // Optimize
        if (empty($choices)) {
            return [];
        }

        return $this->loadChoiceList($value)->getValuesForChoices($choices);
=======
    protected function loadChoices(): iterable
    {
        return ($this->callback)();
>>>>>>> ThomasN
    }
}
