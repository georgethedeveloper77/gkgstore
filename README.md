`composer update --ignore-platform-reqs`

`composer install --ignore-platform-reqs`

# Boostrap
Go to app >> Providers >> AppServiceProvider.php
Under the boot method, paste the code below:

  `if($this->app->environment('production')) {
\URL::forceScheme('https');
        }`
        
