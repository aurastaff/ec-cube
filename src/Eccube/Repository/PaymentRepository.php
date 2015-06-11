<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


namespace Eccube\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * PaymentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PaymentRepository extends EntityRepository
{
    public function findOrCreate($id)
    {
        if ($id == 0) {
            $Creator = $this
                ->getEntityManager()
                ->getRepository('\Eccube\Entity\Member')
                ->find(2)
            ;

            $rank = $this
                ->findOneBy(array(), array('rank' => 'DESC'))
                ->getRank() + 1
            ;

            $Payment = new \Eccube\Entity\Payment();
            $Payment
                ->setRank($rank)
                ->setDelFlg(0)
                ->setFixFlg(1)
                ->setChargeFlg(1)
                ->setCreator($Creator)
            ;

        } else {
            $Payment = $this->find($id);

        }

        return $Payment;
    }

    public function findAllArray()
    {

        $query = $this
            ->getEntityManager()
            ->createQuery('SELECT p FROM Eccube\Entity\Payment p INDEX BY p.id')
        ;
        $result = $query
            ->getResult(Query::HYDRATE_ARRAY)
        ;

        return $result;

    }
}
