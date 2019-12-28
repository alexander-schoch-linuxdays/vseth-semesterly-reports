<?php

/*
 * This file is part of the vseth-semesterly-reports project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form\Event;

use App\Entity\Event;
use App\Form\Type\SemesterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('semester', SemesterType::class);
        $builder->add('nameDe', TextType::class, ['required' => false]);
        $builder->add('nameEn', TextType::class, ['required' => false]);
        $builder->add('descriptionDe', TextType::class, ['required' => false]);
        $builder->add('descriptionEn', TextType::class, ['required' => false]);
        $builder->add('location', TextType::class);

        $builder->add('budget', NumberType::class);
        $builder->add('needFinancialSupport', CheckboxType::class, ['required' => false, 'help' => 'help.need_financial_support']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
            'translation_domain' => 'entity_event',
        ]);
    }
}
