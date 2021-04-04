<?php
	
namespace App\Form;

use App\Entity\Event;
use App\Entity\Category;
use App\Entity\PostalAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Doctrine\ORM\EntityRepository;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('about', TextType::class, [
	    	    'required' => true
            ])
	    	->add('description', TextType::class, [
	    	    'required' => false
            ])
	    	->add('startDate', DateType::class, [
                'required' => true,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd-MM-yyyy'
            ])
	    	->add('endDate', DateType::class, [
	    	    'required' => true,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd-MM-yyyy'
            ])
	    	->add('doorTime', TimeType::class, [
	    	    'required' => false,
                'widget' => 'single_text',
                'html5' => false
            ])
	    	->add('startTime', TimeType::class, [
	    	    'required' => true,
                'widget' => 'single_text',
                'html5' => false
            ])
	    	->add('endTime', TimeType::class, [
	    	    'required' => true,
                'widget' => 'single_text',
                'html5' => false
            ])
	    	->add('eventStatus', ChoiceType::class, [
	    		'required' => true,
	    		'attr' => [
							'class' => 'select2'
						],
				 'placeholder' => 'Select...',
	    		 'choices'  => array(
			        'Confirmed' => 'Confirmed',
			        'Tentative' => 'Tentative',
			        'Cancelled' => 'Cancelled')
            ])
			->add('isAccessibleForFree', CheckboxType::class, [
			    'required' => false,
                'attr' => ['data-plugin' => 'switchery']
            ])
			->add('maximumAttendeeCapacity', IntegerType::class, [
			    'required' => false
            ])
			->add('remainingAttendeeCapacity', IntegerType::class, [
			    'required' => false
            ])
	    	->add('category', EntityType::class, array(
					    'class' => Category::class,
					    'multiple' => true,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u')
					        	->andWhere('u.additionalType = :additionalType')
					        	->setParameter('additionalType', 'event')
					            ->orderBy('u.name', 'ASC');
					    },
					    'choice_label' => 'name',
					    'required' => true,
					    'attr' => [
							'class' => 'select2 select2-multiple',
							'multiple' => 'multiple',
							'multiple data-placeholder' => 'Select...'
						]
					))
			->add('location', EntityType::class, array(
					    'class' => PostalAddress::class,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u');
					        	//->andWhere('u.additionalType = :additionalType')
					        	//->setParameter('additionalType', 'event')
					            //->orderBy('u.name', 'ASC');
					    },
					    'choice_label' => 'venue',
					    'placeholder' => 'Select...',
					    'required' => true,
					    'attr' => [
							'class' => 'select2'
						]
					)); 
	} 
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class
        ]);
    }
}
