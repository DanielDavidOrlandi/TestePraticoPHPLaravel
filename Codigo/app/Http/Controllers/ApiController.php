<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\Registro;

class ApiController extends Controller
{
    public function consultaOfertas(Request $request)
    {
        // CPF informado na requisição
        $cpf = $request->input('cpf');

        // Create a new Guzzle HTTP client
        $client = new Client(['verify' => false]);

        // Lista de CPFs disponíveis
        $cpfsDisponiveis = [
            '11111111111',
            '12312312312',
            '22222222222',
        ];

        // Verifica se o CPF informado está disponível
        if (!in_array($cpf, $cpfsDisponiveis)) {
            return response()->json(['error' => 'CPF não encontrado'], 404);
        }

        try {
            // Make a POST request to the external API with the CPF as a query parameter
            $response = $client->post('https://dev.gosat.org/api/v1/simulacao/credito', [
                'json' => ['cpf' => $cpf],
            ]);

            $responseData = json_decode($response->getBody(), true);

            $ofertas = $responseData['instituicoes'];

            // Simula as ofertas de crédito
            $ofertasSimuladas = [];
            foreach ($ofertas as $instituicao) {
                foreach ($instituicao['modalidades'] as $modalidade) {
                    // Create a new Guzzle HTTP client
                    $client = new Client(['verify' => false]);

                    $response = $client->post('https://dev.gosat.org/api/v1/simulacao/oferta', [
                        'query' => ['cpf' => $cpf,
                        'instituicao_id' => $instituicao['id'],
                        'codModalidade' => $modalidade['cod']],
                    ]);

                    $detalhesOferta = json_decode($response->getBody(), true);

                    if ($detalhesOferta) {
                        $ofertaSimulada = [
                            'instituicaoFinanceira' => $instituicao['nome'],
                            'modalidadeCredito' => $modalidade['nome'],
                            'valorAPagar' => round($detalhesOferta['valorMax'] * pow((1 + $detalhesOferta['jurosMes']), $detalhesOferta['QntParcelaMax']),2),
                            'valorSolicitado' => $detalhesOferta['valorMax'],
                            'taxaJuros' => $detalhesOferta['jurosMes'],
                            'qntParcelas' => $detalhesOferta['QntParcelaMax'],
                        ];
                        $ofertasSimuladas[] = $ofertaSimulada;
                    }
                }
            }

            // Ordena as ofertas da mais vantajosa para a menos vantajosa
            usort($ofertasSimuladas, function ($a, $b) {
                return $a['taxaJuros'] <=> $b['taxaJuros'];
            });

            $registro = new Registro;
            $registro->cpf = $cpf;
            $registro->registration = response()->json(array_slice($ofertasSimuladas, 0, 3));
            $registro->save();

            // Retorna até 3 ofertas de crédito simuladas
            return response()->json(array_slice($ofertasSimuladas, 0, 3));


        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function simularOferta($cpf, $instituicaoId, $codModalidade)
    {
        // Create a new Guzzle HTTP client
        $client = new Client(['verify' => false]);

        $response = $client->post('https://dev.gosat.org/api/v1/simulacao/oferta', [
            'query' => ['cpf' => $cpf,
            'instituicao_id' => $instituicaoId,
            'codModalidade' => $codModalidade],
        ]);

        $responseData = json_decode($response->getBody(), true);

        return response()->json($responseData);
    }
}
