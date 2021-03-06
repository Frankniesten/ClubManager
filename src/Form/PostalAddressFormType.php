<?php
	
namespace App\Form;

use App\Entity\PostalAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PostalAddressFormType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('venue', TextType::class, ['required' => true])
	    	->add('streetAddress', TextType::class, ['required' => true])
	    	->add('postalCode', TextType::class, ['required' => true])
	    	->add('addressLocality', TextType::class, ['required' => true]);
	} 
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostalAddress::class
        ]);
    }
}

