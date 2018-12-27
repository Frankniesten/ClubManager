<?php
	
namespace App\Form;

use App\Entity\Person;
use App\Entity\ProgramMembership;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityRepository;

class MemberOfFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    	->add('memberOf', EntityType::class, array(
					    'class' => ProgramMembership::class,
					    'query_builder' => function (EntityRepository $er) {
					        return $er->createQueryBuilder('u');
					    },
					    'choice_label' => 'programName',
					    'required' => false,
					    'label' => 'Rol(len)',
					    'multiple' => true
					));
	}

	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class
        ]);
    }
}
