<?php

declare(strict_types=1);

/**
 * @copyright  2021 Podlibre
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html AGPL3
 * @link       https://castopod.org/
 */

namespace ActivityPub\Objects;

use ActivityPub\Core\ObjectType;
use ActivityPub\Entities\Actor;

class ActorObject extends ObjectType
{
    /**
     * @var string|string[]
     */
    protected $context = ['https://www.w3.org/ns/activitystreams', 'https://w3id.org/security/v1'];

    protected $type = 'Person';

    protected $name;

    protected $preferredUsername;

    protected $summary;

    protected $inbox;

    protected $outbox;

    protected $followers;

    protected $url;

    /**
     * @var array<string, string>
     */
    protected $image = [];

    /**
     * @var array<string, string>
     */
    protected $icon = [];

    /**
     * @var array<string, string>
     */
    protected $publicKey = [];

    public function __construct(Actor $actor)
    {
        $this->id = $actor->uri;

        $this->name = $actor->display_name;
        $this->preferredUsername = $actor->username;
        $this->summary = $actor->summary;
        $this->url = $actor->uri;

        $this->inbox = $actor->inbox_url;
        $this->outbox = $actor->outbox_url;
        $this->followers = $actor->followers_url;

        $this->image = [
            'type' => 'Image',
            'mediaType' => $actor->cover_image_mimetype,
            'url' => $actor->cover_image_url,
        ];

        $this->icon = [
            'type' => 'Image',
            'mediaType' => $actor->avatar_image_mimetype,
            'url' => $actor->avatar_image_url,
        ];

        if ($actor->public_key !== null) {
            $this->publicKey = [
                'id' => $actor->public_key_id,
                'owner' => $actor->uri,
                'publicKeyPem' => $actor->public_key,
            ];
        }
    }
}
