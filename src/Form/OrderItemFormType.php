<?php
	
namespace App\Form;

use App\Entity\OrderItem;
use App\Entity\Offer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class OrderItemFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('orderQuantity', IntegerType::class, array( 'required' => true))
			->add('orderedItem', EntityType::class, array(
					    'class' => Offer::class,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('u')
                                ->orderBy('u.alternateName', 'ASC');
                        },
					    'choice_label' => 'alternateName',
					    'required' => true,
					    'multiple' => false,
					    'placeholder' => 'Select...',
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

