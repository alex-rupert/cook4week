Cook4week
=========

A Symfony project created on July 9, 2017, 20:49 pm.
This web project is made with [Symfony 3.3][1] and [PHP 7][2].

*Annoyed to ask yourself what meal you'll eat today ? And what you need to buy for this meal ? Cook4week is made for you, it will choose for you your meals, check your expiry date of your aliments and more !*

## Installation & configuration ##
 1. Clone the project : 

    ```
    git clone https://github.com/alex-rupert/cook4week.git   
    ```
 2. Update your vendors : 

    ```
    composer update
    ```
 3. Check permissions for your **var/cache**, **var/logs** and **var/sessions** folders :

    ```
    sudo setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX app/cache app/logs
    sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs    
    ```
 4. Create the database :

    ```
    php bin/console doctrine:database:create
    ```
 5. Update the database schema (do it each time you make a pull and you have errors with doctrine) :

    ```
    php bin/console doctrine:schema:update --dump-sql
    php bin/console doctrine:schema:update --force
    ```
 6. Seed the database by executing these commands :

    ```
    php app/console migration:seed
    ```
 7. Create your assets (don't forget to use this command each time you update your CSS and JS) : 

    ```
    php app/console assets:install
    php app/console assetic:dump
    ```
 8. Update your app/config/parameters.yml with your settings.

### You did it ! Now you can run the project :-) ###

> This project is at the beginning, I will update this file when the development will progress


  [1]: https://symfony.com/doc/3.3/book/index.html
  [2]: http://php.net/    
