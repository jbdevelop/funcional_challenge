<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Conta;

/*
Os testes falham para métodos private/protected. Então, ao invés de
usar ReflectionClass e permitir a visibilidade dos métodos para
os testes, para o desafio decidi manter public todos eles.
*/
class TransacaoController extends Controller
{
    public function show(Request $request)
    {
        $conta = Conta::where('conta', $request->conta)->first();

        if (!$conta || $request->conta <= 0 || $request->conta === NULL) {
            return response()->json([
                "errors" => [[
                    "message" => "Conta inválida"
                ]]
            ]);
        }

        return response()->json([
            "data" => [
                "saldo" => $conta->saldo
            ]
        ]);
    }

    public function update(Request $request)
    {
        $conta = Conta::where('conta', $request->conta)->first();

        if (!$conta || $request->conta <= 0 || $request->conta === NULL) {
            return response()->json([
                "errors" => [[
                    "message" => "Conta inválida"
                ]]
            ]);
        }

        if ($request->valor <= 0 || $request->valor === NULL) {
            return response()->json([
                "errors" => [[
                    "message" => "Valor inválido para transação"
                ]]
            ]);
        }

        $rota = $request->route()->getName();

        if ($rota === "sacar") {
            if ($request->valor > $conta->saldo) {
                return response()->json([
                    "errors" => [[
                        "message" => "Saldo insuficiente"
                    ]]
                ]);
            }
            $conta->saldo -= $request->valor;

        } elseif ($rota === "depositar") {
            $conta->saldo += $request->valor;
        }

        $conta->save();

        return response()->json([
            "data" => [
                "conta" => $conta->conta,
                "saldo" => $conta->saldo
            ]
        ]);
    }
}
