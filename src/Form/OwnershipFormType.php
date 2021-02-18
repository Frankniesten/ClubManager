<?php

namespace App\Form;

use App\Entity\Person;
use App\Entity\OwnershipInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class OwnershipFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ownedFrom', DateType::class, ['required' => true, 'widget' => 'single_text', 'html5' => false, 'format' => 'dd-MM-yyyy'])
            ->add('ownedTrough', DateType::class, ['required' => false, 'widget' => 'single_text', 'html5' => false, 'format' => 'dd-MM-yyyy'])
            ->add('person', EntityType::class, array(
                'class' => Person::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.familyName', 'ASC');
                },
                'choice_label' => function (Person $person) { return
                    $person->getFamilyName(). ', ' .
                    $person->getGivenName(). ' ' .
                    $person->getAdditionalName();

                },
                'required' => true,
                'placeholder' => 'Select...',
                'attr' => [
                    'class' => 'select2'
                ]
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OwnershipInfo::class
        ]);
    }
}

