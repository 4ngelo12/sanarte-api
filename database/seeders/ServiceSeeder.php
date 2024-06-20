<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Masaje de medio cuerpo',
                'description' => 'Un masaje localizado de cabeza, cuello y espalda acompañado de compresas calientes 
                y aromaterapia, nos enfocamos en su zona de dolor o tensión.',
                'price' => 75.00,
                'duration' => [40],
                'state' => 1,
                'category_id' => 1
            ],
            [
                'name' => 'Electromasage - terapeutico',
                'description' => 'La sesión comienza con la colocación de tens en zonas de alta tensión para actuar 
                como analgésico muscular. Posteriormente, se realiza un masaje de tejido profundo que 
                ayuda a liberar nudos y contracturas',
                'price' => 95.00,
                'duration' => [60],
                'state' => 1,
                'category_id' => 1
            ],
            [
                'name' => 'Facial Orgánico',
                'description' => 'La limpieza profunda con productos orgánicos ofrece una solución natural para eliminar impurezas y restaurar la luminosidad de la piel. Adecuada para todas las edades y especialmente recomendada para mujeres embarazadas o en lactancia, esta técnica promueve una piel equilibrada y protegida, sin irritaciones ni sustancias nocivas',
                'price' => 55.00,
                'duration' => [75],
                'state' => 1,
                'category_id' => 2
            ],
            [
                'name' => 'Microneedling',
                'description' => 'El microneedling, una técnica mínimamente invasiva, utiliza microagujas para aplicar productos específicos, mejorando la firmeza y textura de la piel, reduciendo arrugas, líneas de expresión, hiperpigmentaciones y cicatrices de acné. Es ideal para quienes buscan una piel rejuvenecida y tonificada con resultados visibles',
                'price' => 85.00,
                'duration' => [60],
                'state' => 1,
                'category_id' => 2
            ],
            [
                'name' => 'Drenaje Linfático',
                'description' => 'El drenaje linfático corporal es un protocolo que mejora la circulación y ayuda a eliminar líquidos, grasas y toxinas. Beneficia la oxigenación, fortalece el sistema inmunológico y es complementario en tratamientos de celulitis y adelgazamiento. Indicado para edemas, piernas cansadas, y como complemento en tratamientos corporales',
                'price' => 125.00,
                'duration' => [85],
                'state' => 1,
                'category_id' => 3
            ],
            [
                'name' => 'Aromaterapia',
                'description' => 'Los aceites esenciales de plantas actúan sobre el organismo, llegando al sistema nervioso. La aromaterapia combate problemas de salud y reduce síntomas como ansiedad, depresión, estrés y dificultades para dormir. Los olores activan hormonas que mejoran el estado emocional',
                'price' => 75.00,
                'duration' => [60],
                'state' => 1,
                'category_id' => 4
            ],
        ];

        foreach ($services as $service) {
            $newService = new Service();
            $newService->name = $service['name'];
            $newService->description = $service['description'];
            $newService->price = $service['price'];
            $newService->duration = $service['duration'];
            $newService->state = $service['state'];
            $newService->category_id = $service['category_id'];

            $newService->save();
        }
    }
}
