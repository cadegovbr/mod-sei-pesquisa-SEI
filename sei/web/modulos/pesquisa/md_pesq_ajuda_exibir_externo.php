<?
/*
* CONSELHO ADMINISTRATIVO DE DEFESA ECON�MICA - CADE
*
* 01/10/2014 - criado por alex braga
*
*
* Vers�o do Gerador de C�digo:
*/
try {
  require_once dirname(__FILE__).'/../../SEI.php';
  
  //////////////////////////////////////////////////////////////////////////////
  InfraDebug::getInstance()->setBolLigado(false);
  InfraDebug::getInstance()->setBolDebugInfra(false);
  InfraDebug::getInstance()->limpar();
  //////////////////////////////////////////////////////////////////////////////

  MdPesqPesquisaUtil ::valiadarLink();

  $strNomeArquivo = '';
  
  switch($_GET['acao_externa']){ 
  	  	
    case 'pesquisa_publica_ajuda':
      break;
	
    default:
      throw new InfraException("A��o '".$_GET['acao']."' n�o reconhecida.");
  }       

}catch(Exception $e){
  die('Erro realizando download do anexo:'.$e->__toString());
}

PaginaSEI::getInstance()->montarDocType();
PaginaSEI::getInstance()->abrirHtml();
PaginaSEI::getInstance()->abrirHead();
PaginaSEI::getInstance()->montarMeta();
PaginaSEI::getInstance()->montarTitle(PaginaSEI::getInstance()->getStrNomeSistema().' - Ajuda Pesquisa');
PaginaSEI::getInstance()->montarStyle();
?>
<style>

div.ajudaTitulo {
  font-size: 1rem;
  font-weight: bold;
  color: white;
  background: #16609B;
  position: relative;
  padding: 2pt;
  border-width: 0px;
  margin-left:1rem;
}

div.ajudaTexto {
  position: relative;
  padding: 5pt;
  border-width: 0px;
  margin-left:2rem;
}

div.ajudaTexto, div.ajudaTexto * {
  font-size: .875rem;
  color: black;
  background: white;
}

div.ajudaTexto a{
  color: #2c67cd !important;
}

.ajudaExemplo {
  font-family: Courier;
  font-size: .875rem;
  color: #006600;
  background: white;
  position: relative;
  padding: 4px;
  border-width: thin;
  border-style: dotted;
  width: 480px;
  margin-left:3rem;
}
</style>

<?

PaginaSEI::getInstance()->montarJavaScript();
PaginaSEI::getInstance()->fecharHead();
?>
<body id="bodyAjuda">
<div>
<blockquote>

  <br />

  <p style='text-align:center;font-weight:bold;font-size:16pt;'>Pesquisa</p>

  <div class="ajudaTexto">A pesquisa busca as informa��es para apresentar no resultado nos seguintes campos: <br />
    <ol>
      <li>No corpo dos documentos criados no pr�prio processo (tipo de documento, n�mero, data, texto, sigla, assinatura, tudo que se visualiza no documento pode ser pesquisado);</li>
      <li>Nos documentos externos digitalizados com processamento de OCR - Reconhecimento �tico de Caracteres (se sua unidade digitaliza documentos, certifique-se que a op��o de OCR est� ativa no programa de escaneamento);</li>
      <li>Nos documentos externos de texto (planilhas, txt, html, doc, docx, xls, pdf, etc.);</li>
      <li>Nos dados cadastrais de processos e documentos.</li>
    </ol>
    <br>
    A pesquisa pode ser realizada por:
  </div>

  <div class="ajudaTitulo">1. Palavras, Siglas, Express�es ou N�meros</div>
  <blockquote>
    <div class="ajudaTexto">Busca ocorr�ncias de uma determinada palavra, sigla, express�o (deve ser informada entre aspas duplas) ou n�mero:</div>
    <div class="ajudaExemplo">prescri��o</div>
    <br>
    <div class="ajudaExemplo">certid�o INSS</div>
    <br>
    <div class="ajudaExemplo">declara��o "imposto de renda"</div>
    <br>
    <div class="ajudaExemplo">portaria 744</div>
    <br>
    <br>
  </blockquote>

  <div class="ajudaTitulo">2. Busca por parte de Palavras ou N�meros (*)</div>
  <blockquote>
    <div class="ajudaTexto">Procura registros que contenham parte da palavra ou n�mero:</div>
    <div class="ajudaExemplo">embarg* (retornar� registros com <strong>embarg</strong>o, <strong>embarg</strong>ou,<strong>embarg</strong>ante,...)</div>
    <br>
    <div class="ajudaExemplo">201.7* (retornar� registros contendo <strong>201.7</strong>98.988-00, <strong>201.7</strong>19,43, <strong>201.7</strong>1, ...)</div>
    <br>
  </blockquote>

  <div class="ajudaTitulo">3. Conector (E)</div>
  <blockquote>
    <div class="ajudaTexto">Pesquisa por registros que contenham todas as palavras e express�es:</div>
    <div class="ajudaExemplo">m�vel e licita��o</div>
    <br>
    <div class="ajudaExemplo">nomea��o e "cargo efetivo"</div>
    <br>

    <div class="ajudaTexto">Este conector ser� utilizado automaticamente caso nenhum outro seja informado.</div>
  </blockquote>

  <div class="ajudaTitulo">4. Conector (OU)</div>
  <blockquote>
    <div class="ajudaTexto">Pesquisa por registros que contenham pelo menos uma das palavras ou express�es:</div>
    <div class="ajudaExemplo">funcion�rio ou servidor</div>
    <br>
  </blockquote>

  <div class="ajudaTitulo">5. Conector (N�O)</div>
  <blockquote>
    <div class="ajudaTexto">Recupera registros que contenham a primeira, mas n�o a segunda palavra ou express�o, isto �, exclui os registros que contenham a palavra ou express�o seguinte ao conector (N�O):</div>
    <div class="ajudaExemplo">certid�o n�o INSS</div>
    <br>
  </blockquote>

</blockquote>
</div>
</body>
<?
PaginaSEI::getInstance()->fecharHtml();
?>