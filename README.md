# Technical Test: Lead Management System Solarkita

## Overview

This project is designed to create a Lead Management System that accommodates different user roles and functionalities related to lead handling in a solar panel installation business. The system allows for the insertion and distribution of leads, status updates, and management of salesperson assignments and penalties.

## Table of Contents

1. [Documentation](#documentation)
2. [Requirements](#requirements)
3. [Installation](#installation)

## Documentation
For more information, visit [Postman](https://documenter.getpostman.com/view/11932880/2sAY4sij8B).

## Requirements
- PHP >= 8.0
- Composer
- Laravel >= 11
- MySQL or another supported database
- Redis 

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/your-repo.git
   cd your-repo
   ```
2. Install dependencies
   ```bash
   composer install
   ```
3. Copy the **.env.example** file to **.env**:
   ```bash
   cp .env.example .env
   ```
4. Generate the application key:
   ```bash
   php artisan key:generate
   ```
5. To start the local development server, run:
   ```bash
   php artisan serve
   ```
