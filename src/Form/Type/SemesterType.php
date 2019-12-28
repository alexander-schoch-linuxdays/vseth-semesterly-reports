<?php


namespace App\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SemesterType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        // unix epoch was 1. Januar 1970; which would be FS70
        // hence FS2020 is 50*2 = 100
        $resolver->setDefaults([
            'choices' => [
                'FS20' => 100,
                'HS20' => 101,
                'FS21' => 102,
                'HS21' => 103
            ],
            'choice_translation_domain' => false
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
