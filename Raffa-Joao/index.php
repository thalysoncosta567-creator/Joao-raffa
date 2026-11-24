<?php
include 'includes/header.php';


if (file_exists('img/casal.png')) {
    $fotoCasal = 'img/casal.png';
} elseif (file_exists('img/casal.png')) {
    $fotoCasal = 'img/casal.png';
}
?>

<main class="d-flex align-items-center py-5">
    <div class="container py-lg-4">
        <div class="row align-items-center g-5">
            
            <!-- Coluna da Foto com Moldura Dupla e Selo de Data -->
            <div class="col-lg-5 offset-lg-1">
                <div class="composicao-foto">
                    <div class="fundo-decorativo"></div>
                    
                    <div class="moldura-casal">
                        <img src="<?= htmlspecialchars($fotoCasal) ?>" alt="Raffa & João">
                    </div>

                    <div class="selo-data shadow-sm">
                        <span class="d-block text-uppercase" style="font-size: 0.7rem; letter-spacing: 2px;">Save the Date</span>
                        <strong class="fonte-serif fs-5">21 . 11 . 2026</strong>
                    </div>
                </div>
            </div>

            <!-- Coluna do Texto / Dedicatória -->
            <div class="col-lg-5">
                <div class="card-historia">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="linha-curta"></span>
                        <span class="text-uppercase" style="letter-spacing: 3px; color: var(--verde-oliva); font-size: 0.8rem; font-weight: 600;">
                            Nossa História
                        </span>
                    </div>

                    <h1 class="display-3 fw-semibold mb-3" style="color: var(--texto-escuro); line-height: 1.05;">
                        Raffa <span class="fonte-serif fst-italic fw-normal" style="color: var(--verde-oliva);">&amp;</span> João
                    </h1>

                    <blockquote class="citacao-destaque my-4">
                        "De todos os caminhos que poderíamos seguir, escolher caminhar lado a lado foi a nossa melhor decisão."
                    </blockquote>

                    <p class="mb-3" style="color: var(--texto-suave); line-height: 1.85; font-size: 0.96rem;">
                        Este site foi criado como um presente especial para guardar as lembranças mais bonitas dessa fase única. Aqui reunimos os registros do nosso pré-wedding e o carinho em forma de vídeo daqueles que estarão no altar conosco.
                    </p>

                    <p class="mb-4" style="color: var(--texto-suave); line-height: 1.85; font-size: 0.96rem;">
                        Sinta-se em casa para reviver cada sorriso e se emocionar com cada homenagem.
                    </p>

                    <div class="d-flex flex-wrap gap-3 pt-2">
                        <a href="casamento.php" class="btn btn-oliva">
                            <i class="bi bi-images me-2"></i>Venha fazer parte dessa história
                        </a>
                        <a href="padrinhos.php" class="btn btn-oliva-outline">
                            <i class="bi bi-play-circle me-2"></i>Vídeos dos Padrinhos
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<footer class="py-4 text-center mt-auto">
    <div class="container">
        <p class="fonte-serif fs-4 mb-1">Raffa &amp; João &bull; Para Sempre</p>
        <small style="opacity: 0.8;">Presente de Casamento &bull; <?= date('Y') ?></small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>