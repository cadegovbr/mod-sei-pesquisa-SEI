<?
/**
* CONSELHO ADMINISTRATIVO DE DEFESA ECONOMICA
*
* 21/10/2021 - criado por Miguel Costa
*
* Versão do Gerador de Código: 1.39.0
*/

require_once dirname(__FILE__).'/../../../SEI.php';

class MdPesqTipoProcessoDTO extends InfraDTO {

  public function getStrNomeTabela() {
  	 return 'tb_pesq_tipo_processo';
  }

  public function montar() {

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'IdPesqTipoProcesso',
                                   'co_seq_md_pesq_tipo_processo');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_NUM,
                                   'Id',
                                   'id_tipo_procedimento');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_DTA,
                                   'Inicio',
                                   'dt_inicio');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_DTA,
                                   'Fim',
                                   'dt_fim');

    $this->adicionarAtributoTabela(InfraDTO::$PREFIXO_STR,
                                   'SinAtivo',
                                   'sin_ativo');

    $this->adicionarAtributoTabelaRelacionada(InfraDTO::$PREFIXO_STR,
      'Nome',
      'nome',
      'tipo_procedimento');

    $this->configurarPK('IdPesqTipoProcesso', InfraDTO::$TIPO_PK_INFORMADO);

    $this->configurarFK('Id', 'tipo_procedimento', 'id_tipo_procedimento');

    $this->configurarExclusaoLogica('SinAtivo', 'N');
  }
  
}
?>
