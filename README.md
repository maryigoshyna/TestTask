For execution tests you should run **selenium server** and make sure you have **php-imagick** extension installed. 
Selenium server is needed for run acceptance tests which I've written, and 
php-imagick extension for comparing images (checkAdminAccountBlockScreen test).

So for running tests you should go to TestTask folder and execute command:
```
php vendor/bin/codecept run --steps 
```