<?php

namespace App\Form;

use App\Entity\BankAccount;
use App\Entity\Organization;
use App\Entity\Person;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BackAccountFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('consumerAccount')
            ->add('consumerBic')
            ->add('consumerName')
            ->add('organization', EntityType::class, array(
                'class' => Organization::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.legalName', 'ASC');
                },
                'choice_label' => 'legalName',
                'required' => false,
                'placeholder' => 'Select...',
                'attr' => [
                    'class' => 'select2'
                ]
            ))
            ->add('person', EntityType::class, array(
                'class' => Person::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.deathDate is NULL')
                        ->orderBy('u.familyName', 'ASC');
                },
                'choice_label' => function (Person $person) { return
                    $person->getFamilyName(). ', ' .
                    $person->getGivenName(). ' ' .
                    $person->getAdditionalName();

                },
                'required' => false,
                'placeholder' => 'Select...',
                'attr' => [
                    'class' => 'select2'
                ]
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BankAccount::class,
        ]);
    }
}
