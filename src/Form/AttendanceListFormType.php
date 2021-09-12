<?php

namespace App\Form;

use App\Entity\AttendanceList;
use App\Entity\Event;
use App\Entity\ProgramMembership;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttendanceListFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('event', EntityType::class, array(
                'class' => Event::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->leftJoin('u.attendanceLists', 'a')
                        ->andWhere('u.startDate >= :today')
                        ->andWhere('u.eventStatus >= :Confirmed')
                        ->andWhere( 'a.Event IS NULL' )
                        ->setParameter('today', date_format(new \DateTime(), 'Y-m-d'))
                        ->setParameter('Confirmed', 'Confirmed')
                        ->orderBy('u.startDate', 'ASC');
                },
                'choice_label' => function (Event $product) {return

                    $product->getAbout(). ' (' .
                    $product->getStartDate()->format('d-m-Y').')';
                },
                'required' => true,
                'placeholder' => 'Select...',
                'attr' => ['class' => 'select2']
            ))
            ->add('programMembership', EntityType::class, array(
                'class' => ProgramMembership::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.programName', 'ASC');
                },
                'choice_label' => 'programName',
                'required' => true,
                'placeholder' => 'Select...',
                'attr' => ['class' => 'select2']
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AttendanceList::class,
        ]);
    }
}
