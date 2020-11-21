<?php

require_once 'class/conexao.php';

/**
 * Classe de categoria
 * @author Arthur Roberto Fronza
 * @since 20/11/2020
 * @package Casa do Gas
 */
class Categoria {

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
     * @return array Array de objetos de Categoria
     */
    private function selectAll() {
        $sSql = 'SELECT *
                   FROM MERCADO.TBCATEGORIA';

        $oResultado = pg_query(Conexao::conectar(), $sSql);

        $aDados = [];

        while ($sLinha = pg_fetch_assoc($oResultado)) {
            $oCategoria = new Categoria();
            $oCategoria->setCodigo($sLinha['catcodigo']);
            $oCategoria->setDescricao($sLinha['catdescricao']);

            $aDados [] = $oCategoria;
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
                    <a href="categoria.php?acao=deletar&registro=' . $oObjeto->getCodigo() . '">Deletar</a>   
                 </td>';
                echo '</tr>';
            }

            echo '</table>';
        }
    }

    public function deletar() {
        $sSql = 'DELETE
                   FROM MERCADO.TBCATEGORIA
                  WHERE CATCODIGO = ' . $this->getCodigo();

        pg_query(Conexao::conectar(), $sSql);
    }

}
