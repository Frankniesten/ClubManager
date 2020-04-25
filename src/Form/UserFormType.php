<?php
	
namespace App\Form;

use App\Entity\User;
use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
			->add('person', EntityType::class, array(
                'class' => Person::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                    ->leftJoin('p.user', 'u')
                        ->where('u.id IS NULL AND p.email IS NOT NULL')
                    ->orderBy('p.familyName', 'ASC');
                    },
                'placeholder' => 'Select...',
                'choice_label' => function (Person $person) { return
                    $person->getFamilyName(). ', ' .
                    $person->getGivenName(). ' ' .
                    $person->getAdditionalName();
                },
                'required' => true,
                'multiple' => false,
                'attr' => [
                    'class' => 'select2'
                ])
            )
        ->add('roles', UserRoleFormType::class, [
            'data_class' => User::class,
        ]);;
	} 
	
	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
        	->setDefaults(['data_class' => User::class]);
    }
}

