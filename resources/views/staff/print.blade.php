<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operations Manifest - {{ now()->format('Y-md') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=inter:400,600,800" rel="stylesheet" />
    <style>
        body { font-family: 'Inter', sans-serif; background: #fff; color: #000; }
        @media print {
            body { padding: 0; margin: 0; }
            .no-print { display: none !important; }
            .page-break { page-break-after: always; }
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 12px; text-align: left; }
        th { background: #f8fafc; font-weight: 800; text-transform: uppercase; font-size: 11px; letter-spacing: 0.1em; }
        td { font-size: 13px; font-weight: 500; }
    </style>
</head>
<body class="p-8 max-w-5xl mx-auto">

    <div class="mb-8 flex justify-between items-start border-b-2 border-slate-900 pb-6">
        <div>
            <h1 class="text-3xl font-black uppercase tracking-tighter mb-1 select-all">Operations Manifest</h1>
            <p class="text-sm font-bold text-slate-600 uppercase tracking-widest">WMS Secure Output Document</p>
        </div>
        <div class="text-right">
            <p class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-1">Generated At</p>
            <p class="font-mono font-bold text-lg select-all">{{ now()->format('Y-m-d H:i:s') }}</p>
            <p class="text-xs font-bold uppercase tracking-widest text-slate-500 mt-2 mb-1">Operative</p>
            <p class="font-black text-sm">{{ auth()->user()->name }}</p>
        </div>
    </div>

    @if($tasks->isEmpty())
        <div class="text-center py-20 border-2 border-dashed border-slate-300">
            <h2 class="text-xl font-bold uppercase tracking-widest text-slate-400">Zero Active Assignments.</h2>
            <p class="text-sm font-medium text-slate-500 mt-2">No pending operations in queue.</p>
        </div>
    @else
        <div class="mb-4">
            <h3 class="font-bold text-slate-800 uppercase tracking-widest text-sm">Task Matrix / Pending Operations</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 15%">Sector/Level</th>
                    <th style="width: 25%">Location Node</th>
                    <th style="width: 15%">Protocol</th>
                    <th style="width: 25%">Time Assigned</th>
                    <th style="width: 15%">Signature</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $index => $task)
                    <tr>
                        <td class="text-center font-bold">{{ $index + 1 }}</td>
                        <td class="font-bold">Level {{ $task->floor->level ?? '?' }}<br><span class="text-xs text-slate-500 uppercase tracking-widest">{{ $task->floor->name ?? 'GRID' }}</span></td>
                        <td class="font-black text-base">{{ $task->room ? $task->room->room_name : ($task->washroom->room_number ?? 'PUBLIC_UNIT') }}</td>
                        <td class="uppercase text-xs font-bold tracking-widest">{{ $task->washroom->type ?? 'Standard' }}</td>
                        <td class="font-mono text-xs">{{ $task->created_at->format('H:i / m-d-Y') }}</td>
                        <td></td> 
                    </tr>
                @endforeach
            </tbody>
        </table>

        
        <div class="mt-12 pt-8 border-t border-slate-300 flex justify-between items-end">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-2">Total Deployments: <span class="text-black text-lg">{{ $tasks->count() }}</span></p>
            </div>
            
            <div class="w-64">
                <div class="border-b border-black mb-2 h-10"></div>
                <p class="text-xs font-bold uppercase tracking-widest text-center text-slate-500">Operative Authorization Signature</p>
            </div>
        </div>
    @endif

    <div class="no-print fixed bottom-8 right-8 flex gap-4">
        <a href="{{ route('staff.dashboard') }}" class="px-6 py-3 bg-slate-900 text-white font-bold rounded-lg shadow-lg hover:bg-slate-800 transition-colors uppercase tracking-widest text-xs flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Return
        </a>
        <button onclick="window.print()" class="px-6 py-3 bg-emerald-600 text-white font-bold rounded-lg shadow-lg hover:bg-emerald-700 transition-colors uppercase tracking-widest text-xs flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Print
        </button>
    </div>
</body>
</html>

