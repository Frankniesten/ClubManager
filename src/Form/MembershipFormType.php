<?php
	
namespace App\Form;

use App\Entity\Membership;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class MembershipFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('startDate', DateType::class, ['label' => 'Datum aanvang lidmaatschap', 'required' => true, 'widget' => 'single_text', 'html5' => false, 'format' => 'dd-MM-yyyy'])
	    	->add('endDate', DateType::class, ['label' => 'Datum beëindiging lidmaatschap (optioneel)', 'required' => false, 'widget' => 'single_text', 'html5' => false, 'format' => 'dd-MM-yyyy']); 
	}

	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Membership::class
        ]);
    }
}
