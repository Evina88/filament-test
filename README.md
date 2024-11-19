Filament Panel Builder

#Installation Requirements

PHP 8.1+
Laravel v10.0+
Livewire v3.0+


Followed these instructions:
    https://filamentphp.com/docs/3.x/panels/installation
    https://filamentphp.com/docs/3.x/panels/getting-started


The demo project
This guide covers building a simple patient management system for a veterinary practice using Filament. It will support adding new patients (cats, dogs, or rabbits), assigning them to an owner, and recording which treatments they received. The system will have a dashboard with statistics about the types of patients and a chart showing the number of treatments administered over the past year.


Commands
To run the server:  php artisan serve

Create a user: php artisan make:filament-user
    => Open localhost/admin in your web browser and sign in with the user you created.