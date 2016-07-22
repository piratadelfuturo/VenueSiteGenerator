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
                ),
                'label' => 'contact_form.name',
                'constraints' => array(
                    new NotBlank(array('message' => 'Name should not be blank.')),
                    new Length(array('min' => 2))
                )
            ))
            ->add('interested', TextType::class, array(
                'attr' => array(
                    'pattern'     => '.{2,}' //minlength
                ),
                'label' => 'contact_form.interested',
                'constraints' => array(
                    new NotBlank(array('message' => 'Last name should not be blank.')),
                    new Length(array('min' => 3))
                )
            ))
            ->add('email', EmailType::class, array(
                'attr' => array(),
                'label' => 'contact_form.email',
                'constraints' => array(
                    new NotBlank(array('message' => 'Email should not be blank.')),
                    new Email(array('message' => 'Invalid email address.'))
                )
            ))
            ->add('details1', TextType::class, array(
                'attr' => array( 'class' => 'width55'),
                'label' => 'contact_form.details1',
                'required' => false
            ))
            ->add('details2', TextType::class, array(
                'attr' => array( 'class' => 'width100'),
                'label' => 'contact_form.details2',
                'required' => false
            ))
            ->add('details3', TextType::class, array(
                'attr' => array( 'class' => 'width100'),
                'label' => 'contact_form.details3',
                'required' => false
            ))
            ->add('details4', TextType::class, array(
                'attr' => array( 'class' => 'width100' ),
                'label' => 'contact_form.details4',
                'required' => false
            ))
            ->add('send', SubmitType::class, array('label' => 'Send'));
    }

    
    
    public function getBlockPrefix()
    {
        return 'corp_contact';
    }
    
    
}