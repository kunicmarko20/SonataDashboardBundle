<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\DashboardBundle\Tests\Entity;

use Sonata\DashboardBundle\Tests\Model\Dashboard;

/**
 *
 */
class DashboardTest extends \PHPUnit_Framework_TestCase
{
    public function testGetterSetter()
    {
        $dashboard = new Dashboard();
        $dashboard->setEnabled(true);
        $this->assertTrue($dashboard->getEnabled());

        $time = new \DateTime();
        $dashboard->setCreatedAt($time);
        $dashboard->setUpdatedAt($time);
        $this->assertEquals($time, $dashboard->getCreatedAt());
        $this->assertEquals($time, $dashboard->getUpdatedAt());

        $dashboard->setName(null);
        $this->assertEquals('-', (string) $dashboard);
        $dashboard->setName('Salut');
        $this->assertEquals('Salut', (string) $dashboard);
    }
}
