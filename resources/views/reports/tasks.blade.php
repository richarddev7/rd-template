{{-- Reporte de Tareas --}}
<div class="summary-box">
    <h3>Resumen</h3>
    <table class="summary-table">
        <tr>
            <td class="label">Total de Tareas:</td>
            <td class="value">{{ $summary['total'] }}</td>
            <td class="label">Completadas:</td>
            <td class="value">{{ $summary['completadas'] }}</td>
            <td class="label">Pendientes:</td>
            <td class="value">{{ $summary['pendientes'] }}</td>
        </tr>
    </table>
</div>

<table class="report-table">
    <thead>
        <tr>
            <th style="width: 4%;">#</th>
            <th style="width: 22%;">Título</th>
            <th style="width: 14%;">Cliente</th>
            <th style="width: 14%;">Asignado A</th>
            <th style="width: 10%;">Prioridad</th>
            <th style="width: 10%;">Estado</th>
            <th style="width: 13%;">Fecha Inicio</th>
            <th style="width: 13%;">Fecha Entrega</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $index => $task)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-bold">{{ $task->title }}</td>
                <td>{{ $task->client?->name ?? '—' }}</td>
                <td>
                    @if($task->users->isNotEmpty())
                        {{ $task->users->pluck('name')->implode(', ') }}
                    @elseif($task->assignedTo)
                        {{ $task->assignedTo->name }}
                    @else
                        —
                    @endif
                </td>
                <td class="text-center">
                    @if($task->priority)
                        @php
                            $prioColor = match ($task->priority->value) {
                                'low' => 'badge-gray',
                                'medium' => 'badge-blue',
                                'high' => 'badge-orange',
                                'critical' => 'badge-red',
                                default => 'badge-gray',
                            };
                        @endphp
                        <span class="badge {{ $prioColor }}">{{ $task->priority->label() }}</span>
                    @else
                        —
                    @endif
                </td>
                <td class="text-center">
                    @if($task->status)
                        <span class="badge badge-blue">{{ $task->status->label() }}</span>
                    @else
                        —
                    @endif
                </td>
                <td class="text-center">{{ $task->start_date?->format('d/m/Y') ?? '—' }}</td>
                <td class="text-center">{{ $task->delivery_date?->format('d/m/Y') ?? '—' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center" style="padding: 20px; color: #a0aec0;">
                    No se encontraron tareas con los filtros aplicados.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>