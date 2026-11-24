<?php
// =========================================================================
// LISTA DE VÍDEOS DOS PADRINHOS (Cole aqui os links copiados do Cloudinary)
// =========================================================================
$videos = [
    [
        'nome'  => 'Sandra & Clébio',
        'papel' => 'Pais da Noiva',
        'url'   => 'https://res.cloudinary.com/xbbwpnmt/video/upload/v1795145895/WhatsApp_Video_2026-11-20_at_00.34.31.mp4'
    ],
    [
        'nome'  => 'Luísa & José',
        'papel' => 'Pais do Noivo',
        'url'   => 'https://res.cloudinary.com/xbbwpnmt/video/upload/v1795145774/WhatsApp_Video_2026-11-19_at_21.42.01.mp4'
    ],
      [
        'nome'  => 'Pedro',
        'papel' => 'Padrinho',
        'url'   => 'https://res.cloudinary.com/xbbwpnmt/video/upload/v1795145806/WhatsApp_Video_2026-11-19_at_20.25.15.mp4'
    ],
     [
        'nome'  => 'Raíssa & Thalyson',
        'papel' => 'Padrinhos',
        'url'   => 'https://res.cloudinary.com/xbbwpnmt/video/upload/v1795145886/WhatsApp_Video_2026-11-20_at_00.34.33.mp4'
    ],
    [
        'nome'  => 'Letićia',
        'papel' => 'Madrinha',
        'url'   => 'https://res.cloudinary.com/xbbwpnmt/video/upload/v1795145851/WhatsApp_Video_2026-11-19_at_13.10.10.mp4'
    ],
     [
        'nome'  => 'Camlia',
        'papel' => 'Madrinha',
        'url'   => 'https://res.cloudinary.com/xbbwpnmt/video/upload/v1795145819/WhatsApp_Video_2026-11-19_at_18.03.44.mp4'
    ],
    [
        'nome'  => 'Nicolas',
        'papel' => 'Padrinho',
        'url'   => 'https://res.cloudinary.com/xbbwpnmt/video/upload/v1795145825/WhatsApp_Video_2026-11-19_at_16.27.41.mp4'
    ],
    [
        'nome'  => 'José & Marie & Maiŕa',
        'papel' => 'Padrinhos',
        'url'   => 'https://res.cloudinary.com/xbbwpnmt/video/upload/v1795145767/WhatsApp_Video_2026-11-19_at_23.59.58.mp4'
    ],
     [
        'nome'  => 'Júnior',
        'papel' => 'Padrinho',
        'url'   => 'https://res.cloudinary.com/xbbwpnmt/video/upload/v1795145796/WhatsApp_Video_2026-11-19_at_21.13.48.mp4'
    ],
      [
        'nome'  => 'Mayara & Gabriel',
        'papel' => 'Padrinhos',
        'url'   => 'https://res.cloudinary.com/xbbwpnmt/video/upload/v1795145843/WhatsApp_Video_2026-11-18_at_08.58.23.mp4'
    ],
    [
        'nome'  => 'Thaiś & Felipe',
        'papel' => 'Padrinhos',
        'url'   => 'https://res.cloudinary.com/xbbwpnmt/video/upload/v1795145837/WhatsApp_Video_2026-11-19_at_13.10.20.mp4'
    ],
     [
        'nome'  => 'Marceli & Esposo',
        'papel' => 'Padrinhos',
        'url'   => 'https://res.cloudinary.com/xbbwpnmt/video/upload/v1795229839/WhatsApp_Video_2026-11-20_at_20.47.49.mp4'
    ],
    // Para adicionar mais vídeos, copie um bloco { ... }, e cole aqui abaixo
];

include 'includes/header.php';
?>

