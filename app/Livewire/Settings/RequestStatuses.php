<?php

namespace App\Livewire\Settings;

use App\Models\RequestStatus;
use Livewire\Component;

class RequestStatuses extends Component
{
    // Request Status Management
    public $requestStatuses;
    public $editingStatusId = null;
    public $statusForm = [
        'name' => '',
        'slug' => '',
        'color' => 'blue',
        'icon' => '',
        'column_classes' => '',
    ];

    public function mount()
    {
        $this->loadRequestStatuses();
    }

    public function loadRequestStatuses()
    {
        $this->requestStatuses = RequestStatus::ordered()->get();
    }

    public function editStatus($statusId)
    {
        $this->editingStatusId = $statusId;
        $status = RequestStatus::find($statusId);

        if ($status) {
            $this->statusForm = [
                'name' => $status->name,
                'slug' => $status->slug,
                'color' => $status->color,
                'icon' => $status->icon ?? '',
                'column_classes' => $status->column_classes ?? '',
            ];
        }
    }

    public function cancelEdit()
    {
        $this->editingStatusId = null;
        $this->resetStatusForm();
    }

    public function resetStatusForm()
    {
        $this->statusForm = [
            'name' => '',
            'slug' => '',
            'color' => 'blue',
            'icon' => '',
            'column_classes' => '',
        ];
    }

    public function saveStatus()
    {
        $rules = [
            'statusForm.name' => 'required|string|max:255',
            'statusForm.slug' => 'required|string|max:255|regex:/^[a-z0-9_]+$/',
            'statusForm.color' => 'required|string|in:gray,blue,green,yellow,red,purple,pink,indigo',
            'statusForm.icon' => 'nullable|string|max:50',
            'statusForm.column_classes' => 'nullable|string|max:500',
        ];

        if ($this->editingStatusId) {
            $rules['statusForm.slug'] .= '|unique:request_statuses,slug,' . $this->editingStatusId;
        } else {
            $rules['statusForm.slug'] .= '|unique:request_statuses,slug';
        }

        $this->validate($rules);

        if ($this->editingStatusId) {
            // Update existing status
            $status = RequestStatus::find($this->editingStatusId);
            $status->update([
                'name' => $this->statusForm['name'],
                'slug' => $this->statusForm['slug'],
                'color' => $this->statusForm['color'],
                'icon' => $this->statusForm['icon'] ?: null,
                'column_classes' => $this->statusForm['column_classes'] ?: null,
            ]);
            session()->flash('success', __('Estado actualizado exitosamente.'));

            // Reset to create mode after update
            $this->cancelEdit();
        } else {
            // Create new status
            $maxOrder = RequestStatus::max('order') ?? 0;
            RequestStatus::create([
                'name' => $this->statusForm['name'],
                'slug' => $this->statusForm['slug'],
                'color' => $this->statusForm['color'],
                'icon' => $this->statusForm['icon'] ?: null,
                'order' => $maxOrder + 1,
                'is_default' => false,
                'column_classes' => $this->statusForm['column_classes'] ?: $this->getDefaultColumnClasses($this->statusForm['color']),
            ]);
            session()->flash('success', __('Estado creado exitosamente.'));

            // Allow creating another one immediately, just reset form
            $this->resetStatusForm();
        }

        $this->loadRequestStatuses();
    }

    public function deleteStatus($statusId)
    {
        $status = RequestStatus::find($statusId);

        if (!$status) {
            session()->flash('error', __('Estado no encontrado.'));
            return;
        }

        if (!$status->canDelete()) {
            session()->flash('error', __('Este estado no puede ser eliminado porque tiene solicitudes asociadas.'));
            return;
        }

        $status->delete();
        session()->flash('success', __('Estado eliminado exitosamente.'));
        $this->loadRequestStatuses();
    }

    public function reorderStatuses($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            RequestStatus::where('id', $id)->update(['order' => $index + 1]);
        }

        $this->loadRequestStatuses();
        session()->flash('success', __('Orden de estados actualizado exitosamente.'));
    }

    private function getDefaultColumnClasses($color)
    {
        return match ($color) {
            'gray' => 'bg-gray-50 dark:bg-gray-800',
            'blue' => 'bg-blue-50 dark:bg-blue-900/20',
            'green' => 'bg-green-50 dark:bg-green-900/20',
            'yellow' => 'bg-yellow-50 dark:bg-yellow-900/20',
            'red' => 'bg-red-50 dark:bg-red-900/20',
            'purple' => 'bg-purple-50 dark:bg-purple-900/20',
            'pink' => 'bg-pink-50 dark:bg-pink-900/20',
            'indigo' => 'bg-indigo-50 dark:bg-indigo-900/20',
            default => 'bg-gray-50 dark:bg-gray-800',
        };
    }

    public function render()
    {
        return view('livewire.settings.request-statuses');
    }
}
