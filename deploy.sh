#!/bin/bash
set -e  # Para o script imediatamente se algum comando falhar

# -----------------------------
# CONFIGURAÇÕES (edite conforme seu ambiente)
# -----------------------------
EC2_USER="ec2-user"
EC2_HOST="ec2-3-133-81-220.us-east-2.compute.amazonaws.com"
TARGET_DIR="/var/www/teste-alpes"
PEM_FILE="wesio.pem"  # Caminho para a sua chave .pem

# Mensagem inicial
echo ">>> Iniciando deploy para a instância $EC2_HOST..."

# -----------------------------
# PASSO 1: COPIAR ARQUIVOS
# -----------------------------
echo ">>> [Passo 1/2] Copiando arquivos para a EC2..."
rsync -avz --delete -e "ssh -i $PEM_FILE -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null" ./* $EC2_USER@$EC2_HOST:$TARGET_DIR
echo ">>> Arquivos copiados com sucesso."

# -----------------------------
# PASSO 2: REINICIAR SERVIDOR
# -----------------------------
echo ">>> [Passo 2/2] Reiniciando o servidor na EC2..."
ssh -i $PEM_FILE -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null $EC2_USER@$EC2_HOST << 'EOF'
    echo ">>> Conectado à EC2"

    cd /var/www/teste-alpes || exit
    echo ">>> Atualizando código do Git..."
    git pull origin main

    echo ">>> Instalando dependências PHP..."
    composer install --no-dev --optimize-autoloader

    echo ">>> Limpando e cacheando Laravel..."
    php artisan cache:clear
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

    echo ">>> Reiniciando serviços..."
    sudo systemctl restart nginx
    sudo systemctl restart php8.1-fpm

    echo ">>> Servidor reiniciado com sucesso!"
EOF

echo ">>> DEPLOY FINALIZADO COM SUCESSO!"
