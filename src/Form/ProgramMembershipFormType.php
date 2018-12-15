<?php
	
namespace App\Form;

use App\Entity\ProgramMembership;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ProgramMembershipFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('programName', TextType::class, ['label' => 'Rol'])
	    	->add('description', TextType::class, ['label' => 'Omschrijving', 'required' => false]);    
	}
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProgramMembership::class
        ]);
    }
    
}

