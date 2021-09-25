<?php

declare(strict_types=1);

/**
 * @copyright  2021 Podlibre
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html AGPL3
 * @link       https://castopod.org/
 */

namespace ActivityPub\Config;

use ActivityPub\Objects\ActorObject;
use ActivityPub\Objects\NoteObject;
use CodeIgniter\Config\BaseConfig;

class ActivityPub extends BaseConfig
{
    /**
     * --------------------------------------------------------------------
     * ActivityPub Objects
     * --------------------------------------------------------------------
     */
    public $actorObject = ActorObject::class;

    public $noteObject = NoteObject::class;

    /**
     * --------------------------------------------------------------------
     * Default avatar and cover images
     * --------------------------------------------------------------------
     */
    public $defaultAvatarImagePath = 'assets/images/avatar-default.jpg';

    public $defaultAvatarImageMimetype = 'image/jpeg';

    public $defaultCoverImagePath = 'assets/images/cover-default.jpg';

    public $defaultCoverImageMimetype = 'image/jpeg';

    /**
     * --------------------------------------------------------------------
     * Cache options
     * --------------------------------------------------------------------
     */
    public $cachePrefix = 'ap_';
}
