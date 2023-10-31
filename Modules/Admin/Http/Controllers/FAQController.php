<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Admin\Components\Messages;
use Modules\Admin\Models\FAQ;

class FAQController extends BaseAdminController
{

    public function index(): Renderable
    {
        return $this->view('faq.index', [
            'faqs' => FAQ::paginate()
        ]);
    }

    public function create(): Renderable
    {
        return $this->view('faq.edit', [
            'faq' => new FAQ(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'question_ru' => 'required|string|max:255',
            'question_en' => 'required|string|max:255',
            'answer_en' => 'required|string',
            'answer_ru' => 'required|string',
        ]);

        $faq = FAQ::create($validated);
        Messages::success('FAQ created successfully');

        return redirect()->route('admin.faq.edit', $faq->id);
    }

    public function edit(FAQ $faq): Renderable
    {
        return $this->view('faq.edit', [
            'faq' => $faq,
        ]);
    }

    public function update(Request $request, FAQ $faq): RedirectResponse
    {
        $validated = $request->validate([
            'question_ru' => 'string|max:255',
            'question_en' => 'string|max:255',
            'answer_en' => 'string',
            'answer_ru' => 'string',
        ]);

        $faq->update($validated);
        Messages::success('FAQ updated successfully');

        return redirect()->route('admin.faq.edit', $faq->id);
    }

    public function destroy(FAQ $faq): RedirectResponse
    {
        $faq->delete();
        Messages::success('FAQ deleted successfully');
        return redirect()->route('admin.faq.index');
    }
}
