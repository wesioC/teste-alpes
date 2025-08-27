#!/bin/bash

# Para o script imediatamente se um comando falhar
set -e

# MENSAGEM INICIAL
echo ">>> Iniciando deploy para a instância $EC2_HOST..."

# PASSO 1: COPIAR ARQUIVOS
# Usamos rsync por ser mais eficiente. Ele sincroniza os arquivos da pasta atual
# (no ambiente do GitHub Actions) para a pasta de destino na EC2.
# A opção --delete apaga arquivos no destino que não existem mais na origem.
echo ">>> [Passo 1/2] Copiando arquivos para a EC2..."
rsync -avz --delete -e "ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null" ./* $EC2_USER@$EC2_HOST:$TARGET_DIR

echo ">>> Arquivos copiados com sucesso."

# PASSO 2: REINICIAR SERVIDOR
# Conecta-se via SSH na instância e executa os comandos para reiniciar a aplicação.
# **IMPORTANTE:** Altere os comandos dentro do bloco 'EOF' para os que sua aplicação precisa.
echo ">>> [Passo 2/2] Reiniciando o servidor na EC2..."
ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null $EC2_USER@$EC2_HOST << 'EOF'
    # Navega para o diretório da aplicação
    cd /var/www/teste-alpes

    # atualizar git
    git pull origin main

    # instalar composer e reiniciar caches
    composer install --no-dev --optimize-autoloader
    php artisan cache:clear
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

    # reiniciar o servidor web
    sudo systemctl restart nginx

    # reiniciar o php-fpm
    sudo systemctl restart php8.1-fpm

    echo ">>> Servidor reiniciado com sucesso!"
EOF

echo ">>> DEPLOY FINALIZADO COM SUCESSO!"