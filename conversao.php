<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Conversor de Moedas</title>
</head>
<body>
    <main>
        <h1>Conversor de Moedas</h1>
        <section>
        <?php
            // cotação vinda da API do Banco Central
            $inicio = date("m-d-Y", strtotime("-7 days"));
            $fim = date("m-d-Y") ;
            $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''. $inicio .'\'&@dataFinalCotacao=\''. $fim .'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';
            $dados = json_decode(file_get_contents($url), true);
            $cotacao = $dados["value"][0]["cotacaoCompra"];

            // Quanto dinheiro você tem?
            $real = $_REQUEST["valor"] ?? 0; 

            // Equivalência em dólar
            $dolar = $real / $cotacao;

            // Mostrar resultado
            $padrao = numfmt_create("pt-BR", NumberFormatter::CURRENCY);
            echo "<p>Seus " . numfmt_format_currency($padrao, $real, "BRL") . " equivalem a " . numfmt_format_currency($padrao, $dolar, "USD") . "</p>";
            ?>
            <button onclick="javascript:history.go(-1)">Voltar</button>
        </section>
    </main>
</body>
</html>
