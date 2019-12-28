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

    public static function getCurrentSemester(): int
    {
        $now = new \DateTime();

        $currentYear = (int)($now)->format("Y");

        $isAutumnSemester = $now > new \DateTime("31.07." . $currentYear);
        $years = $currentYear - 1970;

        return $years * 2 + 1 * $isAutumnSemester;
    }

    public static function semesterToString(int $semester): string
    {
        $isAutumnSemester = $semester % 2;
        $yearsSince1970 = (int)($semester / 2);
        $year = 1970 + $yearsSince1970 - 2000;

        return ($isAutumnSemester ? "HS" : "FS") . $year;
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
