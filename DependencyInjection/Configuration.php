<?php

namespace FL\XeroBundle\DependencyInjection;

use FL\XeroBundle\XeroPHP\ApplicationFactory;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use XeroPHP\Remote\OAuth\Client;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fl_xero');

        $rootNode
            ->children()
                ->enumNode('type')
                    ->values([
                        ApplicationFactory::TYPE_PUBLIC,
                        ApplicationFactory::TYPE_PRIVATE,
                        ApplicationFactory::TYPE_PARTNER,
                    ])
                    ->isRequired()
                ->end()
                ->floatNode('core_version')
                    ->info('API versions can be overridden if necessary for some reason.')
                    ->defaultValue('2.0')
                ->end()
                ->floatNode('payroll_version')
                    ->info('API versions can be overridden if necessary for some reason.')
                    ->defaultValue('1.0')
                ->end()
                ->floatNode('file_version')
                    ->info('API versions can be overridden if necessary for some reason.')
                    ->defaultValue('1.0')
                ->end()
                ->arrayNode('oauth')
                    ->children()
                        ->scalarNode('callback')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('consumer_key')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('consumer_secret')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->enumNode('signature_location')
                            ->info('If you have issues passing the Authorization header, you can set it to append to the query string.')
                            ->values([Client::SIGN_LOCATION_HEADER, Client::SIGN_LOCATION_QUERY])
                            ->defaultValue(Client::SIGN_LOCATION_HEADER)
                        ->end()
                        ->scalarNode('rsa_private_key')
                            ->info('For certs on disk or a string - allows anything that is valid with openssl_pkey_get_private.')
                        ->end()
                        ->scalarNode('rsa_public_key')
                            ->info('For certs on disk or a string - allows anything that is valid with openssl_pkey_get_public.')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('curl')
                    ->info('These are raw curl options, see http://php.net/manual/en/function.curl-setopt.php for details.')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
