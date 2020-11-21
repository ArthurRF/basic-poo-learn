<?php

require_once 'class/conexao.php';

/**
 * Classe de cidade
 * @author Arthur Roberto Fronza
 * @since 20/11/2020
 * @package Casa do Gas
 */
class Cidade {

    private $codigo;
    private $nome;

    public function getCodigo() {
        return $this->codigo;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    /**
     * Busca todos os registros no banco de dados
     * @return array Array de objetos de Cidade
     */
    private function selectAll() {
        $sSql = 'SELECT *
                   FROM MERCADO.TBCIDADE';

        $oResultado = pg_query(Conexao::conectar(), $sSql);

        $aDados = [];

        while ($sLinha = pg_fetch_assoc($oResultado)) {
            $oCidade = new Cidade();
            $oCidade->setCodigo($sLinha['cidcodigo']);
            $oCidade->setNome($sLinha['cidnome']);

            $aDados [] = $oCidade;
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
                echo '<td>' . $oObjeto->getNome() . '</td>';
                echo '<td>
                    <a href="cidade.php?acao=deletar&registro=' . $oObjeto->getCodigo() . '">Deletar</a>   
                 </td>';
                echo '</tr>';
            }

            echo '</table>';
        }
    }

    public function deletar() {
        $sSql = 'DELETE
                   FROM MERCADO.TBCIDADE
                  WHERE CIDCODIGO = ' . $this->getCodigo();

        pg_query(Conexao::conectar(), $sSql);
    }

}
