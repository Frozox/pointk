<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Form\Extension\Core\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\IntegerToLocalizedStringTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IntegerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer(new IntegerToLocalizedStringTransformer($options['grouping'], $options['rounding_mode']));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if ($options['grouping']) {
            $view->vars['type'] = 'text';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'grouping' => false,
            // Integer cast rounds towards 0, so do the same when displaying fractions
<<<<<<< HEAD
            'rounding_mode' => IntegerToLocalizedStringTransformer::ROUND_DOWN,
=======
            'rounding_mode' => \NumberFormatter::ROUND_DOWN,
>>>>>>> ThomasN
            'compound' => false,
        ]);

        $resolver->setAllowedValues('rounding_mode', [
<<<<<<< HEAD
            IntegerToLocalizedStringTransformer::ROUND_FLOOR,
            IntegerToLocalizedStringTransformer::ROUND_DOWN,
            IntegerToLocalizedStringTransformer::ROUND_HALF_DOWN,
            IntegerToLocalizedStringTransformer::ROUND_HALF_EVEN,
            IntegerToLocalizedStringTransformer::ROUND_HALF_UP,
            IntegerToLocalizedStringTransformer::ROUND_UP,
            IntegerToLocalizedStringTransformer::ROUND_CEILING,
=======
            \NumberFormatter::ROUND_FLOOR,
            \NumberFormatter::ROUND_DOWN,
            \NumberFormatter::ROUND_HALFDOWN,
            \NumberFormatter::ROUND_HALFEVEN,
            \NumberFormatter::ROUND_HALFUP,
            \NumberFormatter::ROUND_UP,
            \NumberFormatter::ROUND_CEILING,
>>>>>>> ThomasN
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'integer';
    }
}
