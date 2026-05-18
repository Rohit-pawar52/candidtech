<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

abstract class BaseCrudController extends Controller
{
    protected string $modelClass;
    protected string $routeName;
    protected string $resourceName = 'Resource';
    protected array $fields = [];

    public function index()
    {
        $records = call_user_func([$this->modelClass, 'all']);

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
        $data = $this->validateRequest($request);
        $data = $this->handleFileUploads($request, $data);
        call_user_func([$this->modelClass, 'create'], $data);

        return Redirect::route($this->routeName . '.index')->with('success', $this->resourceName . ' saved successfully.');
    }

    public function edit($id)
    {
        $record = call_user_func([$this->modelClass, 'findOrFail'], $id);

        return view('admin.crud.form', [
            'title' => $this->resourceName,
            'record' => $record,
            'fields' => $this->fields,
            'routeName' => $this->routeName,
        ]);
    }

    public function show($id)
    {
        $record = call_user_func([$this->modelClass, 'findOrFail'], $id);

        return view('admin.crud.show', [
            'title' => $this->resourceName,
            'record' => $record,
            'fields' => $this->fields,
            'routeName' => $this->routeName,
        ]);
    }

    public function update(Request $request, $id)
    {
        $record = call_user_func([$this->modelClass, 'findOrFail'], $id);
        $data = $this->validateRequest($request);
        $data = $this->handleFileUploads($request, $data, $record);
        $record->update($data);

        return Redirect::route($this->routeName . '.index')->with('success', $this->resourceName . ' updated successfully.');
    }

    public function destroy($id)
    {
        $record = call_user_func([$this->modelClass, 'findOrFail'], $id);
        $record->delete();

        return Redirect::route($this->routeName . '.index')->with('success', $this->resourceName . ' deleted successfully.');
    }

    protected function validateRequest(Request $request): array
    {
        $rules = [];

        foreach ($this->fields as $name => $meta) {
            $rules[$name] = $meta['rules'] ?? 'nullable';
        }

        return $request->validate($rules);
    }

    protected function handleFileUploads(Request $request, array $data, $record = null): array
    {
        foreach ($this->fields as $name => $field) {
            if ($field['type'] === 'file' && $request->hasFile($name)) {
                $file = $request->file($name);
                
                // Delete old file if updating
                if ($record && $record->{$name}) {
                    Storage::disk('public')->delete($record->{$name});
                }
                
                // Store new file
                $path = $file->store('uploads', 'public');
                $data[$name] = $path;
            }
        }

        return $data;
    }
}
