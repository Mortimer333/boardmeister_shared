<?php

declare(strict_types=1);

namespace Shared\Service\Helper;

abstract class TestHelper
{
    public const USER_EMAIL = 'user@test.com';
    public const USER_NAME = 'user';
    public const SUPER_USER_EMAIL = 'superuser@test.com';
    public const SUPER_USER_NAME = 'super';
    public const DEACTIVATED_USER_EMAIL = 'deactivated@test.com';
    public const DEACTIVATED_USER_NAME = 'deactivated';
    public const DEACTIVATED_USER_PLAIN_PASSWORD = 'passPASS123@';
    public const USER_PLAIN_PASSWORD = 'passPASS123@';
    public const SUPER_USER_PLAIN_PASSWORD = '@321ASSPassp';
    public const GAME_CODE_IMAGE_TAG = 'game_tag_image';
    public const GAME_CODE_NN_IMAGE_TAG = 'game_nn_tag_image';
    public const SKIP_CAPTCHA = '_captcha_skip_token';
}
