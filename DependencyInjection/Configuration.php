<?php

namespace Kronhyx\BaseBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('kronhyx_base')->isRequired();

        $this->addUserInterfaceNode($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $rootNode
     *
     * @return ArrayNodeDefinition
     *
     * @throws \ReflectionException
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    private function addUserInterfaceNode(ArrayNodeDefinition $rootNode)
    {
        $validate = function (string $interface) {

            $class = new \ReflectionClass(\str_replace(':', '\\Entity\\', $interface));

            return !$class->implementsInterface(UserInterface::class);
        };

        $rootNode->children()->variableNode('user_provider')
            ->info('The user provider entity')
            ->isRequired()
            ->validate()
            ->ifTrue($validate)
            ->thenInvalid('%s isn\'t a valid user provider.')
            ->end()
            ->end();

        return $rootNode;
    }
}
