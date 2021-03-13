# Loja WebJump

## Projeto Realizado para simular uma loja com cadastro de Produtos (Multicategoria), com upload de imagens e log. Utilizando conceito de Orientação a Objetos e trigger no banco de dados para inserir os logs;

# Tecnologias utilizadas:
- PHP 7.3;
- Banco de dados Mysql 5.7;

# Iniciando a instalação do Projeto:
- Instalar o PHP 7/apache e Mysql no HOST;
- Clonar este projeto;
- Importar o dump que está na pasta db;
- Renomear o arquivo loja_webjump_conf.ini para loja_webjump.ini com as configrações da sua base de dados;

# Passos da construção do projeto
- Criação das tabelas no Mysql (category, product, product_categories);
- Criação das Classes, aplicações de controle e arquivos de conexão PDO;
- Criação dos Cruds de categoria e Produto;
- Criação da Classe de upload de imagem;
- Ajustes nas aplicações de produto que utilizam as imagens;
- Ajustes na tela de dashboard para exibir os 4 últimos registros cadastrados com imagem;
- Criação da tabela de LOG;
- Criação das Triggers (log_delete_category, log_delete_product, log_delete_product_categories, log_insert_category, log_insert_product, log_insert_product_categories, log_update_category,log_update_product) para inserir os **LOGS** na tabela;
- Criação da lista de logs;

# Melhorias futuras
- Criar Models para o projeto;
- Validar melhor as informações inseridas nos Forms;
- Validar melhor o upload de arquivos;
- Criar uma tela para importar o arquivo import.csv;
- Criar testes automatizados;