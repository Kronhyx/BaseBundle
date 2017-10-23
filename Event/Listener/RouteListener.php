<?php
/**
 * Created by PhpStorm.
 * User: kronhyx
 * Date: 23/10/2017
 * Time: 14:51
 */

namespace Kronhyx\BaseBundle\Event\Listener;


use Doctrine\Common\Collections\ArrayCollection;
use Kronhyx\BaseBundle\KronhyxBaseBundle;
use Sonata\AdminBundle\Route\AdminPoolLoader;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Router;

/**
 * Class RouteListener
 * @package Kronhyx\BaseBundle\Event\Listener
 */
class RouteListener extends Loader
{
    /**
     * @var Router $router
     */
    private $router;

    /**
     * @var KernelInterface $kernel
     */
    private $kernel;

    /**
     * RouteListener constructor.
     * @param Router $router
     * @param KernelInterface $kernel
     */
    public function __construct(Router $router, KernelInterface $kernel)
    {
        $this->router = $router;
        $this->kernel = $kernel;
    }

    /**
     * @param mixed $resource
     * @param null $type
     * @return RouteCollection
     */
    public function load($resource, $type = null)
    {
        $collection = new RouteCollection();
        $bundles = new ArrayCollection($this->kernel->getBundles());
        $bundles = $bundles->filter(function (Bundle $bundle) {
            return $bundle instanceof KronhyxBaseBundle;
        });

        /**@var Bundle $bundle */
        foreach ($bundles->toArray() as $bundle) {
            if (file_exists($bundle->getPath() . '/Resources/config/routing.yml')) {
                $importedRoutes = $this->import(sprintf('@%s/Resources/config/routing.yml', $bundle->getName()), 'yaml');
                $collection->addCollection($importedRoutes);
            }
        }

        return $collection;
    }

    /**
     * @param mixed $resource
     * @param null $type
     * @return bool
     */
    public function supports($resource, $type = null)
    {
        return $type === AdminPoolLoader::ROUTE_TYPE_NAME;
    }
}