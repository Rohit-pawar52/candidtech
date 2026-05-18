<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\HtmlHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

abstract class BaseCrudController extends Controller
{
    protected string $modelClass;
    protected string $routeName;
    protected string $resourceName = 'Resource';
    protected array $fields = [];

    public function index()
    {
        $records = $this->newModel()
            ->orderByDesc('id')
            ->get();

        return view('admin.crud.index', [
            'title' => $this->resourceName,
            'records' => $records,
            'fields' => $this->fields,
            'routeName' => $this->routeName,
        ]);
    }

    public function create()
    {
        return view('admin.crud.form', [
            'title' => $this->resourceName,
            'record' => null,
            'fields' => $this->fields,
            'routeName' => $this->routeName,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->validationRules());
        $data = $this->sanitizeHtmlFields($data);
        $data = $this->processFileUploads($request, $data);
        $this->newModel()->create($data);

        return Redirect::route($this->routeName . '.index')
            ->with('success', $this->resourceName . ' saved successfully.');
    }

    public function edit($id)
    {
        $record = $this->findRecord($id);

        return view('admin.crud.form', [
            'title' => $this->resourceName,
            'record' => $record,
            'fields' => $this->fields,
            'routeName' => $this->routeName,
        ]);
    }

    public function show($id)
    {
        $record = $this->findRecord($id);

        return view('admin.crud.show', [
            'title' => $this->resourceName,
            'record' => $record,
            'fields' => $this->fields,
            'routeName' => $this->routeName,
        ]);
    }

    public function update(Request $request, $id)
    {
        $record = $this->findRecord($id);
        $data = $request->validate($this->validationRules());
        $data = $this->sanitizeHtmlFields($data);
        $data = $this->processFileUploads($request, $data, $record);
        $record->update($data);

        return Redirect::route($this->routeName . '.index')
            ->with('success', $this->resourceName . ' updated successfully.');
    }

    public function destroy($id)
    {
        $record = $this->findRecord($id);
        $this->deleteUploadedFiles($record);
        $record->delete();

        return Redirect::route($this->routeName . '.index')
            ->with('success', $this->resourceName . ' deleted successfully.');
    }

    protected function validationRules(): array
    {
        $rules = [];

        foreach ($this->fields as $name => $meta) {
            $rules[$name] = $meta['rules'] ?? 'nullable';
        }

        return $rules;
    }

    /**
     * Sanitize HTML fields using CKEditor content
     */
    protected function sanitizeHtmlFields(array $data): array
    {
        foreach ($this->fields as $name => $field) {
            if ($field['type'] === 'ckeditor' && isset($data[$name])) {
                $data[$name] = HtmlHelper::sanitize($data[$name]);
            }
        }

        return $data;
    }

    protected function processFileUploads(Request $request, array $data, ?Model $record = null): array
    {
        foreach ($this->fields as $name => $field) {
            if ($field['type'] !== 'file') {
                continue;
            }

            if (! $request->hasFile($name)) {
                continue;
            }

            if ($record && $record->{$name}) {
                $this->deleteFile($record->{$name});
            }

            $data[$name] = $request->file($name)->store('uploads', 'public');
        }

        return $data;
    }

    protected function deleteUploadedFiles(Model $record): void
    {
        foreach ($this->fields as $name => $field) {
            if ($field['type'] !== 'file') {
                continue;
            }

            if ($record->{$name}) {
                $this->deleteFile($record->{$name});
            }
        }
    }

    protected function deleteFile(string $path): void
    {
        Storage::disk('public')->delete($path);
    }

    protected function findRecord($id): Model
    {
        return $this->newModel()->findOrFail($id);
    }

    protected function newModel(): Model
    {
        return new $this->modelClass();
    }
}
