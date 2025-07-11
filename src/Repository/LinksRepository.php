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
        if ($link->isDisposable() === null) {
            $link->setDisposable(false);
        }
        $link->setShortUrl($slug);
        $link->setCreationDate(new \DateTime());
        $link->setNumbersOfClick(0);

        $this->getEntityManager()->persist($link);
        $this->getEntityManager()->flush();
        return $link;
    }

    /**
     * Функция обновления показателя счетчика перехода на сайт по короткой ссылки, обновление вренмени
     */
    public function updateClickLink(Links $link): Links{
        $link->setLastUseDate(new \DateTime());
        $link->setNumbersOfClick($link->getNumbersOfClick() + 1);
        $this->getEntityManager()->flush();
        return $link;
    }


    // Функция для удаления
    public function findNonDisposableOrMultipleClicks()
    {
        return $this->createQueryBuilder('l')
            ->where('l.disposable = false OR l.numbersOfClick > 1')
            ->getQuery()
            ->getResult();
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








    public function saveNewLink2(Links $link): Links
    {
        if ($link->isDisposable() === null) {
            $link->setDisposable(false);
        }
        $link->setCreationDate(new \DateTime());
        $link->setNumbersOfClick(0);

        $this->getEntityManager()->persist($link);
        $this->getEntityManager()->flush();

        $slug = $this->idToShortCode($link->getId());
        $link->setShortUrl($slug);
        $this->getEntityManager()->flush();
        return $link;
    }


    private function idToShortCode(int $id): string
    {
        $map = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $shortCode = '';
        $num = $id;
        $len = 6;

        do {
            $index = $num % 62;
            $shortCode = $map[$index] . $shortCode;
            $num = (int)($num / 62);
        } while ($num > 0);

        return str_pad($shortCode, $len, '0', STR_PAD_LEFT);
    }


}
