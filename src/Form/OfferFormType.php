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
	    	->add('alternateName', TextType::class, ['required' => true])
	    	->add('price', MoneyType::class, ['required' => true, 'grouping' => false])
	    	->add('inventoryLevel', TextType::class, ['required' => false])
	    	->add('availability', ChoiceType::class, [
	    		'required' => true,
	    		'placeholder' => 'Select...',
	    		'attr' => [
							'class' => 'select2'
						],
	    		 'choices'  => array(
			        'In stock' => 'In stock',
			        'Out of stock' => 'Out of stock',
			        'Reorder' => 'Reorder')])
			->add('validFrom', DateType::class, ['required' => true, 'widget' => 'single_text', 'html5' => false, 'format' => 'dd-MM-yyyy'])
			->add('validThrough', DateType::class, ['required' => false, 'widget' => 'single_text', 'html5' => false, 'format' => 'dd-MM-yyyy'])
			->add('availabilityStarts', DateType::class, ['required' => false, 'widget' => 'single_text', 'html5' => false, 'format' => 'dd-MM-yyyy'])
			->add('availabilityEnds', DateType::class, ['required' => false, 'widget' => 'single_text', 'html5' => false, 'format' => 'dd-MM-yyyy'])
	    	;
	} 
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offer::class
        ]);
    }
}