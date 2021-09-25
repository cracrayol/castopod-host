<?php

declare(strict_types=1);

/**
 * @copyright  2021 Podlibre
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html AGPL3
 * @link       https://castopod.org/
 */

namespace ActivityPub\Controllers;

use ActivityPub\WebFinger;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class WebFingerController extends Controller
{
    public function index(): ResponseInterface
    {
        try {
            $webfinger = new WebFinger($this->request->getGet('resource'));
        } catch (Exception $e) {
            // return 404, actor not found
            throw PageNotFoundException::forPageNotFound();
        }

        return $this->response->setJSON($webfinger->toArray());
    }
}
