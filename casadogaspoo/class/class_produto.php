<?php
require_once 'class/conexao.php';
require_once 'class_categoria.php';
require_once 'class_fornecedor.php';
require_once 'class_cidade.php';

class Produto {
    
    /** @var Categoria */
    private $Categoria;
    /** @var Fornecedor */
    private $Fornecedor;
    private $codigo;
    private $nome;
    private $descricao;
    private $valor;
    private $estoque;
    
    public function getCategoria() {
        return $this->Categoria;
    }

    public function getFornecedor() {
        return $this->Fornecedor;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getValor() {
        return $this->valor;
    }

    public function getEstoque() {
        return $this->estoque;
    }

    public function setCategoria(Categoria $Categoria) {
        $this->Categoria = $Categoria;
    }

    public function setFornecedor($Fornecedor) {
        $this->Fornecedor = $Fornecedor;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function setEstoque($estoque) {
        $this->estoque = $estoque;
    }

    private function selectAll() {
        $sSql = 'SELECT *
                   FROM MERCADO.TBPRODUTO
                   JOIN MERCADO.TBCATEGORIA
                        USING(CATCODIGO)
                   JOIN MERCADO.TBFORNECEDOR
                        USING(FORCODIGO)
                   JOIN MERCADO.TBCIDADE
                        USING(CIDCODIGO)';

        $oResultado = pg_query(Conexao::conectar(), $sSql);

        $aDados = [];

        while ($aLinha = pg_fetch_assoc($oResultado)) {
            $oCategoria = new Categoria();
            $oFornecedor = new Fornecedor();
            $oProduto = new Produto();
            
            $oCategoria->setCodigo($aLinha['catcodigo']);
            $oCategoria->setDescricao($aLinha['catdescricao']);

            $oFornecedor->setCodigo($aLinha['forcodigo']);
            $oFornecedor->setNome($aLinha['fornome']);
            $oFornecedor->setCnpj($aLinha['forcnpj']);
            
            $oProduto->setCodigo($aLinha['procodigo']);
            $oProduto->setNome($aLinha['pronome']);
            $oProduto->setDescricao($aLinha['prodescricao']);
            $oProduto->setValor($aLinha['provalor']);
            $oProduto->setEstoque($aLinha['proestoque']);
            $oProduto->setCategoria($oCategoria);
            $oProduto->setFornecedor($oFornecedor);
            
            $aDados[] = $oProduto;
        }

        return $aDados;
    }
    
    public function montaTabela() {
        $aDados = $this->selectAll();

        if (empty($aDados)) {
            echo 'Não existem registros';
        } else {
            echo '<table border=1>';
            echo '<tr>';
            echo '<th>Codigo</th>';
            echo '<th>Nome</th>';
            echo '<th>Descricao</th>';
            echo '<th>Valor</th>';
            echo '<th>Estoque</th>';
            echo '<th>Categoria - Nome</th>';
            echo '<th>Fornecedor - Nome</th>';
            echo '<th>Acoes</th>';
            echo '</tr>';

            foreach ($aDados as $oObjeto) {
                echo '<tr>';
                echo '<td>' . $oObjeto->getCodigo() . '</td>';
                echo '<td>' . $oObjeto->getNome() . '</td>';
                echo '<td>' . $oObjeto->getDescricao() . '</td>';
                echo '<td>' . $oObjeto->getValor() . '</td>';
                echo '<td>' . $oObjeto->getEstoque() . '</td>';
                echo '<td>' . $oObjeto->getCategoria()->getDescricao() . '</td>';
                echo '<td>' . $oObjeto->getFornecedor()->getNome() . '</td>';
                echo '<td><a href="produto.php?acao=deletar&registro=' . $oObjeto->getCodigo() . '">Deletar</a></td>';
                echo '</tr>';
            }

            echo '</table>';
        }
    }
    
    public function deletar() {
        $sSql = 'DELETE 
                   FROM MERCADO.TBPRODUTO
                  WHERE PROCODIGO = ' . $this->getCodigo();
        
        pg_query(Conexao::conectar(), $sSql);
    }
}
