<?php

declare(strict_types=1);

/**
 * @copyright  2020 Podlibre
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html AGPL3
 * @link       https://castopod.org/
 */

namespace App\Controllers\Admin;

use App\Entities\Podcast;
use App\Models\PersonModel;
use App\Models\PodcastModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class PodcastPersonController extends BaseController
{
    protected $podcast;

    public function _remap(string $method, string ...$params)
    {
        if (count($params) === 0) {
            throw PageNotFoundException::forPageNotFound();
        }

        if (
            ($this->podcast = (new PodcastModel())->getPodcastById((int) $params[0])) !== null
        ) {
            unset($params[0]);
            return $this->{$method}(...$params);
        }

        throw PageNotFoundException::forPageNotFound();
    }

    public function index(): string
    {
        helper('form');

        $data = [
            'podcast' => $this->podcast,
            'podcastPersons' => (new PersonModel())->getPodcastPersons($this->podcast->id),
            'personOptions' => (new PersonModel())->getPersonOptions(),
            'taxonomyOptions' => (new PersonModel())->getTaxonomyOptions(),
        ];
        replace_breadcrumb_params([
            0 => $this->podcast->title,
        ]);
        return view('admin/podcast/persons', $data);
    }

    public function attemptAdd(): RedirectResponse
    {
        $rules = [
            'persons' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        (new PersonModel())->addPodcastPersons(
            $this->podcast->id,
            $this->request->getPost('persons'),
            $this->request->getPost('roles') ?? [],
        );

        return redirect()->back();
    }

    public function remove(string $personId): RedirectResponse
    {
        (new PersonModel())->removePersonFromPodcast($this->podcast->id, (int) $personId);

        return redirect()->back();
    }
}
