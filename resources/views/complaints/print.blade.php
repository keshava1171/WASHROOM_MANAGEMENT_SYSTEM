<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Paper — Incident #{{ strtoupper(substr((string)($complaint->_id ?? $complaint->id), -8)) }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; color: #000; background: #fff; padding: 40px; line-height: 1.5; }

        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .print-btns { display: flex; gap: 10px; }
        .print-btns button { padding: 10px 24px; font-size: 13px; font-weight: bold; cursor: pointer; border: none; }
        .btn-print { background: #000; color: #fff; }
        .btn-close { background: #eee; color: #333; }

        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 16px; margin-bottom: 25px; }
        .header h1 { font-size: 22px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; }
        .header .subtitle { font-size: 13px; color: #555; margin-top: 5px; }
        .header .doc-type { display: inline-block; margin-top: 8px; padding: 4px 20px; border: 2.5px solid #000; font-size: 11px; font-weight: 900; letter-spacing: 3px; text-transform: uppercase; }

        
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px; }
        .info-box { border: 1.5px solid #000; padding: 12px 15px; }
        .info-box .label { font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; color: #666; border-bottom: 1px solid #ddd; padding-bottom: 5px; margin-bottom: 8px; }
        .info-box .value { font-size: 16px; font-weight: 900; }
        .info-box .value.small { font-size: 13px; }

        
        .status-section { text-align: right; margin-bottom: 20px; }
        .status-stamp { display: inline-block; padding: 8px 22px; font-size: 18px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; }
        .stamp-pending     { border: 4px solid #b45309; color: #b45309; }
        .stamp-in_progress { border: 4px solid #1d4ed8; color: #1d4ed8; transform: rotate(-3deg); }
        .stamp-resolved    { border: 4px solid #15803d; color: #15803d; transform: rotate(-3deg); }

        
        .desc-box { border: 1.5px solid #000; padding: 20px; margin-bottom: 20px; min-height: 120px; }
        .desc-box .label { font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #000; padding-bottom: 5px; margin-bottom: 12px; }
        .desc-box p { font-size: 14px; line-height: 1.7; }

        
        .evidence-box { border: 1.5px solid #000; padding: 15px; margin-bottom: 20px; }
        .evidence-box .label { font-size: 11px; font-weight: 900; text-transform: uppercase; border-bottom: 1px solid #000; padding-bottom: 5px; margin-bottom: 12px; }
        .evidence-box img { max-width: 240px; max-height: 180px; object-fit: cover; border: 1px solid #ccc; display: block; }

        
        .notes-box { border: 1.5px dashed #b45309; padding: 15px; margin-bottom: 20px; background: #fffbf5; }
        .notes-box .label { font-size: 11px; font-weight: 900; text-transform: uppercase; color: #b45309; margin-bottom: 8px; }

        
        .footer { margin-top: 55px; display: flex; justify-content: space-between; gap: 20px; }
        .sig-box { flex: 1; text-align: center; }
        .sig-line { border-top: 1.5px solid #000; margin-top: 45px; padding-top: 6px; font-size: 12px; font-weight: bold; text-transform: uppercase; }

        .no-data-notice { padding: 30px; background: #f5f5f5; border: 2px dashed #ccc; text-align: center; color: #999; font-size: 14px; font-style: italic; border-radius: 4px; }

        @media print {
            .no-print { display: none !important; }
            body { padding: 15px; }
        }
    </style>
</head>
<body>

    <div class="top-bar no-print">
        <div style="font-size:13px; color:#555;">
            <strong>Live Complaint Record.</strong> Status and data reflect the current database state.
            Generated at: <strong>{{ now()->format('d M Y H:i:s') }}</strong>
        </div>
        <div class="print-btns">
            <button class="btn-print" onclick="window.print()">🖨 Print Complaint Paper</button>
            <button class="btn-close" onclick="window.history.back()">← Back</button>
        </div>
    </div>

    <div class="header">
        <h1>Hospital Washroom Management System</h1>
        <div class="subtitle">Support &amp; Incident Resolution Division</div>
        <div class="doc-type">Complaint Paper — Incident Report</div>
    </div>

    
    <div class="status-section">
        <div class="status-stamp stamp-{{ $complaint->status }}">
            STATUS: {{ strtoupper(str_replace('_', ' ', $complaint->status)) }}
        </div>
    </div>

    
    <div class="info-grid">
        <div class="info-box">
            <div class="label">Room / Unit No.</div>
            <div class="value">
                @if($complaint->room)
                    {{ $complaint->room->room_number }}
                    <span style="font-size:12px; font-weight:normal;">({{ strtoupper($complaint->room->type ?? 'ROOM') }})</span>
                @elseif($complaint->washroom)
                    {{ $complaint->washroom->room_number ?? $complaint->washroom->name }}
                    <span style="font-size:12px; font-weight:normal;">(PUBLIC WASHROOM)</span>
                @else
                    <span style="font-size:13px; font-weight:normal; color:#999;">General Floor Area</span>
                @endif
            </div>
        </div>

        <div class="info-box">
            <div class="label">Floor Level</div>
            <div class="value">{{ $complaint->floor->name ?? 'N/A' }}</div>
        </div>

        <div class="info-box">
            <div class="label">Reported By</div>
            <div class="value small">{{ $complaint->user->name ?? 'Anonymous' }}</div>
        </div>

        <div class="info-box">
            <div class="label">Date &amp; Time Reported</div>
            <div class="value small">{{ $complaint->created_at->format('d M Y') }}<br>
                <span style="font-size:12px; font-weight:normal;">{{ $complaint->created_at->format('H:i:s') }}</span>
            </div>
        </div>

        <div class="info-box">
            <div class="label">Issue Type / Classification</div>
            <div class="value small">{{ $complaint->complaint_type ?? 'Not Specified' }}</div>
        </div>

        <div class="info-box">
            <div class="label">Tracking ID</div>
            <div class="value small">#{{ strtoupper(substr((string)($complaint->_id ?? $complaint->id), -8)) }}</div>
        </div>
    </div>

    
    <div class="desc-box">
        <div class="label">Incident Description / Operative Intelligence</div>
        @if($complaint->description)
            <p>{{ $complaint->description }}</p>
        @else
            <p style="color:#999; font-style:italic;">No additional description was provided by the reporter. Classification alone was submitted.</p>
        @endif
    </div>

    
    @if($complaint->image_path)
        <div class="evidence-box">
            <div class="label">Photographic Evidence</div>
            <img src="{{ asset('storage/' . $complaint->image_path) }}" alt="Complaint Evidence">
        </div>
    @endif

    
    @if($complaint->admin_notes || $complaint->status === 'resolved')
        <div class="notes-box">
            <div class="label">⚠ Handler Notes / Resolution Remarks</div>
            <p style="font-size:13px;">
                {{ $complaint->admin_notes ?? 'Complaint marked as resolved with no additional remarks.' }}
            </p>
            @if($complaint->resolved_at)
                <p style="font-size:12px; color:#666; margin-top:8px;">
                    Resolved at: <strong>{{ $complaint->resolved_at->format('d M Y — H:i:s') }}</strong>
                </p>
            @endif
            @if(isset($complaint->handler_name))
                <p style="font-size:12px; color:#666; margin-top:4px;">
                    Handled by: <strong>{{ $complaint->handler_name }}</strong>
                </p>
            @endif
        </div>
    @else
        <div class="no-data-notice">
            This complaint has not yet been resolved. If cleaning or maintenance has been allocated, it will appear in this section once the operative marks the task complete.
        </div>
    @endif

    <div class="footer">
        <div class="sig-box"><div class="sig-line">Maintenance Supervisor</div></div>
        <div class="sig-box"><div class="sig-line">Operative / Handler</div></div>
        <div class="sig-box"><div class="sig-line">Facility Audit Representative</div></div>
    </div>

</body>
</html>

