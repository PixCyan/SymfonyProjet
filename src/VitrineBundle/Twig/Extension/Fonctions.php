<?php
/**
 * Created by PhpStorm.
 * User: raffennn
 * Date: 13/04/16
 * Time: 20:37
 */

namespace VitrineBundle\Twig\Extension;
use Twig_Extension;
use Twig_SimpleFunction;
use VitrineBundle\Entity\Article;

class Fonctions extends Twig_Extension {
    private $em;

    /*
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
        $this->conn = $em->getConnection();
    }*/


    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName() {
        return 'fonctions_extension';
    }

    public function getFilters() {
        return array(
            new \Twig_SimpleFilter('typeApidae', array($this, 'getTypeApidae')));
    }

    public function getFunctions() {
        return array(new Twig_SimpleFunction('tradLangue', array($this, 'getTradLangue')),
            new Twig_SimpleFunction('firstImage', array($this, 'getFirstImage')));
    }

    function getTypeApidae($str) {
        $chaineExplode = explode("_", $str);
        return $chaineExplode[0];
    }

    function getFirstImage(Article $article) {
        //return $articles = $this->em->getRepository(Article::class)->articleLesPlusVendus();
        $img = null;
        foreach($article->getImages() as $value) {
            if($value->getOrdre() == 1) {
                $img = $value;
            }
        }
        return $img;

    }
}