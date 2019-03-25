<?php
	
namespace App\Form;

use App\Entity\Event;
use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityRepository;

class SponsorFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    
	    $builder
	    	->add('sponsor', EntityType::class, array(
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
					    'label' => 'Sponsoren',
					    'multiple' => true 
					));
	
	}

	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class
        ]);
    }
}


