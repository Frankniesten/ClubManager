<?php

namespace App\Form;

use App\Entity\BankAccount;
use App\Entity\Donation;
use App\Entity\Organization;
use App\Entity\Person;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class DonationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('transactionId', TextType::class,
                [
                    'required' => false
                ]
            )
            ->add('amount', MoneyType::class,
                [
                    'required' => true
                ]
            )
            ->add('description', TextType::class,
                [
                    'required' => false
                ]
            )
            ->add('currency', CurrencyType::class,
                [
                    'required' => true,
                    'preferred_choices' => ['EUR'],
                    'attr' => ['class' => 'select2'],
                ]
            )
            ->add('donationDate', DateType::class,
                [
                    'required' => true,
                    'widget' => 'single_text',
                    'html5' => false,
                    'format' => 'dd-MM-yyyy',
                ])
            ->add('url', UrlType::class,
                [
                    'required' => false,
                ]
            )
            ->add('paymentMethod')
            ->add('person', EntityType::class, array(
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
                'placeholder' => 'Select...',
                'attr' =>
                    [
                        'class' => 'select2'
                    ]
            ))
            ->add('organization', EntityType::class, array(
                'class' => Organization::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u');
                },
                'choice_label' => function (Organization $person) { return
                    $person->getLegalName();

                },
                'required' => false,
                'placeholder' => 'Select...',
                'attr' =>
                    [
                        'class' => 'select2'
                    ]
            ))
            ->add('bankAccount', EntityType::class,
                [
                    'class' => BankAccount::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.person', 'ASC');
                    },
                    'choice_label' => function (BankAccount $bankAccount) {
                        return
                        $bankAccount->getConsumerName();
                    },
                    'required' => false,
                    'placeholder' => 'Select...',
                    'attr' =>
                        [
                            'class' => 'select2'
                        ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Donation::class,
        ]);
    }
}
