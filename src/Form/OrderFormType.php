<?php
	
namespace App\Form;

use App\Entity\Orders;
use App\Entity\Offer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;

class OrderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('orderDate', DateType::class, ['label' => 'Order datum', 'required' => true, 'widget' => 'single_text', 'html5' => false,])    
			->add('orderStatus', ChoiceType::class, array(
				'choices'  => array(
					
					'In behandeling' => 'In behandeling',
					'Afgerond' => 'Afgerond',
					'Geannuleerd' => 'Geannuleerd',
					'In de wacht' => 'In de wacht',
					'Terugbetaald' => 'Terugbetaald',
					'Wachtend op betaling' => 'Wachtend op betaling'))
			);	
	} 

	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Orders::class
        ]);
    }
}

