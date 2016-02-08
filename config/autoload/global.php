<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
return array(
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Home',
                'route' => 'home',
            ),
            array(
                'label' => 'Operations',
                'route' => 'home/operations',
                'resource' => 'HouseholdBudget\Controller\Operations',
//                'pages' => array(
//                    array(
//                        'label' => 'Add',
//                        'route' => 'home/operations/operations_add'
//                    )
//                )
            ),
            array(
                'label' => 'Wallets',
                'route' => 'home/wallets',
//                'pages' => array(
//                    array(
//                        'label' => 'Add',
//                        'route' => 'home/wallets/wallets_add'
//                    )
//                )
            ),
            array(
                'label' => 'Stats',
                'route' => 'home/stats'
            ),
            array(
                'label' => 'Users',
                'route' => 'home/users'
            )
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
);
