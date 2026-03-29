<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        /* ──────────────────────────────────────────────── */
        /* Base Styles - mPDF Compatible (no Flexbox/Grid) */
        /* ──────────────────────────────────────────────── */
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #2d3748;
            line-height: 1.4;
        }

        h1,
        h2,
        h3 {
            color: #1a365d;
            margin: 0;
            padding: 0;
        }

        h1 {
            font-size: 18px;
        }

        h2 {
            font-size: 14px;
            margin-top: 15px;
            margin-bottom: 8px;
        }

        h3 {
            font-size: 12px;
        }

        /* ──────────────────────────────────────────────── */
        /* Data Table                                       */
        /* ──────────────────────────────────────────────── */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .report-table thead th {
            background-color: #1a365d;
            color: #ffffff;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 8px 6px;
            text-align: left;
            border: 1px solid #1a365d;
        }

        .report-table tbody td {
            padding: 6px;
            border: 1px solid #e2e8f0;
            font-size: 10px;
            vertical-align: top;
        }

        .report-table tbody tr:nth-child(even) {
            background-color: #f7fafc;
        }

        .report-table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        /* ──────────────────────────────────────────────── */
        /* Summary Box                                      */
        /* ──────────────────────────────────────────────── */
        .summary-box {
            background-color: #ebf8ff;
            border: 1px solid #90cdf4;
            border-radius: 4px;
            padding: 10px 15px;
            margin-bottom: 15px;
        }

        .summary-box h3 {
            color: #2b6cb0;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .summary-table {
            width: 60%;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 3px 15px 3px 0;
            font-size: 10px;
            white-space: nowrap;
        }

        .summary-table td.label {
            font-weight: bold;
            color: #2d3748;
        }

        .summary-table td.value {
            color: #4a5568;
        }

        /* ──────────────────────────────────────────────── */
        /* Badges                                           */
        /* ──────────────────────────────────────────────── */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-green {
            background-color: #c6f6d5;
            color: #22543d;
        }

        .badge-red {
            background-color: #fed7d7;
            color: #742a2a;
        }

        .badge-blue {
            background-color: #bee3f8;
            color: #2a4365;
        }

        .badge-yellow {
            background-color: #fefcbf;
            color: #744210;
        }

        .badge-gray {
            background-color: #e2e8f0;
            color: #4a5568;
        }

        .badge-orange {
            background-color: #feebc8;
            color: #7b341e;
        }

        .badge-purple {
            background-color: #e9d8fd;
            color: #553c9a;
        }

        /* ──────────────────────────────────────────────── */
        /* Signature Section                                */
        /* ──────────────────────────────────────────────── */
        .signatures {
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signature-line {
            border-top: 1px solid #2d3748;
            width: 200px;
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #4a5568;
            padding-top: 5px;
        }

        /* Utility */
        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-small {
            font-size: 9px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    {!! $content !!}
</body>

</html>