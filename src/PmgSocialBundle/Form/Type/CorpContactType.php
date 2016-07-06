<?php
namespace PmgSocialBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Description of ContactType
 *
 * @author daniel
 */
class CorpContactType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'attr' => array(
                    'pattern'     => '.{2,}' //minlength
                )
            ))
            ->add('interested', TextType::class, array(
                'attr' => array(
                    'pattern'     => '.{2,}' //minlength
                )
            ))
            ->add('email', EmailType::class, array(
                'attr' => array()
            ))
            ->add('details1', TextType::class, array(
                'attr' => array()
            ))
            ->add('details2', TextType::class, array(
                'attr' => array()
            ))
            ->add('details3', TextType::class, array(
                'attr' => array()
            ))
            ->add('details4', TextType::class, array(
                'attr' => array()
            ))
            ->add('send', SubmitType::class, array('label' => 'Send'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
                
        $collectionConstraint = new Collection(array(
            'name' => array(
                new NotBlank(array('message' => 'Name should not be blank.')),
                new Length(array('min' => 2))
            ),
            'insterested' => array(
                new NotBlank(array('message' => 'Last name should not be blank.')),
                new Length(array('min' => 3))
            ),

            'email' => array(
                new NotBlank(array('message' => 'Email should not be blank.')),
                new Email(array('message' => 'Invalid email address.'))
            )
        ));

        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint
        ));
        
        
    }
    
    public function getName()
    {
        return 'corp_contact';
    }
    
    
}
