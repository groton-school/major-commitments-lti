<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use GrotonSchool\LTI\Registration\Instructure\Canvas\LtiConfiguration;
use GrotonSchool\LTI\Registration\Instructure\Canvas\LtiMessage;
use GrotonSchool\LTI\Registration\v1p0\OpenIDConfiguration;
use Odan\Session\SessionInterface;
use Packback\Lti1p3\LtiConstants;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            $TOOL_NAME = 'Major Commitments LTI';
            $PROJECT_URL = 'https://' . getenv('HTTP_HOST');
            $SCOPES = [LtiConstants::NRPS_SCOPE_MEMBERSHIP_READONLY];
            return new Settings([
                'displayErrorDetails'   => false,
                'logError'              => true,
                'logErrorDetails'       => true,
                Settings::LOG_REQUESTS  => false,

                // get Google Cloud Project ID and URL from local environment
                Settings::PROJECT_ID => getenv('GOOGLE_CLOUD_PROJECT'),
                Settings::PROJECT_URL => $PROJECT_URL,
                Settings::TOOL_NAME => $TOOL_NAME,
                Settings::SCOPES => $SCOPES,
                Settings::CACHE_DURATION => 3600, // seconds
                Settings::REDIRECT_URI => "{$PROJECT_URL}/login/oauth2/redirect",
                Settings::TOOL_REGISTRATION => [
                    OpenIDConfiguration::APPLICATION_TYPE => OpenIDConfiguration::APPLICATION_TYPE_WEB,
                    OpenIDConfiguration::CLIENT_NAME => $TOOL_NAME,
                    OpenIDConfiguration::CLIENT_URI => $PROJECT_URL,
                    OpenIDConfiguration::GRANT_TYPES => OpenIDConfiguration::GRANT_TYPES_REQUIRED,
                    OpenIDConfiguration::JWKS_URI => "{$PROJECT_URL}/lti/jwks",
                    OpenIDConfiguration::TOKEN_ENDPOINT_AUTH_METHOD => 'private_key_jwt',
                    OpenIDConfiguration::INITIATE_LOGIN_URI =>  "{$PROJECT_URL}/lti/login",
                    OpenIDConfiguration::REDIRECT_URIS => ["{$PROJECT_URL}/lti/launch"],
                    OpenIDConfiguration::RESPONSE_TYPES => [OpenIDConfiguration::RESPONSE_TYPE_ID_TOKEN],
                    OpenIDConfiguration::SCOPE => join(' ', $SCOPES),
                    OpenIDConfiguration::LTI_TOOL_CONFIGURATION => [
                        LtiConfiguration::DOMAIN => parse_url($PROJECT_URL, PHP_URL_HOST),
                        LtiConfiguration::TARGET_LINK_URI => "{$PROJECT_URL}/lti/launch",
                        LtiConfiguration::MESSAGES => [
                            [
                                LtiMessage::TYPE => LtiMessage::TYPE_RESOURCE,
                                LtiMessage::ICON_URI => "{$PROJECT_URL}/assets/icon.svg",
                                LtiMessage::LABEL => "Major Commitments",
                                LtiMessage::CUSTOM_PARAMETERS => [
                                    'user_id' => '$Canvas.user.id',
                                    'brand_config_json_url' => '$com.instructure.brandConfigJSON.url',
                                    'brand_config_js_url' => '$com.instructure.brandConfigJS.url',
                                    'common_css_url' => '$Canvas.css.common',
                                    'prefers_high_contrast' => '$Canvas.user.prefersHighContrast',
                                ],
                                LtiMessage::PLACEMENTS => [LtiMessage::PLACEMENT_COURSE_NAVIGATION],
                                LtiMessage::ROLES => [LtiConstants::MEMBERSHIP_INSTRUCTOR],
                            ]
                        ],
                        LtiConfiguration::CLAIMS => [
                            "sub",
                            "iss",
                            "name",
                            "given_name",
                            "family_name",
                            "nickname",
                            "picture",
                            "email",
                            "locale"
                        ],
                        LtiConfiguration::PRIVACY_LEVEL => LtiConfiguration::PRIVACY_PUBLIC

                    ]
                ],
                SessionInterface::class => [
                    'name' => "major-commitments-session",
                    'lifetime' => 60 * 60 * 24,
                    'cookie_samesite' => 'None',
                    'secure' => true,
                    'httponly' => true
                ]
            ]);
        }
    ]);
};
