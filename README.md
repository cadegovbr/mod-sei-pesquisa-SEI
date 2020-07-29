# Módulo de Pesquisa Pública

## Requisitos:
- SEI 3.0.10 instalado ou atualizado (verificar valor da constante de versão do SEI no arquivo /sei/web/SEI.php).
- Instalar nas máquinas que rodam o SEI a biblioteca "php-mcrypt".
- Antes de executar os scripts de instalação (itens 4 e 5 abaixo), o usuário de acesso aos bancos de dados do SEI e do SIP, constante nos arquivos ConfiguracaoSEI.php e ConfiguracaoSip.php, deverá ter permissão de acesso total ao banco de dados, permitindo, por exemplo, criação e exclusão de tabelas.

## Procedimentos para Instalação:

1. Fazer backup dos bancos de dados do SEI e do SIP.

2. Carregar no servidor os arquivos do módulo localizados na pasta "/sei/web/modulos/pesquisa" e os scripts de instalação/atualização "/sei/scripts/sei_instalar_modulo_pesquisa.php" e "/sip/scripts/sip_instalar_modulo_pesquisa.php".

3. Editar o arquivo "/sei/config/ConfiguracaoSEI.php", tomando o cuidado de usar editor que não altere o charset do arquivo, para adicionar a referência à classe de integração do módulo e seu caminho relativo dentro da pasta "/sei/web/modulos" na array 'Modulos' da chave 'SEI':

		'SEI' => array(
			'URL' => 'http://[Servidor_PHP]/sei',
			'Producao' => false,
			'RepositorioArquivos' => '/var/sei/arquivos',
			'Modulos' => array('PesquisaIntegracao' => 'pesquisa',)
			),

4. Rodar o script de banco "/sei/scripts/sei_instalar_modulo_pesquisa.php" em linha de comando no servidor do SEI, verificando se não houve erro em sua execução, em que ao final do log deverá ser informado "FIM". Exemplo de comando de execução:

		/usr/bin/php -c /etc/php.ini /var/www/html/sei/scripts/sei_instalar_modulo_pesquisa.php > atualizacao_modulo_pesquisa_sei.log

5. Rodar o script de banco "/sip/scripts/sip_instalar_modulo_pesquisa.php" em linha de comando no servidor do SIP, verificando se não houve erro em sua execução, em que ao final do log deverá ser informado "FIM". Exemplo de comando de execução:

		/usr/bin/php -c /etc/php.ini /var/www/html/sip/scripts/sip_instalar_modulo_pesquisa.php > atualizacao_modulo_pesquisa_sip.log

6. Após a execução com sucesso dos dois scripts de banco acima, com um usuário com permissão de Administrador no SEI, abra o menu de configuração do módulo no SEI (Administração > Pesquisa Pública > Parâmetros Pesquisa Pública) e verifique as opções de configuração.

Obs. (Não se esqueça de alterar o campo "Chave para criptografia dos links de processos e documentos").

7. Após a configuração, a página de Pesquisa Pública estará acessível pelo endereço a seguir:
	http://[Servidor_PHP]/sei/modulos/pesquisa/md_pesq_processo_pesquisar.php?acao_externa=protocolo_pesquisar&acao_origem_externa=protocolo_pesquisar&id_orgao_acesso_externo=0

8. Em caso de erro durante a execução dos dois script de banco verificar (lendo as mensagens de erro,no SEI em Infra > Log e no SIP em Infra > Log) se a causa foi algum problema na infra-estrutura local. Neste caso, após a correção, restaurar o backup do banco de dados e executar novamente os scripts indicados nos itens 4 e 5 acima.
	- Caso não seja possível identificar a causa, abrir Issue no projeto do módulo no Gitlab do Portal do SPB: https://softwarepublico.gov.br/gitlab/cade/mod-sei-pesquisa

## Orientações Negociais:

1. A partir da versão 3.0.6 do Módulo de Pesquisa Pública existe integração com o Módulo de Peticionamento e Intimação Eletrônicos, em que a Pesquisa Pública percebe se existe o mencionado módulo na versão 2.0.0 ou superior instalado no SEI e, com isso, tem comportamento próprio na tela de acesso ao processo pela Pesquisa Pública para **proteger o acesso a documento público que esteja relacionado com Intimação Eletrônica ainda não cumprida**.
	- Este comportamento visa a proteger o conhecimento do teor do documento por meios diversos do Cumprimento da Intimação Eletrônica.
	- Após o Cumprimento da Intimação Eletrônica pelos destinatários, por ser documento público, o acesso a seu teor por meio da Pesquisa Pública passa a estar liberado.