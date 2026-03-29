<style>
    body {
        font-family: sans-serif;
        font-size: 11px;
        color: #333;
    }

    h1,
    h2,
    h3 {
        color: #1a365d;
        margin-top: 0;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 5px;
        margin-bottom: 10px;
    }

    .table-details {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .table-details th {
        background-color: #f8fafc;
        text-align: left;
        padding: 8px;
        border: 1px solid #e2e8f0;
        width: 30%;
        color: #475569;
        font-weight: bold;
    }

    .table-details td {
        padding: 8px;
        border: 1px solid #e2e8f0;
    }

    .timeline {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        margin-bottom: 20px;
    }

    .timeline th {
        background-color: #f1f5f9;
        text-align: left;
        padding: 8px;
        border-bottom: 2px solid #cbd5e1;
        font-weight: bold;
    }

    .timeline td {
        padding: 8px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: top;
    }
</style>

<h3>Detalles de la Tarea</h3>

<table class="table-details">
    <tr>
        <th>Título</th>
        <td colspan="3">{{ $task->title }}</td>
    </tr>
    <tr>
        <th>Cliente</th>
        <td>{{ $task->client->name ?? '-' }}</td>
        <th>Creado Por</th>
        <td>{{ $task->createdBy->name ?? '-' }}</td>
    </tr>
    <tr>
        <th>Prioridad</th>
        <td>{{ $task->priority->label() }}</td>
        <th>Estado</th>
        <td>{{ $task->status->label() }}</td>
    </tr>
    <tr>
        <th>Fecha de Inicio</th>
        <td>{{ $task->start_date ? $task->start_date->format('M d, Y H:i') : '-' }}</td>
        <th>Fecha de Entrega</th>
        <td>{{ $task->delivery_date ? $task->delivery_date->format('M d, Y H:i') : '-' }}</td>
    </tr>
    <tr>
        <th>Fecha Completada</th>
        <td>{{ $task->completed_at ? $task->completed_at->format('M d, Y H:i') : '-' }}</td>
        <th>Asignado A</th>
        <td>
            @if($task->users->count() > 0)
                {{ $task->users->pluck('name')->join(', ') }}
            @else
                <span style="color: #64748b; font-style: italic;">Sin asignar</span>
            @endif
        </td>
    </tr>
</table>

@if($task->description)
    <h3>Descripción</h3>
    <table class="table-details">
        <tr>
            <td>{!! nl2br(e($task->description)) !!}</td>
        </tr>
    </table>
@endif

<h3>Historial de Actividad</h3>
@if($task->histories && $task->histories->count() > 0)
    <table class="timeline">
        <thead>
            <tr>
                <th style="width: 25%;">Fecha</th>
                <th style="width: 50%;">Acción</th>
                <th style="width: 25%;">Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach($task->histories as $history)
                <tr>
                    <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($history->action === 'created')
                            Tarea creada
                        @elseif($history->action === 'status_changed')
                            Estado cambiado: {{ $history->old_value }} → {{ $history->new_value }}
                        @elseif($history->action === 'file_uploaded')
                            Archivo subido: {{ $history->new_value }}
                        @elseif($history->action === 'file_deleted')
                            Archivo eliminado: {{ $history->old_value }}
                        @else
                            {{ ucfirst($history->field_changed) }} actualizado
                        @endif
                    </td>
                    <td>{{ $history->user->name ?? 'Sistema' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p style="color: #64748b; font-style: italic;">No hay historial registrado.</p>
@endif