#!/bin/bash

# Como usar: ./init.sh

echo "🚀 Iniciando setup do Laravel com Docker..."

# 📄 Verifica .env
if [ ! -f .env ]; then
  echo "📄 Arquivo .env não encontrado. Criando a partir do .env.example..."
  cp .env.example .env
else
  echo "📄 Arquivo .env já existe."
fi

# 🔥 Sobe os containers
docker compose up -d --build

# ⏳ Espera o MySQL estar realmente pronto (CORREÇÃO REAL)
echo "⏳ Aguardando MySQL aceitar conexões..."

until docker compose exec app php -r "
try {
    new PDO('mysql:host=db;dbname=laravel','laravel','laravel');
    exit(0);
} catch (Exception \$e) {
    exit(1);
}
" >/dev/null 2>&1; do
  echo "⏳ Banco ainda não pronto... tentando novamente em 2s"
  sleep 2
done

echo "✅ MySQL pronto e acessível!"

# 📦 Instala dependências do Laravel
echo "📦 Instalando dependências..."
docker compose exec app composer install

# 🔑 Gera APP_KEY (somente se não existir)
echo "🔑 Verificando APP_KEY..."
docker compose exec app php artisan key:generate --force

# 🗄️ Rodando migrations
echo "🗄️ Rodando migrations..."
docker compose exec app php artisan migrate

echo "🎉 Projeto pronto com sucesso!"