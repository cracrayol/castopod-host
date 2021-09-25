<?php

declare(strict_types=1);

/**
 * @copyright  2021 Podlibre
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html AGPL3
 * @link       https://castopod.org/
 */

namespace ActivityPub\Models;

use ActivityPub\Entities\PreviewCard;
use CodeIgniter\Database\BaseResult;
use CodeIgniter\Model;

class PreviewCardModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'activitypub_preview_cards';

    /**
     * @var string[]
     */
    protected $allowedFields = [
        'id',
        'url',
        'title',
        'description',
        'type',
        'author_name',
        'author_url',
        'provider_name',
        'provider_url',
        'image',
        'html',
    ];

    /**
     * @var string
     */
    protected $returnType = PreviewCard::class;

    /**
     * @var bool
     */
    protected $useSoftDeletes = false;

    /**
     * @var bool
     */
    protected $useTimestamps = true;

    public function getPreviewCardFromUrl(string $url): ?PreviewCard
    {
        $hashedPreviewCardUrl = md5($url);
        $cacheName =
            config('ActivityPub')
                ->cachePrefix .
            "preview_card-{$hashedPreviewCardUrl}";
        if (! ($found = cache($cacheName))) {
            $found = $this->where('url', $url)
                ->first();
            cache()
                ->save($cacheName, $found, DECADE);
        }

        return $found;
    }

    public function getStatusPreviewCard(string $statusId): ?PreviewCard
    {
        $cacheName =
            config('ActivityPub')
                ->cachePrefix . "status#{$statusId}_preview_card";
        if (! ($found = cache($cacheName))) {
            $found = $this->join(
                'activitypub_statuses_preview_cards',
                'activitypub_statuses_preview_cards.preview_card_id = id',
                'inner',
            )
                ->where('status_id', service('uuid') ->fromString($statusId) ->getBytes())
                ->first();

            cache()
                ->save($cacheName, $found, DECADE);
        }

        return $found;
    }

    public function deletePreviewCard(int $id, string $url)
    {
        $hashedPreviewCardUrl = md5($url);
        cache()
            ->delete(config('ActivityPub') ->cachePrefix . "preview_card-{$hashedPreviewCardUrl}");

        return $this->delete($id);
    }
}
