<?php

declare(strict_types=1);

use App\Domain\LTI\LaunchDataRepositoryInterface;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Persistence\FirestoreUserRepository;
use App\Infrastructure\Session\SessionLaunchDataRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LaunchDataRepositoryInterface::class => DI\autowire(SessionLaunchDataRepository::class),
        UserRepositoryInterface::class => DI\autowire(FirestoreUserRepository::class),
    ]);
};
