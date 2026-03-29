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
    }

    .badge-primary {
        background-color: #3b82f6;
    }

    .badge-success {
        background-color: #10b981;
    }

    .badge-warning {
        background-color: #f59e0b;
    }

    .badge-danger {
        background-color: #ef4444;
    }

    .badge-info {
        background-color: #0ea5e9;
    }

    .badge-gray {
        background-color: #64748b;
    }
</style>

<h3>Detalles del Expediente</h3>

<table class="table-details">
    <tr>
        <th>Nº de Caso</th>
        <td>{{ $legalCase->case_number }}</td>
        <th>Código Interno</th>
        <td>{{ $legalCase->internal_code ?? '-' }}</td>
    </tr>
    <tr>
        <th>Título</th>
        <td colspan="3">{{ $legalCase->title }}</td>
    </tr>
    <tr>
        <th>Cliente</th>
        <td>{{ $legalCase->client->name ?? '-' }}</td>
        <th>Contraparte</th>
        <td>{{ $legalCase->opposing_party ?? '-' }}</td>
    </tr>
    <tr>
        <th>Tipo de Servicio</th>
        <td>{{ $legalCase->serviceType->name ?? '-' }}</td>
        <th>Prioridad</th>
        <td>{{ $legalCase->priority->label() }}</td>
    </tr>
    <tr>
        <th>Abogado Principal</th>
        <td>{{ $legalCase->leadLawyer->name ?? 'Sin asignar' }}</td>
        <th>Supervisor</th>
        <td>{{ $legalCase->supervisor->name ?? 'Sin asignar' }}</td>
    </tr>
    <tr>
        <th>Estado</th>
        <td>{{ $legalCase->status->label() }}</td>
        <th>Próx. Vencimiento</th>
        <td>{{ $legalCase->next_deadline_at ? $legalCase->next_deadline_at->format('d/m/Y H:i') : '-' }}</td>
    </tr>
</table>

@if($legalCase->description)
    <h3>Descripción</h3>
    <table class="table-details">
        <tr>
            <td>{!! nl2br(e($legalCase->description)) !!}</td>
        </tr>
    </table>
@endif

@if($legalCase->teamMembers->count() > 0)
    <h3>Equipo de Trabajo</h3>
    <table class="table-details">
        <tr>
            @foreach($legalCase->teamMembers as $member)
                <td style="border: none; padding: 0 10px 10px 0; width: 33%;">
                    <strong>{{ $member->name }}</strong><br>
                    <span style="color: #64748b; font-size: 10px;">{{ ucfirst($member->pivot->role ?? 'Miembro') }}</span>
                </td>
            @endforeach
        </tr>
    </table>
@endif

<h3>Bitácora de Actualizaciones</h3>
@if($legalCase->updates->count() > 0)
    <table class="timeline">
        <thead>
            <tr>
                <th style="width: 15%;">Fecha</th>
                <th style="width: 15%;">Tipo</th>
                <th style="width: 50%;">Descripción / Título</th>
                <th style="width: 20%;">Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach($legalCase->updates as $update)
                <tr>
                    <td>{{ $update->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="badge badge-gray">{{ $update->type->label() }}</span>
                        @if($update->hours > 0)
                            <br><span style="font-size: 9px; color: #64748b; margin-top: 2px;">{{ $update->hours }} h</span>
                        @endif
                        @if($update->is_private)
                            <br><span style="color: #ef4444; font-size: 9px;">Privada</span>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $update->title ?: 'Sin título' }}</strong>
                        @if($update->description)
                            <br>
                            <span style="color: #475569;">{{ $update->description }}</span>
                        @endif
                    </td>
                    <td>{{ $update->user->name ?? 'Sistema' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p style="color: #64748b; font-style: italic;">No hay actualizaciones registradas.</p>
@endif