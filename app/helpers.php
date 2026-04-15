<?php

if (!function_exists('getRiscoColor')) {
    function getRiscoColor($risco) {
        return match($risco) {
            'seguro' => 'success',
            'suspeito' => 'warning',
            'perigoso' => 'danger',
            default => 'secondary'
        };
    }
}

if (!function_exists('getStatusColor')) {
    function getStatusColor($status) {
        return match($status) {
            'pendente' => 'warning',
            'aprovado' => 'info',
            'rejeitado' => 'danger',
            'resolvido' => 'success',
            default => 'secondary'
        };
    }
}

if (!function_exists('getPrioridadeColor')) {
    function getPrioridadeColor($prioridade) {
        return match($prioridade) {
            'alta' => 'danger',
            'media' => 'warning',
            'baixa' => 'success',
            default => 'secondary'
        };
    }
}
