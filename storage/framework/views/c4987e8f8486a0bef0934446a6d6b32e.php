<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Relatório - Ondyove</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Relatório de Atividades</h1>
    <p>Gerado em: <?php echo e(now()->format('d/m/Y H:i')); ?></p>
    
    <h2>Denúncias por Tipo</h2>
    <table>
        <tr><th>Tipo</th><th>Total</th></tr>
        <?php $__currentLoopData = $relatorios['denunciasPorTipo']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr><td><?php echo e($tipo); ?></td><td><?php echo e($total); ?></td></tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
    
    <h2>Denúncias por Status</h2>
    <table>
        <tr><th>Status</th><th>Total</th></tr>
        <?php $__currentLoopData = $relatorios['denunciasPorStatus']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr><td><?php echo e($status); ?></td><td><?php echo e($total); ?></td></tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
</body>
</html><?php /**PATH /Users/mac/Herd/Fraude/resources/views/admin/relatorios-pdf.blade.php ENDPATH**/ ?>