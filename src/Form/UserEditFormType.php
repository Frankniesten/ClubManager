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

class UserEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
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

