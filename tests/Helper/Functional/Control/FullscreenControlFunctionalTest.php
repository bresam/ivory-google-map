<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\Tests\GoogleMap\Helper\Functional\Control;

use Ivory\GoogleMap\Control\ControlPosition;
use Ivory\GoogleMap\Control\FullscreenControl;
use Ivory\GoogleMap\Map;
use Ivory\Tests\GoogleMap\Helper\Functional\AbstractMapFunctional;

/**
 * @author GeLo <geloen.eric@gmail.com>
 *
 * @group functional
 */
class FullscreenControlFunctionalTest extends AbstractMapFunctional
{
    public function testRender()
    {
        $map = new Map();
        $map->getControlManager()->setFullscreenControl($this->createFullscreenControl());

        $this->renderMap($map);
        $this->assertMap($map);
    }

    /**
     * @return FullscreenControl
     */
    private function createFullscreenControl()
    {
        return new FullscreenControl(ControlPosition::TOP_CENTER);
    }
}
