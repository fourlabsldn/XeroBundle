<?php

namespace FL\XeroBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class FLXeroExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // resolve values of curl constants
        if (array_key_exists('curl', $config)) {
            foreach ($config['curl'] as $option => $value) {
                if (!defined($option)) {
                    throw new InvalidConfigurationException(sprintf(
                        'Invalid option %s, expecting valid curl option.',
                        $option
                    ));
                }

                unset($config['curl'][$option]);
                $config['curl'][constant($option)] = $value;
            }
        }

        $container->setParameter('fl_xero.type', $config['type']);
        unset($config['type']);

        $container->setParameter('fl_xero.config', $config);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
