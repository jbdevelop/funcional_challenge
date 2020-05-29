<div align="center">
    <h1>DESAFIO</h1>
    <img width=150 src='https://www.aboutfarma.com.br/images/materias/2019/04/1023623288_Funcional_health_logo_451.png'>
</div>


## Sobre o desafio

Desenvolver uma API em PHP + Laravel que simule algumas funcionalidades de um banco digital.

## Requisitos
- [PHP](https://www.php.net/downloads) 7.2 ou superior<br>
- [Composer](https://getcomposer.org/download/)
- [Xdebug (Para o PHPUnit coverage)](https://xdebug.org/docs/install)

## Preparando o projeto para rodar

1. Faça o clone do projeto: <br>
    ```git clone https://github.com/jbdevelop/funcional_challenge.git```

2. Entre no diretório **funcional_challenge** e instale as dependências: <br>
    ```composer install```

3. Faça o pull da imagem postgres, baixe, crie e inicie o container: <br>
    ```docker run --name banco -e POSTGRES_PASSWORD=docker -e POSTGRES_DB=banco -p 5432:5432 -d postgres```
          
4. Faça a migrate do banco: <br>
    ```php artisan migrate```

5. Faça o seed do banco: <br>
    ```php artisan db:seed --class=ContaSeeder```

6. Suba o server (o servidor deve rodar no endereço http://127.0.0.1:8000): <br>
    ```php artisan serve```

## Cliente Rest usado para testar endpoints
- [Insomnia](https://insomnia.rest/download/)<br>
    O aquivo **Insomnia.json** está pronto para testes na raiz do projeto

## Testando a API

**Obter Saldo**

http://127.0.0.1:8000/api/saldo <br>
Requisição: 
```
{
  "conta": 3535
}
```

Resposta: 
```
{
  "data": {
    "saldo": "523.22"
  }
}
```

**Sacar dinheiro**

http://127.0.0.1:8000/api/sacar <br>
Requisição:
```
{
  "conta": 7201,
  "valor": 100
}
```

Resposta: 
```
{
  "data": {
    "conta": "7201",
    "saldo": 10698.75
  }
}
```

**Depositar dinheiro**

http://127.0.0.1:8000/api/depositar <br>
Requisição: 
```
{
  "conta": 2769,
  "valor": 200
}
```

Resposta: 
```
{
  "data": {
    "conta": "2769",
    "saldo": 5920.89
  }
}
```

### Erros

**Saque > que saldo**

http://127.0.0.1:8000/api/sacar <br>
Requisição: 
```
{
  "conta": 3535,
  "valor": 1000
}
```

Resposta: 
```
{
  "errors": [
    {
      "message": "Saldo insuficiente"
    }
  ]
}
```

**Saque <= 0 ou vazio**

Requisição: <br>
http://127.0.0.1:8000/api/sacar

```
{
  "conta": 2769,
  "valor": -1
}
```

Resposta: 
```
{
  "errors": [
    {
      "message": "Valor inválido para transação"
    }
  ]
}
```

**Depósito <= 0 ou vazio**

Requisição: <br>
http://127.0.0.1:8000/api/depositar

```
{
  "conta": 7201,
  "valor": 0
}
```

Resposta: 
```
{
  "errors": [
    {
      "message": "Valor inválido para transação"
    }
  ]
}
```

## Rodando testes no PHPUnit pelo terminal 
##### * Execute a partir da pasta do projeto **funcional_challenge** *

- Rodar os testes <br>
    ```./vendor/bin/phpunit```
    
- Rodar os testes com a flag de cobertura **coverage** e saída **html** <br>
    ```./vendor/bin/phpunit --coverage-html <diretorio_destino>```


    
