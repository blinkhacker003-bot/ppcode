#!/bin/bash

# Gere uma senha aleatória de 10 caracteres para o MySQL
mysql_root_password=$(date +%s | sha256sum | base64 | head -c 10)

# Instale o Apache, PHP, MySQL e phpMyAdmin
apt update
apt install -y apache2 php mysql-server php-mysql libapache2-mod-php php-cli php-json php-common php-mbstring php-zip php-gd php-curl php-xml php-pear php-bcmath phpmyadmin

# Configure o Apache para usar o PHP
echo "ServerName localhost" >> /etc/apache2/apache2.conf
a2enmod php
systemctl restart apache2

# Configure o MySQL para acesso remoto
sed -i 's/127.0.0.1/0.0.0.0/' /etc/mysql/mysql.conf.d/mysqld.cnf
mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH 'mysql_native_password' BY '$mysql_root_password';"
systemctl restart mysql

# Reinicie o Apache para aplicar as configurações
systemctl restart apache2

# Ativar o módulo mod_rewrite
a2enmod rewrite

# Resumo da instalação
echo "Instalação concluída:"
echo "Apache, PHP, MySQL e phpMyAdmin foram instalados."
echo "Usuário root do MySQL teve a senha definida para:  $mysql_root_password"
echo "Acesso remoto ao MySQL foi configurado (use com cuidado)."
