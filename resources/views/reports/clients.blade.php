{{-- Reporte de Clientes --}}
@forelse($data as $client)
    <div
        style="margin-top: 20px; border: 1px solid #1a365d; border-radius: 5px; overflow: hidden; page-break-inside: avoid;">
        <div style="background-color: #f1f5f9; padding: 10px; border-bottom: 1px solid #1a365d;">
            <h4 style="margin: 0; color: #1a365d;">Cliente: {{ $client->name }}</h4>
            <div style="font-size: 10px; color: #64748b; margin-top: 4px;">
                Email: {{ $client->email ?? '—' }} | Teléfono: {{ $client->phone ?? '—' }} | Persona de Contacto:
                {{ $client->contact_person ?? '—' }}
            </div>
        </div>

        @php
            $grandTotalHours = 0;
            $hasAnyData = $client->report_tasks->count() > 0 || $client->report_requests->count() > 0 || $client->report_cases->count() > 0;
        @endphp

        @if(!$hasAnyData)
            <div style="padding: 15px; text-align: center; color: #94a3b8; font-size: 11px;">
                No se encontraron registros (solicitudes, expedientes o tareas) para este cliente.
            </div>
        @else
            {{-- Tasks Table --}}
            @if($client->report_tasks->count() > 0)
                <div
                    style="padding: 10px 10px 5px 10px; background-color: #f8fafc; font-weight: bold; font-size: 12px; color: #1e293b; border-bottom: 1px solid #e2e8f0;">
                    Tareas
                </div>
                <table class="report-table" style="margin-top: 0; border: none;">
                    <thead>
                        <tr style="background-color: #cbd5e1;">
                            <th style="width: 3%; text-align: center;">#</th>
                            <th style="width: 12%;">Número</th>
                            <th style="width: 27%;">Título</th>
                            <th style="width: 20%;">Abogado</th>
                            <th style="width: 10%;">Estado</th>
                            <th style="width: 10%; text-align: center;">Ingreso</th>
                            <th style="width: 10%; text-align: center;">Terminado</th>
                            <th style="width: 8%; text-align: center;">Horas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($client->report_tasks as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-bold">{{ $item['numero'] }}</td>
                                <td>{{ $item['titulo'] }}</td>
                                <td>{{ $item['abogado'] }}</td>
                                <td>{{ $item['estado'] }}</td>
                                <td class="text-center">{{ $item['fecha_ingreso'] }}</td>
                                <td class="text-center">{{ $item['fecha_terminado'] }}</td>
                                <td class="text-center text-bold">{{ number_format($item['horas'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @php $grandTotalHours += $client->report_tasks->sum('horas'); @endphp
            @endif

            {{-- Requests Table --}}
            @if($client->report_requests->count() > 0)
                <div
                    style="padding: 10px 10px 5px 10px; background-color: #f8fafc; font-weight: bold; font-size: 12px; color: #1e293b; border-bottom: 1px solid #e2e8f0; border-top: 1px solid #cbd5e1;">
                    Solicitudes
                </div>
                <table class="report-table" style="margin-top: 0; border: none;">
                    <thead>
                        <tr style="background-color: #cbd5e1;">
                            <th style="width: 3%; text-align: center;">#</th>
                            <th style="width: 12%;">Número</th>
                            <th style="width: 27%;">Título</th>
                            <th style="width: 20%;">Abogado</th>
                            <th style="width: 10%;">Estado</th>
                            <th style="width: 10%; text-align: center;">Ingreso</th>
                            <th style="width: 10%; text-align: center;">Terminado</th>
                            <th style="width: 8%; text-align: center;">Horas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($client->report_requests as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-bold">{{ $item['numero'] }}</td>
                                <td>{{ $item['titulo'] }}</td>
                                <td>{{ $item['abogado'] }}</td>
                                <td>{{ $item['estado'] }}</td>
                                <td class="text-center">{{ $item['fecha_ingreso'] }}</td>
                                <td class="text-center">{{ $item['fecha_terminado'] }}</td>
                                <td class="text-center text-bold">{{ number_format($item['horas'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @php $grandTotalHours += $client->report_requests->sum('horas'); @endphp
            @endif

            {{-- Cases Table --}}
            @if($client->report_cases->count() > 0)
                <div
                    style="padding: 10px 10px 5px 10px; background-color: #f8fafc; font-weight: bold; font-size: 12px; color: #1e293b; border-bottom: 1px solid #e2e8f0; border-top: 1px solid #cbd5e1;">
                    Expedientes
                </div>
                <table class="report-table" style="margin-top: 0; border: none;">
                    <thead>
                        <tr style="background-color: #cbd5e1;">
                            <th style="width: 3%; text-align: center;">#</th>
                            <th style="width: 12%;">Número</th>
                            <th style="width: 27%;">Título</th>
                            <th style="width: 20%;">Abogado</th>
                            <th style="width: 10%;">Estado</th>
                            <th style="width: 10%; text-align: center;">Ingreso</th>
                            <th style="width: 10%; text-align: center;">Terminado</th>
                            <th style="width: 8%; text-align: center;">Horas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($client->report_cases as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-bold">{{ $item['numero'] }}</td>
                                <td>{{ $item['titulo'] }}</td>
                                <td>{{ $item['abogado'] }}</td>
                                <td>{{ $item['estado'] }}</td>
                                <td class="text-center">{{ $item['fecha_ingreso'] }}</td>
                                <td class="text-center">{{ $item['fecha_terminado'] }}</td>
                                <td class="text-center text-bold">{{ number_format($item['horas'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @php $grandTotalHours += $client->report_cases->sum('horas'); @endphp
            @endif

            {{-- Client Grand Total --}}
            <div
                style="background-color: #1a365d; color: white; padding: 8px 15px; text-align: right; font-weight: bold; font-size: 12px;">
                Gran Total Horas Invertidas para {{ $client->name }}: {{ number_format($grandTotalHours, 2) }}
            </div>
        @endif
    </div>
@empty
    <div
        style="padding: 30px; text-align: center; color: #64748b; border: 1px dashed #cbd5e1; border-radius: 8px; margin-top: 20px;">
        No se encontraron clientes con los filtros aplicados.
    </div>
@endforelse