<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Admin\Models\WidgetVariable;

class WidgetVariableController extends BaseAdminController
{

    public function index(): Renderable
    {
        $variables = WidgetVariable::paginate();
        return $this->view('widget-variable.index', [
            'variables' => $variables,
        ]);
    }

    public function edit(WidgetVariable $widgetVariable): Renderable
    {
        return $this->view('widget-variable.edit', [
            'variable' => $widgetVariable,
        ]);
    }

    public function update(Request $request, WidgetVariable $widgetVariable): RedirectResponse
    {
        $validated = $request->validate([
            'value' => 'required|numeric',
        ]);

        $widgetVariable->update($validated);

        return redirect()->route('admin.widget-variable.edit', $widgetVariable->id);
    }

}
