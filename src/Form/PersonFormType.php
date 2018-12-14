<?php
	
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PersonFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('givenName', TextType::class, ['label' => 'Voornaam', 'required' => false])
	    	->add('additionalName', TextType::class, ['label' => 'Tussenvoegsel', 'required' => false])
	    	->add('familyName', TextType::class, ['label' => 'Achternaam', 'required' => true])
	    	->add('email', EmailType::class, ['label' => 'Email', 'required' => false])
	    	->add('birthDate', DateType::class, ['label' => 'Geboorte Datum', 'required' => false])
	    	->add('gender', ChoiceType::class, [
	    		'label' => 'Geslacht', 
	    		'required' => false,
	    		 'choices'  => array(
			        'Man' => 'Man',
			        'Vrouw' => 'Vrouw')])
			->add('telephone', TextType::class, ['label' => 'Telefoon', 'required' => false])
			->add('mobilePhone', TextType::class, ['label' => 'Mobiel', 'required' => true]);
	}  
}

