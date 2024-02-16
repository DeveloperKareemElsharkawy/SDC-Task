<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

# Project SDC Task

This project serves as an authentication system with email and Telegram events integrated.

## Installation

To get started with this project, follow these steps:

1. Clone the repository to your local machine:
   ```bash
   git clone git@github.com:DeveloperKareemElsharkawy/SDC-Task.git

 
2. Run Composer
   ```bash
   composer update
   ```

2. Make .env File
   ```bash
    cp .env.example .env
    php artisan key:generate
   ```

3. add Telegram Token For Notifications
   ```bash
        TELEGRAM_BOT_TOKEN="6830750936:AAE6kWAHT8XrTvL32OuUyE4ggfovRpMpiCE"
   ```

4. Run migration
   ```bash
        php artisan migrate
   ```
5. Import the Postman collection using the provided link or from the repository file named `Auth System SDC APP Task.postman_collection`:
   - [Postman Collection Link](https://elements.getpostman.com/redirect?entityId=21322026-6135900c-ed56-4428-9eb3-12d3bfebcd78&entityType=collection)

