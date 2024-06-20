<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;
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
            'status_id' => 'integer',
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

        // Convertir fecha y hora al formato adecuado
        $date_reservation = Carbon::createFromFormat('Y-m-d', $request->date_reservation)->startOfDay();
        $time_reservation = Carbon::parse($request->time_reservation)->format('H:i'); // Formatear a HH:MM
        // Guardar los datos en la base de datos
        $reservation = new Reservation();
        $reservation->date_reservation = $date_reservation;
        $reservation->time_reservation = $time_reservation;
        $reservation->status_id = 1;
        $reservation->service_id = $request->service_id;
        $reservation->client_id = $request->client_id;
        $reservation->user_id = $request->user_id;
        $reservation->save();

        // $reservation = Reservation::create($validatedData);

        if (!$reservation) {
            return response()->json([
                'message' => 'Error al realizar la reserva, intente nuevamente',
                'status' => 500
            ], 500);
        }

        $response = [
            'message' => 'Reserva realizada correctamente',
            'status' => 201,
            'data' => $reservation
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
