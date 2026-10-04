# Step 1: Use an official image that has Linux, PHP 8.2, and the Apache web server pre-installed
From php:8.2-apache

# Step 2: Install the database drivers so PHP is capable of talking to a MySQL database
RUN docker-php-ext-install mysqli

# Step 3: Copy all the PHP source code files from your Windows PC into the server's standard web folder
COPY . /var/www/html/

# Step 4: Change Apache's configuration files so it listens to hidden internal Port 8080 instead of public Port 80
RUN sed -i 's/Listen 80/listen 8080/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Step 5: Inform Docker that Port 8080 is the open doorway where web traffic enters this container
EXPOSE 8080