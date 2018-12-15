<?php
	
namespace App\Form;

use App\Entity\MusicalInstrument;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MusicalInstrumentFormType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('musicalInstrument', TextType::class, ['label' => 'Muziekinstrument', 'required' => true]); 
	} 
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MusicalInstrument::class
        ]);
    }
}

