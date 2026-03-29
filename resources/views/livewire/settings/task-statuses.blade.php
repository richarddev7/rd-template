<div class="space-y-6">
    <div class="flex items-start justify-between border-b border-gray-200 dark:border-gray-700 pb-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-icons-round text-blue-500">view_kanban</span>
                {{ __('Task Status Management') }}
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ __('Configure task statuses for kanban board and task forms') }}
            </p>
        </div>
        <div class="flex items-center gap-2">
            <flux:button @click="$flux.modal('task-status-modal').close()" type="button" variant="ghost" icon="x-mark"
                size="sm">
            </flux:button>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="p-4 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- Inline Form for Create/Edit --}}
    <div class="bg-gray-50 dark:bg-slate-800/50 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
        <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-3">
            {{ $editingStatusId ? __('Edit Status') : __('Add New Status') }}
        </h3>

        <form wire:submit="saveStatus">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                {{-- Name --}}
                <div class="col-span-1 md:col-span-2 lg:col-span-1">
                    <flux:input wire:model="statusForm.name" placeholder="{{ __('Status Name') }}" required />
                    <flux:error name="statusForm.name" />
                </div>

                {{-- Slug --}}
                <div class="col-span-1 md:col-span-2 lg:col-span-1">
                    <flux:input wire:model="statusForm.slug" placeholder="{{ __('Slug') }}" required />
                    <flux:error name="statusForm.slug" />
                </div>

                {{-- Color --}}
                <div>
                    <flux:select wire:model="statusForm.color" required placeholder="{{ __('Color') }}">
                        <flux:select.option value="gray">{{ __('Gray') }}</flux:select.option>
                        <flux:select.option value="blue">{{ __('Blue') }}</flux:select.option>
                        <flux:select.option value="green">{{ __('Green') }}</flux:select.option>
                        <flux:select.option value="yellow">{{ __('Yellow') }}</flux:select.option>
                        <flux:select.option value="red">{{ __('Red') }}</flux:select.option>
                        <flux:select.option value="purple">{{ __('Purple') }}</flux:select.option>
                        <flux:select.option value="pink">{{ __('Pink') }}</flux:select.option>
                        <flux:select.option value="indigo">{{ __('Indigo') }}</flux:select.option>
                    </flux:select>
                    <flux:error name="statusForm.color" />
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-2">
                    <flux:button type="submit" variant="primary" size="sm" class="w-full">
                        {{ $editingStatusId ? __('Update') : __('Add') }}
                    </flux:button>
                    @if($editingStatusId)
                        <flux:button type="button" wire:click="cancelEdit" variant="ghost" size="sm">
                            {{ __('Cancel') }}
                        </flux:button>
                    @endif
                </div>
            </div>

            {{-- Advanced Fields (Optional) --}}
            <div class="text-xs">
                <details>
                    <summary
                        class="cursor-pointer text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        {{ __('Advanced Options') }}
                    </summary>
                    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <flux:input wire:model="statusForm.column_classes" size="sm"
                            placeholder="{{ __('Custom Column Classes (e.g., bg-blue-50)') }}" />
                    </div>
                </details>
            </div>
        </form>
    </div>

    {{-- Lista de estados --}}
    <div class="space-y-2 max-h-[400px] overflow-y-auto pr-1" id="status-list">
        @forelse($taskStatuses as $status)
            <div wire:key="status-{{ $status->id }}"
                class="flex items-center gap-4 p-3 bg-white dark:bg-slate-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 transition-colors {{ $editingStatusId === $status->id ? 'ring-2 ring-blue-500 border-transparent' : '' }}"
                data-status-id="{{ $status->id }}">
                {{-- Handle para drag & drop --}}
                <span
                    class="material-icons-round cursor-move text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">drag_indicator</span>

                {{-- Preview de color --}}
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 rounded border border-gray-300 dark:border-gray-600 {{ $status->badgeClasses() }}">
                    </div>
                </div>

                {{-- Badge de color --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium text-gray-900 dark:text-white truncate">
                            {{ $status->name }}
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-medium {{ $status->badgeClasses() }}">
                            {{ $status->slug }}
                        </span>
                        @if($status->is_default)
                            <span
                                class="text-[10px] bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200 px-2 py-0.5 rounded font-medium">
                                {{ __('Default') }}
                            </span>
                        @endif
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        {{ $status->tasks()->count() }} {{ __('tasks') }}
                    </div>
                </div>

                {{-- Acciones --}}
                <div class="flex items-center gap-1">
                    <flux:button wire:click="editStatus({{ $status->id }})" type="button" variant="ghost" icon="pencil"
                        size="xs">
                    </flux:button>

                    @if($status->tasks()->count() === 0)
                        <flux:button wire:click="deleteStatus({{ $status->id }})" type="button" variant="ghost" icon="trash"
                            size="xs" class="text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20">
                        </flux:button>
                    @else
                        <div class="w-6 h-6 flex items-center justify-center"
                            title="{{ __('Cannot delete: has associated tasks') }}">
                            <span class="material-icons-round text-gray-300 text-sm">block</span>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-6 text-gray-500">
                {{ __('No statuses found.') }}
            </div>
        @endforelse
    </div>
</div>