<?php
// ==========================================
// 1. CONFIGURAÇÃO DO CLOUDINARY
// ==========================================
$cloudName    = 'xbbwpnmt';
$uploadPreset = 'casamento_preset';

$arquivoRegistro = 'dados/fotos_casamento.json';
if (!is_dir('dados')) {
    mkdir('dados', 0775, true);
}
if (!file_exists($arquivoRegistro)) {
    file_put_contents($arquivoRegistro, json_encode([]));
}

$fotosCasamento = json_decode(file_get_contents($arquivoRegistro), true) ?: [];

$mensagemFeedback = '';
$tipoAlerta = '';
$limiteBytes = 52428800; // 50 MB em bytes (50 * 1024 * 1024)
$extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp', 'heic', 'heif'];

function enviarParaCloudinary($caminhoTemporario, $nomeArquivo, $cloudName, $uploadPreset) {
    $url = "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload";
    
    $mime = function_exists('mime_content_type') ? mime_content_type($caminhoTemporario) : 'image/jpeg';
    $cfile = new CURLFile($caminhoTemporario, $mime, $nomeArquivo);
    
    $postFields = [
        'file'          => $cfile,
        'upload_preset' => $uploadPreset,
        'folder'        => 'casamento'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    
    $resposta = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $dados = json_decode($resposta, true);
        return $dados['secure_url'] ?? false;
    }
    return false;
}

