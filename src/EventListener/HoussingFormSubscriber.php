<?php
namespace App\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class HoussingFormSubscriber implements EventSubscriberInterface{
    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }
    public static function getSubscribedEvents(){
       

        return [
            FormEvents::PRE_SUBMIT => 'onPreSubmit',
            FormEvents::PRE_SET_DATA => 'preSetData'
        ];
    }

    
    public function onPreSubmit(FormEvent $event): void{
        $form = $event->getForm();
         
        if($form->has("postalCode") && !$form->has("city")){
            $postalCode = $event->getData()["postalCode"];
            $conn = $this->em->getConnection();

            $sql = 'Select ville_nom FROM spec_villes_france_free WHERE ville_code_postal LIKE :code';
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery(['code' => "%".$postalCode."%"]);
            
            $cities = $resultSet->fetchAllAssociative();

            $villes = [];
            foreach($cities as $c){
                $villes[$c['ville_nom']] = $c['ville_nom'];
            }
            //dd($cities);
            $form->add('city', ChoiceType::class,  [
                'choices'  =>
                $villes ,
               'constraints' => [new NotBlank(["message"=>"Merci de préciser la ville"])],
                "mapped"=>false
            ]);
            
        }
    }

    public function preSetData(FormEvent $event){
        //dd($event->getData());
        if($event->getData()->getId() !=null){
            $form = $event->getForm();
            $form->remove('houssingType');
            $form->remove('adresse');
            $form->remove('postalCode');
            $form->remove('type');
            $form->remove('slug');
        }
    }
}