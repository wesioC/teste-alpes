<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Carro;

class ImportaCarros extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:importa-carros';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = "https://hub.alpes.one/api/v1/integrator/export/1902";

        $this->info("Baixando dados da API...");

        $response = Http::get($url);

        if ($response->failed()) {
            $this->error("Erro ao acessar a URL");
            return;
        }

        $cars = $response->json();

        foreach ($cars as $car) {
            Carro::updateOrCreate(
                ['id' => $car['id']],
                [
                    'type' => $car['type'] ?? null,
                    'brand' => $car['brand'] ?? null,
                    'model' => $car['model'] ?? null,
                    'version' => $car['version'] ?? null,
                    'year_model' => $car['year']['model'] ?? null,
                    'year_build' => $car['year']['build'] ?? null,
                    'optionals' => json_encode($car['optionals'] ?? []),
                    'doors' => $car['doors'] ?? null,
                    'board' => $car['board'] ?? null,
                    'chassi' => $car['chassi'] ?? null,
                    'transmission' => $car['transmission'] ?? null,
                    'km' => $car['km'] ?? null,
                    'description' => $car['description'] ?? null,
                    'sold' => $car['sold'] ?? 0,
                    'category' => $car['category'] ?? null,
                    'url_car' => $car['url_car'] ?? null,
                    'old_price' => $car['old_price'] ?? null,
                    'price' => $car['price'] ?? null,
                    'color' => $car['color'] ?? null,
                    'fuel' => $car['fuel'] ?? null,
                    'fotos' => json_encode($car['fotos'] ?? []),
                    'created_at' => $car['created'] ?? now(),
                    'updated_at' => $car['updated'] ?? now(),
                ]
            );
        }

        $this->info("Importação concluída!");
    }

}
