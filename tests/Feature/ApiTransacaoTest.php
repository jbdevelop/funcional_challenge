<?php

namespace Tests\Feature;

use Tests\TestCase;
class ApiTransacaoTest extends TestCase
{
    public function saldoProvider() {
        return [
            ['2769'],
            ['3535']
        ];
    }

    /**
     * @dataProvider saldoProvider
     */
    public function testApiSaldo($conta)
    {
        $data = ['conta' => $conta];

        $resposta = $this->call('GET','api/saldo', $data);

        $resposta->assertJson([
            'data' => [
                'saldo' => $resposta['data']['saldo']
            ]
        ]);
    }

    public function sacarProvider()
    {
        return [
            ['2769', 300],
            ['3535', 400],
            ['7201', 500]
        ];
    }

    /**
     * @dataProvider sacarProvider
     */
    public function testApiSacar($conta, $valor)
    {
        $data = [
            'conta' => $conta,
            'valor' => $valor
        ];

        $resposta = $this->call('GET','api/saldo', ['conta' => $data['conta']]);

        $saldo = $resposta['data']['saldo'] - $data['valor'];

        $resposta = $this->call('PUT', 'api/sacar', $data);

        $resposta->assertJson([
            'data' => [
                'conta' => $data['conta'],
                'saldo' => $saldo
            ]
        ]);
    }

    public function saqueMaiorQueSaldoProvider()
    {
        return [
            ['2769', 15000],
            ['3535', 18000],
            ['7201', 20000]
        ];
    }

    /**
     * @dataProvider saqueMaiorQueSaldoProvider
     */
    public function testApiSaqueMaiorQueSaldo($conta, $valor) {
        $data = [
            'conta' => $conta,
            'valor' => $valor
        ];

        $resposta = $this->call('PUT', 'api/sacar', $data);

        $resposta->assertJson([
            "errors" => [[
                "message" => "Saldo insuficiente"
            ]]
        ]);
    }

    public function saqueMenorIgualZeroProvider()
    {
        return [
            ['2769', 0],
            ['3535', -1],
            ['7201', -5],
        ];
    }

    /**
     * @dataProvider saqueMenorIgualZeroProvider
     */
    public function testApiSaqueMenorIgualZero($conta, $valor){
        $data = [
            'conta' => $conta,
            'valor' => $valor
        ];

        $resposta = $this->call('PUT', 'api/sacar', $data);

        $resposta->assertJson([
            "errors" => [[
                "message" => "Valor inválido para transação"
            ]]
        ]);
    }

    public function depositarProvider()
    {
        return [
            ['2769', 400],
            ['3535', 500],
            ['7201', 600]
        ];
    }

    /**
     * @dataProvider depositarProvider
     */
    public function testApiDepositar($conta, $valor)
    {
        $data = [
            'conta' => $conta,
            'valor' => $valor
        ];

        $resposta = $this->call('GET','api/saldo', ['conta' => $data['conta']]);

        $saldo = $resposta['data']['saldo'] + $data['valor'];

        $resposta = $this->call('PUT', 'api/depositar', $data);

        $resposta->assertJson([
            'data' => [
                'conta' => $data['conta'],
                'saldo' => $saldo
            ]
        ]);
    }
}
