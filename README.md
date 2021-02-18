# CI4 - Integração com PayPal

### **Configuração**

1º Abra o arquivo 'app/Config/Constants/Constants.php' e altere as linhas:
```bash
// BANCO DE DADOS
defined('HOSTNAME') || define('HOSTNAME', 'seu_hostname');
defined('USERNAME') || define('USERNAME', 'seu_username');
defined('PASSWORD') || define('PASSWORD', 'seu_password');
defined('DATABASE') || define('DATABASE', 'seu_database');
```
```bash
// DADOS PAYPAL
defined('PAYPAL_CLIENT_ID') || define('PAYPAL_CLIENT_ID', 'seu_client_id');
defined('PAYPAL_SECRET') || define('PAYPAL_SECRET', 'seu_secret');
```
- Primeiro bloco é a configuração do seu banco de dados e o segundo bloco é a configuração do seu PagSeguro (Sandbox ou Production).

2º Após ter feito a configuração do banco de dados, abra seu terminal e acesse o projeto. Em seguida execute os comandos abaixo:
 ```bash
 // Migra todas as tabelas já prontas
 php spark migrate
 ```
 - Em seguida:
  ```bash
  // Irá popular as tabelas do banco de dados
  php spark db:seed ProductsSeeder
  ```

4º Caso necessite usar o próprio servidor interno do framework, abre o terminal e digite o comando abaixo:
 ```bash
 php spark serve
 ```
 - Após este comando, acesse o projeto assim http://localhost:8080
 
5º Acesse a página https://developer.paypal.com e faça seu cadastro.
- Acesse 'My Apps & Credentials' no menu esquerdo, crie o aplicativo
    - Após criar o aplicativo, copie o 'Client ID' e 'Secret'
    
6º Para ambiente de teste Acesse 'Accounts' no menu esquerdo e utilize o email com o tipo 'Business' para simular a compra. 