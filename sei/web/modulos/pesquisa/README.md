# Módulo de Pesquisa Pública

## Requisitos:
- SEI 4.0.0 instalado/atualizado.
	- Verificar valor da constante de versão no arquivo /sei/web/SEI.php ou, após logado no sistema, parando o mouse sobre a logo do SEI no canto superior esquerdo.
- Antes de executar os scripts de instalação/atualização, o usuário de acesso aos bancos de dados do SEI e do SIP, constante nos arquivos ConfiguracaoSEI.php e ConfiguracaoSip.php, deverá ter permissão de acesso total ao banco de dados, permitindo, por exemplo, criação e exclusão de tabelas.
- Os códigos-fonte do Módulo podem ser baixados a partir do link a seguir, devendo sempre utilizar a versão mais recente: [https://github.com/cadegovbr/mod-sei-pesquisa-SEI/releases](https://github.com/cadegovbr/mod-sei-pesquisa-SEI/releases "Clique e acesse")

## Procedimentos para Instalação:

## Procedimentos para Instalação
1. Fazer backup dos bancos de dados do SEI e do SIP.
2. Carregar no servidor os arquivos do módulo nas pastas correspondentes nos servidores do SEI e do SIP.
	- **Caso se trate de atualização de versão anterior do Módulo**, antes de copiar os códigos-fontes para a pasta "/sei/web/modulos/peticionamento", é necessário excluir os arquivos anteriores pré existentes na mencionada pasta, para não manter arquivos de códigos que foram renomeados ou descontinuados.
3. Editar o arquivo "/sei/config/ConfiguracaoSEI.php", tomando o cuidado de usar editor que não altere o charset do arquivo, para adicionar a referência à classe de integração do módulo e seu caminho relativo dentro da pasta "/sei/web/modulos" na array 'Modulos' da chave 'SEI':

		'SEI' => array(
			'URL' => 'http://[Servidor_PHP]/sei',
			'Producao' => false,
			'RepositorioArquivos' => '/var/sei/arquivos',
			'Modulos' => array('PesquisaIntegracao' => 'pesquisa',)
			),

4. Antes de seguir para os próximos passos, é importante conferir se o Módulo foi corretamente declarado no arquivo "/sei/config/ConfiguracaoSEI.php". Acesse o menu **Infra > Módulos** e confira se consta a linha correspondente ao Módulo, pois, realizando os passos anteriores da forma correta, independente da execução do script de banco, o Módulo já deve ser reconhecido na tela aberta pelo menu indicado.
   
5. Rodar o script de banco "/sip/scripts/sip_atualizar_versao_modulo_pesquisa.php" em linha de comando no servidor do SIP, verificando se não houve erro em sua execução, em que ao final do log deverá ser informado "FIM". Exemplo de comando de execução:

   	/usr/bin/php -c /etc/php.ini /opt/sip/scripts/sip_atualizar_versao_modulo_pesquisa.php 2>&1 > atualizacao_pesquisa_sip.log

6. Antes de rodar o script de banco do SEI, para evitar erros de chave duplicada, importante executar o script do core do SEI de atualização dos sequences das tabelas:

   	/usr/bin/php -c /etc/php.ini /opt/sei/scripts/atualizar_sequencias.php 2>&1 > atualizar_sequencias_sei.log

7. Rodar o script de banco "/sei/scripts/sei_atualizar_versao_modulo_pesquisa.php" em linha de comando no servidor do SEI, verificando se não houve erro em sua execução, em que ao final do log deverá ser informado "FIM". Exemplo de comando de execução:

   	/usr/bin/php -c /etc/php.ini /opt/sei/scripts/sei_atualizar_versao_modulo_pesquisa.php 2>&1 > atualizacao_pesquisa_sei.log 

8. **IMPORTANTE**: Na execução dos dois scripts de banco acima, ao final deve constar o termo "FIM", o "TEMPO TOTAL DE EXECUÇÃO" e a informação de que a instalação/atualização foi realizada com sucesso na base de dados correspondente (SEM ERROS). Do contrário, o script não foi executado até o final e algum dado não foi inserido/atualizado no respectivo banco de dados, devendo recuperar o backup do banco e repetir o procedimento.
	- Constando ao final da execução do script as informações indicadas, pode logar no SEI e SIP e verificar no menu **Infra > Parâmetros** dos dois sistemas se consta o parâmetro "VERSAO_MODULO_PETICIONAMENTO" com o valor da última versão do módulo.
	
9. Em caso de erro durante a execução do script, verificar (lendo as mensagens de erro e no menu Infra > Log do SEI e do SIP) se a causa é algum problema na infraestrutura local ou ajustes indevidos na estrutura de banco do core do sistema. Neste caso, após a correção, deve recuperar o backup do banco pertinente e repetir o procedimento, especialmente a execução dos scripts de banco indicados acima.
	- Caso não seja possível identificar a causa, entrar em contato com: Nome do Responsável - email do resposável
	
10. Após a execução com sucesso, com um usuário com permissão de Administrador no SEI, seguir os passos dispostos no tópico "Orientações Negociais" mais abaixo.

## Orientações Negociais:

1. A partir da versão 3.0.6 do Módulo de Pesquisa Pública existe integração com o Módulo de Peticionamento e Intimação Eletrônicos, em que a Pesquisa Pública percebe se existe o mencionado módulo na versão 2.0.0 ou superior instalado no SEI e, com isso, tem comportamento próprio na tela de acesso ao processo pela Pesquisa Pública para **proteger o acesso a documento público que esteja relacionado com Intimação Eletrônica ainda não cumprida**.
	- Este comportamento visa a proteger o conhecimento do teor do documento por meios diversos do Cumprimento da Intimação Eletrônica.
	- Após o Cumprimento da Intimação Eletrônica pelos destinatários, por ser documento público, o acesso a seu teor por meio da Pesquisa Pública passa a estar liberado.
