<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'HouseholdBudget\Controller\Operations' => 'HouseholdBudget\Controller\OperationsController',
            'HouseholdBudget\Controller\OperationTypes' => 'HouseholdBudget\Controller\OperationTypesController',
            'HouseholdBudget\Controller\Wallets' => 'HouseholdBudget\Controller\WalletsController',
            'HouseholdBudget\Controller\Stats' => 'HouseholdBudget\Controller\StatsController',
            'HouseholdBudget\Controller\Index' => 'HouseholdBudget\Controller\IndexController',
            'HouseholdBudget\Controller\Users' => 'HouseholdBudget\Controller\UsersController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'HouseholdBudget\Controller\Operations',
                        'action' => 'index'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'register' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'register[/]',
                            'defaults' => array(
                                'controller' => 'HouseholdBudget\Controller\Users',
                                'action' => 'add',
                            ),
                        ),
                    ),
                    'users' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'users[/]',
                            'defaults' => array(
                                'controller' => 'HouseholdBudget\Controller\Users',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'users_delete' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => 'delete[/:id]',
                                    'constraints' => array(
                                        'id' => '[0-9]+'
                                    ),
                                    'defaults' => array(
                                        'controller' => 'HouseholdBudget\Controller\Users',
                                        'action' => 'delete',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'login' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'login[/]',
                            'defaults' => array(
                                'controller' => 'HouseholdBudget\Controller\Index',
                                'action' => 'login',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'logout[/]',
                            'defaults' => array(
                                'controller' => 'HouseholdBudget\Controller\Index',
                                'action' => 'logout',
                            ),
                        ),
                    ),
                    'operations' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'operations[/]',
                            'defaults' => array(
                                'controller' => 'HouseholdBudget\Controller\Operations',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'operations_add' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => 'add/:type',
                                    'constraints' => array(
                                        'type' => 'income|transfer|expense',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'HouseholdBudget\Controller\Operations',
                                        'action' => 'add'
                                    )
                                )
                            ),
                            'operations_edit' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => 'edit/:id',
                                    'constraints' => array(
                                        'id' => '[0-9]+'
                                    ),
                                    'defaults' => array(
                                        'controller' => 'HouseholdBudget\Controller\Operations',
                                        'action' => 'edit'
                                    )
                                )
                            ),
                            'operations_delete' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => 'delete/:id',
                                    'constraints' => array(
                                        'id' => '[0-9]+'
                                    ),
                                    'defaults' => array(
                                        'controller' => 'HouseholdBudget\Controller\Operations',
                                        'action' => 'delete'
                                    )
                                )
                            ),
                            'operations_types' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => 'types[/]',
                                    'defaults' => array(
                                        'controller' => 'HouseholdBudget\Controller\OperationTypes',
                                        'action' => 'index'
                                    )
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'operations_types_add' => array(
                                        'type' => 'literal',
                                        'options' => array(
                                            'route' => 'add',
                                            'defaults' => array(
                                                'controller' => 'HouseholdBudget\Controller\OperationTypes',
                                                'action' => 'add'
                                            )
                                        )
                                    ),
                                    'operation_types_edit' => array(
                                        'type' => 'segment',
                                        'options' => array(
                                            'route' => 'edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]+'
                                            ),
                                            'defaults' => array(
                                                'controller' => 'HouseholdBudget\Controller\OperationTypes',
                                                'action' => 'edit'
                                            )
                                        )
                                    )
                                )
                            ),
                        )
                    ),
                    'wallets' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'wallets[/]',
                            'defaults' => array(
                                'controller' => 'HouseholdBudget\Controller\Wallets',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'wallets_add' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => 'add',
                                    'defaults' => array(
                                        'controller' => 'HouseholdBudget\Controller\Wallets',
                                        'action' => 'add',
                                    ),
                                ),
                            ),
                            'wallets_show' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => ':id',
                                    'constraints' => array(
                                        'id' => '[0-9]+'
                                    ),
                                    'defaults' => array(
                                        'controller' => 'HouseholdBudget\Controller\Wallets',
                                        'action' => 'show'
                                    )
                                )
                            ),
                            'wallets_edit' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => 'edit/:id',
                                    'constraints' => array(
                                        'id' => '[0-9]+'
                                    ),
                                    'defaults' => array(
                                        'controller' => 'HouseholdBudget\Controller\Wallets',
                                        'action' => 'edit',
                                    ),
                                ),
                            ),
                            'wallets_delete' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => 'delete/:id',
                                    'constraints' => array(
                                        'id' => '[0-9]+'
                                    ),
                                    'defaults' => array(
                                        'controller' => 'HouseholdBudget\Controller\Wallets',
                                        'action' => 'delete',
                                    ),
                                ),
                            ),
                        )
                    ),
                    'stats' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'stats[/:year]',
                            'defaults' => array(
                                'controller' => 'HouseholdBudget\Controller\Stats',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'HouseholdBudget\Entity\User',
                'identity_property' => 'username',
                'credential_property' => 'password',
                'credential_callable' => function(HouseholdBudget\Entity\User $user, $passwordGiven) {
            if ($user->getPassword() == md5($passwordGiven)) {
                return true;
            } else {
                return false;
            }
        },
            ),
        ),
        'driver' => array(
            'Application_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/HouseholdBudget/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'HouseholdBudget\Entity' => 'Application_driver',
                ),
            ),
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'EntityPlugin' => 'HouseholdBudget\Controller\Plugin\EntityPlugin',
        )
    ),
    'acl' => array(
        'roles' => array(
            'guest' => null,
            'user' => 'guest',
            'admin' => 'user',
        ),
        'resources' => array(
            'allow' => array(
                'HouseholdBudget\Controller\Index' => array(
                    'all' => 'guest',
                ),
                'HouseholdBudget\Controller\Operations' => array(
                    'all' => 'user',
                ),
                'HouseholdBudget\Controller\Stats' => array(
                    'all' => 'user',
                ),
                'HouseholdBudget\Controller\Wallets' => array(
                    'all' => 'user',
                ),
                'HouseholdBudget\Controller\Users' => array(
                    'index' => 'admin',
                    'add' => 'guest',
                    'delete' => 'admin',
                ),
                'ZFTool\Controller\Diagnostics' => array(
                    'all' => 'guest',
                ),
            )
        )
    )
);
