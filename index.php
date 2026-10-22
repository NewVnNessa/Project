
<?php include('layouts/header.php');?>

<main class="container py-5">
    <div class="card shadow p-4 mx-auto formulario">

        <h1 class="text-center mb-3">
            Descubra seu signo aqui!
        </h1>

        <p class="text-center">
            Por favor, informe sua data de nascimento
            para descobrirmos seu signo do zodíaco!
        </p>

        <form
            id="signo-form"
            method="POST"
            action="show_zodiac_sign.php"
        >
            <div class="mb-3">
                <label
                    for="data_nascimento"
                    class="form-label"
                >
                    Data de nascimento
                </label>

                <input
                    type="date"
                    class="form-control"
                    id="data_nascimento"
                    name="data_nascimento"
                    required
                >
            </div>

            <button
                type="submit"
                class="btn btn-primary w-100"
            >
                Descobrir meu signo
            </button>
        </form>

    </div>
</main>

</body>
</html>
