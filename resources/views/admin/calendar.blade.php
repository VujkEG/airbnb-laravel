@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 style="font-size:1.5rem; font-weight:700; color:#1a1a2e; margin-bottom: 4px;">Kalendar zauzetosti</h1>
            <p class="text-muted mb-0" style="font-size: 13px;">Pregled svih rezervacija i slobodnih termina u realnom vremenu</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn" style="background:#f1f5f9; color:#1a1a2e; border-radius:8px; font-weight:600;">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard
        </a>
    </div>

    {{-- Legenda boja --}}
    <div class="d-flex gap-3 mb-3 p-3" style="background: white; border: 1.5px solid #f1f5f9; border-radius: 12px; font-size: 13px; font-weight: 500;">
        <div class="d-flex align-items-center gap-2">
            <span style="display:inline-block; width:14px; height:14px; background:#ef4444; border-radius:4px;"></span>
            <span style="color: #475569;">Potvrđena rezervacija (Zauzeto)</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span style="display:inline-block; width:14px; height:14px; background:#f59e0b; border-radius:4px;"></span>
            <span style="color: #475569;">Zahtev na čekanju</span>
        </div>
    </div>

    {{-- Kalendar Kontejner --}}
    <div style="background: white; border: 1.5px solid #f1f5f9; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <div id="calendar"></div>
    </div>
</div>

{{-- Skripte za FullCalendar --}}
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/sr.js"></script>

<style>
    /* Doterivanje izgleda kalendara da matches Airbnb stil */
    .fc-theme-standard td, .fc-theme-standard th {
        border-color: #f1f5f9 !important;
    }
    .fc-header-toolbar {
        margin-bottom: 20px !important;
    }
    .fc-button-primary {
        background-color: #1a1a2e !important;
        border-color: #1a1a2e !important;
    }
    .fc-button-primary:hover {
        background-color: #2e2e4f !important;
        border-color: #2e2e4f !important;
    }
    .fc-button-active {
        background-color: #e53e3e !important;
        border-color: #e53e3e !important;
    }
    .fc-event {
        cursor: pointer;
        padding: 2px 4px;
        font-size: 12px;
        border-radius: 6px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'sr',
            firstDay: 1, // Ponedeljak kao prvi dan
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            events: "{{ route('admin.calendar.events') }}",
            eventClick: function(info) {
                // Kada admin klikne na baner u kalendaru, otvara se prozorčić sa detaljima
                alert(
                    "Rezervacija #" + info.event.id + "\n" +
                    "Objekat: " + info.event.extendedProps.smestaj + "\n" +
                    "Gost: " + info.event.extendedProps.gost + "\n" +
                    "Status: " + info.event.extendedProps.status
                );
            }
        });
        calendar.render();
    });
</script>
@endsection