<main class="py-5">
    <div class="container">
        
        <!-- Cabeçalho da Página -->
        <div class="text-center mb-5">
            <p class="text-uppercase mb-1" style="letter-spacing: 3px; color: var(--verde-oliva); font-size: 0.85rem; font-weight: 600;">
                Homenagens Especiais
            </p>
            <h1 class="display-4 fw-semibold">Vídeos dos Padrinhos</h1>
            <div class="divisor-oliva mx-auto"></div>
            <p class="mx-auto" style="max-width: 620px; color: var(--texto-suave);">
                Palavras de carinho, histórias e votos de felicidade de quem caminhou ao nosso lado até o altar.
            </p>
        </div>

        <!-- Grade de Vídeos em Quadrados -->
        <?php if (empty($videos)): ?>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center py-5 px-3 rounded-4" style="background-color: var(--bege-cartao); border: 1px dashed var(--verde-oliva-suave);">
                        <i class="bi bi-camera-reels fs-1 mb-2 d-block" style="color: var(--verde-oliva);"></i>
                        <p class="fonte-serif fs-4 mb-1">Em breve, as homenagens</p>
                        <p class="small mb-0" style="color: var(--texto-suave);">
                            Os vídeos dos nossos padrinhos aparecerão aqui muito em breve.
                        </p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row g-3 g-md-4 justify-content-center">
                <?php foreach ($videos as $video): ?>
                    <?php 
                        $urlVideo = $video['url'];
                        // Gera automaticamente a imagem de capa (thumbnail 600x600) direto pelo Cloudinary
                        $urlCapa  = preg_replace(
                            '/\.(mp4|mov|webm|m4v)$/i', 
                            '.jpg', 
                            str_replace('/upload/', '/upload/c_fill,g_auto,w_600,h_600,q_auto/', $urlVideo)
                        );
                    ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="quadrado-video" onclick="abrirVideoModal('<?= htmlspecialchars($urlVideo) ?>', '<?= htmlspecialchars($video['nome'], ENT_QUOTES) ?>', '<?= htmlspecialchars($video['papel'], ENT_QUOTES) ?>')">
                            <img src="<?= htmlspecialchars($urlCapa) ?>" alt="<?= htmlspecialchars($video['nome']) ?>" class="w-100 h-100" style="object-fit: cover;">
                            
                            <div class="overlay-video">
                                <div class="botao-play-quadrado">
                                    <i class="bi bi-play-fill fs-2 ms-1"></i>
                                </div>
                            </div>

                            <div class="legenda-video">
                                <span class="d-block fw-semibold"><?= htmlspecialchars($video['nome']) ?></span>
                                <?php if (!empty($video['papel'])): ?>
                                    <small style="font-size: 0.75rem; opacity: 0.85;"><?= htmlspecialchars($video['papel']) ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<!-- Modal para assistir o vídeo ampliado com som -->
<div class="modal fade" id="modalVideoPadrinhos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 overflow-hidden" style="background-color: #1E2118;">
            <div class="modal-header border-0 px-4 pt-3 pb-2">
                <div>
                    <h5 class="modal-title fonte-serif fs-4 text-white mb-0" id="tituloModalVideo">Homenagem</h5>
                    <small id="papelModalVideo" style="color: #C5D1B0;"></small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body p-0 text-center bg-black">
                <video id="playerModalVideo" controls playsinline class="w-100" style="max-height: 78vh; outline: none;">
                    Seu navegador não suporta a reprodução de vídeos.
                </video>
            </div>
        </div>
    </div>
</div>

<footer class="py-4 text-center mt-auto">
    <div class="container">
        <p class="fonte-serif fs-4 mb-1">Raffa &amp; João &bull; Para Sempre</p>
        <small style="opacity: 0.8;">Presente de Casamento &bull; <?= date('Y') ?></small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const modalEl = document.getElementById('modalVideoPadrinhos');
    const player = document.getElementById('playerModalVideo');
    const tituloEl = document.getElementById('tituloModalVideo');
    const papelEl = document.getElementById('papelModalVideo');

    function abrirVideoModal(caminho, titulo, papel) {
        tituloEl.textContent = titulo;
        papelEl.textContent = papel || '';
        player.src = caminho;
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
        player.play().catch(() => {});
    }

    modalEl.addEventListener('hidden.bs.modal', function () {
        player.pause();
        player.removeAttribute('src');
        player.load();
    });
</script>
</body>
</html>