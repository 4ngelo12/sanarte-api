<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function topServicesLastMonth()
    {
        // Obtener las fechas de inicio y fin del mes anterior
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        // Realizar la consulta
        $topServices = Reservation::select('service_id', DB::raw('count(*) as total_reservations'))
            ->whereBetween('date_reservation', [$startOfLastMonth, $endOfLastMonth])
            ->groupBy('service_id')
            ->orderBy('total_reservations', 'desc')
            ->with('service') // Cargar la relación del servicio
            ->take(3)
            ->get();

        // Preparar los datos para la respuesta
        $result = $topServices->map(function ($reservation) {
            return [
                'service_id' => $reservation->service_id,
                'total_reservations' => $reservation->total_reservations,
                'service_name' => $reservation->service->name,
            ];
        });

        // Preparar la respuesta
        $data = [
            'message' => 'Top services from last month',
            'status' => 200,
            'data' => $result
        ];

        return response()->json($data, 200);
    }

    public function topDaysLastMonth()
    {
        // Obtener las fechas de inicio y fin del mes anterior
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        // Realizar la consulta y agrupar por día
        $topDays = Reservation::select(DB::raw('DATE(date_reservation) as day'), DB::raw('count(*) as total_reservations'))
            ->whereBetween('date_reservation', [$startOfLastMonth, $endOfLastMonth])
            ->groupBy(DB::raw('DATE(date_reservation)'))
            ->orderBy('total_reservations', 'desc')
            ->take(3) // Limitar a los 3 primeros resultados
            ->get();

        // Preparar los datos para la respuesta
        $result = $topDays->map(function ($reservation) {
            $dayOfWeek = Carbon::parse($reservation->day)->locale('es')->isoFormat('dddd'); // Convertir la fecha al nombre del día en español
            return [
                'day' => ucfirst($dayOfWeek), // Capitalizar la primera letra
                'total_reservations' => $reservation->total_reservations,
            ];
        });

        // Preparar la respuesta
        $data = [
            'message' => 'Top days from last month',
            'status' => 200,
            'data' => $result
        ];

        return response()->json($data, 200);
    }
}
