<?php
namespace Digbang\DoctrineExtensions\Functions\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\PathExpression;
use Doctrine\ORM\Query\TokenType;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class NumericCastFunction extends FunctionNode
{
    public const IDENTIFIER = 'NUMERIC_CAST';

    /** @var PathExpression */
    protected $first;
    /** @var string */
    protected $second;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return "CAST({$this->first->dispatch($sqlWalker)} AS {$this->second})";
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->first = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_AS);
        $parser->match(TokenType::T_IDENTIFIER);
        $this->second = $parser->getLexer()->token->value;
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
