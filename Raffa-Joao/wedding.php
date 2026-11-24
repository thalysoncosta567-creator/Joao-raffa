<?php
// Busca todas as imagens dentro de img/wedding/
$fotos = glob('img/weeding/*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}', GLOB_BRACE) ?: [];

// Ordena naturalmente pelo nome do arquivo (ex: 01.jpg, 02.jpg, 10.jpg...)
if (!empty($fotos)) {
    natsort($fotos);
    $fotos = array_values($fotos);
}

include 'includes/header.php';
?>

<main class="py-5">
    <div class="container">
        
        <!-- Cabeçalho da Página -->
        <div class="text-center mb-4">
            <p class="text-uppercase mb-1" style="letter-spacing: 3px; color: var(--verde-oliva); font-size: 0.85rem; font-weight: 600;">
                Antes do Grande Dia
            </p>
            <h1 class="display-4 fw-semibold">Nosso Pré-Wedding</h1>
            <div class="divisor-oliva mx-auto"></div>
            <p class="mx-auto" style="max-width: 600px; color: var(--texto-suave);">
                Cada olhar, sorriso e detalhe registrado antes de dizermos o nosso "sim".
            </p>
        </div>

        <?php if (empty($fotos)): ?>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center py-5 px-3 rounded-4" style="background-color: var(--bege-cartao); border: 1px dashed var(--verde-oliva-suave);">
                        <i class="bi bi-camera fs-1 mb-2 d-block" style="color: var(--verde-oliva);"></i>
                        <p class="fonte-serif fs-4 mb-1">Nenhuma foto adicionada ainda</p>
                        <p class="small mb-0" style="color: var(--texto-suave);">
                            Coloque as fotos do ensaio dentro da pasta <code>img/wedding/</code> para exibi-las aqui automaticamente.
                        </p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Carrossel com Moldura Adaptável -->
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <div id="carrosselWedding" class="carousel slide carousel-fade moldura-carrossel" data-bs-ride="carousel" data-bs-interval="4500">
                        
                        <!-- Contador discreto no canto superior -->
                        <div class="contador-slides">
                            <span id="slideAtual">1</span> / <?= count($fotos) ?>
                        </div>

                        <!-- Indicadores inferiores -->
                        <div class="carousel-indicators">
                            <?php foreach ($fotos as $index => $foto): ?>
                                <button type="button" 
                                        data-bs-target="#carrosselWedding" 
                                        data-bs-slide-to="<?= $index ?>" 
                                        class="<?= $index === 0 ? 'active' : '' ?>" 
                                        aria-current="<?= $index === 0 ? 'true' : 'false' ?>">
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <!-- Imagens (sem w-100 para a moldura abraçar o formato exato da foto) -->
                        <div class="carousel-inner">
                            <?php foreach ($fotos as $index => $foto): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <img src="<?= htmlspecialchars($foto) ?>" alt="Foto Pré-Wedding <?= $index + 1 ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Setas de Navegação -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#carrosselWedding" data-bs-slide="prev">
                            <span class="seta-carrossel" aria-hidden="true">
                                <i class="bi bi-chevron-left"></i>
                            </span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carrosselWedding" data-bs-slide="next">
                            <span class="seta-carrossel" aria-hidden="true">
                                <i class="bi bi-chevron-right"></i>
                            </span>
                            <span class="visually-hidden">Próximo</span>
                        </button>
                    </div>

                    <!-- Miniaturas clicáveis abaixo do carrossel -->
                    <div class="barra-miniaturas d-flex justify-content-center flex-wrap gap-2 mt-4">
                        <?php foreach ($fotos as $index => $foto): ?>
                            <button type="button" 
                                    class="btn-miniatura <?= $index === 0 ? 'ativa' : '' ?>" 
                                    data-bs-target="#carrosselWedding" 
                                    data-bs-slide-to="<?= $index ?>">
                                <img src="<?= htmlspecialchars($foto) ?>" alt="Miniatura <?= $index + 1 ?>">
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</main>

<footer class="py-4 text-center mt-auto">
    <div class="container">
        <p class="fonte-serif fs-4 mb-1">Raffa &amp; João &bull; Para Sempre</p>
        <small style="opacity: 0.8;">Presente de Casamento &bull; <?= date('Y') ?></small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const carrossel = document.getElementById('carrosselWedding');
    if (carrossel) {
        carrossel.addEventListener('slid.bs.carousel', function (evento) {
            const contador = document.getElementById('slideAtual');
            if (contador) {
                contador.textContent = evento.to + 1;
            }

            document.querySelectorAll('.btn-miniatura').forEach((btn, idx) => {
                btn.classList.toggle('ativa', idx === evento.to);
            });
        });
    }
</script>
</body>
</html>