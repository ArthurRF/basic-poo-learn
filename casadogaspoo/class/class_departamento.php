<?php

require_once 'class/conexao.php';

/**
 * Classe de departamento
 * @author Arthur Roberto Fronza
 * @since 20/11/2020
 * @package Casa do Gas
 */
class Departamento {

    private $codigo;
    private $descricao;

    public function getCodigo() {
        return $this->codigo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    /**
     * Busca todos os registros no banco de dados
     * @return array Array de objetos de Departamento
     */
    private function selectAll() {
        $sSql = 'SELECT *
                   FROM MERCADO.TBDEPARTAMENTO';

        $oResultado = pg_query(Conexao::conectar(), $sSql);

        $aDados = [];

        while ($sLinha = pg_fetch_assoc($oResultado)) {
            $oDepartamento = new Departamento();
            $oDepartamento->setCodigo($sLinha['dptcodigo']);
            $oDepartamento->setDescricao($sLinha['dptdescricao']);

            $aDados [] = $oDepartamento;
        }

        return $aDados;
    }

    /**
     * Método utilizado para imprimir todos os registros na tela
     */
    public function montaTabela() {
        $aDados = $this->selectAll();

        if (empty($aDados)) {
            echo 'Não existem registros';
        } else {
            echo '<table border=1>';
            echo '<tr>';
            echo '<th>Código</th>';
            echo '<th>Nome</th>';
            echo '<th>Acoes</th>';
            echo '</tr>';

            foreach ($aDados as $oObjeto) {
                echo '<tr>';
                echo '<td>' . $oObjeto->getCodigo() . '</td>';
                echo '<td>' . $oObjeto->getDescricao() . '</td>';
                echo '<td>
                    <a href="departamento.php?acao=deletar&registro=' . $oObjeto->getCodigo() . '">Deletar</a>   
                 </td>';
                echo '</tr>';
            }

            echo '</table>';
        }
    }

    public function deletar() {
        $sSql = 'DELETE
                   FROM MERCADO.TBDEPARTAMENTO
                  WHERE DPTCODIGO = ' . $this->getCodigo();

        pg_query(Conexao::conectar(), $sSql);
    }

}
