<?php

declare(strict_types=1);

namespace Odiseo\SyliusReportPlugin\Repository;

trait AddressRepositoryTrait
{
    // `createQueryBuilder()` est fournie par la classe utilisatrice, qui etend l'EntityRepository de
    // Doctrine. La declaration abstraite qui figurait ici en donnait le contrat, mais avec une signature
    // non typee : depuis doctrine/orm 3, qui type cette methode, PHP la jugeait incompatible et le
    // chargement de toute classe utilisant ce trait echouait en erreur fatale. La retirer garde le trait
    // utilisable sur l'ORM 2 comme sur l'ORM 3, ou une signature typee ici exclurait l'ORM 2.

    public function findByCityName(string $cityName): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.city LIKE :city')
            ->setParameter('city', '%' . $cityName . '%')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByProvinceName(string $provinceName): array
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.province', 'province', 'WITH', 'province.code = o.provinceCode')
            ->where('o.provinceName LIKE :province')
            ->orWhere('province.name LIKE :province')
            ->setParameter('province', '%' . $provinceName . '%')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByPostcode(string $postcode): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.postcode LIKE :postcode')
            ->setParameter('postcode', '%' . $postcode . '%')
            ->getQuery()
            ->getResult()
        ;
    }
}
