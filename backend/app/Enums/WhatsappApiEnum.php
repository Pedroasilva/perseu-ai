<?php

namespace App\Enums;

enum WhatsappApiEnum: string
{
    case SESSAO_NAO_ENCONTRADA = 'session_not_found';
    case SESSAO_NAO_CONECTADA = 'session_not_connected';
    case SESSAO_CONECTADA = 'session_connected';

    /**
     * Retorna os valores do Enum como array.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Retorna o nome amigável do status.
     */
    public function label(): string
    {
        return match ($this) {
            self::SESSAO_NAO_ENCONTRADA => 'Sessão não encontrada',
            self::SESSAO_NAO_CONECTADA => 'Sessão não conectada',
            self::SESSAO_CONECTADA => 'Sessão conectada',
        };
    }

}
