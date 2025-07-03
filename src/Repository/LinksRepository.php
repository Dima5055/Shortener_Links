<?php

namespace App\Repository;

use App\Entity\Links;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;


/**
 * @extends ServiceEntityRepository<Links>
 */
class LinksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Links::class);
    }

    /**
     * Функция добавление новой ссылки
     */
    public function saveNewLink(Links $link, string $slug): Links
    {
        date_default_timezone_set('Europe/Moscow');
        if ($link->isDisposable() === null) {
            $link->setDisposable(false);
        }
        $link->setShortUrl($slug);
        $link->setCreationDate(new \DateTime());
        $link->setLastUseDate(new \DateTime());
        $link->setNumbersOfClick(0);

        $this->getEntityManager()->persist($link);
        $this->getEntityManager()->flush();
        return $link;
    }

    /**
     * Функция обновления показателя счетчика перехода на сайт по короткой ссылки, обновление вренмени
     */
    public function updateClickLink(Links $link): Links{
        date_default_timezone_set('Europe/Moscow');
        $link->setLastUseDate(new \DateTime());
        $link->setNumbersOfClick($link->getNumbersOfClick() + 1);
        $this->getEntityManager()->flush();
        return $link;
    }


    //Функция получение полной сокращенной ссылки по идентфикатору
    public function fullShortLink(string $slug, string $schemeAndHost): string
    {
        return $schemeAndHost . '/short/' . $slug;
    }


    //Функция для удаление записей по списку Links id
    public function deleteByIds($selectedIds): void
    {
        if (!empty($selectedIds)) {
            $links = $this->findBy(['id' => $selectedIds]);
            foreach ($links as $link) {
                $this->getEntityManager()->remove($link);
            }
            $this->getEntityManager()->flush();
        }
    }


}
