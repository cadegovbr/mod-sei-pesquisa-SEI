<?
/**
 * CONSELHO ADMINISTRATIVO DE DEFESA ECON�MICA
 * 2014-09-29
 * Vers�o do Gerador de C�digo: 1.0
 * Vers�o no CVS/SVN:
 *
 * sei
 * pesquisa
 * Processo DTO
 *
 *
 * @author Alex Alves Braga <bsi.alexbraga@gmail.com>
 */

/**
 * Classe mantem dados processo DBCade.
 *
 *
 * @package institucional_pesquisa_processo_pesquisar
 * @author Alex Alves Braga <bsi.alexbraga@gmail.com>
 * @license Creative Commons Atribui��o 3.0 n�o adaptada
 *          <http://creativecommons.org/licenses/by/3.0/deed.pt_BR>
 * @ignore Este c�digo � livre para uso sem nenhuma restri��o, 
 *         salvo pelas informa��es a seguir referentes
 * @copyright Conselho Administrativo de Defesa Econ�mica �2014-2018
 *            <http://www.cade.gov.br>
 * @author Alex Alves Braga <bsi.alexbraga@gmail.com>
 */


require_once dirname(__FILE__).'/../../../SEI.php';

class MdPesqProtocoloPesquisaPublicaDTO extends InfraDTO {
	
	
	
	public function getStrNomeTabela(){
		return null;
	}
	
	
	
	public function montar(){
		
		$this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'NumeroSEI');
		$this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'TipoDocumento');
		$this->adicionarAtributo(InfraDTO::$PREFIXO_DTA, 'Documento');
		$this->adicionarAtributo(InfraDTO::$PREFIXO_DTA, 'Registro');
		$this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'Unidade' );
		$this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'StaAssociacao');
		$this->adicionarAtributo(InfraDTO::$PREFIXO_OBJ, 'DocumentoDTO');
		$this->adicionarAtributo(InfraDTO::$PREFIXO_OBJ, 'ProcedimentoDTO');
		
		
		
		
	}
	
	
	
	
	
	
}
