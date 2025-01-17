<?php

declare(strict_types=1);

/**
 * @copyright  2020 Podlibre
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html AGPL3
 * @link       https://castopod.org/
 */

namespace App\Controllers\Admin;

use App\Entities\Page;
use App\Models\PageModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class PageController extends BaseController
{
    protected $page;

    public function _remap(string $method, string ...$params)
    {
        if (count($params) === 0) {
            return $this->{$method}();
        }

        if ($this->page = (new PageModel())->find($params[0])) {
            return $this->{$method}();
        }

        throw PageNotFoundException::forPageNotFound();
    }

    public function list(): string
    {
        $data = [
            'pages' => (new PageModel())->findAll(),
        ];

        return view('admin/page/list', $data);
    }

    public function view(): string
    {
        return view('admin/page/view', [
            'page' => $this->page,
        ]);
    }

    public function create(): string
    {
        helper('form');

        return view('admin/page/create');
    }

    public function attemptCreate(): RedirectResponse
    {
        $page = new Page([
            'title' => $this->request->getPost('title'),
            'slug' => $this->request->getPost('slug'),
            'content_markdown' => $this->request->getPost('content'),
        ]);

        $pageModel = new PageModel();

        if (! $pageModel->insert($page)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $pageModel->errors());
        }

        return redirect()
            ->route('page-list')
            ->with('message', lang('Page.messages.createSuccess', [
                'pageTitle' => $page->title,
            ]));
    }

    public function edit(): string
    {
        helper('form');

        replace_breadcrumb_params([
            0 => $this->page->title,
        ]);
        return view('admin/page/edit', [
            'page' => $this->page,
        ]);
    }

    public function attemptEdit(): RedirectResponse
    {
        $this->page->title = $this->request->getPost('title');
        $this->page->slug = $this->request->getPost('slug');
        $this->page->content_markdown = $this->request->getPost('content');

        $pageModel = new PageModel();

        if (! $pageModel->update($this->page->id, $this->page)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $pageModel->errors());
        }

        return redirect()->route('page-list');
    }

    public function delete(): RedirectResponse
    {
        (new PageModel())->delete($this->page->id);

        return redirect()->route('page-list');
    }
}
