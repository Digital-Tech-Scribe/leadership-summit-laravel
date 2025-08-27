# Leadership Summit Laravel - Development Makefile
# This file provides convenient shortcuts for common development tasks

.PHONY: help dev-setup serve test assets migrate seed fresh cache-clear

# Default target
help: ## Show this help message
	@echo "Leadership Summit Laravel - Development Commands"
	@echo "=============================================="
	@echo ""
	@echo "Available commands:"
	@echo ""
	@grep -E '^[a-zA-Z_-]+:.*?## .*$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-15s\033[0m %s\n", $1, $2}'
	@echo ""
	@echo "Examples:"
	@echo "  make dev-setup # Complete local development setup"
	@echo "  make serve     # Start local development server"
	@echo "  make test      # Run tests"
	@echo "  make assets    # Build frontend assets"

dev-setup: ## Complete local development setup
	@echo "🚀 Setting up local development environment..."
	composer install
	npm install
	cp .env.example .env
	php artisan key:generate
	touch database/database.sqlite
	php artisan migrate --seed
	npm run build
	@echo "✅ Setup complete! Run 'make serve' to start development server"

serve: ## Start local development server
	@echo "🌐 Starting local development server..."
	php artisan serve

test: ## Run tests
	@echo "🧪 Running tests..."
	php artisan test

assets: ## Build frontend assets
	@echo "🎨 Building frontend assets..."
	npm run build

assets-dev: ## Build frontend assets for development
	@echo "🎨 Building frontend assets (development)..."
	npm run dev

assets-watch: ## Watch and rebuild frontend assets
	@echo "👀 Watching frontend assets..."
	npm run dev

migrate: ## Run database migrations
	@echo "🗄️ Running database migrations..."
	php artisan migrate

seed: ## Seed database with sample data
	@echo "🌱 Seeding database..."
	php artisan db:seed

fresh: ## Fresh database with migrations and seeds
	@echo "🔄 Fresh database setup..."
	php artisan migrate:fresh --seed

cache-clear: ## Clear all caches
	@echo "🧹 Clearing caches..."
	php artisan cache:clear
	php artisan config:clear
	php artisan route:clear
	php artisan view:clear

install: ## Install dependencies
	@echo "📦 Installing dependencies..."
	composer install
	npm install

update: ## Update dependencies
	@echo "🔄 Updating dependencies..."
	composer update
	npm update