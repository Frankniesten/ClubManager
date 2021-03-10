<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;



class TagAddFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('people', EntityType::class, array(
                'class' => Person::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u');
                },
                'choice_label' => function (Person $person) { return
                    $person->getFamilyName(). ', ' .
                    $person->getGivenName(). ' ' .
                    $person->getAdditionalName();

                },
                'required' => false,
                'multiple' => true,
                'by_reference' => false,
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Tag::class]);
    }
}