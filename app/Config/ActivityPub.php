<?php

declare(strict_types=1);

namespace Config;

use ActivityPub\Config\ActivityPub as ActivityPubBase;
use App\Libraries\NoteObject;

class ActivityPub extends ActivityPubBase
{
    /**
     * --------------------------------------------------------------------
     * ActivityPub Objects
     * --------------------------------------------------------------------
     */
    public $noteObject = NoteObject::class;

    /**
     * --------------------------------------------------------------------
     * Default avatar and cover images
     * --------------------------------------------------------------------
     */
    public $defaultAvatarImagePath = 'assets/images/castopod-avatar-default.jpg';

    public $defaultAvatarImageMimetype = 'image/jpeg';

    public $defaultCoverImagePath = 'assets/images/castopod-cover-default.jpg';

    public $defaultCoverImageMimetype = 'image/jpeg';
}
