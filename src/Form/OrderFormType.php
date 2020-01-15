<?php
	
namespace App\Form;

use App\Entity\Orders;
use App\Entity\Offer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
	    	->add('orderDate', DateType::class, ['required' => true, 'widget' => 'single_text', 'html5' => false, 'format' => 'dd-MM-yyyy'])
			->add('orderStatus', ChoiceType::class, array(
				'choices'  => array(
					'In behandeling' => 'In behandeling',
					'Afgerond' => 'Afgerond',
					'Geannuleerd' => 'Geannuleerd',
					'In de wacht' => 'In de wacht',
					'Terugbetaald' => 'Terugbetaald',
					'Wachtend op betaling' => 'Wachtend op betaling'),
					'placeholder' => 'Selecteer...',
					'attr' => [
							'class' => 'select2'
						]
						))
        ->add('orderItem', CollectionType::class, [
            'entry_type' => OrderItemFormType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,

        ]);
	}

	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Orders::class
        ]);
    }
}

