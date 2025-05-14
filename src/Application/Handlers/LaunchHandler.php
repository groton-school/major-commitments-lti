<?php

declare(strict_types=1);

namespace App\Application\Handlers;

use GrotonSchool\Slim\LTI\Handlers\LaunchHandlerInterface;
use Packback\Lti1p3\LtiConstants;
use Packback\Lti1p3\LtiMessageLaunch;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\PhpRenderer;

class LaunchHandler implements LaunchHandlerInterface
{
    public function handle(ResponseInterface $response, LtiMessageLaunch $launch): ResponseInterface
    {
        /*
        * TODO actual handling of the LTI launch request goes here!
        */
        $renderer = new PhpRenderer(__DIR__ . '/../../../views');
        $data = $launch->getLaunchData();
        return $renderer->render($response, 'launch.php', [
            'messageType' => $data[LtiConstants::MESSAGE_TYPE],
            'launchData' => $data
        ]);
    }
}
