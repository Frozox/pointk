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

/**
 * Callback choice loader optimized for Intl choice types.
 *
 * @author Jules Pietri <jules@heahprod.com>
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 */
class IntlCallbackChoiceLoader extends CallbackChoiceLoader
{
    /**
     * {@inheritdoc}
     */
    public function loadChoicesForValues(array $values, callable $value = null)
    {
<<<<<<< HEAD
        // Optimize
        $values = array_filter($values);
        if (empty($values)) {
            return [];
        }

        return $this->loadChoiceList($value)->getChoicesForValues($values);
=======
        return parent::loadChoicesForValues(array_filter($values), $value);
>>>>>>> ThomasN
    }

    /**
     * {@inheritdoc}
     */
    public function loadValuesForChoices(array $choices, callable $value = null)
    {
<<<<<<< HEAD
        // Optimize
        $choices = array_filter($choices);
        if (empty($choices)) {
            return [];
        }
=======
        $choices = array_filter($choices);
>>>>>>> ThomasN

        // If no callable is set, choices are the same as values
        if (null === $value) {
            return $choices;
        }

<<<<<<< HEAD
        return $this->loadChoiceList($value)->getValuesForChoices($choices);
=======
        return parent::loadValuesForChoices($choices, $value);
>>>>>>> ThomasN
    }
}
