<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Masajes',
                'description' => 'Ofrecemos masajes personalizados utilizando diversas técnicas para activar y regenerar el organismo, aliviar el dolor, mejorar la circulación, reducir el estrés, aumentar la relajación y promover la salud y el bienestar general',
                'warning' => 'Inflamaciones, enfermedades infecciosas o contagiosas, cáncer, tumores, quistes, hematomas, úlceras avanzadas, varices avanzadas, cicatrices recientes, fracturas, hemorragias internas, fiebres, apendicitis',
                'image' => 'masajes'
            ],
            [
                'name' => 'Tratamientos Faciales',
                'description' => 'Ofrecemos tratamientos faciales de vanguardia realizados por profesionales expertos para realzar tu belleza y promover el bienestar emocional. Nuestra propuesta en Wellness & Esthetics fusiona belleza, salud y bienestar, brindando un ambiente exclusivo para armonizar mente y cuerpo, y vivir una experiencia de bienestar integral',
                'image' => 'tratamiento-facial'
            ],
            [
                'name' => 'Tratamientos corporales',
                'description' => 'En Sanarte tenemos tratamientos corporales para cada necesidad. Pasa por una evaluación gratuita y te ayudaremos a identificar cual es el indicado para ti. Todos los métodos son seguros y eficaces',
                'image' => 'tratamieto-corporal'
            ], [
                'name' => 'Terapias Holisticas',
                'description' => 'En Sanarte tenemos terapias holísticas, que son un método alternativo a las terapias que conocemos, ya que aborda la gestión de las emociones y las alteraciones psicológicas de un modo distinto al tradicional',
                'image' => 'terapia-holistica'
            ], [
                'name' => 'Rituales',
                'description' => 'Nuestros rituales son experiencias únicas que buscan conectar con tu esencia y equilibrar tu energía. Cada uno de ellos combina técnicas de masaje, faciales y limpieza de aura, acompañados de aromaterapia y musicoterapia para una experiencia de 5 sentidos. Conoce nuestros rituales y elige el que más se adapte a tus necesidades',
                'image' => 'masajes'
            ], [
                'name' => 'Pestañas y Cejas',
                'description' => 'Resalta tu mirada con nuestros servicios de pestañas y cejas. Desde lifting y tinte de pestañas, hasta laminado y botox regenerador para cejas',
                'image' => 'tratamiento-pestanias'
            ], [
                'name' => 'Depilación Láser Soprano',
                'description' => 'La depilación láser Soprano Titanium ofrece una solución avanzada y sin dolor, con tres longitudes de onda combinadas para mayor eficacia y seguridad en todos los tipos de piel. Ganadora del premio al mejor láser mundial, su tecnología 3D destruye los folículos pilosos progresivamente, garantizando resultados duraderos',
                'warning' => 'Incluyen embarazo, tatuajes y lunares grandes, heridas, insolaciones, pelo blanco o pelirrojo, ciertos medicamentos como antineoplásicos o isotretinoína, y tratamientos como quimioterapia. Si se usan despigmentantes o retinol en la zona a depilar, suspender 3 días antes y después de la sesión',
                'image' => 'depilacion-laser'
            ]
        ];

        foreach ($categories as $category) {
            $newCategory = new Category();
            $newCategory->name = $category['name'];
            $newCategory->description = $category['description'];
            isset($category['warning']) ? $newCategory->warning = $category['warning'] : null;
            $newCategory->image = $category['image'];

            $newCategory->save();
        }
    }
}
