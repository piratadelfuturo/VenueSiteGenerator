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
class ContactType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Name',
                    'pattern'     => '.{2,}' //minlength
                )
            ))
            ->add('last_name', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Last name',
                    'pattern'     => '.{2,}' //minlength
                )
            ))
            ->add('email', EmailType::class, array(
                'attr' => array(
                    'placeholder' => 'E-mail'
                )
            ))
            ->add('message', TextareaType::class, array(
                'attr' => array(
                    'cols' => 90,
                    'rows' => 10,
                    'placeholder' => 'Message'
                )
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
            'last_name' => array(
                new NotBlank(array('message' => 'Last name should not be blank.')),
                new Length(array('min' => 3))
            ),

            'email' => array(
                new NotBlank(array('message' => 'Email should not be blank.')),
                new Email(array('message' => 'Invalid email address.'))
            ),
            'message' => array(
                new NotBlank(array('message' => 'Message should not be blank.')),
                new Length(array('min' => 5))
            )
        ));

        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint
        ));
        
        
    }
    
    public function getName()
    {
        return 'contact';
    }
    
    
}
