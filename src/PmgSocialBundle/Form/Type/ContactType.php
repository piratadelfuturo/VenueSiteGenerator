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
                    'pattern'     => '.{2,}', //minlength
                ),
                'constraints' => array(
                    new NotBlank(array('message' => 'Name should not be blank.')),
                    new Length(array('min' => 2))
                )
            ))
            ->add('last_name', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Last name',
                    'pattern'     => '.{2,}', //minlength
                ),
                'constraints' => array(
                        new NotBlank(array('message' => 'Last name should not be blank.')),
                        new Length(array('min' => 3))
                )

            ))
            ->add('email', EmailType::class, array(
                'attr' => array(
                    'placeholder' => 'E-mail'
                ),
                'constrainst' => array(
                    new NotBlank(array('message' => 'Email should not be blank.')),
                    new Email(array('message' => 'Invalid email address.'))
                ),

            ))
            ->add('message', TextareaType::class, array(
                'attr' => array(
                    'cols' => 90,
                    'rows' => 10,
                    'placeholder' => 'Message'
                ),
                'constraints' => array(
                    new NotBlank(array('message' => 'Message should not be blank.')),
                    new Length(array('min' => 5))
                )
            ))
            ->add('send', SubmitType::class, array('label' => 'Send'));
    }

    public function getBlockPrefix()
    {
        return 'contact';
    }
    
    
}
