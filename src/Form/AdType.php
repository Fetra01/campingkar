<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    
    /**
     * Permet d'avoir la configuration de base d'un champ
     * 
     * @param string $label
     * @param string $placeholder
     * @return array
     */
    private function getConfiguration($label, $placeholder, $option = []){
        return array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ], $option);
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre","Tapez un super titre pour votre annonce !"))
            ->add('type', ChoiceType::class, $this->getConfiguration("Type de voiture", "Type de voiture", [
                'choices' => [
                   'Camping car' => "campng car",
                   'Van'         => "van",
                   'Combi'       => "Combi"
                ],
            ] ))
            ->add('slug', TextType::class, $this->getConfiguration("Chaine URL", "Adresse web (automatique)",[
                'required' => false
            ]))
            ->add('coverImage', UrlType::class, $this->getConfiguration("URL de l'image principale", "Donnez l'adresse d'une image de votre véhicule"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction", "Donnez une déscription globale de l'annonce"))
            ->add('Content', TextareaType::class, $this->getConfiguration("Description détaillée", "Entrez une description détaillée de votre véhicule !"))
            ->add('places', IntegerType::class, $this->getConfiguration("Nombre de Places", "Le nombre de place dans le véhicule !"))
            ->add('bedding', IntegerType::class, $this->getConfiguration("Nombre de Couchages", "Le nombre de couchages dans le véhicule !"))
            ->add('price', MoneyType::class, $this->getConfiguration("Prix par jour","Indiquez le prix que vous voulez par jour !"))
            ->add('images', CollectionType::class,
                [
                    'entry_type'    => ImageType::class,
                    'allow_add'     => true,
                    'allow_delete'  => true
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
