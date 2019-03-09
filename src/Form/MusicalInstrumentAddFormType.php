<?php
	
namespace App\Form;

use App\Entity\Person;
use App\Entity\MusicalInstrument;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityRepository;

class MusicalInstrumentAddFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('musicalInstrument', EntityType::class, array(
					    'class' => MusicalInstrument::class,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u');
					    },
					    'placeholder' => 'Selecteer...',
					    'choice_label' => 'musicalInstrument',
					    'attr' => [
							'class' => 'select2'
						],
					    'required' => false,
					    'label' => 'Muziekinstrument'
					));
	}

	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class
        ]);
    }
}