// ==========================================
// 2. PROCESSAMENTO DO UPLOAD
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fotos_casamento'])) {
    $arquivos = $_FILES['fotos_casamento'];
    $totalEnviados = 0;
    $erros = [];

    for ($i = 0; $i < count($arquivos['name']); $i++) {
        $nomeOriginal = $arquivos['name'][$i];
        $tmpName      = $arquivos['tmp_name'][$i];
        $tamanho      = $arquivos['size'][$i];
        $erroUpload   = $arquivos['error'][$i];

        if ($erroUpload === UPLOAD_ERR_NO_FILE) {
            continue;
        }

        if ($erroUpload !== UPLOAD_ERR_OK) {
            $erros[] = "Erro ao enviar \"$nomeOriginal\" (código $erroUpload).";
            continue;
        }

        if ($tamanho > $limiteBytes) {
            $erros[] = "\"$nomeOriginal\" ultrapassa o limite de 50 MB.";
            continue;
        }

        $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
        if (!in_array($extensao, $extensoesPermitidas)) {
            $erros[] = "Formato inválido em \"$nomeOriginal\". Envie JPG, PNG ou WEBP.";
            continue;
        }

        $urlNuvem = enviarParaCloudinary($tmpName, $nomeOriginal, $cloudName, $uploadPreset);

        if ($urlNuvem) {
            array_unshift($fotosCasamento, [
                'url'  => $urlNuvem,
                'data' => date('Y-m-d H:i:s')
            ]);
            $totalEnviados++;
        } else {
            $erros[] = "Não foi possível enviar \"$nomeOriginal\" para a nuvem (verifique se o Upload Preset está como Unsigned).";
        }
    }

    if ($totalEnviados > 0) {
        file_put_contents($arquivoRegistro, json_encode($fotosCasamento, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    if ($totalEnviados > 0 && empty($erros)) {
        header("Location: casamento.php?sucesso=$totalEnviados");
        exit;
    } elseif ($totalEnviados > 0 && !empty($erros)) {
        $tipoAlerta = 'warning';
        $mensagemFeedback = "$totalEnviados foto(s) enviada(s), mas houve avisos: " . implode(' ', $erros);
    } elseif (!empty($erros)) {
        $tipoAlerta = 'danger';
        $mensagemFeedback = implode('<br>', $erros);
    }
}

if (isset($_GET['sucesso'])) {
    $qtd = (int) $_GET['sucesso'];
    $tipoAlerta = 'success';
    $mensagemFeedback = "Obrigado! $qtd foto(s) salva(s) no álbum do casamento com sucesso.";
}

include 'includes/header.php';
?>

<main class="py-5">
    <div class="container">
        
        <!-- Cabeçalho da Página -->
        <div class="text-center mb-4">
            <p class="text-uppercase mb-1" style="letter-spacing: 3px; color: var(--verde-oliva); font-size: 0.85rem; font-weight: 600;">
                Registros do Grande Dia
            </p>
            <h1 class="display-4 fw-semibold">Álbum do Casamento</h1>
            <div class="divisor-oliva mx-auto"></div>
            <p class="mx-auto" style="max-width: 620px; color: var(--texto-suave);">
                Tirou uma foto especial na cerimônia ou na festa? Compartilhe aqui para que possamos guardar cada ângulo desse dia inesquecível.
            </p>
        </div>

        <!-- Alertas de Retorno -->
        <?php if (!empty($mensagemFeedback)): ?>
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8">
                    <div class="alert alert-<?= $tipoAlerta ?> alert-dismissible fade show rounded-4 shadow-sm" role="alert">
                        <?= $mensagemFeedback ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Caixa de Upload -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <form action="casamento.php" method="POST" enctype="multipart/form-data" id="formUploadCasamento" class="caixa-upload text-center">
                    <div class="mb-3">
                        <div class="icone-upload mx-auto mb-3">
                            <i class="bi bi-camera-fill fs-3"></i>
                        </div>
                        <h3 class="fonte-serif fw-bold mb-1" style="color: var(--verde-oliva-escuro);">
                            Envie suas fotos aqui
                        </h3>
                        <p class="small mb-3" style="color: var(--texto-suave);">
                            Selecione uma ou várias fotos de uma vez (JPG, PNG ou WEBP &bull; Até <strong>50 MB</strong> por foto)
                        </p>
                    </div>

                    <input type="file" name="fotos_casamento[]" id="inputFotos" accept="image/*" multiple required class="d-none">

                    <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3">
                        <button type="button" class="btn btn-oliva-outline" onclick="document.getElementById('inputFotos').click()">
                            <i class="bi bi-folder2-open me-2"></i>Escolher Fotos
                        </button>

                        <button type="submit" id="btnEnviar" class="btn btn-oliva d-none">
                            <i class="bi bi-cloud-arrow-up-fill me-2"></i>Enviar Agora
                        </button>
                    </div>

                    <div id="infoArquivos" class="mt-3 small fw-medium" style="color: var(--verde-oliva-escuro);"></div>
                </form>
            </div>
        </div>

        <!-- Cabeçalho da Galeria -->
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2" style="border-bottom: 1px solid var(--bege-borda);">
            <h2 class="fonte-serif fs-3 fw-bold mb-0" style="color: var(--verde-oliva-escuro);">
                Galeria dos Convidados
            </h2>
            <span class="badge rounded-pill px-3 py-2" style="background-color: var(--bege-cartao); color: var(--verde-oliva-escuro);">
                <?= count($fotosCasamento) ?> <?= count($fotosCasamento) === 1 ? 'foto' : 'fotos' ?>
            </span>
        </div>

        <!-- Grade de Fotos em Quadrados -->
        <?php if (empty($fotosCasamento)): ?>
            <div class="text-center py-5 rounded-4" style="background-color: var(--bege-cartao); border: 1px dashed var(--bege-borda);">
                <i class="bi bi-images fs-1 mb-2 d-block" style="color: var(--verde-oliva-suave);"></i>
                <p class="fonte-serif fs-4 mb-1">Nenhuma foto enviada ainda</p>
                <p class="small mb-0" style="color: var(--texto-suave);">Seja o primeiro a registrar um momento especial acima!</p>
            </div>
        <?php else: ?>
            <div class="row g-3 g-md-4">
                <?php foreach ($fotosCasamento as $item): ?>
                    <?php 
                        $urlOriginal  = $item['url'];
                        $urlMiniatura = str_replace('/upload/', '/upload/c_fill,w_600,h_600,q_auto,f_auto/', $urlOriginal);
                    ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="quadrado-foto" onclick="abrirFotoModal('<?= htmlspecialchars($urlOriginal) ?>')">
                            <img src="<?= htmlspecialchars($urlMiniatura) ?>" alt="Foto do Casamento" loading="lazy">
                            <div class="overlay-quadrado">
                                <i class="bi bi-arrows-fullscreen fs-4 text-white"></i>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<!-- Modal para ampliar a foto ao clicar no quadrado -->
<div class="modal fade" id="modalFotoCasamento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 text-center position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 bg-dark p-2 rounded-circle" data-bs-dismiss="modal" aria-label="Fechar"></button>
                <img id="imgModalAmpliada" src="" class="img-fluid rounded-4 shadow-lg" style="max-height: 85vh;" alt="Foto Ampliada">
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
    const inputFotos = document.getElementById('inputFotos');
    const infoArquivos = document.getElementById('infoArquivos');
    const btnEnviar = document.getElementById('btnEnviar');
    const formUpload = document.getElementById('formUploadCasamento');
    const limiteMax50MB = 52428800; // 50 MB
    const limiteCloudinaryFree = 9961472; // 9.5 MB

    function otimizarImagemGrande(arquivo) {
        return new Promise((resolve) => {
            if (arquivo.size <= limiteCloudinaryFree || !arquivo.type.startsWith('image/')) {
                return resolve(arquivo);
            }

            const img = new Image();
            const urlTemp = URL.createObjectURL(arquivo);
            img.onload = () => {
                URL.revokeObjectURL(urlTemp);
                const maxLado = 2560;
                let { width, height } = img;

                if (width > maxLado || height > maxLado) {
                    if (width > height) {
                        height = Math.round((height * maxLado) / width);
                        width = maxLado;
                    } else {
                        width = Math.round((width * maxLado) / height);
                        height = maxLado;
                    }
                }

                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                canvas.toBlob((blob) => {
                    if (blob) {
                        const nomeJpg = arquivo.name.replace(/\.[^/.]+$/, "") + ".jpg";
                        resolve(new File([blob], nomeJpg, { type: 'image/jpeg' }));
                    } else {
                        resolve(arquivo);
                    }
                }, 'image/jpeg', 0.88);
            };
            img.onerror = () => resolve(arquivo);
            img.src = urlTemp;
        });
    }

    inputFotos.addEventListener('change', async function() {
        const arquivos = Array.from(this.files);
        if (arquivos.length === 0) {
            infoArquivos.textContent = '';
            btnEnviar.classList.add('d-none');
            return;
        }

        const arquivoMuitoGrande = arquivos.find(f => f.size > limiteMax50MB);
        if (arquivoMuitoGrande) {
            alert(`A foto "${arquivoMuitoGrande.name}" ultrapassa o limite máximo de 50 MB.`);
            this.value = '';
            infoArquivos.textContent = '';
            btnEnviar.classList.add('d-none');
            return;
        }

        infoArquivos.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Preparando foto(s)...';
        
        const dataTransfer = new DataTransfer();
        for (const arq of arquivos) {
            const arqFinal = await otimizarImagemGrande(arq);
            dataTransfer.items.add(arqFinal);
        }
        this.files = dataTransfer.files;

        const totalMB = (Array.from(this.files).reduce((acc, f) => acc + f.size, 0) / 1048576).toFixed(1);
        infoArquivos.innerHTML = `<i class="bi bi-check-circle-fill me-1 text-success"></i> ${this.files.length} foto(s) pronta(s) para envio (${totalMB} MB)`;
        btnEnviar.classList.remove('d-none');
    });

    formUpload.addEventListener('submit', function() {
        btnEnviar.disabled = true;
        btnEnviar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando para o álbum...';
    });

    function abrirFotoModal(caminho) {
        document.getElementById('imgModalAmpliada').src = caminho;
        const modal = new bootstrap.Modal(document.getElementById('modalFotoCasamento'));
        modal.show();
    }
</script>
</body>
</html>