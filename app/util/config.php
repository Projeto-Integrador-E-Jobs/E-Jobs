<?php
#Nome do arquivo: config.php
#Objetivo: define constantes para serem utilizadas no projeto

//Configuraçao de erro no PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Banco de dados: conexão MySQL
define('DB_HOST', 'localhost');
define('DB_NAME', 'ejobs');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');

//Caminho para adionar imagens, scripts e chamar páginas no sistema
//Deve ter o nome da pasta do projeto no servidor APACHE
define('BASEURL', '/E-Jobs/app');

//Nome do sistema
define('APP_NAME', 'E-Jobs');

//Página de logout do sistema
define('LOGIN_PAGE', BASEURL . '/controller/LoginController.php?action=login');

//Página de login do sistema
define('LOGOUT_PAGE', BASEURL . '/controller/LoginController.php?action=logout');

//Página home do sistema
define('HOME_PAGE', BASEURL . '/controller/HomeController.php?action=home');

//Página home da Empresa
define('EMPRESAHOME_PAGE', BASEURL . '/controller/EmpresaController.php?action=home');

//Página home do Administrador do sistema
define('ADMINHOME_PAGE', BASEURL . '/controller/AdminController.php?action=home');

//Sessão do usuário
define('SESSAO_USUARIO_ID', "usuarioLogadoId");
define('SESSAO_USUARIO_NOME', "usuarioLogadoNome");
define('SESSAO_USUARIO_PAPEL', "usuarioLogadoPapel");




