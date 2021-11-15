<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Data\SearchData;


/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }
        // Find/search articles by title/content
        public function findArticlesByName(string $query)
        {
            $qb = $this->createQueryBuilder('p');
            $qb
                ->where(
                    $qb->expr()->andX(
                        $qb->expr()->orX(
                            $qb->expr()->like('p.titre', ':query'),
                           
                        ),
                      
                    )
                )
                ->setParameter('query', '%' . $query . '%')
            ;
            return $qb
                ->getQuery()
                ->getResult();
        }
       

  
    
  

  
    public function setQuantity($value, $id)
    {
        $updateEtat = $this->createQueryBuilder('r')
            ->update(Livre::class, 'r')
            ->set('r.qteStock', '?1')
            ->where('r.id = :id')
            ->setParameter('id', $id)
            ->setParameter(1, $value)
            ->getQuery();
        dump($updateEtat);
        $updateEtat->execute();
    }
  
}
