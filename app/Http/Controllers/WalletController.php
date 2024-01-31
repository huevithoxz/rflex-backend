<?php


namespace App\Http\Controllers;

use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class WalletController extends Controller
{
    public function getValueFromDate($initDate,$endDate) {

        try {
            $initYear = Carbon::parse($initDate)->year;
            $endYear = Carbon::parse($endDate)->year;
            if (($initYear == 2023 || $initYear == 2024) && ($endYear == 2023 || $endYear == 2024)) {
                // Si tanto $a como $b son iguales a 2023 o 2024
                // Coloca aquí el código que deseas ejecutar si la condición es verdadera
                echo $initDate;
                echo $endDate;
                $initDateFormat = Carbon::parse($initDate)->format('Y-m-d');
                $endtDateFormat = Carbon::parse($endDate)->format('Y-m-d');
                $wallets = Wallet::whereBetween('date', [$initDateFormat, $endtDateFormat])->get();
                return $wallets;
            } else {
                // Si al menos una de las variables no es igual a 2023 o 2024
                // Coloca aquí el código que deseas ejecutar si la condición es falsa
                echo "Al menos una de las variables no es igual a 2023 o 2024";
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
       
    } 
}
