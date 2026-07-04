<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Apartman; // POPRAVLJENO: Uvezen novi model Apartman umesto starog Product
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        // 1. Ukupan prihod samo od POTVRĐENIH rezervacija
        $totalRevenue = Booking::whereIn('status', ['Potvrđeno', 'approved', 'confirmed'])
            ->sum('total_price');

        // 2. Broj predstojećih gostiju koji stižu ove nedelje (narednih 7 dana)
        $upcomingGuestsCount = Booking::whereIn('status', ['Potvrđeno', 'approved', 'confirmed'])
            ->whereBetween('start_date', [Carbon::today()->toDateString(), Carbon::today()->addDays(7)->toDateString()])
            ->count();

        // 3. Procenat popunjenosti kapaciteta u tekućem mesecu (POPRAVLJENO: Koristi se model Apartman)
        $totalProperties = Apartman::count();
        $daysInMonth = Carbon::now()->daysInMonth;
        $totalPossibleAvailableDays = $totalProperties * $daysInMonth;

        $bookedDaysThisMonth = 0;
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        $bookingsThisMonth = Booking::whereIn('status', ['Potvrđeno', 'approved', 'confirmed'])
            ->where(function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                      ->orWhereBetween('end_date', [$startOfMonth, $endOfMonth])
                      ->orWhere(function ($q) use ($startOfMonth, $endOfMonth) {
                          $q->where('start_date', '<', $startOfMonth)
                            ->where('end_date', '>', $endOfMonth);
                      });
            })->get();

        foreach ($bookingsThisMonth as $booking) {
            $bookingStart = Carbon::parse($booking->start_date);
            $bookingEnd = Carbon::parse($booking->end_date);

            $calcStart = $bookingStart->isBefore(Carbon::now()->startOfMonth()) ? Carbon::now()->startOfMonth() : $bookingStart;
            $calcEnd = $bookingEnd->isAfter(Carbon::now()->endOfMonth()) ? Carbon::now()->endOfMonth() : $bookingEnd;

            $bookedDaysThisMonth += $calcStart->diffInDays($calcEnd) + 1;
        }

        $occupancyRate = $totalPossibleAvailableDays > 0 
            ? round(($bookedDaysThisMonth / $totalPossibleAvailableDays) * 100, 1) 
            : 0;

        $recentBookings = Booking::with(['product', 'user'])->latest()->take(5)->get();
        $propertiesCount = $totalProperties;
        $usersCount = User::count();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'upcomingGuestsCount',
            'occupancyRate',
            'recentBookings',
            'propertiesCount',
            'usersCount'
        ));
    }

    // Prikaz stranice sa kalendarom
    public function calendarView()
    {
        return view('admin.calendar');
    }

    // JSON API koji FullCalendar poziva da povuče zauzete termine
    public function getCalendarEvents()
    {
        $bookings = Booking::with(['product', 'user'])->get();
        $events = [];

        foreach ($bookings as $booking) {
            $status = trim(strtolower($booking->status));
            
            // Određivanje boje u zavisnosti od statusa rezervacije
            if (in_array($status, ['pending', 'na cekanju', 'na čekanju'])) {
                $color = '#f59e0b'; // Žuta/Narandžasta za čekanje
            } elseif (in_array($status, ['approved', 'confirmed', 'potvrđeno', 'potvrdjeno'])) {
                $color = '#ef4444'; // Crvena za zauzeto/potvrđeno
            } else {
                $color = '#94a3b8'; // Sivi fallback za ostale statuse
            }

            $events[] = [
                'id' => $booking->id,
                'title' => ($booking->product->name ?? 'Apartman') . ' - ' . ($booking->user->name ?? 'Gost'),
                'start' => $booking->start_date,
                'end' => Carbon::parse($booking->end_date)->addDay()->toDateString(),
                'backgroundColor' => $color,
                'borderColor' => $color,
                'allDay' => true,
                'extendedProps' => [
                    'gost' => $booking->user->name ?? 'Neznan gost',
                    'smestaj' => $booking->product->name ?? 'Neznani smeštaj',
                    'status' => $booking->status
                ]
            ];
        }

        return response()->json($events);
    }
}