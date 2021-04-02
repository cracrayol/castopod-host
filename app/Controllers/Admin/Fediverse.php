<?php

/**
 * @copyright  2020 Podlibre
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html AGPL3
 * @link       https://castopod.org/
 */

namespace App\Controllers\Admin;

use ActivityPub\Models\BlockedDomainModel;

class Fediverse extends BaseController
{
    public function dashboard()
    {
        return view('admin/fediverse/dashboard');
    }

    public function blockedActors()
    {
        helper(['form']);

        $blockedActors = model('ActorModel')->getBlockedActors();

        return view('admin/fediverse/blocked_actors', [
            'blockedActors' => $blockedActors,
        ]);
    }

    public function blockedDomains()
    {
        helper(['form']);

        $blockedDomains = model('BlockedDomainModel')->getBlockedDomains();

        return view('admin/fediverse/blocked_domains', [
            'blockedDomains' => $blockedDomains,
        ]);
    }
}
