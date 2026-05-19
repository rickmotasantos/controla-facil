<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota de Venda</title>
</head>
<body>
    <h2>Nota de Venda</h2>

    <script>
        window.onload = function(){
            window.print();

            window.onafterprint = function(){
                window.location.href = "index.php?action=vendas";
            }
        }
    </script>
</body>
</html>