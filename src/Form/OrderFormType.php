<?php
	
namespace App\Form;

use App\Entity\Orders;
use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;


class OrderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('orderDate', DateType::class, ['required' => true, 'widget' => 'single_text', 'html5' => false, 'format' => 'dd-MM-yyyy'])
            ->add('person', EntityType::class, [
                'class' => Person::class,
                'choice_label' => function (Person $person) { return
                    $person->getFamilyName(). ', ' .
                    $person->getGivenName(). ' ' .
                    $person->getAdditionalName();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.familyName', 'ASC');
                },
                'attr' => ['class' => 'select2'],
                'required' => true,
                'placeholder' => 'Select...'
            ])
			->add('orderStatus', ChoiceType::class, array(
				'choices'  => array(
					'In progress' => 'In progress',
					'Finished' => 'Finished',
					'Canceled' => 'Canceled',
					'On hold' => 'On hold',
					'Refunded' => 'Refunded',
					'Waiting for payment' => 'Waiting for payment'),
					'placeholder' => 'Select...',
					'attr' => [
							'class' => 'select2'
						]
						))
        ->add('orderItem', CollectionType::class, [
            'entry_type' => OrderItemFormType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
        ]);
	}

	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Orders::class
        ]);
    }
}

