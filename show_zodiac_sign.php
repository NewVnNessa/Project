
<?php
include('layouts/header.php');

$nomeSigno = null;
$descricao = null;
$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dataNascimento = $_POST['data_nascimento'] ?? '';

    $data = DateTime::createFromFormat(
        '!Y-m-d',
        $dataNascimento
    );

    $errosData = DateTime::getLastErrors();

    if (
        !$data ||
        ($errosData !== false &&
        ($errosData['warning_count'] > 0 ||
         $errosData['error_count'] > 0)) ||
        $data->format('Y-m-d') !== $dataNascimento
    ) {
        $erro = 'Informe uma data de nascimento válida.';
    } else {

        $signos = simplexml_load_file(
            __DIR__ . '/signos.xml'
        );

        if ($signos === false) {
            $erro = 'Não foi possível carregar o arquivo XML.';
        } else {

            $dataComparacao = $data->format('m-d');

            foreach ($signos->signo as $signo) {

                $inicioData = DateTime::createFromFormat(
                    '!d/m/Y',
                    $signo->dataInicio . '/2000'
                );

                $fimData = DateTime::createFromFormat(
                    '!d/m/Y',
                    $signo->dataFim . '/2000'
                );

                $inicio = $inicioData->format('m-d');
                $fim = $fimData->format('m-d');

                if ($inicio > $fim) {
                    // Capricórnio: dezembro até janeiro
                    $encontrado =
                        $dataComparacao >= $inicio ||
                        $dataComparacao <= $fim;
                } else {
                    $encontrado =
                        $dataComparacao >= $inicio &&
                        $dataComparacao <= $fim;
                }

                if ($encontrado) {
                    $nomeSigno = (string) $signo->signoNome;
                    $descricao = (string) $signo->descricao;
                    break;
                }
            }

            if ($nomeSigno === null) {
                $erro = 'Não foi possível identificar seu signo.';
            }
        }
    }

} else {
    $erro = 'Preencha o formulário para consultar seu signo.';
}
?>

<main class="container py-5">
    <div class="card shadow p-4 mx-auto formulario text-center">

        <?php if ($erro !== null): ?>

            <h1 class="mb-3">Ops!</h1>

            <div class="alert alert-danger">
                <?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?>
            </div>

        <?php else: ?>

            <h1 class="mb-3">Seu signo é:</h1>

            <h2 class="text-primary">
                <?= htmlspecialchars($nomeSigno, ENT_QUOTES, 'UTF-8') ?>
            </h2>

            <p class="mt-3">
                <?= htmlspecialchars($descricao, ENT_QUOTES, 'UTF-8') ?>
            </p>

        <?php endif; ?>

        <a href="index.php" class="btn btn-outline-primary mt-3">
            Voltar
        </a>

    </div>
</main>

</body>
</html>
