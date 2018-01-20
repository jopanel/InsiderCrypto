<?php
/**
 * LiskPhp - A PHP wrapper for the LISK API
 * Copyright (c) 2017  Marcus Puchalla <cb0@0xcb0.com>
 *
 * LiskPhp is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * LiskPhp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with LiskPhp.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Lisk\Api\Apps;

use Lisk\AbstractResponse;
use Lisk\Model\App;

class GetAppsResponse extends AbstractResponse
{
    private $apps;

    public function success($jsonResponse)
    {
        $apps = [];
        foreach ($jsonResponse['dapps'] as $app) {
            $app = (new App())
                ->setName($app['name'])
                ->setDescription($app['description'])
                ->setTags($app['tags'])
                ->setLink($app['link'])
                ->setType($app['type'])
                ->setCategory($app['category'])
                ->setIcon($app['icon'])
                ->setTransactionId($app['transactionId']);
            $apps[] = $app;
        }
        $this->apps = $apps;
    }

    /**
     * @return mixed
     */
    public function getApps()
    {
        return $this->apps;
    }

    /**
     * @param mixed $apps
     */
    public function setApps($apps)
    {
        $this->apps = $apps;
    }


}