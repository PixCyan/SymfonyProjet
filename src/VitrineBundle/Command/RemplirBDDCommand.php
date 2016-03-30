<?php

namespace VitrineBundle\Command;

use Exception;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VitrineBundle\Entity\Article;
use VitrineBundle\Entity\Categorie;

class RemplirBDDCommand extends ContainerAwareCommand
{
    private $em;

    // …
    protected function configure()
    {
        $this
            ->setName('command:remplir')
            ->setDescription('Traitement des données pour remplir la base de données');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //$this->em = $this->getDoctrine()->getManager();
        $this->em = $this->getApplication()->getKernel()->getContainer()->get('doctrine')->getManager();

        try {
            //Récupération fichiers :
            $fileBDD = file_get_contents("/var/www/html/sites/Symfony/Projet/src/VitrineBundle/Command/bonbons.json");
            $data = json_decode($fileBDD);
            foreach ($data->categories as $value) {
                $this->traitementCategories($value);
            }
            $this->em->flush();
            foreach ($data->articles as $value) {
                $this->traitementArticles($value);
                $this->em->flush();
            }

            //---
            $output->writeln("Fin de traitement.");
        } catch (Exception $e) {
            $output->writeln("Problème : " . $e->getMessage());
        }
    }

    private function traitementCategories($value)
    {
        $libelle = $value->nom;
        $ordre = $value->ordre;
        $categorie = $this->em->getRepository(Categorie::class)->findOneByLibelle($libelle);
        if($categorie) {
            $update = true;
        } else {
            $categorie = new Categorie();
            $update = false;
        }
        $categorie->setLibelle($libelle);
        $categorie->setOrdre($ordre);
        $this->updateObjet($categorie, $update);

    }

    private function traitementArticles($value)
    {
        $libelle = $value->titre;
        $article = $this->em->getRepository(Article::class)->findOneByLibelle($libelle);
        if($article) {
            $update = true;
        } else {
            $article = new Article();
            $update = false;
        }
        $article->setLibelle($libelle);
        $article->setDescription($value->description);
        $article->setImage(" TODO ");
        $article->setPrix($value->prix);
        $article->setStock($value->stock);
        foreach($value->categories as $categorie) {
            $cat = $this->em->getRepository(Categorie::class)->findOneById($categorie->ref);
            if($cat) {
                if(!$article->getCategories()->contains($cat)) {
                    $article->addCategorie($cat);
                    $this->updateObjet($cat, true);
                }
                if(!$cat->getArticles()->contains($article)) {
                    $cat->addArticle($article);
                }
                $this->updateObjet($article, $update);
            }
        }
    }

    private function updateObjet($objet, $update) {
        if($update) {
            $this->em->merge($objet);
        } else {
            $this->em->persist($objet);
        }
    }

}
