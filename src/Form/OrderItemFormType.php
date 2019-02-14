<?php
	
namespace App\Form;

use App\Entity\OrderItem;
use App\Entity\Offer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;

class OrderItemFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('orderQuantity', TextType::class, ['label' => 'Aantal', 'required' => true])    
			
			->add('orderedItem', EntityType::class, array(
					    'class' => Offer::class,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u')
								
								->where('u.validFrom < :now AND u.validThrough > :now')
								->setParameter('now', new \DateTime('now'))
								
								
					            ->orderBy('u.alternateName', 'ASC');
					    },
					    'choice_label' => 'alternateName',
					    'required' => true,
					    'label' => 'Product',
					    'multiple' => false,
					    'attr' => [
							'class' => 'select2'
						]
					));
	} 

	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderItem::class
        ]);
    }
}

