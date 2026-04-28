<?php $__env->startSection('title', 'Reportar Nova Denúncia'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="page-title">Reportar Nova Denúncia</h1>

            <div class="card shadow-lg">
                <div class="card-body p-4">
                    <form action="<?php echo e(route('denuncias.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Título da Denúncia *</label>
                            <input type="text" name="titulo" class="form-control <?php $__errorArgs = ['titulo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('titulo')); ?>" required placeholder="Ex: Phishing de conta bancária">
                            <?php $__errorArgs = ['titulo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tipo de Fraude *</label>
                                <select name="tipo" class="form-select <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Selecione...</option>
                                    <option value="phishing" <?php echo e(old('tipo') === 'phishing' ? 'selected' : ''); ?>>Phishing</option>
                                    <option value="malware" <?php echo e(old('tipo') === 'malware' ? 'selected' : ''); ?>>Malware</option>
                                    <option value="fraude" <?php echo e(old('tipo') === 'fraude' ? 'selected' : ''); ?>>Fraude Financeira</option>
                                    <option value="roubo_identidade" <?php echo e(old('tipo') === 'roubo_identidade' ? 'selected' : ''); ?>>Roubo de Identidade</option>
                                    <option value="spam" <?php echo e(old('tipo') === 'spam' ? 'selected' : ''); ?>>Spam</option>
                                    <option value="outro" <?php echo e(old('tipo') === 'outro' ? 'selected' : ''); ?>>Outro</option>
                                </select>
                                <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Prioridade</label>
                                <select name="prioridade" class="form-select">
                                    <option value="media" selected>Média</option>
                                    <option value="baixa">Baixa</option>
                                    <option value="alta">Alta</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Descrição Detalhada *</label>
                            <textarea name="descricao" class="form-control <?php $__errorArgs = ['descricao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      rows="5" required placeholder="Descreva com detalhes o incidente..."><?php echo e(old('descricao')); ?></textarea>
                            <?php $__errorArgs = ['descricao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">URL Suspeita (opcional)</label>
                            <input type="url" name="url_suspeita" class="form-control <?php $__errorArgs = ['url_suspeita'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('url_suspeita')); ?>" placeholder="https://exemplo.com">
                            <?php $__errorArgs = ['url_suspeita'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Provas (imagem, PDF, vídeo ou áudio)</label>
                            <input type="file" name="provas[]" class="form-control <?php $__errorArgs = ['provas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> <?php $__errorArgs = ['provas.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   accept=".jpg,.jpeg,.png,.webp,.pdf,.mp4,.mov,.webm,.mp3,.wav,.m4a,.ogg,.aac,image/*,application/pdf,video/*,audio/*" multiple>
                            <small class="text-muted">Pode anexar prints, PDFs, vídeos e áudios (máx. 50MB por ficheiro).</small>
                            <?php $__errorArgs = ['provas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <?php $__errorArgs = ['provas.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Localização (opcional)</label>
                                <input type="text" name="localizacao" class="form-control" 
                                       value="<?php echo e(old('localizacao')); ?>" placeholder="Ex: Brasil, São Paulo">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Data do Incidente (opcional)</label>
                                <input type="date" name="data_incidente" class="form-control <?php $__errorArgs = ['data_incidente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       value="<?php echo e(old('data_incidente')); ?>">
                                <?php $__errorArgs = ['data_incidente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="aceitar" required>
                            <label class="form-check-label" for="aceitar">
                                Confirmo que as informações acima são precisas e verdadeiras
                            </label>
                        </div>

                        <div class="d-grid gap-2 d-sm-flex">
                            <button type="submit" class="btn btn-primary btn-lg flex-sm-grow-1">
                                <i class="bi bi-check-circle"></i> Enviar Denúncia
                            </button>
                            <a href="<?php echo e(route('denuncias.index')); ?>" class="btn btn-secondary btn-lg flex-sm-grow-1">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="alert alert-info mt-4">
                <h6><i class="bi bi-info-circle"></i> Informações Importantes</h6>
                <ul class="mb-0 mt-2">
                    <li>Todas as denúncias são revisadas antes de publicação</li>
                    <li>Forneca o máximo de detalhes possível para uma análise melhor</li>
                    <li>Screenshots ou evidências ajudam bastante</li>
                    <li>Dados pessoais serão mantidos confidenciais</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mac/Herd/Fraude/resources/views/denuncias/create.blade.php ENDPATH**/ ?>