## ACTIVATOR - Temporary activation code generator

This laravel package provides mechanism for activation code generating and validation.

### Documentation

You can find api documentation and demo [here](https://activator.modric.org/docs/).

### Installation

After every install/update process is finished you should execute next command:

    php artisan vendor:publish --provider="Modricl\Activator\ActivatorServiceProvider"

Add this to .env

    MODRICL_ACTIVATOR_DRIVER=mysql
    MODRICL_ACTIVATOR_HOST=<host>
    MODRICL_ACTIVATOR_PORT=3306
    MODRICL_ACTIVATOR_DATABASE=<database>
    MODRICL_ACTIVATOR_USERNAME=<username>
    MODRICL_ACTIVATOR_PASSWORD=<password>
