<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cleaning Paper — {{ $staff->name }} | {{ now()->format('d M Y') }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; color: #000; background: #fff; padding: 30px; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .print-btns button { padding: 10px 24px; font-size: 13px; font-weight: bold; cursor: pointer; border: none; margin-left: 8px; }
        .btn-print { background: #000; color: #fff; }
        .btn-close { background: #eee; color: #333; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { font-size: 22px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; }
        .header .subtitle { font-size: 13px; font-weight: bold; color: #444; margin-top: 4px; }
        .header .doc-type { display: inline-block; margin-top: 8px; padding: 3px 16px; border: 2px solid #000; font-size: 11px; font-weight: 900; letter-spacing: 2px; text-transform: uppercase; }
        .meta { display: flex; justify-content: space-between; font-size: 13px; font-weight: bold; padding: 10px 0; border-bottom: 1px solid #ccc; margin-bottom: 20px; }
        .floor-section { margin-bottom: 28px; page-break-inside: avoid; }
        .floor-header { background: #000; color: #fff; padding: 8px 14px; font-size: 13px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1.5px solid #000; padding: 9px 12px; font-size: 13px; text-align: left; }
        th { background: #f4f4f4; font-weight: 900; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; }
        .status-badge { display: inline-block; padding: 2px 10px; border: 1.5px solid currentColor; font-size: 11px; font-weight: bold; text-transform: uppercase; }
        .status-pending     { color: #b45309; }
        .status-in_progress { color: #1d4ed8; }
        .status-assigned    { color: #6d28d9; }
        .summary-box { border: 2px solid #000; padding: 12px 18px; margin-top: 18px; display: flex; justify-content: space-between; font-size: 13px; font-weight: bold; }
        .no-data-box { border: 3px dashed #ccc; padding: 50px 20px; text-align: center; color: #999; font-size: 16px; margin: 30px 0; }
        .footer { margin-top: 50px; display: flex; justify-content: space-between; gap: 20px; }
        .sig-box { flex: 1; text-align: center; }
        .sig-line { border-top: 1.5px solid #000; margin-top: 40px; padding-top: 6px; font-size: 12px; font-weight: bold; text-transform: uppercase; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 10px; }
        }
    </style>
</head>
<body>

    <div class="top-bar no-print">
        <div style="font-size:13px; color:#555;">
            <strong>Live Document.</strong> Shows only <u>pending / in-progress / assigned</u> cleaning tasks at time of generation: <strong>{{ now()->format('d M Y H:i:s') }}</strong>
        </div>
        <div class="print-btns">
            <button class="btn-print" onclick="window.print()">🖨 Print Cleaning Paper</button>
            <button class="btn-close" onclick="window.close()">✕ Close</button>
        </div>
    </div>

    <div class="header">
        <h1>Hospital Washroom Management System</h1>
        <div class="subtitle">Washroom &amp; Room Cleaning Allocation Register</div>
        <div class="doc-type">Cleaning Paper — Maintenance Manifest</div>
    </div>

    <div class="meta">
        <div>
            <div>Staff Operative: <strong>{{ $staff->name }}</strong></div>
            <div>Staff ID: <strong>#{{ strtoupper(substr((string)$staff->id, -6)) }}</strong></div>
        </div>
        <div style="text-align:right;">
            <div>Generated: <strong>{{ now()->format('d M Y — H:i:s') }}</strong></div>
            <div>Shift Reference: <strong>#WMS-{{ now()->format('Ymd-Hi') }}</strong></div>
        </div>
    </div>

    @if($tasksByFloor->isEmpty())
        <div class="no-data-box">
            <strong>NO PENDING CLEANING TASKS</strong><br><br>
            All assigned tasks have been completed, or no tasks have been allocated yet.<br>
            <span style="font-size:13px;">Once new tasks are assigned by Command, they will appear here automatically.</span>
        </div>
    @else
        @php $totalCount = $tasksByFloor->flatten()->count(); @endphp

        @foreach($tasksByFloor as $floorName => $tasks)
            <div class="floor-section">
                <div class="floor-header">
                    {{ $floorName }} — {{ $tasks->count() }} Pending Unit(s)
                </div>
                <table>
                    <thead>
                        <tr>
                            <th style="width:45px;">S.No</th>
                            <th style="width:130px;">Room / Unit No.</th>
                            <th>Unit Type</th>
                            <th>Task Description</th>
                            <th style="width:130px;">Status</th>
                            <th style="width:160px;">Done? (Tick)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $rowNum = 1; @endphp
                        @foreach($tasks as $task)
                            @php
                                $roomNo   = $task->room->room_number ?? $task->washroom->room_number ?? '—';
                                $unitType = ($task->room_id && $task->room)
                                    ? ucfirst($task->room->type ?? 'Standard') . ' Room'
                                    : 'Public Washroom';
                            @endphp
                            <tr>
                                <td>{{ $rowNum++ }}</td>
                                <td><strong>{{ $roomNo }}</strong></td>
                                <td>{{ $unitType }}</td>
                                <td>{{ $task->description ?? 'Standard Cleaning' }}</td>
                                <td>
                                    <span class="status-badge status-{{ $task->status }}">
                                        {{ strtoupper(str_replace('_', ' ', $task->status)) }}
                                    </span>
                                </td>
                                <td style="font-size:13px;">[ ] Done &nbsp; [ ] Skipped</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach

        <div class="summary-box">
            <div>Total Pending Units: <strong>{{ $totalCount }}</strong></div>
            <div>Completed tasks are NOT shown in this paper.</div>
        </div>
    @endif

    <div class="footer">
        <div class="sig-box"><div class="sig-line">Cleaning Staff Signature</div></div>
        <div class="sig-box"><div class="sig-line">Patient / Ward Signature<br><span style="font-weight:normal;font-size:11px;">(Private Rooms Only)</span></div></div>
        <div class="sig-box"><div class="sig-line">Floor Incharge Signature</div></div>
    </div>

</body>
</html>
