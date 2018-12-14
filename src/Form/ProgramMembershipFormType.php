<?php
	
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProgramMembershipFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('programName', TextType::class, ['label' => 'Rol'])
	    	->add('description', TextType::class, ['label' => 'Omschrijving', 'required' => false]);    
	}
    
}

