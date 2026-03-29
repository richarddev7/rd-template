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

    .badge {
        padding: 3px 6px;
        border-radius: 4px;
        font-size: 9px;
        font-weight: bold;
        color: #fff;
        display: inline-block;
        margin-bottom: 2px;
    }

    .badge-primary {
        background-color: #3b82f6;
    }

    .badge-gray {
        background-color: #64748b;
    }
</style>

<h3>Detalles de la Solicitud</h3>

<table class="table-details">
    <tr>
        <th>ID de Solicitud</th>
        <td>#{{ $clientRequest->id }}</td>
        <th>Estado</th>
        <td>{{ $clientRequest->status->name ?? 'Sin Estado' }}</td>
    </tr>
    <tr>
        <th>Título</th>
        <td colspan="3">{{ $clientRequest->title }}</td>
    </tr>
    <tr>
        <th>Cliente</th>
        <td>{{ $clientRequest->client->name ?? '-' }}</td>
        <th>Solicitante</th>
        <td>
            {{ $clientRequest->responsible ?? '-' }}<br>
            @if($clientRequest->contact_email) <span
            style="font-size: 9px; color: #64748b;">{{ $clientRequest->contact_email }}</span><br> @endif
            @if($clientRequest->contact_phone) <span
            style="font-size: 9px; color: #64748b;">{{ $clientRequest->contact_phone }}</span> @endif
        </td>
    </tr>
    <tr>
        <th>Fecha Inicial</th>
        <td>{{ $clientRequest->start_date ? $clientRequest->start_date->format('d/m/Y h:i A') : 'N/A' }}</td>
        <th>Fecha Límite</th>
        <td>{{ $clientRequest->deadline_date ? $clientRequest->deadline_date->format('d/m/Y h:i A') : 'N/A' }}</td>
    </tr>
    <tr>
        <th>Asignado A</th>
        <td colspan="3">
            @if($clientRequest->assignees->count() > 0)
                {{ $clientRequest->assignees->pluck('name')->join(', ') }}
            @else
                <span style="color: #64748b; font-style: italic;">Sin usuarios asignados</span>
            @endif
        </td>
    </tr>
    <tr>
        <th>Categorías</th>
        <td colspan="3">
            @if($clientRequest->request_types && count($clientRequest->request_types) > 0)
                @foreach($clientRequest->request_types as $type)
                    <span class="badge badge-primary">{{ $type }}</span>
                @endforeach
            @else
                -
            @endif
        </td>
    </tr>
</table>

@if($clientRequest->context)
    <h3>Contexto de la Solicitud</h3>
    <table class="table-details">
        <tr>
            <td>{!! nl2br(e($clientRequest->context)) !!}</td>
        </tr>
    </table>
@endif

@if($clientRequest->expected_result_description)
    <h3>Descripción de la Solicitud</h3>
    <table class="table-details">
        <tr>
            <td>{!! nl2br(e($clientRequest->expected_result_description)) !!}</td>
        </tr>
    </table>
@endif

@if($clientRequest->expected_results && count($clientRequest->expected_results) > 0)
    <h3>Objetivos</h3>
    <table class="table-details">
        <tr>
            <td>
                <ul style="margin: 0; padding-left: 15px;">
                    @foreach($clientRequest->expected_results as $result)
                        <li>{{ $result }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
    </table>
@endif

<h3>Tareas Asociadas</h3>
@if($clientRequest->tasks && $clientRequest->tasks->count() > 0)
    <table class="timeline">
        <thead>
            <tr>
                <th>Título de la Tarea</th>
                <th>Prioridad</th>
                <th>Estado</th>
                <th>Vencimiento</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientRequest->tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->priority->label() ?? '-' }}</td>
                    <td>{{ $task->status->label() ?? '-' }}</td>
                    <td>{{ $task->delivery_date ? $task->delivery_date->format('d/m/Y') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p style="color: #64748b; font-style: italic;">No hay tareas asociadas a esta solicitud.</p>
@endif