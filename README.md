# Shopify Product Fetcher

Laravel application that integrates with Shopify's Admin API to fetch and manage product data.

## Overview

This project demonstrates a clean implementation of Shopify API integration in Laravel, focusing on secure authentication, data retrieval, and the foundation for real-time inventory automation.

Built to solve a common pain point: online stores waste 10-20 hours weekly manually managing product data across platforms. This fetcher automates that first step.

## Current Implementation

**Core functionality:**

-   Shopify Admin API authentication via custom app tokens
-   Product data retrieval (titles, prices, variants, inventory)
-   Environment-based configuration for secure credential management

**In development:**

-   Database persistence layer for product storage
-   Webhook integration for real-time updates
-   Background job processing for scheduled syncs

## Technical Stack

-   **Backend:** Laravel 12.x, PHP 8.2+
-   **API:** Shopify Admin REST API (2026-01)
-   **Database:** MySQL
-   **HTTP Client:** Laravel's built-in HTTP facade

## Setup

**Prerequisites:**

-   PHP 8.2+
-   Composer
-   MySQL
-   Shopify Partner account with development store

**Installation:**

```bash
git clone https://github.com/OlakiitanEkundayo/Shopify-Product-Fetcher.git
cd shopify-product-fetcher
composer install
cp .env.example .env
php artisan key:generate
```

**Configuration:**

Add your Shopify credentials to `.env`:

```env
SHOPIFY_DOMAIN=your-store.myshopify.com
SHOPIFY_ACCESS_TOKEN=shpat_your_access_token
SHOPIFY_API_VERSION=2026-01

DB_DATABASE=shopify_fetcher
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

**Database:**

```bash
php artisan migrate
```

**Run:**

```bash
php artisan serve
```

Visit `http://localhost:8000` to test the integration.

## API Integration Architecture

**Authentication:**

-   Uses Shopify Custom App access tokens
-   Credentials stored securely in environment variables
-   Token passed via HTTP headers for API requests

**Data Flow:**

1. Laravel HTTP client makes authenticated request to Shopify
2. API returns product data in JSON format
3. Application processes and displays/stores data
4. (Future) Webhooks push real-time updates to Laravel endpoint

## Roadmap

**Phase 1:** Basic product fetch and display ✓ (in progress)  
**Phase 2:** Database persistence with Eloquent models  
**Phase 3:** Webhook receiver for inventory updates  
**Phase 4:** Background job processing for scheduled syncs  
**Phase 5:** Low-stock alert system

## Use Cases

This integration serves as the foundation for:

-   Multi-channel inventory synchronization
-   Automated stock level monitoring
-   Custom product data dashboards
-   Elimination of manual export/import workflows

Target audience: eCommerce stores doing $200k-$5M annually that need custom automation beyond what Shopify apps provide.

## Project Context

Part of my backend automation work focused on eCommerce operations. This represents the foundational API integration layer that powers more complex automation systems.

Tech skills demonstrated:

-   RESTful API consumption
-   Secure credential management
-   HTTP client implementation
-   Environment-based configuration
-   Laravel routing and controllers

## Resources

-   [Shopify Admin API Documentation](https://shopify.dev/docs/api/admin-rest)
-   [Laravel HTTP Client Documentation](https://laravel.com/docs/http-client)

## Contact

Building backend automation for eCommerce. Connect on [LinkedIn](https://www.linkedin.com/in/olakiitan-ekundayo-983124244/).
