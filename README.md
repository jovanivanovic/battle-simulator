# Battle Simulator

This project is made using Laravel and VueJS.

## Installation instructions

- Make a copy of `.env.example` and rename it to `.env`
- Execute `php artisan key:generate` to generate an encryption key
- Update MySQL database information in the `.env` file
- Execute `composer install` to install necessary packages
- Execute `php artisan migrate` to create database tables
- Execute `npm install` to install necessary NPM packages
- Execute `npm run dev` to compile JavaScript and Sass assets
- Execute `php artisan serve` to run a local HTTP server for the current Laravel instance

## Usage

Open the web address you have set up in your browser.

## REST API Routes

| Path | Method | Description |
| --- | --- | --- |
| `/api/games` | `GET` | Returns all the games |
| `/api/games` | `POST` | Creates a new game |
| `/api/games/{id}` | `GET` | Returns a game by the specified `{id}` parameter |
| `/api/games/{id}/armies` | `POST` | Adds an army to the game. Required data: `name, starting_units, strategy` |
| `/api/games/{id}/attack` | `POST` | Runs the attack |
| `/api/games/{id}/reset` | `POST` | Resets the game |
