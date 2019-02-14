<?php
	
namespace App\Form;

use App\Entity\Service;
use App\Entity\Offer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Doctrine\ORM\EntityRepository;

class OfferFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('alternateName', TextType::class, ['label' => 'Naam aanbod', 'required' => true])
	    	->add('price', MoneyType::class, ['label' => 'Prijs', 'required' => true, 'grouping' => false])
	    	->add('inventoryLevel', TextType::class, ['label' => 'Voorraadstatus', 'required' => false])
	    	->add('availability', ChoiceType::class, [
	    		'label' => 'Voorraad', 
	    		'required' => true,
	    		'attr' => [
							'class' => 'select2'
						],
	    		 'choices'  => array(
			        'Voorraad' => 'Voorraad',
			        'Uitverkocht' => 'Uitverkocht',
			        'Nabestelling' => 'Nabestelling')])
			->add('validFrom', DateType::class, ['label' => 'Aanbod beschikbaar (van / tot)', 'required' => true, 'widget' => 'single_text', 'html5' => false,])
			->add('validThrough', DateType::class, ['label' => 'Aanbod beschikbaar (van / tot)', 'required' => false, 'widget' => 'single_text', 'html5' => false,])
			->add('availabilityStarts', DateType::class, ['label' => 'Product beschikbaar (van / tot)', 'required' => false, 'widget' => 'single_text', 'html5' => false,])
			->add('availabilityEnds', DateType::class, ['label' => 'Product beschikbaar (van / tot)', 'required' => false, 'widget' => 'single_text', 'html5' => false,])
			
	    	
	    	;
	
	} 
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offer::class
        ]);
    }
}

