<?php

/*
 * This file is part of the Ivory Google Map package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMap\Overlay;

use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Utility\OptionsAwareInterface;
use Ivory\GoogleMap\Utility\OptionsAwareTrait;
use Ivory\GoogleMap\Utility\StaticOptionsAwareInterface;
use Ivory\GoogleMap\Utility\StaticOptionsAwareTrait;
use Ivory\GoogleMap\Utility\VariableAwareTrait;

/**
 * @see http://code.google.com/apis/maps/documentation/javascript/reference.html#Marker
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class Marker implements ExtendableInterface, OptionsAwareInterface, StaticOptionsAwareInterface
{
    use OptionsAwareTrait;
    use StaticOptionsAwareTrait;
    use VariableAwareTrait;

    /**
     * @var Coordinate
     */
    private $position;

    /**
     * @var string|null
     */
    private $animation;

    /**
     * @var Icon|null
     */
    private $icon;

    /**
     * @var Symbol|null
     */
    private $symbol;

    /**
     * @var MarkerShape|null
     */
    private $shape;

    /**
     * @var InfoWindow|null
     */
    private $infoWindow;

    /**
     * @param string|null $animation
     * @param mixed[]     $options
     */
    public function __construct(
        Coordinate $position,
        $animation = null,
        ?Icon $icon = null,
        ?Symbol $symbol = null,
        ?MarkerShape $shape = null,
        array $options = []
    ) {
        $this->setPosition($position);
        $this->setAnimation($animation);
        $this->setShape($shape);
        $this->addOptions($options);

        if (null !== $icon) {
            $this->setIcon($icon);
        } elseif (null !== $symbol) {
            $this->setSymbol($symbol);
        }
    }

    /**
     * @return Coordinate
     */
    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition(Coordinate $position)
    {
        $this->position = $position;
    }

    /**
     * @return bool
     */
    public function hasAnimation()
    {
        return null !== $this->animation;
    }

    /**
     * @return string|null
     */
    public function getAnimation()
    {
        return $this->animation;
    }

    /**
     * @param string|null $animation
     */
    public function setAnimation($animation = null)
    {
        $this->animation = $animation;
    }

    /**
     * @return bool
     */
    public function hasIcon()
    {
        return null !== $this->icon;
    }

    /**
     * @return Icon|null
     */
    public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon(?Icon $icon = null)
    {
        $this->icon = $icon;

        if (null !== $icon) {
            $this->setSymbol(null);
        }
    }

    /**
     * @return bool
     */
    public function hasSymbol()
    {
        return null !== $this->symbol;
    }

    /**
     * @return Symbol|null
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    public function setSymbol(?Symbol $symbol = null)
    {
        $this->symbol = $symbol;

        if (null !== $symbol) {
            $this->setIcon(null);
        }
    }

    /**
     * @return bool
     */
    public function hasShape()
    {
        return null !== $this->shape;
    }

    /**
     * @return MarkerShape|null
     */
    public function getShape()
    {
        return $this->shape;
    }

    public function setShape(?MarkerShape $shape = null)
    {
        $this->shape = $shape;
    }

    /**
     * @return bool
     */
    public function hasInfoWindow()
    {
        return null !== $this->infoWindow;
    }

    /**
     * @return InfoWindow|null
     */
    public function getInfoWindow()
    {
        return $this->infoWindow;
    }

    public function setInfoWindow(?InfoWindow $infoWindow = null)
    {
        $this->infoWindow = $infoWindow;
    }
}
