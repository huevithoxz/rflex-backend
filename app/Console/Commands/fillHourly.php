<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class fillHourly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill-hourly {year=2023}';

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
        try {
            $url = 'https://mindicador.cl/api/dolar/' . $year;
            $response = Http::withOptions(['verify' => false])->get($url);
            $response = json_decode($response->body());
            $serie = $response->serie;
    
            foreach ($serie as $s) {
                $fecha = $s->fecha;
                $formatedDate = Carbon::parse($fecha)->format('d-m-Y');
    
                // Validate if the year is in th bd
                $yearExists = Wallet::whereYear('date', $year)->exists();
    
                if (!$yearExists) {
                    $wallet = new Wallet();
                    $wallet->date = $formatedDate;
                    $wallet->value = $s->valor;
                    $wallet->save();
                }
            }
    
            return $serie;
        } catch (Exception $e) {
            // Manejar la excepción
            // Por ejemplo, puedes registrar el error o devolver un mensaje de error adecuado
            Log::error('Error al obtener valores de la API: ' . $e->getMessage());
            return [];
        }
            }
        
    }

