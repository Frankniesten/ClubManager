<?php
	
namespace App\Form;

use App\Entity\Organization;
use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityRepository;

class OrganizerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    
	    $builder
	    	->add('organizer', EntityType::class, array(
					    'class' => Organization::class,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u');
					    },
					    'choice_label' => function (Organization $organisation) { return
						    $organisation->getLegalName();
						    
						    },
					    'required' => false,
					    'label' => 'Organisator',
					    'multiple' => true 
					));
	}

	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>Event::class
        ]);
    }
}


