<?php
	
namespace App\Form;

use App\Entity\Organization;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class OrganizationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('legalName', TextType::class, ['label' => 'Naam', 'required' => true])
	    	->add('description', TextType::class, ['label' => 'Omschrijving', 'required' => false])
	    	->add('email', EmailType::class, ['label' => 'Email', 'required' => false])
			->add('telephone', TextType::class, ['label' => 'Telefoon', 'required' => false])
			->add('telephone_2', TextType::class, ['label' => 'Mobiel', 'required' => false])
			->add('leiCode', TextType::class, ['label' => 'K.v.K. Nummer', 'required' => false])
			->add('vatID', TextType::class, ['label' => 'Belasting Nummer', 'required' => false])
			->add('url', UrlType::class, ['label' => 'Website', 'required' => false]);
	} 
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Organization::class
        ]);
    }
}

