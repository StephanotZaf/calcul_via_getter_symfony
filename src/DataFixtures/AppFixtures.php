<?php

namespace App\DataFixtures;

use App\Entity\Grade;
use App\Entity\Lieu;
use App\Entity\Personnel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $gradeArrayCollection = new ArrayCollection();
        $gradeValues = [
            array(
                "code" => "GST",
                "name" => "Gendarme stagiaire"
            ), array(
                "code" => "G1",
                "name" => "Gendarme de premier classe"
            ), array(
                "code" => "G2",
                "name" => "Gendarme de deuxième classe"
            ), array(
                "code" => "GHC",
                "name" => "Gendarme hors classe"
            ), array(
                "code" => "GP2C",
                "name" => "Gendarme principale de deuxième classe"
            )
            , array(
                "code" => "GP1C",
                "name" => "Gendarme principale de preémière classe"
            )
            , array(
                "code" => "GPHC",
                "name" => "Gendarme principale hors classe"
            ), array(
                "code" => "GPCE",
                "name" => "Gendarme principale de classe exceptionnelle"
            )];
        foreach ($gradeValues as $gradeValue)
        {
            $grade = new Grade();
            $grade->setCode($gradeValue['code']);
            $grade->setName($gradeValue['name']);
            $manager->persist($grade);
            $gradeArrayCollection->add($grade);
        }

        $lieuArrayCollection = new ArrayCollection();
        $lieuValues = [
            array(
                "name" => "Antananarivo"
            ), array(
                "name" => "Vakinakaratra"
            ), array(
                "name" => "Analamanga"
            ), array(
                "name" => "Haute Matsiatra"
            ), array(
                "name" => "Manakara"
            )
            , array(
                "name" => "Sakaraha"
            )
            , array(
                "name" => "Vondrozo"
            ), array(
                "name" => "Betioky"
            ), array(
                "name" => "Mananara Nord"
            )
            , array(
                "name" => "Fort dauphin"
            )
            , array(
                "name" => "Mahajanga"
            ), array(
                "name" => "Toamasina"
            )];
        foreach ($lieuValues as $lieuValue)
        {
            $lieu = new Lieu();
            $lieu->setName($lieuValue['name']);
            $manager->persist($lieu);
            $lieuArrayCollection->add($lieu);
        }

        $personnelValues = [
            array(
                "firstName" => "RAKOTONIRIN",
                "lastName" => "Jean Abel"
            ), array(
                "firstName" => "RAKOTOARISO",
                "lastName" => "Jean Max"
            ), array(
                "firstName" => "RAKOTOARIVONY",
                "lastName" => "Jean Nino"
            ), array(
                "firstName" => "RAKOTOZINA",
                "lastName" => "Jean Paul"
            ), array(
                "firstName" => "RAKOTONIRINA",
                "lastName" => "Jean Pierre"
            )
            , array(
                "firstName" => "RAKOTONIAVO",
                "lastName" => "Jean Mamie"
            )
            , array(
                "firstName" => "RAKOTONANDRASANA",
                "lastName" => "Jean Baptiste"
            ), array(
                "firstName" => "RAKOTOARISOA",
                "lastName" => "Jean Nirina"
            )];

        foreach ($personnelValues as $personnelValue)
        {
            $personnel = new Personnel();
            $personnel->setFirstName($personnelValue['firstName']);
            $personnel->setLastName($personnelValue['lastName']);
            $personnel->setGrade($gradeArrayCollection->get(rand(0,sizeof($gradeArrayCollection->toArray()) -1 )));
            $personnel->setLieu($lieuArrayCollection->get(rand(0,sizeof($lieuArrayCollection->toArray()) - 1 )));
            $manager->persist($personnel);
        }

        $manager->flush();
    }
}
