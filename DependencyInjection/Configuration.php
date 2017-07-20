<?php

namespace Kronhyx\BaseBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Kronhyx\BaseBundle\DependencyInjection
 * @link http://symfony.com/doc/current/cookbook/bundles/configuration.html
 * @author Randy Téllez Galán <kronhyx@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        return new TreeBuilder();
    }
}
