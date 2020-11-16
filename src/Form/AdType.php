<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
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
    private function getConfiguration($label, $placeholder){
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', TextType::class, $this->getConfiguration("Type de voiture", "Entrer le type de votre voiture (camping car, van, combi, ...)" ))
            //->add('slug', TextType::class, $this->getConfiguration("Chaine URL", "Adresse web (automatique)"))
            ->add('coverImage', UrlType::class, $this->getConfiguration("URL de l'image principale", "Donnez l'adresse d'une image de votre véhicule"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction", "Donnez une déscription globale de l'annonce"))
            ->add('Content', TextareaType::class, $this->getConfiguration("Description détaillée", "Entrez une description détaillée de votre véhicule !"))
            ->add('places', IntegerType::class, $this->getConfiguration("Nombre de Places", "Le nombre de place dans le véhicule !"))
            ->add('bedding', IntegerType::class, $this->getConfiguration("Nombre de Couchages", "Le nombre de couchages dans le véhicule !"))
            ->add('price', MoneyType::class, $this->getConfiguration("Prix par jour","Indiquez le prix que vous voulez par jour !"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
