{{-- Reporte de Expedientes (Legal Cases) --}}
<div class="summary-box">
    <h3>Resumen</h3>
    <table class="summary-table">
        <tr>
            <td class="label">Total de Expedientes:</td>
            <td class="value">{{ $summary['total'] }}</td>
        </tr>
        @if(!empty($summary['por_estado']))
            @foreach($summary['por_estado'] as $estado => $count)
                <tr>
                    <td class="label">{{ $estado }}:</td>
                    <td class="value">{{ $count }}</td>
                </tr>
            @endforeach
        @endif
    </table>
</div>

<table class="report-table">
    <thead>
        <tr>
            <th style="width: 4%;">#</th>
            <th style="width: 10%;">N° Expediente</th>
            <th style="width: 18%;">Título</th>
            <th style="width: 13%;">Cliente</th>
            <th style="width: 13%;">Abogado Principal</th>
            <th style="width: 10%;">Estado</th>
            <th style="width: 10%;">Prioridad</th>
            <th style="width: 10%;">Tipo</th>
            <th style="width: 12%;">Próx. Vencimiento</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $index => $case)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-bold">{{ $case->case_number ?? '—' }}</td>
                <td>{{ $case->title }}</td>
                <td>{{ $case->client?->name ?? '—' }}</td>
                <td>{{ $case->leadLawyer?->name ?? '—' }}</td>
                <td class="text-center">
                    @if($case->status)
                        @php
                            $statusColor = match ($case->status->value) {
                                'draft' => 'badge-gray',
                                'active' => 'badge-green',
                                'on_hold' => 'badge-yellow',
                                'settled' => 'badge-blue',
                                'closed' => 'badge-red',
                                default => 'badge-gray',
                            };
                        @endphp
                        <span class="badge {{ $statusColor }}">{{ $case->status->label() }}</span>
                    @else
                        —
                    @endif
                </td>
                <td class="text-center">
                    @if($case->priority)
                        @php
                            $prioColor = match ($case->priority->value) {
                                'low' => 'badge-gray',
                                'medium' => 'badge-blue',
                                'high' => 'badge-orange',
                                'urgent' => 'badge-red',
                                default => 'badge-gray',
                            };
                        @endphp
                        <span class="badge {{ $prioColor }}">{{ $case->priority->label() }}</span>
                    @else
                        —
                    @endif
                </td>
                <td>{{ $case->serviceType?->name ?? '—' }}</td>
                <td class="text-center">{{ $case->next_deadline_at?->format('d/m/Y') ?? '—' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center" style="padding: 20px; color: #a0aec0;">
                    No se encontraron expedientes con los filtros aplicados.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>