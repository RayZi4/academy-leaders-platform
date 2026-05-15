@extends('layout.app')
@section('title', 'Диаграмма Ганта – проекты')
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/frappe-gantt@0.5.0/dist/frappe-gantt.css">
    <style>
        .gantt-container {
            background: white;
            border-radius: 1.25rem;
            box-shadow: var(--card-shadow);
            padding: 1rem;
            overflow-x: auto;
            margin-bottom: 1.5rem;
        }
        #gantt {
            width: 100%;
            min-width: 800px;
        }
        .btn-export {
            margin-bottom: 1rem;
        }
        .no-projects {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 1.25rem;
        }
    </style>
@endpush
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h1><i class="bi bi-bar-chart-steps text-primary"></i> Диаграмма Ганта проектов</h1>
        <button id="exportBtn" class="btn btn-outline-secondary btn-sm"><i class="bi bi-download"></i> Экспорт как PNG</button>
    </div>

    <div class="position-relative">
        <div class="gantt-container">
            <svg id="gantt"></svg>
        </div>
    </div>

    @if(empty($tasks))
        <div class="no-projects">
            <i class="bi bi-info-circle fs-1 text-muted"></i>
            <p class="mt-2">Нет активных проектов для отображения</p>
        </div>
    @endif
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/frappe-gantt@0.5.0/dist/frappe-gantt.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tasks = @json($tasks);
            if (!tasks.length) return;

            const ganttChart = new Gantt("#gantt", tasks, {
                on_click: function(task) {
                    console.log('Task clicked', task);
                },
                on_date_change: function(task, start, end) {
                    console.log('Task changed', task, start, end);
                },
                view_mode: 'Week',
                language: 'ru'
            });

            document.getElementById('exportBtn').addEventListener('click', function() {
                const element = document.querySelector('.gantt-container');
                html2canvas(element, { scale: 2, backgroundColor: '#ffffff' }).then(canvas => {
                    const link = document.createElement('a');
                    link.download = 'gantt.png';
                    link.href = canvas.toDataURL();
                    link.click();
                });
            });
        });
    </script>
@endpush
