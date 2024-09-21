<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservation = Reservation::all();

        if ($reservation->isEmpty()) {
            $data = [
                'message' => 'No reservations found',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        $data = [
            'message' => 'Reservations found',
            'status' => 200,
            'data' => $reservation
        ];

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'reservations' => 'required|array',
            'reservations.*.date_reservation' => [
                'required',
                'date_format:Y-m-d',
                function ($attribute, $value, $fail) use ($request) {
                    $inputDate = Carbon::createFromFormat('Y-m-d', $value)->startOfDay();
                    $today = Carbon::today();

                    if ($inputDate < $today) {
                        $fail('The ' . $attribute . ' must be a date after today.');
                    }

                    // Obtener el índice de la reserva actual
                    $index = explode('.', $attribute)[1];
                    $time_reservation = $request->reservations[$index]['time_reservation'];
                    $service_id = $request->reservations[$index]['service_id'];

                    // Obtener la duración máxima del arreglo duration de la tabla services
                    $service = DB::table('services')->where('id', $service_id)->first();
                    $durations = json_decode($service->duration); // Decodificar el arreglo
                    $maxDuration = max($durations); // Obtener la duración más alta

                    // Verificar si ya existe una reserva en la base de datos para la misma fecha
                    $existingReservation = Reservation::whereDate('date_reservation', $value)
                        ->where('service_id', $service_id)
                        ->first();

                    if ($existingReservation) {
                        $existingTime = Carbon::parse($existingReservation->time_reservation);

                        // Calcular la diferencia en minutos
                        $inputTime = Carbon::parse($time_reservation);
                        $differenceInMinutes = $inputTime->diffInMinutes($existingTime);
                        $formattedTime = Carbon::parse($time_reservation)->format('H:i');

                        // Verificar si la diferencia es menor a la duración máxima
                        if ($differenceInMinutes < $maxDuration) {
                            $fail("Ya hay una reserva en el dia $value a las $formattedTime, la nueva reserva debe tener al menos $maxDuration minutos de diferencia.");
                        }
                    }
                },
            ],
            'reservations.*.time_reservation' => [
                'nullable',
                'regex:/^([01][0-9]|2[0-3]):([0-5][0-9])$/' // Validación de formato HH:MM
            ],
            'reservations.*.status_id' => 'integer',
            'reservations.*.service_id' => 'required|integer',
            'reservations.*.client_id' => 'required|integer',
            'reservations.*.personal_id' => 'required|integer',
            'reservations.*.user_id' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Hubo un error al validar los datos, por favor verifica los campos',
                'errors' => $validation->errors()
            ], 400);
        }

        // Procesar las reservas si pasan la validación
        $reservationsData = $request->reservations;
        $createdReservations = [];

        foreach ($reservationsData as $reservationData) {
            // Convertir fecha y hora al formato adecuado
            $date_reservation = Carbon::createFromFormat('Y-m-d', $reservationData['date_reservation'])->startOfDay();
            $time_reservation = Carbon::parse($reservationData['time_reservation'])->format('H:i'); // Formatear a HH:MM

            // Guardar los datos en la base de datos
            $reservation = new Reservation();
            $reservation->date_reservation = $date_reservation;
            $reservation->time_reservation = $time_reservation;
            $reservation->status_id = 1;
            $reservation->service_id = $reservationData['service_id'];
            $reservation->personal_id = $reservationData['personal_id'];
            $reservation->client_id = $reservationData['client_id'];
            $reservation->user_id = $reservationData['user_id'];
            $reservation->save();

            if (!$reservation) {
                return response()->json([
                    'message' => 'Error al realizar la reserva, intente nuevamente',
                    'status' => 500
                ], 500);
            }

            $createdReservations[] = $reservation;
        }

        $response = [
            'message' => 'Reservas realizadas correctamente',
            'status' => 201,
            'data' => $createdReservations
        ];

        return response()->json($response, 201);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            $data = [
                'message' => 'La reserva que buscas no existe',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => 'Reserva encontrada',
            'status' => 200,
            'data' => $reservation
        ];

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'message' => 'La reserva que buscas no existe',
                'status' => 404
            ], 404);
        }

        $validation = Validator::make($request->all(), [
            'date_reservation' => [
                'required',
                'date_format:Y-m-d',
                function ($attribute, $value, $fail) {
                    $inputDate = Carbon::createFromFormat('Y-m-d', $value)->startOfDay();
                    $today = Carbon::today();

                    if ($inputDate <= $today) {
                        $fail('The ' . $attribute . ' must be a date after today.');
                    }
                },
            ],
            'time_reservation' => ['nullable', 'regex:/^([01][0-9]|2[0-3]):([0-5][0-9])$/'], // Validación de formato HH:MM
            'status_id' => 'required|integer',
            'service_id' => 'required|integer',
            'client_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Hubo un error al validar los datos, por favor verifica los campos',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();
        $reservation->fill($validatedData);

        if (!$reservation->save()) {
            return response()->json([
                'message' => 'Error al actualizar la información de la reserva',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'Reserva actualizada correctamente',
            'status' => 200,
            'data' => $reservation
        ];

        return response()->json($response, 200);
    }

    public function updatePartial(Request $request, string $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'message' => 'La reserva que buscas no existe',
                'status' => 404
            ], 404);
        }

        $validation = Validator::make($request->all(), [
            'date_reservation' => [
                'required',
                'date_format:Y-m-d',
                function ($attribute, $value, $fail) {
                    $inputDate = Carbon::createFromFormat('Y-m-d', $value)->startOfDay();
                    $today = Carbon::today();

                    if ($inputDate <= $today) {
                        $fail('The ' . $attribute . ' must be a date after today.');
                    }
                },
            ],
            'time_reservation' => ['required', 'regex:/^([01][0-9]|2[0-3]):([0-5][0-9])$/'], // Validación de formato HH:MM
            'status_id' => 'required|integer',
            'service_id' => 'integer',
            'client_id' => 'integer',
            'user_id' => 'integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'message' => 'Hubo un error al validar los datos, por favor verifica los campos',
                'errors' => $validation->errors()
            ], 400);
        }

        // Obtén los datos validados
        $validatedData = $validation->validated();
        $reservation->update($validatedData);

        $response = [
            'message' => 'Reserva actualizada correctamente',
            'status' => 200,
            'data' => $reservation
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json([
                'message' => 'La reserva que buscas no existe',
                'status' => 404
            ], 404);
        }

        // Actualizar el estado del servicio a false
        $reservation->status_id = 3;

        // Guardar los cambios en la base de datos
        if (!$reservation->save()) {
            return response()->json([
                'message' => 'Error al actualizar la información de la reserva',
                'status' => 500
            ], 500);
        }

        // Respuesta exitosa
        return response()->json([
            'status' => 204
        ], 204);
    }
}
