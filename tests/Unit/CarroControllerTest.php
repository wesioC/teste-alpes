<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use App\Models\Carro;

class CarroControllerTest extends TestCase
{
    use RefreshDatabase;
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_list_cars()
    {
        Carro::factory()->count(3)->create();

        $response = $this->getJson('/api/carros');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data'); 
    }
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_a_car()
    {
        $data = [
            'type' => 'carro',
            'brand' => 'Hyundai',
            'model' => 'CRETA',
            'version' => 'CRETA 16A ACTION',
            'year' => ['model' => 2025, 'build' => 2025],
            'optionals' => [],
            'doors' => 5,
            'board' => 'JCU2I93',
            'chassi' => '',
            'transmission' => 'Automática',
            'km' => 24208,
            'description' => 'Carro revisado',
            'sold' => false,
            'category' => 'SUV',
            'url_car' => 'hyundai-creta-2025-automatica-125306',
            'price' => 115900.00,
            'color' => 'Branco',
            'fuel' => 'Gasolina',
            'fotos' => [],
        ];

        $response = $this->postJson('/api/carros', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['brand' => 'Hyundai']);

        $this->assertDatabaseHas('carros', [
            'brand' => 'Hyundai',
            'model' => 'CRETA'
        ]);
    }

    public function it_can_show_a_car()
    {
        $carro = Carro::factory()->create();

        $response = $this->getJson("/api/carros/{$carro->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $carro->id]);
    }
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_update_a_car()
    {
        $carro = Carro::factory()->create();

        $data = [
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'year' => ['model' => 2026, 'build' => 2026],
        ];

        $response = $this->putJson("/api/carros/{$carro->id}", $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['brand' => 'Toyota', 'model' => 'Corolla']);

        $this->assertDatabaseHas('carros', [
            'id' => $carro->id,
            'brand' => 'Toyota',
            'model' => 'Corolla',
        ]);
    }
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_delete_a_car()
    {
        $carro = Carro::factory()->create();

        $response = $this->deleteJson("/api/carros/{$carro->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('carros', [
            'id' => $carro->id
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_import_cars_from_api()
    {
        $fakeCars = [
            [
                'id' => 6,
                'type' => 'carro',
                'brand' => 'Nissan',
                'model' => 'Sentra',
                'version' => 'SV 2.0',
                'year' => ['model' => 2025, 'build' => 2025],
                'optionals' => [],
                'doors' => 4,
                'board' => 'MNO345',
                'chassi' => '',
                'transmission' => 'Automática',
                'km' => 10000,
                'description' => 'Carro revisado',
                'sold' => false,
                'category' => 'Sedan',
                'url_car' => 'nissan-sentra-2025',
                'price' => 130000,
                'color' => 'Branco',
                'fuel' => 'Gasolina',
                'fotos' => ['https://alpes-hub.s3.amazonaws.com/img1.jpeg'],
                'created' => now()->toDateTimeString(),
                'updated' => now()->toDateTimeString(),
            ]
        ];

        Http::fake([
            'hub.alpes.one/*' => Http::response($fakeCars, 200),
        ]);

        $this->artisan('importa-carros')
             ->expectsOutput('Baixando dados da API...')
             ->expectsOutput('Importação concluída!')
             ->assertExitCode(0);

        $this->assertDatabaseHas('carros', [
            'id' => 6,
            'brand' => 'Nissan',
            'model' => 'Sentra',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_handles_failed_import_api()
    {
        Http::fake([
            'hub.alpes.one/*' => Http::response([], 500),
        ]);

        $this->artisan('importa-carros')
             ->expectsOutput('Baixando dados da API...')
             ->expectsOutput('Erro ao acessar a URL')
             ->assertExitCode(0);

        $this->assertDatabaseCount('carros', 0);
    }
}
